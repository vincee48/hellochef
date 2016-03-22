<?php

class UserHistory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usershistory';

	public function getUser()
	{
		return User::find($this->userid);
	}
}
