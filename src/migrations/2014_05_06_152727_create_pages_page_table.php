<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesPageTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'pages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('handle',50);
			$table->string('type');
			$table->unsignedInteger('parent_id');
			$table->timestamps();
			$table->softDeletes();

			$table->index('deleted_at');
			$table->index('handle');
			$table->index('type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'pages');
	}

}
