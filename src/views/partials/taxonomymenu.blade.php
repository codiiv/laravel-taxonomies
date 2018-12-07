<div class="taxonomies-menu">
  <ul>
    @foreach($taxonomies as $key => $tax)
      <li><a href="{{ '?taxonomy='.$key }}">{{ $tax['labels']['name'] }}</a></li>
    @endforeach
  </ul>
</div>
