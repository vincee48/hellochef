<?php

class Cuisine extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cuisines';	
	
	public static function getOrderedArrayWithAny()
	{
		$arr[""] = "Any";
		
		$arr = Cuisine::getOrderedArrayGeneric($arr);

		return $arr;
	}
	
	public static function getOrderedArray()
	{
		$arr[""] = "";
		
		$arr = Cuisine::getOrderedArrayGeneric($arr);
				
		return $arr;
	}
	
	public static function getOrderedArrayGeneric($arr)
	{
		$cuisines = Cuisine::where('active', '=', '1')->orderBy('name', 'asc')->get();
		
		foreach ($cuisines as $cuisine) {			
			$arr[$cuisine->id] = $cuisine->name;
		}
		
		return $arr;
	}
	
	public static function getOrderedJson() 
	{
		$cuisines = Cuisine::where('active', '=', '1')->orderBy('name', 'asc')->get();
		
		$arr = [];
		foreach ($cuisines as $cuisine) {
			$arr[] = $cuisine->name;
		}
		
		return json_encode($arr);
	}
	
	public static function getCuisine($id)
	{
		return Cuisine::find($id)->name;
	}
	
	public static function getValidationRules()
	{	
		return array(
			'name' => 'required|unique:cuisines'
		);		
	}
}
