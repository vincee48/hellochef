<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuitemshistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menuitemshistory', function ($table)
		{
			$table->increments('id');	
			$table->integer('menuitemid');
			$table->string('name');
			$table->string('description');			
			$table->float('alacarteprice');
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
		Schema::drop('menuitemshistory');
	}

}
