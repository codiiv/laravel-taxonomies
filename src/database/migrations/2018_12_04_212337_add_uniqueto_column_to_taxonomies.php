<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUniquetoColumnToTaxonomies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      if (!Schema::hasColumn('taxonomies', 'unique_to')){
        Schema::table('taxonomies', function (Blueprint $table) {
          $table->string('unique_to')->after("description")->default('')->nullable()->comments('Usually an entity such as the company');
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
      if (Schema::hasColumn('taxonomies', 'unique_to')){
        Schema::table('taxonomies', function (Blueprint $table) {
          $table->dropColumn('unique_to');
        });
      }
    }
}
