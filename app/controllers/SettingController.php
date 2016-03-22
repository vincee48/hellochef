<?php

class SettingController extends BaseController {

	public function settings()
	{
		$user = User::find(Auth::user()->id);
		$latest = $user->getLatestHistory();
		$profile = $user->getProfile()->getLatestHistory();
		$menus = $user->getProfile()->getMenus();

		return View::make('my.settings.index', array('userhistory' => $latest, 'profile' => $profile, 'menus' => $menus));
	}

	public function updateProfile($id)
	{
		$user = User::find($id);
		$profile = $user->getProfile();

		$rules = array(
			'aboutme' => 'required',
			'experience' => 'required',
			'profilepic' => 'image',
			'state' => 'required',
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->with('error_message', 'There has been an error with your input.');
		}
		else {
			if (Input::hasFile('profilepic')) {
				$file = Input::file('profilepic');
				if ($file->isValid()) {					
					$olddoc = $user->getProfilePicture();
					if ($olddoc) {
						$olddoc->delete();
					}
					$doc = new Document;
					$doc->userid = $user->id;
					$doc->uploadedby = Auth::id();
					$doc->filename = str_random(20) . "." . $file->getClientOriginalExtension();
					$doc->filetype = $file->getMimeType();
					$doc->filesize = $file->getSize();
					$doc->filecontent = file_get_contents($file);
					$doc->isprofilepic = 1;
					$doc->save();
				}
			}
			// Create new profile if it does not exist already
			if (!$profile) {
				$profile = new Profile;
				$profile->active = 1;
				$profile->createdby = Auth::id();
				$profile->userid = Auth::id();
				$profile->save();
			}

			$profilehistory = new ProfileHistory;
			$profilehistory->aboutme = Input::get('aboutme');
			$profilehistory->experience = Input::get('experience');
			$profilehistory->updatedby = Auth::id();
			$profilehistory->profileid = $profile->id;
			$profilehistory->save();

			$profile->useownvenue = Input::get('useownvenue');
			$profile->state = Input::get('state');
			$profile->save();

			return Redirect::back()
				->with('info_message', 'Your details have been successfully updated.');
		}
	}

	public function updateAccount($id)
	{
		$user = User::find($id);

		if (Input::get('email') == $user->email) {
			$rules = array(
				'email' => 'required|email',
				'password' => 'required',
				'newpassword' => 'confirmed|min:6',
				'firstname' => 'required',
				'lastname' => 'required'
			);
		}
		else {
			$rules = array(
				'email' => 'required|email|unique:users',
				'password' => 'required',
				'newpassword' => 'confirmed|min:6',
				'firstname' => 'required',
				'lastname' => 'required'
			);
		}

		$validator = Validator::make(Input::all(), $rules);

		$passwordConfirmed = Hash::check(Input::get('password'), $user->password);

		if ($validator->fails()) {
			return Redirect::to('/my/settings')
				->withErrors($validator)
				->withInput(Input::except('password'))
				->with('prevSettingPage', '.account');
		}
		else if (!$passwordConfirmed) {
			return Redirect::to('/my/settings/account')
				->with('error_message', 'Your password did not match the current password.');
		}
		else {
			$latest = $user->getLatestHistory();
			$userhistory = new UserHistory;
			$userhistory->userid = $id;
			$userhistory->firstname = Input::get('firstname');
			$userhistory->middlename = Input::get('middlename');
			$userhistory->lastname = Input::get('lastname');
			$user->email = Input::get('email');
			$userhistory->updatedby = Auth::id();
			$userhistory->save();

			if (Input::has('newpassword')) {
				$user->password = Hash::make(Input::get('newpassword'));
			}
			$user->save();

			return Redirect::to('/my/settings')
				->with('info_message', 'Your details have been successfully updated.');
		}
	}

	public function settingsAccount()
	{
		return Redirect::to('/my/settings')
			->with('prevSettingPage', '.account')
			->with('info_message', Session::get('info_message'))
			->with('error_message', Session::get('error_message'));
	}

	public function settingsMenu()
	{
		return Redirect::to('/my/settings')
			->with('prevSettingPage', '.menu')
			->with('info_message', Session::get('info_message'))
			->with('error_message', Session::get('error_message'));
	}

	public function settingsProfile()
	{
		return Redirect::to('/my/settings')
			->with('prevSettingPage', '.profile')
			->with('info_message', Session::get('info_message'))
			->with('error_message', Session::get('error_message'));
	}

}
