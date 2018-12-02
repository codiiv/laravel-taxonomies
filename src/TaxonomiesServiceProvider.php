<?php

namespace Codiiv\Taxonomies;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class TaxonomiesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      //
      include __DIR__.'/Routes/web.php';
      $this->publishes([
        __DIR__.'/config/taxonomies.php' => config_path('taxonomies.php'),
        __DIR__.'/public' => public_path('taxonomies/assets'),
      ]);
      $this->publishes([
          __DIR__.'/database/seeds/' => database_path('seeds'),
      ], 'projectmgr_seeds');
      $this->loadMigrationsFrom(__DIR__.'/database/migrations');

      /************************  TO VIEWS ***************************/

      view()->composer('*', function ($view){
       $request =  Request();
       if(\Auth::check()) {
         $theTaxs = new Models\Taxonomies();
         $custom = new Models\Custom();
         $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');

         $view->with('Taxonomy', $theTaxs);

         // $sortedList = $common::getTermsSorted($taxonomy);
         //



         $view->with('common', new Models\Common());
         $view->with('taxonomiesPath', \Config::get('taxonomies.taxonomy_path'));

         if(isset($_GET['taxonomy'])){
           $collection = collect($theTaxs::sortedTerms($_GET['taxonomy'], null, 0, []));

         }else{
           $defaultCat = \Config::get('taxonomies.default_taxonomy');
           $collection = collect($theTaxs::sortedTerms($defaultCat, null, 0, []));
         }
         $view->with('taxonomy', $taxonomy);

         $view -> with('taxonomies', $custom::Taxonomies());

         $page = isset($_GET['page']) ? $_GET['page'] : 1;

         $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');

         $itemsPerPage = \Config::get('taxonomies.terms_per_page');
         $perPage = ($itemsPerPage > 0) ? $itemsPerPage:10; //To avoid division by zero
         $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url(\Config::get('taxonomies.taxonomy_path').'?taxonomy='.$taxonomy)]);
         $view->with('paginatedTerms', $paginatedTerms);
       };
      });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
      // register our controller
      $this->app->make('Codiiv\Taxonomies\Controllers\TaxonomiesController');
      $this->loadViewsFrom(__DIR__.'/views', 'taxonomies');
      $this->commands([
        Console\Commands\AssignSuperadmin::class
      ]);
    }
}
