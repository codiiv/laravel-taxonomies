<?php

namespace Codiiv\Taxonomies\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use Codiiv\Taxonomies\Models\Taxonomies;

class TaxonomiesController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
  }

  public function loadIndex(Request $request){

    $itemsPerPage = \Config::get('taxonomies.terms_per_page');
    $defaultTax   = \Config::get('taxonomies.default_taxonomy');
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');

    if(isset($_GET['taxonomy'])){
      $collection = collect(Taxonomies::sortedTerms($_GET['taxonomy'], null, 0, []));
    }else{
      $collection = collect(Taxonomies::sortedTerms($defaultTax, null, 0, []));
    }

    $perPage = ($itemsPerPage > 0) ? $itemsPerPage:10; //To avoid division by zero
    
    // $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url(\Config::get('taxonomies.taxonomy_path').'?taxonomy='.$taxonomy)]);
    $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>'?taxonomy='.$taxonomy]);

    return view("taxonomies::admin", ['paginatedTerms' => $paginatedTerms]);
  }

  public function newTaxonomy(Request $request){
    // $slug = str_slug('Laravel 5 Framework', '-');
    $perpage  = \Config::get('taxonomies.terms_per_page');
    $total = Taxonomies::where("taxonomy", $request->taxonomy)->count();
    $pageNumber = ceil($total/$perpage);

    $tax            = new Taxonomies;
    // $taxSlug = str_slug($request->name, '-');
    $page = isset($request->page) ? $request->page : false;
    $taxSlug = $request->slug;
      if($request->unique_to !=""){
        for ($i=0; $i < 10; $i++) {
          if($tax::where('slug', $taxSlug)->where('unique_to', $request->unique_to)->where('taxonomy', $request->taxonomy)->exists()){
            $taxSlug = $taxSlug.'-1';
          }
        }
      }else{
        for ($i=0; $i < 10; $i++) {
          if($tax::where('slug', $taxSlug)->exists()){
            $taxSlug = $taxSlug.'-1';
          }
        }
      }
    $back_to =  $request ->back_to;
    $tax->parent_id = $request->parent != "" ? $request->parent :  null;
    $tax->name      = $request->name;
    $tax->color     = '#'.$request->color;
    $tax->taxonomy  = $request->taxonomy;
    $tax->slug      = $taxSlug;
    $tax->description  = $request->description != "" ? $request->description : " ";
    $tax->unique_to =  $request->unique_to;
    $tax->save();
    if($tax->id){
      $message = "Added successfully";
      $msgtype = 1;
    }else{
      $message = "We encountered errors processing that request";
      $msgtype = 0;
    }
    $taxonomiesPath = \Config::get('taxonomies.taxonomy_path');
    return redirect($back_to)->with(["itemtype"=>'company',"message"=>$message, "msgtype"=>$msgtype]);
  }
  /*
  | Method : updateTaxonomy
  | @param : $request
   */
  public function updateTaxonomy(Request $request){

    $tax            = new Taxonomies;
    $taxonomy  = $request->taxonomy;
    $term_id  = $request->term_id;
    $page     = isset($request->page)? $request->page : false;

    $back_to =  $request ->back_to;

    /*
     | We make sure that term exits
     | in that taxonomy. OtherWise we prevent the action and pass a warning
     */
    if($tax::where('id', $term_id)->where('taxonomy', $taxonomy)->exists()){

      $taxSlug = $request->slug;
      $unique_to =  $request ->unique_to;

      for ($i=0; $i < 10; $i++) {
        if($tax::where('slug', $taxSlug)->exists()){
          $taxSlug = $taxSlug;
        }
      }

      // We update the  record as needed
     $updateTerm = Taxonomies::where('id', $term_id)
     ->update([
           'parent_id' => $request->parent != "" ? $request->parent :  null,
           'name' => $request->name,
           'color' => '#'.$request->color,
           'slug' => $taxSlug,
           'unique_to'=>$unique_to,
           'description' => $request->description != "" ? $request->description : " ",
           ]);

     if($updateTerm){
       $message = "Updated successfully";
       $msgtype = 1;
     }else{
       $message = "There were errors";
       $msgtype = 1;
     }
    }else{
      $message = "You are trying to update a record that does NOT exist";
      $msgtype = 1;
    }

    $taxonomiesPath = \Config::get('taxonomies.taxonomy_path');
    return redirect($back_to)->with(["itemtype"=>'company',"message"=>$message, "msgtype"=>$msgtype, "action_type"=>"update"]);
  }
  public function deleteTaxonomy(Request $request){
    $page     = isset($request->page) ?  $request->page : false;
    $taxonomy = $request->taxonomy;
    $togo  = $request->tobedeleted;
    $dis = Taxonomies::where('id', $togo)->first();
    $directParent = $dis->parent_id;
    // We update direct descendants if any
    $updateOrphans = Taxonomies::where('parent_id', $togo)
    ->update(['parent_id' => $directParent]);
    //WE then obliterate the category
    $deleted = Taxonomies::destroy($togo);

    if($deleted){
      $message = __("Deleted Successfully");
      $msgtype = "success";
    }else{
      $message = __("There were errors deleting category");
      $msgtype = 0;
    }
    return redirect(\Config::get('taxonomies.taxonomy_path').'?taxonomy='.$taxonomy.($page ? '&page='.$page : '' ))->with('status', ["message"=>$message, "msgtype"=>$msgtype]);
  }
}
