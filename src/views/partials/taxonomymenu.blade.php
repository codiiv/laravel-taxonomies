<div class="taxonomies-menu" style="clear:both">
  <ul>
    @foreach($taxonomies as $key => $tax)
      <?php
        $uniqueTo = isset(\Request()->unique_to) && \Request()->unique_to != '' ? '&unique_to='.\Request()->unique_to : '';
      ?>
      <li class="taxonomy-item {{ ($key == $taxonomy) ? 'active':'' }}"><a href="{{ '?taxonomy='.$key.$uniqueTo }}">{{ $tax['labels']['name'] }}</a></li>
    @endforeach
  </ul>
</div>
