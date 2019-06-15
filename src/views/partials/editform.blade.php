<?php
$unique_to = isset($unique_to) ? $unique_to : '';
?>
<div class="add-header">

</div>
<form class="new-tax-form" action="/{{ $taxonomiesPath.'/update/taxonomy' }}" method="post">
  @csrf
  <input type="hidden" name="taxonomy" value="{{ $taxonomy }}">
  <input type="hidden" name="back_to" value="{{ url()->full() }}">
  <input type="hidden" name="term_id" value="{{ $the_term->id }}">
  <?php if(isset($_GET['page'])){ ?>
    <input type="hidden" name="page" value="{{ $_GET['page'] }}">
  <?php } ?>
  <input type="hidden" name="unique_to" value="{{ $unique_to }}">
  <fieldset>
    <label for="name">{{ __("Name") }}</label><input type="text" name="name" value="{{ $the_term->name }}" placeholder="{{ $taxonomies[$taxonomy]['labels']['singular_name'] }} name" required="">
  </fieldset>
  <fieldset>
    <label for="slug">{{ __("Slug") }}</label><input type="text" name="slug" value="{{ $the_term->slug }}" required="" style="background-color:#efe">
  </fieldset>


  <!-- specify_unique_to -->
  <?php if(Codiiv\Taxonomies\Models\Custom::Taxonomies()[$taxonomy]['hierarchical']): ?>
    <fieldset>
      <label for="parent">{{ __("Parent") }}</label><select class="parent" name="parent">
        <option value=""> — — — — {{ __("Choose One") }} — — — — </option>
        @foreach($taxs as $key => $tax)
        <option value="{{ $tax->id }}" class="level-{{ $tax->level }}" {{ $tax->id == $the_term -> parent_id ? 'selected':'' }}>{{ $tax->pointer.' '.$tax->name }}</option>
        @endforeach
      </select>
    </fieldset>
  <?php endif; ?>

  <fieldset>

    <label for="name">{{ __("Color") }}</label><input type="text" class="jscolor" name="color" value="{{ $the_term ->color }}" required="" autocomplete="off" style="background-image: none; background-color: rgb(171, 37, 103); color: rgb(255, 255, 255);">

    <script>
    function setTextColor(picker) {
      document.getElementsByTagName('body')[0].style.color = '#' + picker.toString()
    }
    </script>

  </fieldset>
  <fieldset>
    <label for="description">Description</label><textarea name="description" class="description">{{ $the_term -> description }}</textarea>
  </fieldset>
  <button type="submit" class="control__button button button--filled button--primary" name="button">{{ __("Update") }}</button>
</form>
