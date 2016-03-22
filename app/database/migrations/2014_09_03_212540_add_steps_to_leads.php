<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStepsToLeads extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('leads', function($table) 
		{
			$table->boolean('step1');
			$table->boolean('step2');
			$table->boolean('step3');
			$table->boolean('step4');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('leads', function($table)
		{
			$table->dropColumn(array('step1', 'step2', 'step3', 'step4'));
		});
	}

}
