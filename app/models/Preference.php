<?php

class Preference extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'preferences';
	
	public static function getAdminEmail()
	{
		return Preference::find(1)->adminemail;
	}

	public static function getUrl()
	{
		return Preference::find(1)->domain;
	}
}
