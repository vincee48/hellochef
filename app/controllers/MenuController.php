<?php

class MenuController extends BaseController {

	public function addMenu()
	{
		return View::make('my.settings.menu.add');
	}

	public function postAddMenu()
	{
		$validator = Validator::make(Input::all(), Menu::getValidationRules());

		if ($validator->fails())	{
			return Redirect::to('/my/settings/menu/add')
				->withErrors($validator)
				->withInput()
				->with('error_message', 'Invalid menu.');
		}
		else {
			$menu = new Menu;
			$menu->profileid = Auth::user()->getProfile()->id;
			$menu->save();

			$history = new MenuHistory;
			$history->menuid = $menu->id;
			$history->title = Input::get('title');
			$history->description = Input::get('description');
			//$history->cuisineid = Input::get('cuisineid');
			$history->minpax = Input::get('minpax');
			$history->maxpax = Input::get('maxpax');
			$history->price = Input::get('price');
			$history->tags = Input::get('tags');
			$history->save();

			return Redirect::to('/my/settings/menu/' . $menu->id)
				->with('info_message', 'Your menu has been added!');
		}
	}

	public function editMenu($id)
	{
		$menu = Menu::find($id);

		if ($menu && $menu->belongsToUser()) {
			return View::make('my.settings.menu.index', array('menu' => $menu, 'pics' => $menu->getPictures()));
		}

		return Redirect::to('/my/settings/menu')
			->with('error_message', 'Invalid menu.');
	}

	public function postEditMenu($id)
	{
		$menu = Menu::find($id);

		$validator = Validator::make(Input::all(), Menu::getValidationRules());

		if ($validator->fails() || ($menu && !$menu->belongsToUser()))	{
			return Redirect::to('/my/settings/menu/' . $id)			
				->with('error_message', 'Error with your input.')
				->withInput()
				->withErrors($validator);
		}
		else {
			$history = new MenuHistory;
			$history->menuid = $id;
			$history->title = Input::get('title');
			$history->description = Input::get('description');
			//$history->cuisineid = Input::get('cuisineid');
			$history->minpax = Input::get('minpax');
			$history->maxpax = Input::get('maxpax');
			$history->price = Input::get('price');			
			$history->tags = Input::get('tags');
			$history->save();
			
			return Redirect::to('/my/settings/menu')
				->with('info_message', 'Your menu has been updated!');
		}
	}

	public function addMenuItem($id)
	{
		return View::make('my.settings.menuitem.add', array('back' => '/my/settings/menu/'.$id, 'enquire' => false, 'history' => null));
	}

	public function postAddMenuItem($id)
	{
		$user = Auth::user();

		$validator = Validator::make(Input::all(), MenuItem::getValidationRules());

		if ($validator->fails()) {
			return Redirect::back()
				->withErrors($validator)
				->withInput()
				->with('info_message', 'Error with your input');
		}
		else {
			$menu = Menu::find($id);

			if ($menu && $menu->belongsToUser()) {
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

				return Redirect::to('/my/settings/menu/' . $id)
					->with('info_message', 'New menu item has been added!');
			}
			else {
				return Redirect::to('/my/settings/menu')
					->with('error_message', 'Invalid menu.');
			}
		}
	}

	public function editMenuItem($id, $menuitemid)
	{
		$menu = Menu::find($id);
		$menuitem = MenuItem::find($menuitemid);
		$back = "/my/settings/menu/" . $id;

		if ($menu && $menu->belongsToUser() && $menuitem && $menuitem->getMenu()->belongsToUser()) {
			return View::make('my.settings.menuitem.edit', array('item' => $menuitem, 'history' => $menuitem->getLatestHistory(), 'back' => $back, 'enquire' => false));
		}

		return Redirect::to('/my/settings/menu/{{ $id }}')
			->with('error_message', 'Invalid menu item.');
	}

	public function postEditMenuItem($id, $menuitemid)
	{
		$menu = Menu::find($id);
		$item = MenuItem::find($menuitemid);
		$user = $item->getUser();
		$rules = MenuItem::getValidationRules();

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails() || $user->id != Auth::id()) {
			return Redirect::to('/my/settings/menu/' . $id)
				->withErrors($validator)
				->with('error_message', "There has been an error with your input.");
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
			$history->menuitemid = $menuitemid;
			$history->name = Input::get('name');
			$history->description = Input::get('description');
			$history->updatedby = Auth::id();
			$history->save();

			$item->order = 0;//Input::get('order');
			$item->save();
		}
		return Redirect::to('/my/settings/menu/' . $id)
			->with('info_message', "Menu item updated successfully.");
	}

	public function publishMenuItem($id, $menuitemid)
	{
		$menu = Menu::find($id);
		$menuitem = MenuItem::find($menuitemid);

		if ($menu && $menu->belongsToUser() && $menuitem && $menuitem->getMenu()->belongsToUser()) {
			$menuitem->active = 1;
			$menuitem->save();

			return Redirect::to('/my/settings/menu/' . $id)
				->with('info_message', 'Menu item has been published.');
		}

		return Redirect::to('/my/settings/menu/' . $id)
			->with('error_message', 'Invalid menu item.');
	}

	public function unpublishMenuItem($id, $menuitemid)
	{
		$menu = Menu::find($id);
		$menuitem = MenuItem::find($menuitemid);

		if ($menu && $menu->belongsToUser() && $menuitem && $menuitem->getMenu()->belongsToUser()) {
			$menuitem->active = 0;
			$menuitem->save();

			return Redirect::to('/my/settings/menu/' . $id)
				->with('info_message', 'Menu item has been unpublished.');
		}

		return Redirect::to('/my/settings/menu/' . $id)
			->with('error_message', 'Invalid menu item.');
	}

	public function publishMenu($id)
	{
		$menu = Menu::find($id);

		if ($menu && $menu->belongsToUser()) {
			$menu->active = 1;
			$menu->save();

			return Redirect::to('/my/settings/menu')
				->with('info_message', 'Menu has been published.');
		}

		return Redirect::to('/my/settings/menu')
			->with('error_message', 'Invalid menu.');
	}

	public function unpublishMenu($id)
	{
		$menu = Menu::find($id);

		if ($menu && $menu->belongsToUser()) {
			$menu->active = 0;
			$menu->save();

			return Redirect::to('/my/settings/menu')
				->with('info_message', 'Menu has been unpublished.');
		}

		return Redirect::to('/my/settings/menu')
			->with('error_message', 'Invalid menu.');
	}

}
