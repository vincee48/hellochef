<?php

class AdminController extends BaseController {

	public function users()
	{
		$users = User::orderBy('created_at', 'desc')->get();
		return View::make('admin.users', array('users' => $users));
	}
	
	public function getUser($id)
	{
		$user = User::find($id);
		return View::make('admin.users.view', array('user' => $user));
	}

	public function getChef($chefname)
	{
		$user = User::where('chefname', '=', $chefname)->first();
		return View::make('admin.chef.view', array('user' => $user));
	}
	
	public function enquiries()
	{
		$enquiries = Enquiry::orderBy('id', 'desc')->get();
		return View::make('admin.enquiries', array('enquiries' => $enquiries));
	}

	public function cuisines()
	{
		$cuisines = Cuisine::all();
		return View::make('admin.cuisines', array('cuisines' => $cuisines));
	}

	public function cuisinesAdd()
	{
		return View::make('admin.cuisines.add');
	}

	public function cuisinesAddPost()
	{
		$validator = Validator::make(Input::all(), Cuisine::getValidationRules());

		if ($validator->fails()) {
			return Redirect::to('/admin/cuisines/add')
				->withErrors($validator)
				->withInput(Input::all());
		}
		else {
			$cuisine = new Cuisine;
			$cuisine->name = Input::get('name');
			$cuisine->active = 1;
			$cuisine->save();

			return Redirect::to('/admin/cuisines');
		}
	}

	public function publishCuisine($id)
	{
		$cuisine = Cuisine::find($id);

		if ($cuisine) {
			$cuisine->active = 1;
			$cuisine->save();
		}

		return Redirect::to('/admin/cuisines');
	}

	public function unpublishCuisine($id)
	{
		$cuisine = Cuisine::find($id);

		if ($cuisine) {
			$cuisine->active = 0;
			$cuisine->save();
		}

		return Redirect::to('/admin/cuisines');
	}

	public function leads()
	{
		$leads = Lead::orderBy('created_at', 'desc')->get();
		return View::make('admin.leads', array('leads' => $leads));
	}

	public function viewLead($id)
	{
		$lead = Lead::find($id);

		if ($lead && $lead->isReady()) {
			if ($lead->qualified) {
				return Redirect::to('/chef/' . $lead->chefname);
			}
			return View::make('chef.profile', array('chef' => $lead->getUser(), 'profile' => $lead->getProfile(), 'chefname' => $lead->chefname, 'id' => $lead->id, 'preview' => true));
		}
		else {
			return Redirect::to('/admin/leads')
				->with('error_message', 'Lead is not ready yet');
		}
	}

	public function viewLeadMenu($id, $menuid)
	{
		$lead = Lead::find($id);
		$menu = Menu::find($menuid);

		if ($lead && $menu && $lead->isReady()) {
			if ($lead->qualified) {
				return Redirect::to('/chef/' . $lead->chefname);
			}
			return View::make('chef.menu', array('chef' => $lead->getUser(), 'profile' => $lead->getProfile(), 'chefname' => $lead->chefname, 'preview' => true, 'id' => $lead->id, 'menu' => $menu));
		}
		else {
			return Redirect::to('/admin/leads')
				->with('error_message', 'Lead is not ready yet');
		}
	}

	public function qualifyLead($id)
	{
		$lead = Lead::find($id);

		if ($lead && $lead->isReady()) {
			if ($lead->qualified) {
				return Redirect::to('/admin/leads')
					->with('error_message', 'Lead has already been qualified!');
			}
			else {
				$lead->qualify();

				return Redirect::to('/admin/leads')
					->with('info_message', 'Lead ' . $lead->chefname . ' is now qualified');
			}
		}
		else {
			return Redirect::to('/admin/leads')
				->with('error_message', 'Lead is not ready yet');
		}
	}

	public function viewMailbox()
	{
		$emails = Email::orderBy('created_at', 'desc')->get();

		return View::make('admin.mailbox', array('emails' => $emails, 'email' => null, 'folder' => 'admin'));
	}

	public function getMail($id)
	{
		$mail = Email::find($id);
		return View::make('admin.mailbox', array('email' => $mail, 'folder' => 'admin', 'back' => 'admin'));
	}

	public function dashboard()
	{
		$user = Auth::user();
		$profile = $user->getProfile();

		return View::make("admin.dashboard", array('profile' => $profile, 'user' => $user));
	}

	public function migrateCuisines()
	{
		$all_history = MenuHistory::all();
		
		foreach ($all_history as $hist)
		{
			if ($hist->tags == "") {
				$cuisine = Cuisine::getCuisine($hist->cuisineid);
				$hist->tags = $cuisine;
				$hist->save();
			}
		}
		
		echo "Successfully migrated cuisines to tags!";
	}
}
