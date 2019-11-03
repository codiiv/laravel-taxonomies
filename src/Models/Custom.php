<?php

namespace Codiiv\Taxonomies\Models;

use Illuminate\Support\ServiceProvider;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
/**
 *
 */
class Custom
{
   static public function Taxonomies(){

     $taxonomies = [];

     $taxonomies = [

           "category"=>[
             'labels' => [
               'name'                       => __( 'Categories' ),
               'singular_name'              => __( 'Category' ),
               'menu_name'                  => __( 'Categories' ),
               'all_items'                  => __( 'All Categories' ),
               'parent_item'                => __( 'Parent Category' ),
               'parent_item_colon'          => __( 'Parent Category:' ),
               'new_item_name'              => __( 'New Location Name' ),
               'add_new_item'               => __( 'Add New Category' ),
               'edit_item'                  => __( 'Edit Category' ),
               'update_item'                => __( 'Update Category' ),
               'view_item'                  => __( 'View Category' ),
               'separate_items_with_commas' => __( 'Separate items with commas' ),
               'add_or_remove_items'        => __( 'Add or remove items' ),
               'choose_from_most_used'      => __( 'Choose from the most used' ),
               'popular_items'              => __( 'Popular Categories' ),
               'search_items'               => __( 'Search Categories' ),
               'not_found'                  => __( 'Not Found' ),
               'no_terms'                   => __( 'No items' ),
               'items_list'                 => __( 'Categories list' ),
               'items_list_navigation'      => __( 'Categories list navigation' ),
             ],
             'hierarchical'               => true,
             'public'                     => true,
             'show_ui'                    => true,
             'show_admin_column'          => true,
             'show_in_nav_menus'          => true,
             'show_tagcloud'              => true,
           ],
           "tags"=>[
             'labels' => [
               'name'                       => __( 'Tags' ),
               'singular_name'              => __( 'Tag' ),
               'menu_name'                  => __( 'Tags' ),
               'all_items'                  => __( 'All Tags' ),
               'parent_item'                => __( 'Parent Tag' ),
               'parent_item_colon'          => __( 'Parent Tag:' ),
               'new_item_name'              => __( 'New Tag Name' ),
               'add_new_item'               => __( 'Add New Tag' ),
               'edit_item'                  => __( 'Edit Tag' ),
               'update_item'                => __( 'Update Tag' ),
               'view_item'                  => __( 'View Tag' ),
               'separate_items_with_commas' => __( 'Separate items with commas' ),
               'add_or_remove_items'        => __( 'Add or remove items' ),
               'choose_from_most_used'      => __( 'Choose from the most used' ),
               'popular_items'              => __( 'Popular Tags' ),
               'search_items'               => __( 'Search Tags' ),
               'not_found'                  => __( 'Not Found' ),
               'no_terms'                   => __( 'No items' ),
               'items_list'                 => __( 'Locations list' ),
               'items_list_navigation'      => __( 'Locations list navigation' ),
             ],
             'hierarchical'               => false,
             'public'                     => true,
             'show_ui'                    => true,
             'show_admin_column'          => true,
             'show_in_nav_menus'          => true,
             'show_tagcloud'              => true,
           ],
           "location"=>[
             'labels' => [
               'name'                       => __( 'Locations' ),
               'singular_name'              => __( 'Location' ),
               'menu_name'                  => __( 'Locations' ),
               'all_items'                  => __( 'All Locations' ),
               'parent_item'                => __( 'Parent Location' ),
               'parent_item_colon'          => __( 'Parent Location:' ),
               'new_item_name'              => __( 'New Location Name' ),
               'add_new_item'               => __( 'Add New Location' ),
               'edit_item'                  => __( 'Edit Location' ),
               'update_item'                => __( 'Update Location' ),
               'view_item'                  => __( 'View Location' ),
               'separate_items_with_commas' => __( 'Separate items with commas' ),
               'add_or_remove_items'        => __( 'Add or remove items' ),
               'choose_from_most_used'      => __( 'Choose from the most used' ),
               'popular_items'              => __( 'Popular Locations' ),
               'search_items'               => __( 'Search Locations' ),
               'not_found'                  => __( 'Not Found' ),
               'no_terms'                   => __( 'No items' ),
               'items_list'                 => __( 'Locations list' ),
               'items_list_navigation'      => __( 'Locations list navigation' ),
             ],
             'hierarchical'               => true,
             'public'                     => true,
             'show_ui'                    => true,
             'show_admin_column'          => true,
             'show_in_nav_menus'          => true,
             'show_tagcloud'              => true,
           ],

         ];
     include(base_path('bootstrap/custom_taxonomies.php'));

     $full = array_merge($taxonomies, $extraTaxonomies);

     return $full;
   }
}
