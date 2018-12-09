<?php
$unique_to = isset($unique_to) ? $unique_to : '';
?>
<div class="add-header">

</div>
<form class="new-tax-form" action="{{ $taxonomiesPath.'/new/taxonomy' }}" method="post">
  @csrf
  <input type="hidden" name="taxonomy" value="{{ $taxonomy }}">
  <input type="hidden" name="back_to" value="{{ url()->full() }}">
  <?php if(isset($_GET['page'])){ ?>
    <input type="hidden" name="page" value="{{ $_GET['page'] }}">
  <?php } ?>
  @if(Config::get('taxonomies.specify_unique_to') && $unique_to!="")
    <input type="hidden" name="unique_to" value="{{ $unique_to }}">
  @endif

  <fieldset>
    <label for="name">{{ __("Name") }}</label><input type="text" name="name" value="" placeholder="{{ $taxonomies[$taxonomy]['labels']['singular_name'] }} name" required="">
  </fieldset>
  <fieldset>
    <label for="slug">{{ __("Slug") }}</label><input type="text" name="slug" value="" required="" style="background-color:#efe">
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
