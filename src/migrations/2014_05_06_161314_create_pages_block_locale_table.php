<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesBlockLocaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'blocks_locale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('block_id');
			$table->string('locale',5);
			$table->string('title');
			$table->string('subtitle');
			$table->text('body');
			$table->longText('data');
			$table->timestamps();

			$table->index('block_id');
			$table->unique(array('block_id','locale'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'blocks_locale');
	}

}
