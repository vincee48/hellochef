<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuitemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menuitems', function ($table) 
		{
			$table->increments('id');
			$table->integer('menuid');
			$table->integer('createdby');
			$table->integer('documentid');			
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
		Schema::drop('menuitems');
	}

}
