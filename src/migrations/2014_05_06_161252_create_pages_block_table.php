<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesBlockTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'blocks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('page_id');
			$table->string('handle',50);
			$table->string('type',50);
			$table->string('area',50);
			$table->longText('data');
			$table->smallInteger('order');
			$table->timestamps();

			$table->index('page_id');
			$table->index('handle');
			$table->index('area');
			$table->index('type');
			$table->index('order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'blocks');
	}

}
