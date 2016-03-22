<?php

class EmailEnquiry extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'emailenquiries';

	public static function getNonSystemMessages($id)
	{
		$emailenqs = EmailEnquiry::where('enquiryid', '=', $id)->orderby('created_at', 'desc')->get();
		$returnVal = array();

		foreach ($emailenqs as $emailenq)
		{
			$email = Email::find($emailenq->emailid);
			if (!$email->fromSystem()) {
				$returnVal[] = $emailenq;
			}
		}

		return $returnVal;
	}

	public function getEmail()
	{
		return Email::find($this->emailid);
	}
	
	public function getEnquiry()
	{
		return Enquiry::find($this->enquiryid);
	}
}
