<?php

$taxonomiesPath = Config::get('taxonomies.taxonomy_path');

Route::group(['prefix' => $taxonomiesPath,  'middleware' => ['web','auth']], function()
{
  /**
   * GET ROUTES
   */
  Route::get('/', 'Codiiv\Taxonomies\Controllers\TaxonomiesController@loadIndex')->name('load.taxonomy.index');

  /**
   * POST ROUTES
   */
   Route::post('new/taxonomy', 'Codiiv\Taxonomies\Controllers\TaxonomiesController@newTaxonomy')->name('post.new.taxonomy');
   Route::post('delete/taxonomy', 'Codiiv\Taxonomies\Controllers\TaxonomiesController@deleteTaxonomy')->name('post.delete.taxonomy');

});
