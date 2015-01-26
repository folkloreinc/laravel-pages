<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePagesPagePublished extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table(Config::get('pages::database_prefix').'pages', function(Blueprint $table)
		{
			$table->boolean('published')
					->after('properties');
			$table->dateTime('publish_at')
					->nullable()
					->after('published');
			
			$table->index('published');
			$table->index('publish_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table(Config::get('pages::database_prefix').'pages', function(Blueprint $table)
		{
			$table->dropColumn('published');
			$table->dropColumn('publish_at');
		});
	}

}
