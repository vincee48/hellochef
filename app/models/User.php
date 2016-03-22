<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
    protected $dates = ['trial_ends_at', 'subscription_ends_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function genConfirmation()
	{
		$this->confirmation = str_random(40);
	}

	public function genReset()
	{
		$this->reset = str_random(55);
	}

	public function getLatestHistory()
	{
		return UserHistory::where('userid', '=', $this->id)->orderby('updated_at', 'desc')->first();
	}

	public function getProfile()
	{
		$profile = Profile::where('userid', '=', $this->id)->where('active', '=', '1')->first();

		return $profile ? $profile : new Profile;
	}

	public function getName()
	{
		$history = $this->getLatestHistory();
		return $history->firstname . " " . $history->lastname;
	}

	public function getProfilePicture()
	{
		return Document::where('userid', '=', $this->id)->where('isprofilepic', '=', 1)->orderby('updated_at', 'desc')->first();
	}

	public function hasCompletedAccount()
	{
		$history = $this->getLatestHistory();
		return $history->firstname && $history->lastname;
	}

	public function canUseProfile()
	{
		return $this->chefname !== "";
	}

	public function isChef()
	{
		return $this->chefname !== "";
	}

	public function isAdmin()
	{
		return $this->type === 'admin';
	}
}
