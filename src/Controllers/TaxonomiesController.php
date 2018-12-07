<?php

namespace Codiiv\Taxonomies\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Codiiv\Taxonomies\Models\Taxonomies;

class TaxonomiesController extends Controller
{
  public function __construct()
  {
      // $this->middleware('auth');
  }
  /*
  "taxonomies" => [
    "category"=>[
      'labels' => [
        [
          'name'                       => __( 'Categories' ),
          'singular_name'              => __( 'Category' ),
          'menu_name'                  => __( 'Taxonomy' ),
          'all_items'                  => __( 'All Items' ),
          'parent_item'                => __( 'Parent Item' ),
          'parent_item_colon'          => __( 'Parent Item:' ),
          'new_item_name'              => __( 'New Item Name' ),
          'add_new_item'               => __( 'Add New Item' ),
          'edit_item'                  => __( 'Edit Item' ),
          'update_item'                => __( 'Update Item' ),
          'view_item'                  => __( 'View Item' ),
          'separate_items_with_commas' => __( 'Separate items with commas' ),
          'add_or_remove_items'        => __( 'Add or remove items' ),
          'choose_from_most_used'      => __( 'Choose from the most used' ),
          'popular_items'              => __( 'Popular Items' ),
          'search_items'               => __( 'Search Items' ),
          'not_found'                  => __( 'Not Found' ),
          'no_terms'                   => __( 'No items' ),
          'items_list'                 => __( 'Items list' ),
          'items_list_navigation'      => __( 'Items list navigation' ),
        ]
      ],
      'hierarchical'               => true,
      'public'                     => true,
      'show_ui'                    => true,
      'show_admin_column'          => true,
      'show_in_nav_menus'          => true,
      'show_tagcloud'              => true,
    ],

  ]
   */
  public function loadIndex(){
    return view("taxonomies::admin");
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
    for ($i=0; $i < 10; $i++) {
      if($tax::where('slug', $taxSlug)->exists()){
        $taxSlug = $taxSlug.'-1';
      }
    }
    $back_to =  $request ->back_to;
    $tax->parent_id = $request->parent != "" ? $request->parent :  null;
    $tax->name      = $request->name;
    $tax->color     = '#'.$request->color;
    $tax->taxonomy  = $request->taxonomy;
    $tax->slug      = $taxSlug;
    $tax->description  = $request->description != "" ? $request->description : " ";
    $tax->save();
    $taxId = $tax->id;
    if($taxId){
      $message = "Added successfully";
      $msgtype = 1;
    }else{
      $message = "There were errors";
      $msgtype = 1;
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
