<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfileTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{		
		Schema::create('profiles', function($table)
		{
			$table->increments('id');	
			$table->integer('userid');
			$table->boolean('active');
			$table->integer('createdby');
			$table->timestamps();
		});	
		
		Schema::create('profileshistory', function($table)
		{
			$table->increments('id');
			$table->integer('profileid');
			$table->text('aboutme');
			$table->text('experience');
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
		Schema::drop('profiles');
		Schema::drop('profileshistory');
	}

}
