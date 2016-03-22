<?php

class UserController extends BaseController {

	public function getLogin()
	{
		return View::make('login');
	}

	public function postLogin()
	{
		$rules = array(
			'email' => 'required|email',
			'password' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('signin')
				->withErrors($validator)
				->withInput(Input::except('password'))
				->with('flash_error', 'There was an error with your login.');
		} else {
			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
			);

			if (Auth::attempt($userdata, Input::get('remember_me')))
			{
				return Redirect::intended('/');
			}
			else
			{
				return Redirect::to('signin')
					->withErrors($validator)
					->withInput(Input::except('password'))
					->with('flash_error', 'There was an error with your login.');
			}
		}
	}

	public function getSignup()
	{
		return View::make('signup');
	}

	public function postSignup()
	{
		$rules = array(
			'email' => 'required|email|unique:users',
			'password' => 'required|min:6|confirmed',
			'firstname' => 'required',
			'lastname' => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('/signup')
				->withErrors($validator)
				->withInput(Input::except('password'))
				->withInput(Input::except('password_confirmation'));
		}
		else {
			$user = new User;
			$user->password = Hash::make(Input::get('password'));
			$user->type = "user";
			$user->email = Input::get('email');
			$user->active = "1";
			$user->genConfirmation();
			$user->confirmed = 0;
			$user->save();

			$user->createdby = $user->id;
			$user->save();

			$userhistory = new UserHistory;
			$userhistory->firstname = Input::get('firstname');
			$userhistory->lastname = Input::get('lastname');
			$userhistory->updatedby = $user->id;
			$userhistory->userid = $user->id;
			$userhistory->save();

			$userdata = array(
				'email' => Input::get('email'),
				'password' => Input::get('password')
			);

			Auth::attempt($userdata, false);

			Email::generateUserConfirmationEmail($user);

			return Redirect::to('/');
		}
	}

	public function getReset()
	{
		return View::make('reset');
	}

	public function postReset()
	{
		$rules = array(
			'email' => 'required|email',
			'recaptcha_response_field' => 'required|recaptcha'
		);

		$validator = Validator::make(Input::all(), $rules);

		$user = User::where('email', '=', Input::get('email'))->first();

		if ($validator->fails()) {
			return Redirect::to('reset')
				->withErrors($validator)
				->withInput(Input::all())
				->with('error_message', 'Your input is invalid.');
		}
		else if (!$user) {
			return Redirect::to('reset')
				->withInput(Input::all())
				->with('error_message', 'The email you have entered does not exist.');
		}
		else {
			$user->genReset();
			$user->save();
			Email::generateResetPasswordEmail($user);
			return Redirect::to('reset')
				->with('info_message', 'An email has been sent to you with instructions on how to reset your password.');
		}
	}

	public function getResetPassword($id, $reset)
	{
		$user = User::find($id);

		if ($user->reset == $reset) {
			return View::make('resetPassword');
		}
		else {
			return Redirect::to('/');
		}
	}

	public function postResetPassword($id, $reset)
	{
		$rules = array(
			'password' => 'required|min:6|confirmed'
		);

		$validator = Validator::make(Input::all(), $rules);

		$user = User::find($id);

		if ($validator->fails() || $user->reset != $reset) {
			return Redirect::to('resetPassword')
				->withErrors($validator)
				->withInput(Input::all())
				->with('error_message', 'Your input is invalid.');
		}
		else {
			$user->reset = "";
			$user->password = Hash::make(Input::get('password'));
			$user->save();

			return Redirect::to('signin')
				->with('info_message', 'Your password has been updated!');
		}
	}

	public function confirm()
	{
		if (Auth::check()) {
			return View::make('confirm');
		}

		return Redirect::to('/');
	}

	public function resendConfirmation()
	{
		if (Auth::check()) {
			$rules = array(
				'email' => 'required|email',
				'recaptcha_response_field' => 'required|recaptcha'
			);

			$validator = Validator::make(Input::all(), $rules);

			if ($validator->fails()) {
				return Redirect::to('/confirm')
					->withErrors($validator);
			}
			else {
				$user = Auth::user();
				$count = User::where('email', '=', Input::get('email'))->count();

				if ($user->email != Input::get('email') && $count == 0) {
					$user->email = Input::get('email');
				}
				else if ($user->email != Input::get('email') && $count > 0) {
					return Redirect::to('/confirm')
						->with('error_message', 'Email address has already been taken!');
				}

				$user->genConfirmation();
				$user->save();
				Email::generateUserConfirmationEmail($user);

				return Redirect::to('/');
			}
		}

		return Redirect::to('/');
	}

	public function confirmed()
	{
		return View::make('confirmed');
	}

	public function confirmAccount($id, $confirmation)
	{
		$user = User::where('id', '=', $id)->first();

		if (!$user->confirmed)
		{
			if ($confirmation === $user->confirmation)
			{
				$user->confirmed = 1;
				$user->save();

				Auth::login($user);
				return Redirect::to('/confirmed');
			}
			else
			{
				return Redirect::to('/');
			}
		}

		return Redirect::to('/');
	}

	public function logout()
	{
		Auth::logout();

		return Redirect::to('/');
	}
}
