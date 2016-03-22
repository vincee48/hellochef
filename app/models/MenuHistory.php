<?php

class MenuHistory extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menushistory';
	
	public function getCuisine()
	{
		return Cuisine::find($this->cuisineid)->name;
	}
	
	public function getPrice()
	{
		return number_format($this->price, 2);
	}
	
}
