<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesCategoryLocaleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create(Config::get('pages::database_prefix').'categories_locale', function(Blueprint $table)
		{
			$table->increments('id');
			$table->unsignedInteger('category_id');
			$table->string('locale',5);
			$table->string('title');
			$table->string('slug');
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
		Schema::drop(Config::get('pages::database_prefix').'categories_locale');
	}

}
