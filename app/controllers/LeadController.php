<?php

class LeadController extends BaseController {

	public function latestEnquiry()
	{
		$lead = Lead::getLeadForUser(Auth::id());

		if (!Auth::user()->hasCompletedAccount()) {
			return Redirect::to('/my/settings/account')
				->with('info_message', 'You have not completed your account information yet!');
		}

		if ($lead->step4 && Auth::user()->accountnum && Auth::user()->bsb) {
			return Redirect::to('/my/become-a-chef/step-6');
		}
		else if ($lead->step4) {
			return Redirect::to('/my/become-a-chef/step-5');
		}
		else if ($lead->step3) {
			return Redirect::to('/my/become-a-chef/step-4');
		}
		else if ($lead->step2) {
			return Redirect::to('/my/become-a-chef/step-3');
		}
		else if ($lead->step1) {
			return Redirect::to('/my/become-a-chef/step-2');
		}

		return Redirect::to('/my/become-a-chef/step-1');
	}

	public function enquiry($page)
	{
		$lead = Lead::getLeadForUser(Auth::id());
		$leadProfile = $lead->getProfile();
		$leadMenu = $lead->getMenu();

		if (!Auth::user()->hasCompletedAccount()) {
			return Redirect::to('/my/settings/account')
				->with('info_message', 'You have not completed your account information yet!');
		}

		switch ($page)
		{
			case 1:
				return View::make('my.enquire.step1', array('lead' => $lead));
				break;
			case 2:
				if ($lead->step1) {
					$profHistory = $leadProfile->getLatestHistory();
					return View::make('my.enquire.step2', array('leadProfile' => $profHistory, 'lead' => $lead));
				}
				break;
			case 3:
				if ($lead->step2) {
					$menuHistory = $leadMenu->getLatestHistory();
					$pics = $leadMenu->getPictures();
					return View::make('my.enquire.step3', array('leadMenu' => $menuHistory, 'lead' => $lead, 'pics' => $pics));
				}
				break;
			case 4:
				if ($lead->step3) {
					$menuitems = $leadMenu->getMenuItems();
					return View::make('my.enquire.step4', array('menuitems' => $menuitems, 'lead' => $lead));
				}
				break;
			case 5:
				if ($lead->step4) {
					return View::make('my.enquire.step5', array('user' => Auth::user()));
				}
				break;
			case 6:
				if ($lead->step4 && Auth::user()->bsb && Auth::user()->accountnum) {
					return View::make('my.enquire.submitted', array('lead' => $lead));
				}
				break;
		}

		return Redirect::to('/my/become-a-chef/step-1');
	}

	public function getAddNewMenuItem()
	{
		return View::make('my.settings.menuitem.add', array('back' => '/my/become-a-chef/step-4', 'enquire' => false, 'history' => null));
	}

	public function getEditMenuItem()
	{
		$id = Session::get('id');
		$item = MenuItem::find($id);
		$history = $item->getLatestHistory();
		return View::make('my.settings.menuitem.edit', array('item' => $item, 'history' => $history, 'back' => "/my/become-a-chef/step-4", 'enquire' => true));
	}

