<div class="taxonomies-menu">
  <ul>
    @foreach($taxonomies as $key => $tax)
      <li><a href="{{ url(Config::get('taxonomies.taxonomy_path')).'?taxonomy='.$key }}">{{ $tax['labels']['name'] }}</a></li>
    @endforeach
  </ul>
</div>
