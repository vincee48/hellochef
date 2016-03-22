<?php

class ProfileHistory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profileshistory';

	public function getProfile()
	{
		return Profile::find($this->profileid);
	}
}
