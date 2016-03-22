<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPaxToMenu extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('menushistory', function ($table)
		{
			$table->integer('minpax');
			$table->integer('maxpax');
			$table->float('price');
		});
		
		Schema::table('emails', function ($table)
		{
			$table->boolean('read');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('menushistory', function ($table)
		{
			$table->dropColumn('minpax', 'maxpax', 'price');
		});
		
		Schema::table('emails', function ($table)
		{
			$table->dropColumn('read');
		});
	}

}
