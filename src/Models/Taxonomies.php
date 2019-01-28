<?php

namespace Codiiv\Taxonomies\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

class Taxonomies extends Model
{
    protected $table = 'taxonomies';

    public function parent(){
      return $this->belongsTo('Codiiv\Taxonomies\Models\Taxonomies', 'parent_id');
    }
    public function children(){
      return $this->hasMany('Codiiv\Taxonomies\Models\Taxonomies', 'parent_id');
    }
    public function getTaxonomy($taxID){
      $item = Taxonomies::where("id", $taxID)->first();
      return $item;
    }
    static  public function getKids($parent){
      $kids = Taxonomies::where('parent_id',$parent)->get();
      return $kids;
    }

    static public function sortedTerms($taxonomy, $parentID = null, $level=0, $list=[], $unique_to=''){
      $pointer = '';
      for ($i=0; $i < $level; $i++) {
        $pointer = $pointer.\Config::get('taxonomies.default_pointer_sign');
      }
      if($unique_to!=""){
        if($level==0){
          $terms = Taxonomies::whereNull('parent_id')->where('unique_to', $unique_to)->where("taxonomy", $taxonomy)->with('children')->paginate(\Config::get('taxonomies.terms_per_page'));
        }else{
          $terms = Taxonomies::where("parent_id", $parentID)->where('unique_to', $unique_to)->where("taxonomy", $taxonomy)->with('children')->paginate(\Config::get('taxonomies.terms_per_page'));
        }
      }else{
        if($level==0){
          $terms = Taxonomies::whereNull('parent_id')->where("taxonomy", $taxonomy)->with('children')->paginate(\Config::get('taxonomies.terms_per_page'));
        }else{
          $terms = Taxonomies::where("parent_id", $parentID)->where("taxonomy", $taxonomy)->with('children')->get();
        }
      }
      foreach ($terms as $k => $t) {
        $t->level   = $level;
        $t->pointer = $pointer;
        $list[] = $t;
        $list   = self::sortedTerms($taxonomy, $t->id, $level+1, $list, $unique_to);
      }
      return $list;
    }
    static public function sortedTermsPaginated($taxonomy, $page=1){

      $itemsPerPage = \Config::get('taxonomies.terms_per_page');
      $defaultTax   = \Config::get('taxonomies.default_taxonomy');

      $collection = collect(Taxonomies::sortedTerms($taxonomy, null, 0, []));

      $perPage = ($itemsPerPage > 0) ? $itemsPerPage:10; //To avoid division by zero
      // $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url(\Config::get('taxonomies.taxonomy_path').'?taxonomy='.$taxonomy)]);
      $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>'?taxonomy='.$taxonomy]);

      return $paginatedTerms;
    }
    static public function loadUnique($taxonomy, $unique_to='', $page=1){

      $itemsPerPage = \Config::get('taxonomies.terms_per_page');
      $defaultTax   = \Config::get('taxonomies.default_taxonomy');

      $collection = collect(Taxonomies::sortedTerms($taxonomy, null, 0, [], $unique_to));

      $perPage = ($itemsPerPage > 0) ? $itemsPerPage:10; //To avoid division by zero
      // $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url(\Config::get('taxonomies.taxonomy_path').'?taxonomy='.$taxonomy)]);
      $paginatedTerms = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>'?taxonomy='.$taxonomy]);

      return $paginatedTerms;
    }
    static public function taxonomyHtml($wrappers=['', '<ul>','</ul>'], $taxonomy, $parentID=null, $level = 0){
      $pointer = '';
      for ($i=0; $i < $level; $i++) {
        $pointer = $pointer.'—';
      }


      // $items = Taxonomies::whereNull('parent_id')->where("taxonomy", $taxonomy)->with('children')->get();

      // $items = Taxonomies::where("parent_id", $parentID)->where("taxonomy", $taxonomy)->with('children')->get();
      //
      // $sortedList = $common::getTermsSorted($taxonomy);
      //
      // $collection = collect($sortedList);
      // $page = isset($_GET['page']) ? $_GET['page'] : 1;
      // $perPage = 10;
      // $paginated = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url($lang.'/dashboard/taxonomy/'.$taxonomy)]);


      return $xhtml;
    }
    static public function taxonomySelect($wrappers=['', '<ul>','</ul>'], $taxonomy, $parentID=null, $level = 0){
      $pointer = '';
      for ($i=0; $i < $level; $i++) {
        $pointer = $pointer.\Config::get('taxonomies.default_pointer_sign');
      }
      $type  = $wrappers[0];
      $xhtml = $wrappers[1];
      if($level == 0){
        $items = Taxonomies::whereNull('parent_id')->where("taxonomy", $taxonomy)->with('children')->get();
      }else{
        $items = Taxonomies::where("parent_id", $parentID)->where("taxonomy", $taxonomy)->with('children')->get();
      }
      foreach($items as $parent){
        if($type=="" || $type=='select'){
          $xhtml .= '<option value="'.$parent->id.'"> '.$pointer. $parent->name .'</option>';
        }else{
          $xhtml .= '<li data-value="'.$parent->id.'" class="level-'.$level.'"> '.$pointer. $parent->name .'</li>';
        }

        $xhtml .= self::taxonomySelect([$type, '',''], $taxonomy, $parent->id,$level+1);
      }
      if($level ==0){
        $xhtml .= $wrappers[2];
      }

      return $xhtml;
    }

    static public function listCategories(){
      $forumCategories = Taxonomies::whereNull('parent_id')->with('children')->get();
      $tree = '<ul>';
      foreach ($forumCategories as $key => $value) {
        $tree .= ' <li id="catid-'.$value->id.'"><div class="unique-cat cat-'.$value->id.'" data-catid="'.$value->id.'">'.$value->name.' <button class="deletecat btn btn-primary" data-catid="'.$value->id.'">'._i("Delete").'</button></div>';
          $children = Taxonomies::where( 'parent_id', $value->id )->get();
            $tree .= '<ul class="submenu level-1">';
            foreach ($children as $child) {
              $tree .= '<li id="catid-'.$child->id.'"><div class="unique-cat cat-'.$child->id.'" data-catid="'.$child->id.'">'.$child->name.' <button class="deletecat btn btn-primary" data-catid="'.$child->id.'">'._i("Delete").'</button></div></li>';
            }
            $tree .= '</ul>';
          $tree .= '</li>';
      }
      $tree .= '</ul>';

      return $tree;
    }
    static public function listCategoriesSelect(){
      $forumCategories = Taxonomies::whereNull('parent_id')->with('children')->get();
      $tree = '<select name="parent">';
      $tree .= '<option value=""> '.'Choose a parent'.'</option>';
      foreach ($forumCategories as $key => $value) {
        $tree .= '<option value="'.$value->id.'"> '.$value->name .'</option>';
          $children = Taxonomies::where( 'parent_id', $value->id )->get();

            foreach ($children as $child) {
              $tree .= '<option value="'.$child->id.'" class="level-1"> — '.$child->name.'</option>';
            }

      }
      $tree .= '</select>';

      return $tree;
    }

}
