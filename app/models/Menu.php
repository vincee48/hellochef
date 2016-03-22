<?php

class Menu extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menus';

	public function belongsToUser()
	{
		return $this->getProfile()->getUser()->id == Auth::id();
	}

	public function getLatestHistory()
	{
		return MenuHistory::where('menuid', '=', $this->id)->orderby('updated_at', 'desc')->first();
	}

	public function getMenuItems()
	{
		return MenuItem::where('menuid', '=', $this->id)->where('active', '=', 1)->orderby('order', 'asc')->get();
	}

	public function getAllMenuItems()
	{
		return MenuItem::where('menuid', '=', $this->id)->orderby('order', 'asc')->get();
	}

	public function getProfile()
	{
		return Profile::where('id', '=', $this->profileid)->first();
	}

	public function getPictures()
	{
		return MenuDocument::where('menuid', '=', $this->id)->get();
	}

	public function getFirstPicture()
	{
		return MenuDocument::where('menuid', '=', $this->id)->first();
	}

	public static function getValidationRules()
	{
		return array(
			'title' => 'required',
			'description' => 'required',
			'tags' => 'required',
			'minpax' => 'required|integer',
			'maxpax' => 'required|integer',
			'price' => 'required|numeric',
		);
	}

	public static function getNumberArrayWithAny()
	{
		$arr[""] = "Any";

		for ($i = 1; $i < 25; $i++) {
			$arr[$i] = $i;
		}

		$arr["25+"] = "25+";

		return $arr;
	}
}
