<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('documents', function($table) 
		{
			$table->increments('id');
			$table->integer('userid');
			$table->string('filename');
			$table->string('filetype');
			$table->integer('filesize');
			$table->integer('uploadedby');
			$table->boolean('isprofilepic');
			$table->timestamps();
		});
		
		DB::statement("ALTER TABLE documents ADD filecontent LONGBLOB");
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('documents');
	}

}
