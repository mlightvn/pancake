<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			// https://laravel.com/docs/5.0/schema
			$table->increments('id');
			$table->integer('parent_id');
			$table->tinyInteger('level', false, true)->length(2)->nullable()->unsigned();
			$table->string('name', 100)->nullable();
			$table->string('slug', 100)->nullable();
			$table->tinyInteger('position', false, true)->length(2)->nullable()->unsigned();
			$table->enum('status', \Config::get('constants.STATUS'))->default('Active');
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
		Schema::dropIfExists('categories');
	}

}
