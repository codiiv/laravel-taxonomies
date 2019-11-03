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
class Common
{
  function __construct()
  {

  }
  static  public function getKids($parent){
    $kids = Taxonomies::where('parent_id',$parent)->get();
    return $kids;
  }
  static public function kidsOptions($items, $level = 0){
    $pointer = '';
    for ($i=0; $i < $level; $i++) {
      $pointer = $pointer.'—';
    }
    $xhtml = '';
    foreach($items as $parent){
      $xhtml .= '<option value="'.$parent->id.'"> '.$pointer. $parent->name .'</option>';

      $xhtml .= self::kidsOptions(self::getKids($parent->id), $level+1);
    }
    return $xhtml;
  }
  static public function randomColor(){
    return str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
  }
  static public function kidsOptionsUl($items, $level = 0){
    $pointer = '';
    for ($i=0; $i < $level; $i++) {
      $pointer = $pointer.'— ';
    }
    $xhtml = '';
    foreach($items as $parent){
      $xhtml .= '<li class="items-unique item-user-'.$parent->id.'">
            <div class="list-inner">
              <div class="pure-g">
                  <div class="cell hand--1-2 nexus--1-3"><p>'. $parent->id .'</p></div><!--
                --><div class="cell hand--1-2 nexus--1-3"><span class="thecolor" style="background-color:'.$parent->color.'"></span><p>'.$pointer. $parent->name .'</p></div><!--
                --><div class="cell hand--1-2 nexus--1-3"><p>'. $parent->slug .'</p></div>
              </div>
              <div class="update-item-actions hidden">
                <button class="edit" type="button" name="button" disabled>Edit</button><button class="delete" type="button" name="button" data-thisid="'.$parent->id.'" data-page="'.(isset($_GET['page'])?$_GET['page']:"1").'">Delete</button><button class="cancel" type="button" name="button">Cancel</button>
              </div>
            </div>
          </li>';

      $xhtml .= self::kidsOptionsUl(self::getKids($parent->id), $level+1);
    }
    return $xhtml;
  }
  static public function getTermsSorted($taxonomy, $parent = null, $level=0){
    $sorted = [];

    $items = Taxonomies::whereNull('parent_id')->where("taxonomy", $taxonomy)->with('children')->get();
    foreach ($items as $item) {
      $sorted[]= ["id"=>$item->id,"name"=>$item->name,"slug"=>$item->slug];

      $children = Taxonomies::where("parent_id", $item->id)->where("taxonomy", $taxonomy)->get();
      // foreach ($children as $child) {
        // self::getTermsSorted($taxonomy, $child->id, $level+1);
      // }
    }
    return $sorted;
  }
  static public function taxonomyHtmlUl($taxonomy, $perPage){

      $items = Taxonomies::whereNull('parent_id')->where("taxonomy", $taxonomy)->with('children')->paginate($perPage);
      //
      // $items = Taxonomies::where("parent_id", $parentID)->where("taxonomy", $taxonomy)->with('children')->get();
      //
      // $sortedList = $common::getTermsSorted($taxonomy);
      //
      // $collection = collect($sortedList);
      // $page = isset($_GET['page']) ? $_GET['page'] : 1;
      // $perPage = 10;
      // $paginated = new LengthAwarePaginator($collection->forPage($page, $perPage), $collection->count(), $perPage, $page, ['path'=>url($lang.'/dashboard/taxonomy/'.$taxonomy)]);
      return $items;
  }

}
