<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('companies', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();

			$table->string('email', 100)->unique();
			$table->string('password', 100);

			$table->string('name', 100)->nullable();
			$table->string('president', 100)->nullable();
			$table->string('capital', 50)->nullable();
			$table->integer('employee_number', 6)->nullable();
			$table->text('description')->nullable();
			$table->text('note')->nullable();
			$table->string('thumbnail', 150)->nullable();
			$table->string('favicon', 150)->nullable();
			$table->string('logo', 150)->nullable();
			$table->string('contact_tel', 25)->nullable();
			$table->string('contact_phone', 25)->nullable();

			$table->string('country', 50)->nullable()->default("Việt Nam");
			$table->string('zip_code', 10)->nullable();
			$table->string('prefecture', 50)->nullable();
			$table->string('city', 100)->nullable();
			$table->string('district', 100)->nullable();
			$table->string('address', 255)->nullable();
			$table->string('building', 255)->nullable();
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
		Schema::drop('companies');
	}

}
