@extends(Config::get('taxonomies.master_file_extend'))

@section(Config::get('taxonomies.yields.head'))
  <link href="{{ url('/taxonomies/assets/css/taxonomies.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="taxonomies-main">
  @include('taxonomies::partials.taxonomymenu')
  <?php
    $taxs = $Taxonomy::sortedTerms($taxonomy, null, 0, []);
  ?>
  <div class="grid">
     <div class="grid__column grid__column--6 grid__column--#--sm ">
       <div class="cat-list-inner">

         @if($term_exists)
            @include('taxonomies::partials.editform', ['taxs' => $taxs])
         @else
            @include('taxonomies::partials.newform', ['taxs' => $taxs])
         @endif

       </div>
     </div><div class="grid__column grid__column--6 grid__column--#--md ">
       <div class="inner-ul-li">
        @include('taxonomies::partials.list-items'])
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
