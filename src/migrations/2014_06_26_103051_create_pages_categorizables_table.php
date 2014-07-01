<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesCategorizablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'categorizables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('category_id');
			$table->unsignedInteger('categorizable_id');
			$table->string('categorizable_type');
			$table->timestamps();

			$table->index('category_id');
			$table->index('categorizable_id');
			$table->index('categorizable_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'categorizables');
	}

}
