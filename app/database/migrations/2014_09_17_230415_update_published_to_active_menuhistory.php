<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePublishedToActiveMenuhistory extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menushistory', function ($table) 
		{
			$table->dropColumn('published');			
		});
		
		Schema::table('menus', function ($table)
		{
			$table->boolean('active');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menus', function ($table)
		{
			$table->dropColumn('active');
		});
	}

}
