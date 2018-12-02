(function($){
  $(document).on('mouseover','.the-items li', function(event){
    $('.the-items li .taxonomies-actions').css({"display":"none"});
    $(this).find('.taxonomies-actions').css({"display":"block"});
  });
  $(document).on('mouseout','.the-items li', function(event){
    $('.the-items li .taxonomies-actions').css({"display":"none"}); 
  });
})(jQuery);
