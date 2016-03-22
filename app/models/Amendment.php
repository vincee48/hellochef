<?php

class Amendment extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'amendments';

	public static function getAmendment($enquiryid, $menuitemid)
	{
		return Amendment::where('enquiryid', '=', $enquiryid)->where('menuitemid', '=', $menuitemid)->first();
	}

	public static function getValidationRules()
	{
		return array('description' => 'required');
	}
}
