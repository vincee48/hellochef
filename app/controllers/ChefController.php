<?php

class ChefController extends BaseController {

	public function getProfile($chefname)
	{
		$chef = User::where('chefname', '=', $chefname)->first();

		$profile = "";
		if ($chef) {
			$profile = $chef->getProfile();
		}
		return View::make('chef.profile', array('chef' => $chef, 'profile' => $profile, 'chefname' => $chefname, 'preview' => false));
	}

	public function getMenu($chefname, $menuid)
	{
		$chef = User::where('chefname', '=', $chefname)->first();
		$menu = Menu::find($menuid);

		if ($chef && $menu && $menu->active) {
			return View::make('chef.menu', array('chef' => $chef, 'profile' => $chef->getProfile(), 'chefname' => $chef->chefname, 'preview' => false, 'menu' => $menu));
		}
		else {
			return Redirect::to('/')
				->with('error_message', 'There has been an error with your request.');
		}
	}

}
