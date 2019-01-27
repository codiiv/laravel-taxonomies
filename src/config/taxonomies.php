<?php
return [
  "taxonomy_path"      => "dashboard/taxonomies",
  /*
  |--------------------------------------------------------------------------
  | master_file_extend
  |--------------------------------------------------------------------------
  | Usually extends the default Laravel layout file. However, you can specify
  | another file to extend. e.g you can extend another package's main layout
  | file like  mypackage::layouts.app (depending on its views are)
  */
  "master_file_extend" => "layouts.app",
  /*
  |--------------------------------------------------------------------------
  | specify_unique_to
  |--------------------------------------------------------------------------
  | There is a nullable column named "unique_to". This can be enabled by changing
  | this parameter to true. This functionality comes in handy for instances when
  | you have multiple taxonomies, but want to separate them by a third party entity.
  * For instance you may want to create a taxonomy like category, and make it different
  * by project specified by a unique slug.
  * If this is true, you need to specify a unique_to field (usually input type hidden)
  * to make this term unique to. For instance, a company slug,a post type,...
  * WE'll make more documentation about this
  */
  "specify_unique_to" => false,

  /*
  |--------------------------------------------------------------------------
  | Header and Footer Yield Inserts for your master file
  |--------------------------------------------------------------------------
  |
  | Chatter needs to add css or javascript to the header and footer of your
  | master layout file. You can choose what these will be called. FYI,
  | chatter will only load resources when you hit a forum route.
  |
  | example:
  | Inside of your <head></head> tag of your master file, you'll need to
  | include @yield('css').
  |
  | Next, before the ending body </body>, you will need to include the footer
  | yield like so @yield('js')
  |
  */

  'yields' => [
      'head'   => 'css',
      'footer' => 'js',
      'taxonomy_content'=>'content'
  ],
  /*
  |--------------------------------------------------------------------------
  | per_page
  |--------------------------------------------------------------------------
  |The default number of terms per page. Default is 10, but you can set it to 20
  |
  */
  'terms_per_page' => 20,
  /*
  |--------------------------------------------------------------------------
  | DEFAULT TAXONOMY
  |--------------------------------------------------------------------------
  |The default taxonomy. This can be defined or changed as needed.
  |
  */
  'default_taxonomy' => 'category',

  /*
  |--------------------------------------------------------------------------
  | DEFAULT TAXONOMY
  |--------------------------------------------------------------------------
  |The default taxonomy. This can be defined or changed as needed.
  |
  */
  'default_pointer_sign' => ' ➤ ',

];
