@extends(Config::get('taxonomies.master_file_extend'))

@section(Config::get('taxonomies.yields.head'))
  <link href="{{ url('/taxonomies/assets/css/taxonomies.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="taxonomies-main">
  @include('taxonomies::partials.taxonomymenu')
  <?php
    $taxs = $Tax::sortedTerms($taxonomy, null, 0, []);
  ?>
  <div class="grid">
     <div class="grid__column grid__column--6 grid__column--#--sm ">
       <div class="cat-list-inner">
        <form class="new-tax-form" action="{{ $taxonomiesPath.'/new/taxonomy' }}" method="post">
          @csrf
          <input type="hidden" name="taxonomy" value="{{ $taxonomy }}">
          <fieldset>
            <label for="name">{{ __("Name") }}</label><input type="text" name="name" value="" placeholder="{{ $taxonomies[$taxonomy]['labels']['singular_name'] }} name" required="">
          </fieldset>
          <fieldset>
            <label for="parent">{{ __("Parent") }}</label><select class="parent" name="parent">
                  <option value=""> — — — — {{ __("Choose One") }} — — — — </option>
                @foreach($taxs as $key => $tax)
                  <option value="{{ $tax->id }}" class="level-{{ $tax->level }}">{{ $tax->pointer.' '.$tax->name }}</option>
                @endforeach
              </select>
          </fieldset>
          <fieldset>

            <label for="name">{{ __("Color") }}</label><input type="text" class="jscolor" name="color" value="ab2567" required="" autocomplete="off" style="background-image: none; background-color: rgb(171, 37, 103); color: rgb(255, 255, 255);">

          	<script>
          	function setTextColor(picker) {
          		document.getElementsByTagName('body')[0].style.color = '#' + picker.toString()
          	}
          	</script>

          </fieldset>
          <fieldset>
            <label for="description">Description</label><textarea name="description" class="description"></textarea>
          </fieldset>
          <button type="submit" class="control__button button button--filled button--primary" name="button">Add New</button>
        </form>
       </div>
     </div><div class="grid__column grid__column--6 grid__column--#--md ">
       <div class="inner-ul-li">
         <ul class="the-items">
           @foreach($paginatedTaxonomies as $key => $taxx )
           <li data-value="{{ $taxx->id }}" class="level-{{ $taxx->level }}"><a href="{{ url(Config::get('taxonomies.taxonomy_path')).'?taxonomy='.$taxonomy.'&term_id='.$taxx->id }}">{{ $taxx->pointer.' '.$taxx->name }}</a></li>
           @endforeach
         </ul>
         <div class="pagination-container">
           {{ $paginatedTaxonomies->links() }}
         </div>
       </div>
     </div>
 </div>

</div>
@endsection


@section(Config::get('taxonomies.yields.footer'))
<script src="{{ url('/taxonomies/assets/js/jscolor.js') }}"></script>
@endsection
