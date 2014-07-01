<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesPicturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'pictures', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('picturable_id');
			$table->string('picturable_type');
			$table->string('picturable_position',50);
			$table->smallInteger('picturable_order');
			$table->string('filename');
			$table->string('original');
			$table->string('mime',50);
			$table->integer('size');
			$table->smallInteger('width');
			$table->smallInteger('height');
			$table->timestamps();

			$table->index('picturable_id');
			$table->index('picturable_type');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'pictures');
	}

}
