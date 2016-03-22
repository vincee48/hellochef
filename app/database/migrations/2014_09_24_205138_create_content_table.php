<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function($table)
		{
			$table->increments('id');
			$table->string('page');
			$table->timestamps();
		});
		
		Schema::create('contentshistory', function ($table)
		{
			$table->increments('id');
			$table->integer('contentid');
			$table->text('content');
			$table->integer('updatedby');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(array('contents', 'contentshistory'));
	}

}
