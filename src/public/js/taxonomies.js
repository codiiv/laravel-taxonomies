(function($){
  function slugify(string) {
      const a = 'àáäâãåèéëêìíïîòóöôùúüûñçßÿœæŕśńṕẃǵǹḿǘẍźḧ·/_,:;'
      const b = 'aaaaaaeeeeiiiioooouuuuncsyoarsnpwgnmuxzh------'
      const p = new RegExp(a.split('').join('|'), 'g')

      return string.toString().toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with
        .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
        .replace(/&/g, '-and-') // Replace & with ‘and’
        .replace(/[^\w\-]+/g, '') // Remove all non-word characters
        .replace(/\-\-+/g, '-') // Replace multiple — with single -
        .replace(/^-+/, '') // Trim — from start of text .replace(/-+$/, '') // Trim — from end of text
  }

  $(document).on('mouseover','.the-items li', function(event){
    $('.the-items li .taxonomies-actions').css({"display":"none"});
    $(this).find('.taxonomies-actions').css({"display":"inline-block"});
  });
  $(document).on('mouseout','.the-items li', function(event){
    $('.the-items li .taxonomies-actions').css({"display":"none"});
  });
  $(document).on("click", ".delete-taxonomy", function(event){
    event.preventDefault();
    var token = $('input[name="_token"]').val();
    var togo = $(this).data('termid');
    $('input[name="tobedeleted"]').val(togo);
    $( ".delete-taxonomy-term" ).submit();
    // alert($( ".delete-taxonomy-term" ).serialize());
  });

  $(document).on('input','input[name="name"]', function(){
    var slug = slugify($(this).val());
    $('input[name="slug"]').val(slug);
  });
})(jQuery);
