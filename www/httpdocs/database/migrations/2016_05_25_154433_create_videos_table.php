<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('company_id')->nullable();
			$table->integer('category_id')->nullable();
			$table->integer('member_id')->nullable();
			$table->string('title', 255);
			$table->bigInteger('likes_number')->nullable();
			$table->text('description')->nullable();
			$table->string('path')->nullable();
			$table->string('mime')->nullable();
			$table->enum('status', \Config::get('constants.PUBLISH_STATUS'))->default('公開');
			$table->timestamps();
			// $table->primary('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
