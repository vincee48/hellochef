<?php

class MenuItem extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menuitems';

	public static function getValidationRules()
	{
		return array(
			'name' => 'required',
			'description' => 'required',
			'picture' => 'image',
		);
	}

	public function getUser()
	{
		$menu = $this->getMenu();
		$profile = $menu->getProfile();

		return $profile->getUser();
	}

	public function getLatestHistory()
	{
		return MenuItemHistory::where('menuitemid', '=', $this->id)->orderby('updated_at', 'desc')->first();
	}

	public function getMenu()
	{
		return Menu::find($this->menuid);
	}

	public function getPicture()
	{
		return Document::where('id', '=', $this->documentid)->where('isprofilepic', '=', 0)->orderby('updated_at', 'desc')->first();
	}
}
