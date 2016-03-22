<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menushistory', function($table) 
		{
			$table->boolean('published');
		});
		
		Schema::create('leads', function($table) 
		{
			$table->increments('id');
			$table->integer('userid');
			$table->string('chefname');
			$table->integer('profileid');
			$table->integer('menuid');
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
		Schema::table('menushistory', function($table)
		{
			$table->dropColumn('published');
		});
		Schema::drop('leads');
	}

}
