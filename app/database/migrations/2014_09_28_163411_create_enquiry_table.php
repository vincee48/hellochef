<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquiryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('enquiries', function ($table)
		{
			$table->increments('id');
			$table->integer('userid');
			$table->integer('chefid');
			$table->integer('menuid');
			$table->integer('quantity');
			$table->date('enquirydate');
			$table->text('specialreq');
			$table->text('additionalinfo');
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
		Schema::drop('enquiries');
	}

}
