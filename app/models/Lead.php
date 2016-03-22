<?php

class Lead extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'leads';

	public static function getLeadForUser($id)
	{
		$lead = Lead::where('userid', '=', $id)->first();

		if ($lead) {
			return $lead;
		}
		else {
			return new Lead;
		}
	}

	public static function isChefNameUnique($name)
	{
		return (Lead::where('chefname', '=', $name)->count() == 0) && (User::where('chefname', '=', $name)->count() == 0);
	}

	public static function getNumberOfCompletedLeads()
	{
		return Lead::where('step4', '=', '1')->where('qualified', '=', 0)->count();
	}

	public function getUser()
	{
		return User::where('id', '=', $this->userid)->first();
	}

	public function getProfile()
	{
		return Profile::where('id', '=', $this->profileid)->first();
	}

	public function getMenu()
	{
		return Menu::where('id', '=', $this->menuid)->first();
	}

	public function qualify()
	{
		$user = $this->getUser();
		$user->chefname = $this->chefname;
		$user->save();

		$profile = $this->getProfile();
		$profile->active = 1;
		$profile->save();

		$menu = $this->getMenu();
		$menu->active = 1;
		$menu->save();

		$this->qualified = 1;
		$this->save();

		Email::generateLeadQualifiedEmail($user);
	}

	public function isReady()
	{
		return $this->step4;
	}
}
