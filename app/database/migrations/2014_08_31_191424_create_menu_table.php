<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cuisines', function($table) {
			$table->increments('id');
			$table->string('name');
		});
		
		Schema::create('menus', function($table) {
			$table->increments('id');
			$table->integer('profileid');
			$table->timestamps();
		});
		
		Schema::create('menushistory', function($table) {
			$table->increments('id');
			$table->integer('menuid');			
			$table->string('title');
			$table->string('description');
			$table->integer('cuisineid');
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
		Schema::drop('cuisines');
		Schema::drop('menus');
		Schema::drop('menushistory');		
	}

}
