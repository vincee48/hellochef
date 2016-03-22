<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCreatedbyToUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function($table)
		{
			$table->integer('createdby');			
		});
		
		Schema::table('usershistory', function($table)
		{
			$table->integer('updatedby');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function($table)
		{
			$table->dropColumn('createdby');
		});		
		
		Schema::table('usershistory', function($table)
		{
			$table->dropColumn('updatedby');
		});	
	}

}
