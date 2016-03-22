<?php

class MenuDocument extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'menudocuments';
	
	public function getDocument()
	{
		return Document::where('id', '=', $this->documentid)->first();
	}
}
