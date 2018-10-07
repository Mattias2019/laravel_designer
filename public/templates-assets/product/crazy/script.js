$(document).ready(function(){
  if($('#shop_page .category-accordian').length>0){
    var selectIds = $('#shop_page .category-accordian .panel-collapse');
    selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
        $(this).prev().find('span i').toggleClass('fa-plus fa-minus');
    })
  }
  
  if($('#shop_page #price_range').length>0){
    $('#shop_page #price_range').slider();
  }
  
  if($('#shop_page .products-list-top .product-views').length>0){
    $('#shop_page .products-list-top .product-views [data-toggle="tooltip"]').tooltip(); 
  }
  
  if($('#shop_page .product-categories-accordian h2 span').length>0){
    $('#shop_page .product-categories-accordian h2 span').click(function(){
      $('#shop_page .product-categories-accordian .category').slideToggle("slow");
      $('#shop_page .product-categories-accordian h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .variations-product-list h2 span').length>0){
    $('#shop_page .variations-product-list h2 span').click(function(){
      $('#shop_page .variations-product-list .variations-list').slideToggle("slow");
      $('#shop_page .variations-product-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .price-filter h2 span').length>0){
    $('#shop_page .price-filter h2 span').click(function(){
      $('#shop_page .price-filter .price-slider-option').slideToggle("slow");
      $('#shop_page .price-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .tags-product-list h2 span').length>0){
    $('#shop_page .tags-product-list h2 span').click(function(){
      $('#shop_page .tags-product-list .tag-list').slideToggle("slow");
      $('#shop_page .tags-product-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .brands-list h2 span').length>0){
    $('#shop_page .brands-list h2 span').click(function(){
      $('#shop_page .brands-list .carousel').slideToggle("slow");
      $('#shop_page .brands-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#shop_page .advertisement h2 span').length>0){
    $('#shop_page .advertisement h2 span').click(function(){
      $('#shop_page .advertisement .advertisement-content').slideToggle("slow");
      $('#shop_page .advertisement h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
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
        $('#shop_page .product-categories-accordian .category, #shop_page .variations-product-list .variations-list, #shop_page .price-filter .price-slider-option, #shop_page .tags-product-list .tag-list, #shop_page .brands-list .carousel, #shop_page .advertisement .advertisement-content, #shop_page .sort-filter .sort-filter-option, #shop_page .colors-filter .colors-filter-option, #shop_page .size-filter .size-filter-option').removeAttr('style');
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