	public function postEditMenuItem($id)
	{
		$item = MenuItem::find($id);
		$user = $item->getMenu()->getProfile()->getUser();
		$rules = MenuItem::getValidationRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails() || $user->id != Auth::id()) {
			return Redirect::to('/my/become-a-chef/step-4/edit')
				->withErrors($validator)
				->with('id', $id);
		}
		else {
			if (Input::hasFile('picture')) {
				$file = Input::file('picture');
				if ($file->isValid()) {
					$doc = new Document;
					$doc->userid = $user->id;
					$doc->uploadedby = $user->id;
					$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
					$doc->filetype = $file->getMimeType();
					$doc->filesize = $file->getSize();
					$doc->filecontent = file_get_contents($file);
					$doc->save();
					$item->documentid = $doc->id;
					$item->save();
				}
			}

			$history = new MenuItemHistory;
			$history->menuitemid = $id;
			$history->name = Input::get('name');
			$history->description = Input::get('description');
			$history->updatedby = Auth::id();
			$history->save();

			$item->order = 0;//Input::get('order');
			$item->save();
		}
		return Redirect::to('/my/become-a-chef/step-4')
			->with('id', $id)
			->with('info_message', "Menu item updated successfully.");
	}
	
	public function unpublishMenuItem($menuid, $menuitemid) 
	{		
		$menu = Menu::find($menuid);
		$menuitem = MenuItem::find($menuitemid);

		if ($menu && $menu->belongsToUser() && $menuitem && $menuitem->getMenu()->belongsToUser()) {
			$menuitem->active = 0;
			$menuitem->save();

			return Redirect::to('/my/become-a-chef/step-4/')
				->with('info_message', 'Menu item has been unpublished.');
		}

		return Redirect::to('/my/become-a-chef/step-4/')
			->with('error_message', 'Invalid menu item.');			
	}

	public function deleteMenuItem()
	{
		$id = Session::get('id');
		$item = MenuItem::find($id);
		$item->active = 0;
		$item->save();
		return Redirect::to('/my/become-a-chef/step-4')
			->with('info_message', 'Menu item has been deleted');
	}

	public function menuItemPerformAction()
	{
		$action = Input::get('action');
		$id = Input::get('id');

		switch ($action)
		{
			case "Edit":
				$item = MenuItem::find($id);
				if ($item && $item->getMenu()->getProfile()->userid == Auth::id()) {
					return Redirect::to('/my/become-a-chef/step-4/edit')->with('id', $item->id);
				}
				break;
			case "Delete":
				$item = MenuItem::find($id);
				if ($item && $item->getMenu()->getProfile()->userid == Auth::id()) {
					return Redirect::to('/my/become-a-chef/step-4/delete')->with('id', $item->id);
				}
				break;
		}
		return Redirect::to('/');
	}

	public function postAddNewMenuItem()
	{
		$user = Auth::user();
		$lead = Lead::getLeadForUser($user->id);

		$validator = Validator::make(Input::all(), MenuItem::getValidationRules());

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('info_message', 'Error with your input');
		}
		else {
			$menu = $lead->getMenu();

			$menuItem = new MenuItem;
			$menuItem->menuid = $menu->id;
			$menuItem->createdby = $user->id;
			$menuItem->active = 1;
			$menuItem->order = 0;//Input::get('order');

			if (Input::hasFile('picture')) {
				$file = Input::file('picture');
				if ($file->isValid()) {
					$doc = new Document;
					$doc->userid = $user->id;
					$doc->uploadedby = $user->id;
					$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
					$doc->filetype = $file->getMimeType();
					$doc->filesize = $file->getSize();
					$doc->filecontent = file_get_contents($file);
					$doc->save();
					$menuItem->documentid = $doc->id;
				}
			}
			$menuItem->save();

			$history = new MenuItemHistory;
			$history->menuitemid = $menuItem->id;
			$history->name = Input::get('name');
			$history->description = Input::get('description');
			$history->updatedby = $user->id;
			$history->save();

			return Redirect::to('/my/become-a-chef/step-4')
				->with('info_message', 'New menu item has been added!');
		}
	}

	public function postStepOne()
	{
		$lead = Lead::getLeadForUser(Auth::id());

		$rules = array(
			'chefname' => 'required|min:3|alphabet_dash',
			'state' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('/my/become-a-chef/step-1')
				->withErrors($validator)
				->withInput()
				->with('info_message', 'Error with your input');
		}
		else {
			$noexists = $lead->chefname == Input::get('chefname') || Lead::isChefNameUnique(Input::get('chefname'));
			if ($noexists) {
				$lead->userid = Auth::id();
				$lead->chefname = Input::get('chefname');
				$lead->step1 = 1;

				// Initialize the profile
				if ($lead->profileid == 0) {
					$leadProfile = new Profile;
					$leadProfile->userid = Auth::id();
					$leadProfile->createdby = Auth::id();
					$leadProfile->save();
					$lead->profileid = $leadProfile->id;
				}
				$leadProfile = $lead->getProfile();
				$leadProfile->state = Input::get('state');
				$leadProfile->save();
				if ($lead->menuid == 0) {
					$leadMenu = new Menu;
					$leadMenu->profileid = $lead->profileid;
					$leadMenu->save();
					$lead->menuid = $leadMenu->id;
				}

				$lead->save();
				return Redirect::to('/my/become-a-chef/step-1')
					->with('info_message', 'Your personal URL has been updated!');
			}
			else {
				return Redirect::to('/my/become-a-chef/step-1')
					->withErrors($validator)
					->with('error_message', 'Personal URL is already taken!');
			}
		}
	}

	public function postStepTwo()
	{
		$lead = Lead::getLeadForUser(Auth::id());
		$leadProfile = $lead->getProfile();
		$user = Auth::user();

		$rules = array(
			'profilepic' => 'image',
			'aboutme' => 'required',
			'experience' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('/my/become-a-chef/step-2')
				->withErrors($validator)
				->withInput()
				->with('error_message', 'Error with your input');
		}
		else {
			if (Input::hasFile('profilepic')) {
				$file = Input::file('profilepic');
				if ($file->isValid()) {							
					$olddoc = Auth::user()->getProfilePicture();
					if ($olddoc) {
						$olddoc->delete();
					}
					$doc = new Document;
					$doc->userid = $user->id;
					$doc->uploadedby = $user->id;
					$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
					$doc->filetype = $file->getMimeType();
					$doc->filesize = $file->getSize();
					$doc->filecontent = file_get_contents($file);
					$doc->isprofilepic = 1;
					$doc->save();
				}
			}

			$profilehistory = new ProfileHistory;
			$profilehistory->aboutme = Input::get('aboutme');
			$profilehistory->experience = Input::get('experience');
			$profilehistory->updatedby = Auth::id();
			$profilehistory->profileid = $leadProfile->id;
			$profilehistory->save();

			$leadProfile->useownvenue = Input::get('useownvenue');
			$leadProfile->save();

			$lead->step2 = 1;
			$lead->save();

			return Redirect::to('/my/become-a-chef/step-2')
				->with('info_message', 'Your profile has been updated!');
		}
	}

	public function postStepThree()
	{
		$lead = Lead::getLeadForUser(Auth::id());

		$minpax = Input::get('minpax');
		$maxpax = Input::get('maxpax');

		$rules = Menu::getValidationRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails() || $minpax > $maxpax || $minpax <= 0 || $maxpax <= 0) {
			return Redirect::to('/my/become-a-chef/step-3')
				->withErrors($validator)
				->withInput()
				->with('error_message', 'Error with your input');
		}
		else {
			$menuhistory = new MenuHistory;
			$menuhistory->menuid = $lead->menuid;
			$menuhistory->title = Input::get('title');
			$menuhistory->description = Input::get('description');
			//$menuhistory->cuisineid = Input::get('cuisineid');
			$menuhistory->minpax = Input::get('minpax');
			$menuhistory->maxpax = Input::get('maxpax');
			$menuhistory->price = Input::get('price');
			$menuhistory->tags = Input::get('tags');
			$menuhistory->save();

			$lead->step3 = 1;
			$lead->save();

			return Redirect::to('/my/become-a-chef/step-3')
				->with('info_message', 'Your menu has been saved!');
		}
	}

	public function postStepFour()
	{
		$lead = Lead::getLeadForUser(Auth::id());

		$lead->step4 = 1;
		$lead->save();

		return Redirect::to('/my/become-a-chef/step-5');
	}

	public function submitForApproval()
	{
		$lead = Lead::getLeadForUser(Auth::id());

		$rules = array(
			'bsb' => 'required',
			'accountnum' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()
				->withInput(Input::all())
				->withErrors($validator)
				->with('error_message', 'Error with your input');
		}
		else {
			$user = Auth::user();
			if (!$lead->qualified && !$user->bsb && !$user->accountnum)
			{
				Email::generateSubmissionEmail(Auth::user());
				Email::generateSubmissionEmailToAdmin($lead);
			}
			$user->bsb = Input::get('bsb');
			$user->accountnum = Input::get('accountnum');
			$user->save();

			return Redirect::to('/my/become-a-chef/step-6');
		}
	}
}
