<?php

class MenuItemHistory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menuitemshistory';

	public function getPrice()
	{
		return number_format($this->alacarteprice, 2);
	}

	public function getMenuItem()
	{
		return MenuItem::find($this->menuitemid);
	}
}
