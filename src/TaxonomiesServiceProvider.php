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
          __DIR__.'/database/' => database_path(),
      ], 'taxonomies');
      $this->loadMigrationsFrom(__DIR__.'/database/migrations');

      /************************  TO VIEWS ***************************/

      view()->composer('*', function ($view){
       $request =  Request();
       if(\Auth::check()) {
         $theTaxs = new Models\Taxonomies();
         $custom = new Models\Custom();
         $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');

         $view->with('Taxonomy', $theTaxs);
         $view->with('common', new Models\Common());

         //****************** We check a term ID has been given ***********
         if(isset($_GET['term_id']) && $theTaxs::where('id', $_GET['term_id'])->exists()){
           $dis = Models\Taxonomies::where('id', $_GET['term_id'])->first();
           $directParent = $dis->parent_id;
           $view->with('term_exists', true);
           $view->with('term_id', $_GET['term_id']);
           $view->with('the_term', $dis);
         }else{
           $view->with('term_exists', false);
         }


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
