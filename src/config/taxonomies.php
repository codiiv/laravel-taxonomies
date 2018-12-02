<?php
return [
  "taxonomy_path"      => "/dashboard/taxonomies",
  "master_file_extend" => "layouts.app",

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
  ],
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
  

];
