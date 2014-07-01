<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesPageLocaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'pages_locale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('page_id');
			$table->string('locale',5);
			$table->string('title');
			$table->string('subtitle');
			$table->text('body');
			$table->string('slug');
			$table->timestamps();

			$table->index('page_id');
			$table->unique(array('page_id','locale','slug'));
			$table->unique(array('page_id','locale'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop(Config::get('pages::database_prefix').'pages_locale');
	}

}
