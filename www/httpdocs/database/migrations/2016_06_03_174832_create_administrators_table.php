<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('administrators', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('email', 100)->unique();
			$table->string('password', 100);
			$table->string('firstname', 50)->nullable();
			$table->string('lastname', 50)->nullable();
			$table->enum('gender', \Config::get('constants.GENDER'))->default('男性');
			$table->date('birthday')->nullable();
			$table->string('phone', 20)->nullable();

			$table->string('logo', 100)->nullable();
			$table->string('images', 100)->nullable();
			$table->text('short_description')->nullable();
			$table->text('description')->nullable();
			$table->string('zip_code', 10)->nullable();
			$table->string('prefecture', 50)->nullable();
			$table->string('city', 255)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('building', 255)->nullable();
			$table->enum('status', \Config::get('constants.STATUS'))->default('Active');

			$table->rememberToken();
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
		Schema::drop('administrators');
	}

}
