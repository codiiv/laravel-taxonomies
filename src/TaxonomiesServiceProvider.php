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
        __DIR__.'/config/custom_taxonomies.php' => base_path('bootstrap/custom_taxonomies.php'),
        __DIR__.'/public' => public_path('taxonomies/assets'),
      ]);
      // $this->publishes([
      //     __DIR__.'/database/' => database_path(),
      // ], 'taxonomies');
      $this->loadMigrationsFrom(__DIR__.'/database/migrations');

      /************************  TO VIEWS ***************************/

      view()->composer('*', function ($view){
       $request =  Request();
       if(\Auth::check()) {

         $theTaxs   = new Models\Taxonomies();
         $custom    = new Models\Custom();
         $taxonomy  = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');

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
         // $page = isset($_GET['page']) ? $_GET['page'] : 1;
         // $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');


         $view -> with('taxonomy', $taxonomy);
         $view -> with('page', isset($_GET['page']) ? $_GET['page'] : 1);
         $view -> with('taxonomies', $custom::Taxonomies());
         $unique = \Config::get('taxonomies.specify_unique_to');
         if($unique && isset($_GET['unique_to'])){
           $view -> with('unique_to', $_GET['unique_to'] );
         }else{
           $view -> with('unique_to', '' );
         }
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
      $this->mergeConfigFrom(
          __DIR__.'/config/taxonomies.php', 'taxonomies'
      );
      // $this->app->register(\Codiiv\Extrameta\ExtrametaServiceProvider::class);
      // $loader = \Illuminate\Foundation\AliasLoader::getInstance();
      // $loader->alias('Form', '\Collective\Html\FormFacade');


    }
}
