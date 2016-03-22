<?php

class MailController extends BaseController {

	public function mailbox()
	{
		$id = Auth::id();
		$emails = Email::where('touser', '=', $id)->orderBy('created_at', 'desc')->get();
		$sentemails = Email::where('fromuser', '=', $id)->orderBy('created_at', 'desc')->get();

		return View::make('my.mailbox.index', array('emails' => $emails, 'sentemails' => $sentemails, 'sent' => false, 'viewemail' => null));
	}

	public function sentMailbox()
	{
		$id = Auth::id();
		$emails = Email::where('touser', '=', $id)->orderBy('created_at', 'desc')->get();
		$sentemails = Email::where('fromuser', '=', $id)->orderBy('created_at', 'desc')->get();

		return View::make('my.mailbox.index', array('emails' => $emails, 'sentemails' => $sentemails, 'sent' => true, 'viewemail' => null));
	}

	public function getMail($id)
	{
		$userid = Auth::id();
		$mail = Email::find($id);

		if (!$mail->read) {
			$mail->read = 1;
			$mail->save();
		}

		$emails = Email::where('touser', '=', $userid)->orderBy('created_at', 'desc')->get();
		$sentemails = Email::where('fromuser', '=', $userid)->orderBy('created_at', 'desc')->get();

		if ($userid == $mail->touser) {
			return View::make('my.mailbox.index', array('emails' => $emails, 'sentemails' => $sentemails, 'viewemail' => $mail, 'sent' => false));
		}
		else {
			return Redirect::to('/my/mailbox')
				->with('info_message', 'Invalid email.');
		}
	}

	public function replyMail($id)
	{
		$userid = Auth::id();
		$mail = Email::find($id);

		$rules = array(
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if (!$validator->fails() && $mail->canReply()) {
			$body = Input::get('body');
			
			Email::generateEmailReply($body, $mail);

			return Redirect::to('/my/mailbox')
				->with('info_message', 'Your message has been sent!');
		}
		else {
			return Redirect::back()
				->withErrors($rules)
				->with('error_message', 'There was an error with your input.');
		}
	}

	public function replyEnquiry($id)
	{
		$userid = Auth::id();
		$mail = Email::find($id);

		$rules = array(
			'body' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if (!$validator->fails() && $mail->canReply()) {
			$body = Input::get('body');
			
			if (!$mail->getEnquiry()->paid) {
				$replacement = "[removed]";			
				$emailpattern = "/[^@\s]*@[^@\s]*\.[^@\s]*/";
				$body = preg_replace($emailpattern, $replacement, $body);

				$urlpattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
				$body = preg_replace($urlpattern, $replacement, $body);
				
				$phonepattern = "/\(?(?:\+?61|0)(?:(?:2\)?[ -]?(?:3[ -]?[38]|[46-9][ -]?[0-9]|5[ -]?[0-35-9])|3\)?(?:4[ -]?[0-57-9]|[57-9][ -]?[0-9]|6[ -]?[1-67])|7\)?[ -]?(?:[2-4][ -]?[0-9]|5[ -]?[2-7]|7[ -]?6)|8\)?[ -]?(?:5[ -]?[1-4]|6[ -]?[0-8]|[7-9][ -]?[0-9]))(?:[ -]?[0-9]){6}|4\)?[ -]?(?:(?:[01][ -]?[0-9]|2[ -]?[0-57-9]|3[ -]?[1-9]|4[ -]?[7-9]|5[ -]?[018])[ -]?[0-9]|3[ -]?0[ -]?[0-5])(?:[ -]?[0-9]){5})*/";
				$body = preg_replace($phonepattern, $replacement, $body);
			}
			Email::generateEmailReply($body, $mail);

			return Redirect::back()
				->with('info_message', 'Your message has been sent!');
		}
		else {
			return Redirect::back()
				->withErrors($rules)
				->with('error_message', 'There was an error with your input.');
		}
	}

	public function getSentMail($id)
	{
		$userid = Auth::id();
		$mail = Email::find($id);
		$emails = Email::where('touser', '=', $userid)->orderBy('created_at', 'desc')->get();
		$sentemails = Email::where('fromuser', '=', $userid)->orderBy('created_at', 'desc')->get();

		if ($userid == $mail->fromuser) {
			return View::make('my.mailbox.index', array('emails' => $emails, 'sentemails' => $sentemails, 'viewemail' => $mail, 'sent' => true));
		}
		else {
			return Redirect::to('/my/mailbox')
				->with('info_message', 'Invalid email.');
		}
	}
}
