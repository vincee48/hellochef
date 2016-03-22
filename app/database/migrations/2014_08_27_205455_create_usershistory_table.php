<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersHistoryTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usershistory', function($table)
		{
			$table->increments('id');
			$table->integer('userid');
			$table->string('email');
			$table->string('firstname');
			$table->string('middlename');
			$table->string('lastname');
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
		Schema::drop('usershistory');
	}

}
