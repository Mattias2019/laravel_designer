$(document).ready(function(){
  if($('.show-mini-cart').length>0){
    $('.show-mini-cart').off('click').on('click', function(e){
      e.preventDefault();
      e.stopPropagation();
      
      $('#list_popover').fadeToggle();return false;
    });
  }
});

$(document).on('click', '.mega-dropdown', function(e) {
  e.stopPropagation()
})