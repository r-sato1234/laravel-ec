<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('items', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('admin_id')->index();
			$table->string('name', 50);
			$table->string('img', 50);
			$table->string('description');
			$table->integer('price');
			$table->string('tag_for_search', 255)->index();
			$table->dateTime('created_at');
			$table->dateTime('updated_at');
			$table->dateTime('deleted_at')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('items');
	}

}
