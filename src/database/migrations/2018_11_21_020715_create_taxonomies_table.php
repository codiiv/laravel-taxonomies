<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxonomiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasTable('taxonomies')) {
        Schema::create('taxonomies', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('parent_id')->unsigned()->nullable();
          $table->integer('order')->default(1);
          $table->string('name');
          $table->string('color', 20)->default("#51C3AC");
          $table->string('slug');
          $table->string('taxonomy')->default("category");
          $table->text('description')->nullable();
          $table->timestamps();
        });
      }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      if (Schema::hasTable('taxonomies')) {
        Schema::dropIfExists('taxonomies');
      }
    }
}
