<div class="taxonomies-menu" style="clear:both">
  <ul>
    @foreach($taxonomies as $key => $tax)
      <li class="taxonomy-item {{ ($key == $taxonomy) ? 'active':'' }}"><a href="{{ '?taxonomy='.$key }}">{{ $tax['labels']['name'] }}</a></li>
    @endforeach
    @if(isset($_GET['taxonomy']))
      <li class="add-tax"> <a href="{{ url()->current() }}?taxonomy={{ $_GET['taxonomy'] }}">{{ __("Add new").' '.$taxonomies[$_GET['taxonomy']]['labels']['singular_name'] }}</a> </li>
    @endif
  </ul>
</div>
