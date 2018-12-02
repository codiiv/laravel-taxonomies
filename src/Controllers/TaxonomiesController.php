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
    $tax            = new Taxonomies;
    $taxSlug = str_slug($request->name, '-');
    for ($i=0; $i < 10; $i++) {
      if($tax::where('slug', $taxSlug)->exists()){
        $taxSlug = $taxSlug.'-1';
      }
    }
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
    return redirect($taxonomiesPath.'?taxonomy='.$tax->taxonomy)->with(["itemtype"=>'company',"message"=>$message, "msgtype"=>$msgtype]);
  }

  public function deleteTaxonomy(Request $request){
    $page     = isset($_GET['page']) ? $_GET['page'] : 1;
    $taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : \Config::get('taxonomies.default_taxonomy');
    // $dis = Taxonomies::where('id', $taxonomy)->first();
    // $directParent = $dis->parent_id;
    // // We update direct descendants if any
    // $updateOrphans = Taxonomies::where('parent_id', $cat)
    // ->update(['parent_id' => $directParent]);
    

  }
}
