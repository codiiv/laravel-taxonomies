<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateWkceWpTermRelationshipsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('term_relationships', function(Blueprint $table)
		{
			$table->bigInteger('object_id')->default(0);
			$table->string('object_type')->default('post')->comment('Could be post, product, user,domain,topic,forum...depending on the case of the taxonomy you defined');
			$table->bigInteger('term_taxonomy_id')->default(0);
			$table->bigInteger('term_order')->default(0);
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
		Schema::drop('wkce_term_relationships');
	}

}
