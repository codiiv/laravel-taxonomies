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

      }else{
        
        if (!Schema::hasColumn('taxonomies', 'id')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->increments('id');
          });
        }
        if (!Schema::hasColumn('taxonomies', 'parent_id')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->integer('parent_id')->unsigned()->nullable();
          });
        }
        if (!Schema::hasColumn('taxonomies', 'order')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->integer('order')->default(1);
          });
        }
        if (!Schema::hasColumn('taxonomies', 'name')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->string('name');
          });
        }
        if (!Schema::hasColumn('taxonomies', 'color')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->string('color', 20)->default("#51C3AC");
          });
        }
        if (!Schema::hasColumn('taxonomies', 'slug')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->string('slug');
          });
        }
        if (!Schema::hasColumn('taxonomies', 'taxonomy')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->string('taxonomy')->default("category");
          });
        }
        if (!Schema::hasColumn('taxonomies', 'description')){
          Schema::create('taxonomies', function (Blueprint $table) {
            $table->text('description')->nullable();
          });
        }
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
