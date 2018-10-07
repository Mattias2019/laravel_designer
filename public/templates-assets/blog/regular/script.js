$(document).ready(function(){
    if($('#blogs_main .blog-categories-accordian .category-accordian').length>0){
        var selectIds = $('#blogs_main .blog-categories-accordian .category-accordian .panel-collapse');
        selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
            $(this).prev().find('span i').toggleClass('fa-plus fa-minus');
        })
    }
  
    if($('#blogs_main .blog-categories-accordian h2 span').length>0){
        $('#blogs_main .blog-categories-accordian h2 span').click(function(){
          $('#blogs_main .blog-categories-accordian .category-accordian').slideToggle("slow");
          $('#blogs_main .blog-categories-accordian h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
        });
    }
  
    $(window).resize(function(){
        if($(window).width() >768 ){
            $('#blogs_main .blog-categories-accordian .category-accordian').removeAttr('style');
        }
    });
});