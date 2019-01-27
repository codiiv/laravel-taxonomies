@extends(Config::get('taxonomies.master_file_extend'))

@section(Config::get('taxonomies.yields.head'))
  <link href="{{ url('/taxonomies/assets/css/taxonomies.css') }}" rel="stylesheet">
@endsection

@section(Config::get('taxonomies.yields.taxonomy_content'))
<div class="taxonomies-main">
  @include('taxonomies::partials.taxonomymenu')
  <?php
    $uniqueTo = '';
    $taxs = $Taxonomy::sortedTerms($taxonomy, null, 0, [], $uniqueTo);
  ?>
  <div class="grid">
     <div class="grid__column grid__column--6 grid__column--#--sm ">
       <div class="cat-list-inner">

         @if($term_exists)
            @include('taxonomies::partials.editform', ['taxs' => $taxs,'unique_to'=>$uniqueTo])
         @else
            @include('taxonomies::partials.newform', ['taxs' => $taxs, 'unique_to'=>$uniqueTo])
         @endif

       </div>
     </div><div class="grid__column grid__column--6 grid__column--#--md ">
       <div class="inner-ul-li">
        @include('taxonomies::partials.list-items',['unique_to'=>$uniqueTo])
       </div>
     </div>
 </div>

</div>
@endsection


@section(Config::get('taxonomies.yields.footer'))
<script src="{{ url('/taxonomies/assets/js/jscolor.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="{{ url('/taxonomies/assets/js/taxonomies.js') }}"></script>
@endsection
