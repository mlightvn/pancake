<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->increments('id')->unsigned();
			$table->integer('company_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->string('slug', 255)->nullable();
			$table->string('url', 255)->nullable();
			$table->string('name', 255)->nullable();
			$table->string('thumbnail', 255)->nullable();
			$table->string('logo', 255)->nullable();
			$table->tiny('rate', 1)->nullable()->default(0);
			$table->integer('market_price', 20)->nullable();
			$table->integer('price', 20)->nullable();
			$table->integer('quantity', 11)->nullable();
			$table->integer('max_quantity', 11)->nullable();
			$table->enum('status', \Config::get('constants.STATUS'))->default('Active');
			$table->text('short_description')->nullable();
			$table->text('description')->nullable();
			$table->datetime('expired_datetime')->nullable();
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
		Schema::drop('products');
	}

}
