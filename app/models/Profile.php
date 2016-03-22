<?php

class Profile extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'profiles';

	public function getLatestHistory()
	{
		return ProfileHistory::where('profileid', '=', $this->id)->orderby('updated_at', 'desc')->first();
	}

	public function getUser()
	{
		return User::where('id', '=', $this->userid)->first();
	}

	public function getMenus()
	{
		return Menu::where('profileid', '=', $this->id)->get();
	}

	public function getActiveMenus()
	{
		return Menu::where('profileid', '=', $this->id)->where('active', '=', '1')->get();
	}

	public function hasReviews()
	{
		return Review::where('profileid', '=', $this->id)->count() > 0;
	}
}
