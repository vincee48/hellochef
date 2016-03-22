<?php

class Email extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emails';

	public static function getNumberOfUnreadEmails($id)
	{
		return Email::where('touser', '=', $id)->where('read', '=', '0')->count();
	}

	public function isReply()
	{
		return substr($this->subject, 0, 3) == "RE:";
	}

	public function getFromUser()
	{
		if ($this->fromuser != 0) {
			return User::find($this->fromuser);
		}
		return new User;
	}

	public function getFromUserName()
	{
		if ($this->fromuser == 0) return "System";

		$user = User::find($this->fromuser);

		return $user->getLatestHistory()->firstname . " " . $user->getLatestHistory()->lastname;
	}

	public function getToUserName()
	{
		if ($this->touser == 0) return "System";

		$user = User::find($this->touser);

		return $user->getLatestHistory()->firstname . " " . $user->getLatestHistory()->lastname;
	}

	public function getBody()
	{
		$string = $this->body;

		$dom = new DOMDocument;
		$dom->loadHTML($string);
		$bodies = $dom->getElementsByTagName('body');
		assert($bodies->length === 1);
		$body = $bodies->item(0);
		for ($i = 0; $i < $body->children->length; $i++) {
			$body->remove($body->children->item($i));
		}
		$string = $dom->saveHTML();

		return $string;
	}

	public function fromSystem()
	{
		return $this->fromuser == 0;
	}

	public function getCreatedAt()
	{
		return $this->created_at->format('d/m/Y g:i A');
	}

	public function canReply()
	{
		return !$this->fromSystem();
	}
	
	public function getEnquiry()
	{
		$enquiry = EmailEnquiry::where('emailid', '=', $this->id)->first();
		return $enquiry->getEnquiry();
	}

	public static function generateResetPasswordEmail($user)
	{
		$history = $user->getLatestHistory();

		$data = array(
			'firstname' => $history->firstname,
			'id' => $user->id,
			'reset' => $user->reset
		);

		$subject = "Reset your password";
		$email = $user->email;

		Mail::queue('emails.reset', $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});
	}

	public static function generateEmailReply($body, $mail)
	{
		$fromuserid = Auth::id();
		$fromuser = Auth::user();
		$touserid = $mail->fromuser == Auth::id() ? $mail->touser : $mail->fromuser;
		$touser = User::find($touserid);
		$touseremail = $touser->email;

		if (!$mail->isReply()) {
			$subject = "RE: " . $mail->subject;
		}
		else {
			$subject = $mail->subject;
		}

		$emailView = 'emails.reply';

		$enquiry = EmailEnquiry::where('emailid', '=', $mail->id)->first();

		$data = array('user' => $touser->getName(),
			'body' => $body,
			'fromuser' => $fromuser->getName(),
			'enq' => $enquiry->id
		);

		$newEmail = new Email;

		$newEmail->touser = $touserid;
		$newEmail->fromuser = $fromuserid;
		$newEmail->subject = $subject;
		$newEmail->body = $body;

		Mail::queue($emailView, $data, function($message) use ($touseremail, $subject)
		{
			$message->to($touseremail);
			$message->subject($subject);
		});

		$newEmail->save();

		if ($enquiry) {
			$emailenq = new EmailEnquiry;
			$emailenq->enquiryid = $enquiry->enquiryid;
			$emailenq->emailid = $newEmail->id;
			$emailenq->save();
		}
	}

	public static function generateUserConfirmationEmail($user)
	{
		$data = array('id' => $user->id, 'confirmation' => $user->confirmation);

		$subject = "Confirm your email";
		$email = $user->email;

		Mail::queue('emails.confirmation', $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});
	}

	public static function generateSubmissionEmail($user)
	{
		$data = array('firstname' => $user->getLatestHistory()->firstname);

		$emailView = 'emails.submission';

		$newEmail = new Email;

		$newEmail->touser = $user->id;
		$newEmail->fromuser = 0;
		$newEmail->subject = "Your submission has been sent for approval";
		$subject = $newEmail->subject;
		$email = $user->email;
		$newEmail->body = View::make($emailView)
			->with('firstname', $user->getLatestHistory()->firstname)
			->with('dbOnly', true)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();
	}

	public static function generateSubmissionEmailToAdmin($lead)
	{
		$user = $lead->getUser();
		$data = array('leadid' => $lead->id, 'userid' => $user->id, 'email' => $user->email, 'name' => $user->getName());

		$emailView = 'emails.admin.submission';

		$newEmail = new Email;

		$newEmail->touser = 0;
		$newEmail->fromuser = 0;
		$newEmail->subject = "A new lead has been submitted!";
		$subject = $newEmail->subject;
		$email = Preference::getAdminEmail();
		$newEmail->body = View::make($emailView)
			->with('leadid', $lead->id)
			->with('userid', $user->id)
			->with('email', $user->email)
			->with('name', $user->getName())
			->with('dbOnly', true)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();
	}

	public static function generateEnquiry($enquiry, $emailView, $isUser, $isUpdate)
	{
		$chef = User::find($enquiry->chefid);
		$user = User::find($enquiry->userid);
		$menu = Menu::find($enquiry->menuid);
		$date = DateTime::createFromFormat('Y-m-d', $enquiry->enquirydate);
		$data = array(
			'chef' => $chef->getName(),
			'user' => $user->getName(),
			'menu' => $menu->getLatestHistory()->title,
			'quantity' => $enquiry->quantity,
			'date' => $date->format('d/m/Y'),
			'reqs' => $enquiry->specialreq,
			'info' => $enquiry->additionalinfo,
			'venue' => $enquiry->venue,
			'time' => $enquiry->time,
			'usechefvenue' => $enquiry->usechefvenue,
			'enquiryid' => $enquiry->id
		);

		$newEmail = new Email;

		if (!$isUser) {
			$newEmail->touser = $chef->id;
			$newEmail->fromuser = $user->id;
			$email = $chef->email;
		}
		else {
			$newEmail->touser = $user->id;
			$newEmail->fromuser = 0;
			$email = $user->email;
		}

		if (!$isUpdate) {
			$newEmail->subject = "New enquiry for " . $enquiry->getMenuName();
		}
		else {
			$newEmail->subject = "Update for the enquiry for " . $enquiry->getMenuName();
		}
		$subject = $newEmail->subject;

		$newEmail->body = View::make($emailView)
			->with('chef', $chef->getName())
			->with('user', $user->getName())
			->with('menu', $menu->getLatestHistory()->title)
			->with('quantity', $enquiry->quantity)
			->with('date', $date->format('d/m/Y'))
			->with('reqs', $enquiry->specialreq)
			->with('info', $enquiry->additionalinfo)
			->with('venue', $enquiry->venue)
			->with('time', $enquiry->time)
			->with('usechefvenue', $enquiry->usechefvenue)
			->with('dbOnly', true)
			->with('enquiryid', $enquiry->id)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();

		if (!$isUpdate) {
			$emailenq = new EmailEnquiry;
			$emailenq->enquiryid = $enquiry->id;
			$emailenq->emailid = $newEmail->id;
			$emailenq->save();
		}
	}

	public static function generateEnquiryEmailToChef($enquiry)
	{
		Email::generateEnquiry($enquiry, 'emails.enquiry.enquiry-chef', false, false);
	}

	public static function generateEnquiryUpdateToChef($enquiry)
	{
		Email::generateEnquiry($enquiry, 'emails.enquiry.enquiry-chef-update', false, true);
	}

	public static function generateEnquiryEmailToUser($enquiry)
	{
		Email::generateEnquiry($enquiry, 'emails.enquiry.enquiry-user', true, false);
	}

	public static function generateEnquiryConfirmationToUser($enquiry)
	{
		$chef = User::find($enquiry->chefid);
		$user = User::find($enquiry->userid);
		$menu = Menu::find($enquiry->menuid);		
		$data = array(
			'chef' => $chef->getName(),
			'user' => $user->getName(),
			'enquiryid' => $enquiry->id,
		);

		$emailView = "emails.enquiry.confirmation";
		$newEmail = new Email;

		$newEmail->touser = $user->id;
		$newEmail->fromuser = 0;
		$email = $user->email;

		$newEmail->subject = "Enquiry Confirmation - " . $enquiry->getMenuName();
		$subject = $newEmail->subject;

		$newEmail->body = View::make($emailView)
			->with('chef', $chef->getName())
			->with('user', $user->getName())
			->with('enquiryid', $enquiry->id)
			->with('dbOnly', true)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();
	}

	public static function generateEnquiryPaid($emailView, $enquiry, $isUser)
	{
		$chef = User::find($enquiry->chefid);
		$user = User::find($enquiry->userid);
		$menu = Menu::find($enquiry->menuid);
		$date = DateTime::createFromFormat('Y-m-d', $enquiry->enquirydate);
		$data = array(
			'chef' => $chef->getName(),
			'user' => $user->getName(),
			'menu' => $enquiry->getMenuName(),
			'quantity' => $enquiry->quantity,
			'date' => $date->format('d/m/Y'),
			'time' => $enquiry->time,
			'venue' => $enquiry->venue,
			'reqs' => $enquiry->specialreq,
			'info' => $enquiry->additionalinfo,
			'usechefvenue' => $enquiry->usechefvenue,
			'price' => $enquiry->price,
			'surcharge' => $enquiry->getSurcharge(),
			'total' => $enquiry->getTotalPriceLessSurcharge()
		);

		$newEmail = new Email;

		if (!$isUser) {
			$newEmail->touser = $chef->id;
			$newEmail->fromuser = 0;
			$email = $chef->email;
		}
		else {
			$newEmail->touser = $user->id;
			$newEmail->fromuser = 0;
			$email = $user->email;
		}

		$newEmail->subject = "Enquiry Paid - " . $enquiry->getMenuName();
		$subject = $newEmail->subject;

		$newEmail->body = View::make($emailView)
			->with('chef', $chef->getName())
			->with('user', $user->getName())
			->with('menu', $enquiry->getMenuName())
			->with('quantity', $enquiry->quantity)
			->with('date', $date->format('d/m/Y'))
			->with('time', $enquiry->time)
			->with('venue', $enquiry->venue)
			->with('reqs', $enquiry->specialreq)
			->with('info', $enquiry->additionalinfo)
			->with('price', $enquiry->price)
			->with('surcharge', $enquiry->getSurcharge())
			->with('total', $enquiry->getTotalPriceLessSurcharge())
			->with('usechefvenue', $enquiry->usechefvenue)
			->with('dbOnly', true)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();
	}

	public static function generateEnquiryPaidToChef($enquiry)
	{
		Email::generateEnquiryPaid("emails.enquiry.paid-chef", $enquiry, false);
	}

	public static function generateEnquiryPaidToUser($enquiry)
	{
		Email::generateEnquiryPaid("emails.enquiry.paid-user", $enquiry, true);
	}

	public static function generateLeadQualifiedEmail($user)
	{
		$data = array(
			'firstname' => $user->getLatestHistory()->firstname,
			'chefname' => $user->chefname
		);
		$emailView = "emails.leadQualified";
		$newEmail = new Email;
		$newEmail->touser = $user->id;
		$newEmail->fromuser = 0;
		$email = $user->email;
		$newEmail->subject = "You have been approved as a chef!";
		$subject = $newEmail->subject;

		$newEmail->body = View::make($emailView)
			->with('chefname', $user->chefname)
			->with('firstname', $user->getLatestHistory()->firstname)
			->with('dbOnly', true)
			->render();

		Mail::queue($emailView, $data, function($message) use ($email, $subject)
		{
			$message->to($email);
			$message->subject($subject);
		});

		$newEmail->save();
	}
}
