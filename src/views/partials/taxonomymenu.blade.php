<div class="taxonomies-menu" style="clear:both">
  <ul>
    @foreach($taxonomies as $key => $tax)
      <li class="taxonomy-item {{ ($key == $taxonomy) ? 'active':'' }}"><a href="{{ '?taxonomy='.$key }}">{{ $tax['labels']['name'] }}</a></li>
    @endforeach
  </ul>
</div>
