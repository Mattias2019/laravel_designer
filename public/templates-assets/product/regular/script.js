$(document).ready(function(){
  if(jQuery('.category-accordian').length>0){
    var selectIds = $('.category-accordian .panel-collapse');
    selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
        $(this).prev().find('span i').toggleClass('fa-plus fa-minus');
    })
  }
  
  if(jQuery('#price_range').length>0){
    $('#price_range').slider();
  }
  
  if($('.products-list-top .product-views').length>0){
    $('.products-list-top .product-views [data-toggle="tooltip"]').tooltip(); 
  }
  
  if($('.product-categories-accordian h2 span').length>0){
    $('.product-categories-accordian h2 span').click(function(){
      $('.product-categories-accordian .category').slideToggle("slow");
      $('.product-categories-accordian h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('.variations-product-list h2 span').length>0){
    $('.variations-product-list h2 span').click(function(){
      $('.variations-product-list .variations-list').slideToggle("slow");
      $('.variations-product-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('.price-filter h2 span').length>0){
    $('.price-filter h2 span').click(function(){
      $('.price-filter .price-slider-option').slideToggle("slow");
      $('.price-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('.tags-product-list h2 span').length>0){
    $('.tags-product-list h2 span').click(function(){
      $('.tags-product-list .tag-list').slideToggle("slow");
      $('.tags-product-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('.brands-list h2 span').length>0){
    $('.brands-list h2 span').click(function(){
      $('.brands-list .carousel').slideToggle("slow");
      $('.brands-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('.advertisement h2 span').length>0){
    $('.advertisement h2 span').click(function(){
      $('.advertisement .advertisement-content').slideToggle("slow");
      $('.advertisement h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .sort-filter h2 span').length>0){
    $('#shop_page .sort-filter h2 span').click(function(){
      $('#shop_page .sort-filter .sort-filter-option').slideToggle("slow");
      $('#shop_page .sort-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .colors-filter h2 span').length>0){
    $('#shop_page .colors-filter h2 span').click(function(){
      $('#shop_page .colors-filter .colors-filter-option').slideToggle("slow");
      $('#shop_page .colors-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .size-filter h2 span').length>0){
    $('#shop_page .size-filter h2 span').click(function(){
      $('#shop_page .size-filter .size-filter-option').slideToggle("slow");
      $('#shop_page .size-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  $(window).resize(function(){
      if($(window).width() >768 ){
        $('.product-categories-accordian .category-accordian, .variations-product-list .variations-list, .price-filter .price-slider-option, .tags-product-list .tag-list, .brands-list .carousel, .advertisement .advertisement-content, #shop_page .sort-filter .sort-filter-option, #shop_page .colors-filter .colors-filter-option, #shop_page .size-filter .size-filter-option').removeAttr('style');
      }
  });
  
  if($('#shop_page #price_range').length>0){
    $('#shop_page #price_range') .slider()
      .on('slideStop', function(ev){
        $('#price_min').val(ev.value[0]);
        $('#price_max').val(ev.value[1]);
        $('.price-slider-option .tooltip-inner').html(ev.value[0] + ':' + ev.value[1]);
      });
  }
  
  if($('#shop_page').length>0){
    $(".sort-by-filter").select2();
    
    $('.sort-by-filter').select2().on('change', function() {
      window.location.href = replaceUrlParam(window.location.href, "sort_by", $(this).val());
    }); 
  }
});

function replaceUrlParam(url, paramName, paramValue){
  if(paramValue == null)
      paramValue = '';
  var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
  if(url.search(pattern)>=0){
      return url.replace(pattern,'$1' + paramValue + '$2');
  }
  return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}