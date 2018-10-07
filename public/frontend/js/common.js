//var frontendLocalizationString;

/*scroll to top*/
$(document).ready(function(){
  $(function () {
          $.scrollUp({
          scrollName: 'scrollUp',
          scrollDistance: 300,
          scrollFrom: 'top',
          scrollSpeed: 300, 
          easingType: 'linear',
          animation: 'fade',
          animationSpeed: 200,
          scrollTrigger: false,
          scrollText: '<i class="fa fa-angle-up"></i>',
          scrollTitle: false,
          scrollImg: false, 
          activeOverlay: false,
          zIndex: 2147483647
          });
  });
	
	$('.shopist-iCheck').iCheck({
		checkboxClass: 'icheckbox_square-purple',
		radioClass: 'iradio_square-purple',
		increaseArea: '20%'
	});

  shopist_frontend.init.pageLoad();
  
  $('#productRequest').on('hidden.bs.modal', function () 
  {
    $('.subscribe-message').text('');
    $('#subscribe_email').val('');
  });
	
  if($('#frontend_all_msg_with_localization').length>0)
  {
    frontendLocalizationString = JSON.parse( $('#frontend_all_msg_with_localization').val() );
  }
  
  //upload profile image
  if($('#frontend_user_profile_picture_uploader').length>0)
  {
    Dropzone.autoDiscover = false;
    $("#frontend_user_profile_picture_uploader").dropzone({ 
      url: $('#hf_base_url').val() + "/upload/product-related-image",
      paramName: "profile_picture", 
      acceptedFiles:  "image/*", 
      uploadMultiple:false, 
      maxFiles:1, 
      autoProcessQueue: true, 
      parallelUploads: 100, 
      addRemoveLinks: true, 
      maxFilesize: 1,
      dataType:  'json',
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
      
      init: function() 
      {
        this.on("maxfilesexceeded", function(file){
            swal("" , frontendLocalizationString.maxfilesexceeded_msg);
        });
        this.on("error", function(file, message){
          if (file.size > 1*1024*1024) 
          {
            swal("" , frontendLocalizationString.file_larger);
            this.removeFile(file)
             return false;
          }
          if(!file.type.match('image.*')) {
            swal("" , frontendLocalizationString.image_file_validation);
            this.removeFile(file)
            return false;
          }
        });
        
        this.on("success", function(file, responseText) 
        {
          if(responseText.status === 'success')
          {
            $('.profile-picture').find('img').attr('src', $('#hf_base_url').val() + '/public/uploads/'+ responseText.name);
            $('.profile-picture').show();
            $('.no-profile-picture').hide();
            $('#frontendUserUploadProfilePicture').modal('hide');
            $('#hf_frontend_profile_picture').val( '/public/uploads/'+ responseText.name );

            this.removeAllFiles();
          }
        });
      }
    });
  }
  
  if($('.remove-frontend-profile-picture').length>0)
  {
    $('.remove-frontend-profile-picture').on('click', function()
    {
      $('.no-profile-picture').show();
      $('.profile-picture').hide();
      $('#hf_frontend_profile_picture').val('');
    });
  }
  
  $('.products-brands-list .carousel[data-type="multi"] .item').each(function(){
    var next = $(this).next();
    if (!next.length) {
      next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    for (var i=0;i<2;i++) {
      next=next.next();
      if (!next.length) {
          next = $(this).siblings(':first');
          }

      next.children(':first-child').clone().appendTo($(this));
    }
  });
  
  //cat accordian
  if($('#product-category .category-accordian').length>0 ){
    var selectIds = $('#product-category .category-accordian .panel-collapse');
    selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
        $(this).prev().find('span i').toggleClass('fa-plus fa-minus');
    })
  }
  
  if($('#blog-cat-content-main .category-accordian').length>0 ){
    var selectIds = $('#blog-cat-content-main .category-accordian .panel-collapse');
    selectIds.on('show.bs.collapse hidden.bs.collapse', function () {
        $(this).prev().find('span i').toggleClass('fa-plus fa-minus');
    })
  }
  
  if($('#product-category #price_range').length>0){
    $('#product-category #price_range') .slider()
      .on('slideStop', function(ev){
        $('#price_min').val(ev.value[0]);
        $('#price_max').val(ev.value[1]);
        $('.price-slider-option .tooltip-inner').html(ev.value[0] + ':' + ev.value[1]);
      });
  }
  
  if($('.products-list-top .product-views').length>0){
    $('.products-list-top .product-views [data-toggle="tooltip"]').tooltip(); 
  }
  
  if($('#product-category .product-categories-accordian h2 span').length>0){
    $('#product-category .product-categories-accordian h2 span').click(function(){
      $('#product-category .product-categories-accordian .category-accordian').slideToggle("slow");
      $('#product-category .product-categories-accordian h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#blog-cat-content-main .blog-categories-accordian h2 span').length>0){
    $('#blog-cat-content-main .blog-categories-accordian h2 span').click(function(){
      $('#blog-cat-content-main .blog-categories-accordian .category-accordian').slideToggle("slow");
      $('#blog-cat-content-main .blog-categories-accordian h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#product-category .price-filter h2 span').length>0){
    $('#product-category .price-filter h2 span').click(function(){
      $('#product-category .price-filter .price-slider-option').slideToggle("slow");
      $('#product-category .price-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#product-category .sort-filter h2 span').length>0){
    $('#product-category .sort-filter h2 span').click(function(){
      $('#product-category .sort-filter .sort-filter-option').slideToggle("slow");
      $('#product-category .sort-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#product-category .colors-filter h2 span').length>0){
    $('#product-category .colors-filter h2 span').click(function(){
      $('#product-category .colors-filter .colors-filter-option').slideToggle("slow");
      $('#product-category .colors-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#product-category .size-filter h2 span').length>0){
    $('#product-category .size-filter h2 span').click(function(){
      $('#product-category .size-filter .size-filter-option').slideToggle("slow");
      $('#product-category .size-filter h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  if($('#tag_single_page_main .tags-product-list h2 span').length>0){
    $('#tag_single_page_main .tags-product-list h2 span').click(function(){
      $('#tag_single_page_main .tags-product-list .tag-list').slideToggle("slow");
      $('#tag_single_page_main .tags-product-list h2 span').toggleClass( 'responsive-accordian responsive-accordian-open');
    });
  }
  
  $(window).resize(function(){
    if($(window).width() >768 ){
      $('#product-category .product-categories-accordian .category-accordian, #blog-cat-content-main .blog-categories-accordian .category-accordian, .price-filter .price-slider-option, .sort-filter .sort-filter-option, .colors-filter .colors-filter-option, .size-filter .size-filter-option, #tag_single_page_main .tags-product-list .tag-list').removeAttr('style');
    }
  });
	
	if($('#table_user_account_order_list').length>0 || $('#coupons_list').length>0 || $('#table_user_account_download_list').length>0){
		$('#table_user_account_order_list, #coupons_list, #table_user_account_download_list').DataTable();
	}
  
	if($('#product_single_page').find('.read-review .reviews').length>0){
    $('#product_single_page').find('.read-review .reviews').on('click', function(){
      product_review_tab_control_with_hashtag();
    });
  }
  
  if($('#product_single_page').find('.write-review .open-comment-form').length>0){
    $('#product_single_page').find('.write-review .open-comment-form').on('click', function(){
      product_review_tab_control_with_hashtag();
    });
  }
  
  $('.blog-reviews-content .rating-select .btn').on('mouseover', function(){
		$(this).removeClass('btn-default').addClass('btn-warning');
		$(this).prevAll().removeClass('btn-default').addClass('btn-warning');
		$(this).nextAll().removeClass('btn-warning').addClass('btn-default');
	});

	$('.blog-reviews-content .rating-select').on('mouseleave', function(){
		active = $(this).parent().find('.blog-selected');
		if(active.length) {
			active.removeClass('btn-default').addClass('btn-warning');
			active.prevAll().removeClass('btn-default').addClass('btn-warning');
			active.nextAll().removeClass('btn-warning').addClass('btn-default');
		} else {
			$(this).find('.btn').removeClass('btn-warning').addClass('btn-default');
		}
	});

	$('.blog-reviews-content .rating-select .btn').click(function(){
		if($(this).hasClass('blog-selected')) {
			$('.blog-reviews-content .rating-select .blog-selected').removeClass('blog-selected');
		} else {
			$('.blog-reviews-content .rating-select .blog-selected').removeClass('blog-selected');
			$(this).addClass('blog-selected');
			
			if($('.blog-reviews-content #selected_rating_value').length>0){
				$('.blog-reviews-content #selected_rating_value').val( $(this).data('rating_value') );
			}
		}
	});
  
  if($('#product_single_page').length>0){
    var hash = window.location.hash;
    
    if(hash && (hash == '#product_description_bottom_tab' || hash == '#new_comment_form')){
      product_review_tab_control_with_hashtag();
    }
  }
  
  if($('#subscribtion_submit').length>0){
    $('#subscribtion_submit').on('click', function(){
      var obj = $(this);
      var str = false;
      
      if($('#subscribe_options_name').length>0 && ($('#subscribe_options_name').val().length == 0 || $('#subscribe_options_name').val() == "")){
        $('#subscribe_options_name').css('border', '2px solid #FF0000');
        str = true;
      }
      else{
        $('#subscribe_options_name').css('border', 'none');
      }
      
      if($('#subscribe_options_email').length>0 && (($('#subscribe_options_email').val().length == 0 || $('#subscribe_options_email').val() == "") || !isValidEmail( $('#subscribe_options_email').val() ))){
        $('#subscribe_options_email').css('border', '2px solid #FF0000');
        str = true; 
      }
      else{
        $('#subscribe_options_email').css('border', 'none');
      }
      
      if(!str){
        var name  = '';
        var email = '';
        var type  = '';
        
        if($('#subscribe_options_name').length> 0 && $('#subscribe_options_name').val().length > 0){
          name = $('#subscribe_options_name').val();
        }
        
        if($('#subscribe_options_email').length>0 && $('#subscribe_options_email').val().length > 0){
          email = $('#subscribe_options_email').val();
        }
        
        if($('#subscription_type').length>0 && $('#subscription_type').val().length > 0){
          type = $('#subscription_type').val();
        }
        
        shopist_frontend.ajaxCall.sendSubscriptionData(obj, name, email, type);
      }
    });
  }
  
  //checkout multistep
  var current = 1;
  var is_enable_selected = false;
		
  widget      = $("#checkout_page .step");
  btnnext     = $("#checkout_page .next");
  btnsubmit   = $("#checkout_page .submit");

  // Init buttons and UI
  widget.not(':eq(0)').hide();
  hideButtons(current);
  setProgress(current);

  // Next button click action
  btnnext.click(function(e){
    e.preventDefault();
   
    if(checkoutStepValidation()){
      if(current < widget.length){
        widget.show();
        //alert($('#checkout_page .checkout-content').find('#guest_user_address').index());
        if($('#selected_user_mode').val().length>0 && $('#selected_user_mode').val() == 'login_user' && !is_enable_selected && $('#is_user_login').val() == false){
          var get_authentication_index = parseInt( $('#checkout_page .checkout-content').find('#authentication').index() ) - 1; 
          
          widget.not(':eq('+ get_authentication_index +')').hide();
          is_enable_selected = true;
        }
        else if($('#selected_user_mode').val().length>0 && $('#selected_user_mode').val() == 'login_user' && !is_enable_selected && $('#is_user_login').val() == true){
          var get_login_user_address_index = parseInt( $('#checkout_page .checkout-content').find('#login_user_address').index() ) - 1; 
          var get_payment_index = parseInt( $('#checkout_page .checkout-content').find('#payment').index() ) - 1;
          
          widget.not(':eq('+ get_login_user_address_index +')').hide();
          is_enable_selected = true;
          current = get_payment_index;
        }
        else if($('#selected_user_mode').val().length>0 && $('#selected_user_mode').val() == 'guest' && !is_enable_selected){
          var get_guest_user_address_index = parseInt( $('#checkout_page .checkout-content').find('#guest_user_address').index() ) - 1; 
          var get_payment_index = parseInt( $('#checkout_page .checkout-content').find('#payment').index() ) - 1; 
          
          widget.not(':eq(' + get_guest_user_address_index + ')').hide();
          is_enable_selected = true;
          current = get_payment_index;
        }
        else{
          widget.not(':eq('+(current++)+')').hide();
        }
        
        setProgress(current);
      }
      
      hideButtons(current);
    }
  })
 
  if($('#checkout_page #user_mode .checkout-process-user-mode').length>0){
    $('#checkout_page #user_mode .checkout-process-user-mode input[type="radio"]').on('ifClicked', function(event){
      $('#selected_user_mode').val(this.value);
    });
  }
  
  if($('#account_bill_phone_number').length>0 || $('#account_shipping_phone_number').length>0 || $('#account_bill_zip_or_postal_code').length>0 || $('#account_shipping_zip_or_postal_code').length>0 || $('#account_bill_fax_number').length>0  || $('#account_shipping_fax_number').length>0){
    $("#account_bill_phone_number, #account_shipping_phone_number, #account_bill_zip_or_postal_code, #account_shipping_zip_or_postal_code, #account_bill_fax_number, #account_shipping_fax_number").ForceNumericOnly();
  }
  
  if($('#apply_coupon_post').length>0){
    $('#apply_coupon_post').on('click', function(e){
      e.preventDefault();
      if($('#apply_coupon_code').val().length == 0 && $('#apply_coupon_code').val() == ''){
        $('#apply_coupon_code').css({'border' : '1px solid #f06953'});
        return false
      }
      else{
        $('#apply_coupon_code').css({'border' : '1px solid #cccccc'});
        shopist_frontend.ajaxCall.applyCoupon( $('#apply_coupon_code').val() );
      }
    });
  }
  
  if($('.delete_item_from_wishlist').length>0){
    $('.delete_item_from_wishlist').on('click', function(e){
      e.preventDefault();
      shopist_frontend.ajaxCall.wishlistItemDelete( $(this).data('id') );
    });
  }
  
  if($('.chk-colors-filter').length>0){
    $('.chk-colors-filter').on('ifChanged', function(event){
      if(event.currentTarget.checked) {
        if($('#selected_colors').length>0 && $('#selected_colors').val().length>0){
          $('#selected_colors').val( $('#selected_colors').val() + ',' + event.currentTarget.value);
        }
        else{
          $('.filter-panel .colors-filter').append('<input name="selected_colors" id="selected_colors" type="hidden">');
          $('#selected_colors').val( event.currentTarget.value );
        }
      } 
      else if(!event.currentTarget.checked) {
        if($('#selected_colors').length>0 && $('#selected_colors').val().length>0){
          var selected_colors = '';
          var parse = $('#selected_colors').val().split(',');
          
          if(parse.length>0){
            for(var i=0; i<parse.length; i++){
              if(event.currentTarget.value != parse[i]){
                selected_colors +=  parse[i] + ',';
              }
            }
          }
          
          if(selected_colors && selected_colors != ''){
            $('#selected_colors').val( selected_colors.replace(/,\s*$/, "") );
          }
          else{
            $('#selected_colors').remove();
          }
        }
      }
    });
  }
  
  if($('.chk-size-filter').length>0){
    $('.chk-size-filter').on('ifChanged', function(event){
      if(event.currentTarget.checked) {
        if($('#selected_sizes').length>0 && $('#selected_sizes').val().length>0){
          $('#selected_sizes').val( $('#selected_sizes').val() + ',' + event.currentTarget.value);
        }
        else{
          $('.filter-panel .size-filter').append('<input name="selected_sizes" id="selected_sizes" type="hidden">');
          $('#selected_sizes').val( event.currentTarget.value );
        }
      } 
      else if(!event.currentTarget.checked) {
        if($('#selected_sizes').length>0 && $('#selected_sizes').val().length>0){
          var selected_sizes = '';
          var parse = $('#selected_sizes').val().split(',');
          
          if(parse.length>0){
            for(var i=0; i<parse.length; i++){
              if(event.currentTarget.value != parse[i]){
                selected_sizes +=  parse[i] + ',';
              }
            }
          }
          
          if(selected_sizes && selected_sizes != ''){
            $('#selected_sizes').val( selected_sizes.replace(/,\s*$/, "") );
          }
          else{
            $('#selected_sizes').remove();
          }
        }
      }
    });
  }
  
  //if($('.mini-cart-content').length>0){
    //shopist_frontend.ajaxCall.getMiniCartContent();
  //}
  
  if($('#different_shipping_address').length>0){
    $('#different_shipping_address').on('ifChecked', function (event){
      $('.different-shipping-address').show();
    });
    $('#different_shipping_address').on('ifUnchecked', function (event) {
      $('.different-shipping-address').hide();
    });
  }
  
  //slick start
  if($('.upsell-products').length>0){
    $('.upsell-products').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows:true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  }
  
  if($('.crosssell-products').length>0){
    $('.crosssell-products').slick({
      dots: false,
      infinite: false,
      speed: 300,
      slidesToShow: 4,
      slidesToScroll: 4,
      arrows:true,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  }
  
  if($('.vendor-top-collection').length>0){
    $('.vendor-top-collection').slick({
      dots: true,
      infinite: true,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows:false,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
            infinite: true,
            dots: false
          }
        },
        {
          breakpoint: 600,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1
          }
        }
      ]
    });
  }
  
  if($('.special-items').length>0){
    slickInit();
  }
  
  $(".vendor-categories-list").mCustomScrollbar({
    autoHideScrollbar:true,
    theme:"rounded"
  }); 
  
  if($('.vendor-special-products-menu').length>0){
    $('#vendor_home_content ul.vendor-special-products-menu li a').on('click', function(){
      $(this).parents('.vendor-special-products-menu').find('.active').removeClass('active');
      $(this).addClass('active');
      
      $(".special-items").slick("unslick");
      setTimeout(slickInit, 10);
    });
  }
});

var shopist_frontend = shopist_frontend || {};

shopist_frontend.init =
{
  pageLoad:function()
  {
    $('.category-products .collapse').on('shown.bs.collapse', function(){
      $(this).parent().find(".fa-plus").removeClass("fa-plus").addClass("fa-minus");
      }).on('hidden.bs.collapse', function(){
      $(this).parent().find(".fa-minus").removeClass("fa-minus").addClass("fa-plus");
    }); 
    
    shopist_frontend.event.filterProducts();
    
    if(jQuery('#productVideoDisplay iframe').length>0)
    {
      jQuery('#productVideoDisplay iframe').removeAttr('width');
      jQuery('#productVideoDisplay iframe').removeAttr('height');
      
      $('#productVideoDisplay').on('hidden.bs.modal', function () 
      {
        var video = $("#productVideoDisplay iframe").attr("src");
        $("#productVideoDisplay iframe").attr("src","");
        $("#productVideoDisplay iframe").attr("src", video);
      });
    }
    
    if(jQuery('#productVideoDisplay video').length>0)
    {
      $('#productVideoDisplay').on('hidden.bs.modal', function () 
      {
        var mediaElement = document.getElementById("product_video"); 
        mediaElement.pause(); 
        mediaElement.currentTime = 0;
      });
    }
    
    if($('#shipping_method_dropdown').length>0){
      $("#shipping_method_dropdown").select2();
      shopist_frontend.event.shipping_method_dropdown_option();
    }
    
    if($('#product-category').length>0){
      $(".sort-by-filter").select2();
      
      $('.sort-by-filter').select2().on('change', function() {
        window.location.href = commonReplaceUrlParam(window.location.href, "sort_by", $(this).val());
      });
    }
    
    if($('#cart_page .cart-total-content input[type="radio"]').length>0 || $('#checkout_page .cart-total-content input[type="radio"]').length>0){
      shopist_frontend.event.shipping_method_radio_option();
    }
    
//    if($('#bill_select_country').length>0)
//    {
//      $("#bill_select_country").select2();
//    }
    
    if($('.view-customize-images').length>0)
    {
      $('.view-customize-images').on('click', function(e)
      {
        e.preventDefault();
        var images = $(this).data('images');
        var html = '';
        
        if(images.length > 0)
        {
          for(var count = 0; count< images.length; count ++)
          {
            html += '<img src= "'+ $('#hf_base_url').val() +'/public/uploads/'+ images[count] +'">';
          }
        }
        
        $('#customizeImages .modal-body').html( html );
        $('#customizeImages').modal('show'); 
      });
    }
    
    $('#customizeImages').on('hidden.bs.modal', function () 
    {
      $('#customizeImages .modal-body').html('');
    });
    
    if($('.payment-options').length>0){
      $('.payment-options input[type="radio"]').on('ifClicked', function(event){
        if(this.value === 'paypal'){
          $('.place-order').text( frontendLocalizationString.proceed_to_payPal );
          $('#bacsPopover, #codPopover, #stripePopover, #twocheckoutPopover').hide();
          $('#paypalPopover').show();
        }
        else if(this.value === 'bacs'){
          $('.place-order').text( frontendLocalizationString.place_order );
          $('#paypalPopover, #codPopover, #stripePopover, #twocheckoutPopover').hide();
          $('#bacsPopover').show();
        }
        else if(this.value === 'cod'){
          $('.place-order').text( frontendLocalizationString.place_order );
          $('#paypalPopover, #bacsPopover, #stripePopover, #twocheckoutPopover').hide();
          $('#codPopover').show();
        }
        else if(this.value === 'stripe'){
          $('.place-order').text( frontendLocalizationString.proceed_to_stripe );
          $('#paypalPopover, #bacsPopover, #codPopover, #twocheckoutPopover').hide();
          $('#stripePopover').show();
        }
        else if(this.value === '2checkout'){
          $('.place-order').text( frontendLocalizationString.proceed_to_2checkout );
          $('#paypalPopover, #bacsPopover, #codPopover, #stripePopover').hide();
          $('#twocheckoutPopover').show();
        }
        
        $('#selected_payment_method').val(this.value);
      });
    }
   
    if($('.frontend-user-logout').length>0)
    {
      $('.frontend-user-logout').on('click', function(e){
        e.preventDefault();
        
        $.ajax({
          url: $('#hf_base_url').val() + '/ajax/frontend-user-logout',
          type: 'POST',
          cache: false,
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
          success: function(data)
          {
            if(data)
            {
              window.location.href = decodeURIComponent(data);
            }
          },
          error:function(){}
        });
      });
    }
		
    if($('.product-wishlist').length>0){
      shopist_frontend.event.user_wishlist_process();
    }
    
    if($('.product-compare').length>0){
      shopist_frontend.event.product_comparison();
    }
    
    if($('.language-list').length>0){
      shopist_frontend.event.multi_lang_process();
    }
		
    if($('.change-multi-currency').length>0){
      shopist_frontend.event.multi_currency_process();
    } 
    
    shopist_frontend.event.manageRequestProducts();
    shopist_frontend.event.remove_user_coupon();
  }
}

shopist_frontend.event =
{
  filterProducts:function()
  {
    if($('#filterProductsByName').length>0)
    {
      $('#filterProductsByName').click(function()
      {
        shopist_frontend.ajaxCall.filterProductsByName( $('#hf_base_url').val() + '/ajax/filter_products' );
      });
    }
  },
  
  ajaxLink:function()
  {
    $('.features-all-images .pagination a').click(function(e)
    {
      e.preventDefault();
      shopist_frontend.ajaxCall.filterProductsByName($(this).attr('href'));
    });
  },
  
  shipping_method_dropdown_option:function()
  {
    $('#cart_page #shipping_method_dropdown, #checkout_page #shipping_method_dropdown').select2().on('change', function() {
      shopist_frontend.ajaxCall.setCartTotalByShippingMethodValue( $(this).val() );
    });
  },
  
  shipping_method_radio_option:function()
  {
    $('#cart_page .cart-total-content input[type="radio"], #checkout_page .cart-total-content input[type="radio"]').on('ifClicked', function(event){
      shopist_frontend.ajaxCall.setCartTotalByShippingMethodValue( this.value );
    });
  },
  
  manageRequestProducts:function()
  {
    if($('#request_product_data_submit').length>0)
    {
      $('#request_product_data_submit').on('click', function(){
        var errorStr = '';

        if($('#request_product_name').val().length == 0 || $('#request_product_name').val() == ""){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_name +'</p>';
        }

        if($('#request_product_email').val().length == 0 || $('#request_product_email').val() == ""){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_email +'</p>';
        }

        if($('#request_product_phone_number').val().length == 0 || $('#request_product_phone_number').val() == ""){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_phone_number +'</p>';
        }

        if($('#request_product_description').val().length == 0 || $('#request_product_description').val() == ""){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_desc +'</p>';
        }

        if($('#request_product_email').val().length > 0 && !isValidEmail($('#request_product_email').val())){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_valid_email +'</p>';
        }

        if($('#request_product_phone_number').val().length > 0 && !validatePhone($('#request_product_phone_number').val())){
         errorStr += '<p class="error">'+ frontendLocalizationString.enter_valid_phone_number +'</p>';
        }


        if(errorStr && errorStr != ''){
          $('.request-field-message').remove();
          var validationStr = '<div class="request-field-message">'+ errorStr +'</div>';
          $('.request-content-main').before( validationStr );
          return false;
        }

        if(errorStr == ''){
          $('.request-field-message').remove();
          shopist_frontend.ajaxCall.sendProductsRequestData( $(this).data('id'), $('#request_product_name').val(), $('#request_product_email').val(), $('#request_product_phone_number').val(), $('#request_product_description').val());
        }
      });
    }
  },
	
  user_wishlist_process:function(){
		$('.product-wishlist').on('click', function(e){
			e.preventDefault();
			shopist_frontend.ajaxCall.setUserWishlistDetails( $(this).data('id') );
		});
  },
  
  product_comparison:function(){
    $('.product-compare').on('click', function(e){
			e.preventDefault();
			shopist_frontend.ajaxCall.setProductCompareData( $(this).data('id') );
		});
  },
  
  multi_lang_process:function()
  {
    $('.language-list .dropdown-content a').on('click', function(e){
      e.preventDefault();
      shopist_frontend.ajaxCall.setMultiLangAndChangeView( $(this).data('lang_name') );
    });
  },
	
  multi_currency_process:function()
  {
    $('.change-multi-currency .dropdown-content a').on('click', function(e){
      e.preventDefault();
      shopist_frontend.ajaxCall.setMultiCurrencyAndChangeView( $(this).data('currency_name') );
    });
  },
  
  remove_user_coupon:function(){
    if($('.remove-coupon').length>0){
      $('.remove-coupon').on('click', function(e){
        e.preventDefault();
        shopist_frontend.ajaxCall.removeCoupon();
      });
    }
  }
}

shopist_frontend.ajaxCall =
{
  filterProductsByName:function(url)
  {
    $('.ajax-overlay').show();
    
    $.ajax({
          url: url,
          type: 'POST',
          cache: false,
          datatype: 'html',
          data: {data:$('#filter_products_title').val()},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },  
          success: function(data)
          {
            if(data.success == true)
            {
              $('.features-all-images').html(data.html);
              shopist_frontend.event.ajaxLink();
            }
            
            $('.ajax-overlay').hide();
          },
          error:function(){}
    });
  },
  
  setCartTotalByShippingMethodValue:function( val )
  {
    $('.cart-total-area-overlay').show();
    $('#loader-1-cart').show();
    
    $.ajax({
        url: $('#hf_base_url').val() + '/ajax/cart-total-update-by-shipping-method',
        type: 'POST',
        cache: false,
        datatype: 'html',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
        data: {data:val},
        success: function(data){
          if(data){
            if($('#cart_page').length>0 || $('#checkout_page').length>0){
              $('.cart-grand-total .value').html( data );
              $('#loader-1-cart').hide();
              $('.cart-total-area-overlay').hide();
            }
          }
        },
        error:function(){}
    });
  },
  
  sendProductsRequestData:function( product_id, product_name, email, phone_number, description )
  {
    $('#request_product_modal').append('<div class="shadow-layer-on-popup"></div>');
    $('#loader-1').show();
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/requested_product_data',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { product_id:product_id, product_name:encodeURIComponent(product_name), email:encodeURIComponent(email), phone_number:encodeURIComponent(phone_number), description:encodeURIComponent(description)},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data)
          {
            if(data.status == 'saved')
            {
              $('#request_product_name').val('');
              $('#request_product_email').val('');
              $('#request_product_phone_number').val('');
              $('#request_product_description').val('');
              $('#loader-1').hide();
              $('#request_product_modal').find('.shadow-layer-on-popup').remove();
              $('.request-field-message').remove();
              $('.request-content-main').before( '<div class="request-field-message"><p class="success">' + frontendLocalizationString.request_saved_msg +'</p></div>');
            }
          },
          error:function(){}
    });
  },
  
  sendSubscriptionData:function(obj, name, email, type){
    $(obj).addClass('subscribtion-loading');
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/subscription_data',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { name:encodeURIComponent(name), email:encodeURIComponent(email), type:type},
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data)
          {
            $(obj).removeClass('subscribtion-loading');
            if($('#subscriptions_modal .subscribe-content').parents('.modal__content').find('.modal-content-msg').length>0){
                $('#subscriptions_modal .subscribe-content').parents('.modal__content').find('.modal-content-msg').remove();
              }
              
              if($('#subscribe_options_email').length>0 && $('#subscribe_options_email').val().length > 0){
               $('#subscribe_options_email').val(''); 
              }
              
              if($('#subscribe_options_name').length>0 && $('#subscribe_options_name').val().length > 0){
               $('#subscribe_options_name').val(''); 
              }
              
            if(data.status == 'saved'){
              $('#subscriptions_modal .subscribe-content').before('<p class="modal-content-msg">'+ frontendLocalizationString.subscribe_success_msg +'</p>');
            }
            else if(data.status == 'error'){
              $('#subscriptions_modal .subscribe-content').before('<p class="modal-content-msg">'+ frontendLocalizationString.subscribe_error_msg +'</p>');
            }
          },
          error:function(){}
    });
  },
  
  applyCoupon:function( val ){
    var msgStr = '<div class="alert alert-danger" style="margin-left:-15px; margin-right:15px;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>'+ frontendLocalizationString.error_message_text +'</strong></div><p class="error-msg-coupon"></p></div>';
    
    $('.cart-total-area-overlay').show();
    $('#loader-1-cart').show();
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/applyCoupon',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { _couponCode: val },
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if($('#cart_page, #checkout_page').find('.error-msg-coupon').length>0){
              $('#cart_page, #checkout_page').find('.error-msg-coupon').parents('.alert-danger').remove();
            }
            
            if(data.error == true && data.error_type == 'no_coupon_data'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_not_exists_msg );
            }
						else if(data.error == true && data.error_type == 'less_from_min_amount' && data.min_amount){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_min_spend_msg + ' '+ data.min_amount);
            }
						else if(data.error == true && data.error_type == 'exceed_from_max_amount' && data.max_amount){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_max_spend_msg + ' '+ data.max_amount);
            }
						else if(data.error == true && data.error_type == 'no_login'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_no_login_msg );
            }
						else if(data.error == true && data.error_type == 'user_role_not_match' && data.role_name){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( data.role_name +' '+ frontendLocalizationString.coupon_no_login_msg );
            }
						else if(data.error == true && data.error_type == 'coupon_expired'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_expired_msg );
            }
            else if(data.error == true && data.error_type == 'coupon_already_apply'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_already_sxist_label );
            }
            
            else if(data.success == true && (data.success_type == 'discount_from_product' || data.success_type == 'percentage_discount_from_product' || data.success_type == 'percentage_discount_from_product' || data.success_type == 'discount_from_total_cart' || data.success_type == 'percentage_discount_from_total_cart')){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.coupon_added_msg );
              $('#cart_page .cart-grand-total, #checkout_page .cart-grand-total').before('<div class="cart-coupon"><div class="label">'+ frontendLocalizationString.coupon_label+'</div><div class="value"> - ' + data.discount_price +'</div><div><button class="remove-coupon btn btn-default btn-xs" type="button">'+ frontendLocalizationString.remove_coupon_label +'</button></div></div>'); 
              $('#cart_page .cart-total-content .cart-grand-total .value, #checkout_page .cart-total-content .cart-grand-total .value').html( data.grand_total );
              
              shopist_frontend.event.remove_user_coupon();
            }
            else if(data.error == true && data.error_type == 'exceed_from_cart_total'){
              $('#cart_page .cart-data, #checkout_page .cart-data').prepend(msgStr);
              $('#cart_page .cart-data, #checkout_page .cart-data').find('.error-msg-coupon').html( frontendLocalizationString.exceed_from_cart_total_msg );
            } 
            
            $('.cart-total-area-overlay').hide();
            $('#loader-1-cart').hide();
          },
          error:function(){}
    });
  },
  
  removeCoupon:function(){
    $('.cart-total-area-overlay').show();
    $('#loader-1-cart').show();
    
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/removeCoupon',
          type: 'POST',
          cache: false,
          dataType: 'json',
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.success == true){
              if($('#cart_page, #checkout_page').find('.cart-data .error-msg-coupon').length>0){
                $('#cart_page, #checkout_page').find('.cart-data .error-msg-coupon').parents('li').remove();
              }
            
							$('#cart_page .cart-total-content .cart-coupon, #checkout_page .cart-total-content .cart-coupon').remove();
              $('#cart_page .cart-total-content .cart-grand-total .value, #checkout_page .cart-total-content .cart-grand-total .value').html( data.grand_total );
              
              $('.cart-total-area-overlay').hide();
              $('#loader-1-cart').hide();
            }
          },
          error:function(){}
    });
  },
  	
  setUserWishlistDetails:function( data ){
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/user-wishlist-data-process',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { data: data },
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.status == 'success' && data.notice_type == 'user_wishlist_saved'){
              swal({
                title: '',
                text: frontendLocalizationString.wishlist_data_saved_msg,
                showCancelButton: true,
                cancelButtonText: frontendLocalizationString.continue_label,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: frontendLocalizationString.wishlist_items_label,
                closeOnConfirm: false,
                imageUrl: $('#hf_base_url').val() + '/public/images/thumbs-up.jpg'
              },
              function(){
                location.href = $('#hf_base_url').val() + '/user/account/my-saved-items';
              });
            }
            else if(data.status == 'error' && data.notice_type == 'user_login_required'){
              swal({
                title: '',
                text: frontendLocalizationString.login_for_wishlist_msg,
                type:'warning'
              });
            }
						else if(data.status == 'error' && data.notice_type == 'item_already_exists'){
              swal({
                title: '',
                text: frontendLocalizationString.already_item_in_wishlist_msg,
                showCancelButton: true,
                cancelButtonText: frontendLocalizationString.continue_label,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: frontendLocalizationString.wishlist_items_label,
                closeOnConfirm: false,
                type:'warning'
              },
              function(){
                location.href = $('#hf_base_url').val() + '/user/account/my-saved-items';
              });
            }
          },
          error:function(){}
    });
  },
  
  setProductCompareData:function(id){
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/product-compare-data-process',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { id: id },
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.status == 'success' && data.notice_type == 'compare_data_saved'){
              swal({
                title: '',
                text: frontendLocalizationString.compare_data_saved_msg,
                showCancelButton: true,
                cancelButtonText: frontendLocalizationString.continue_label,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: frontendLocalizationString.compare_items_label,
                closeOnConfirm: false,
                imageUrl: $('#hf_base_url').val() + '/public/images/thumbs-up.jpg'
              },
              function(){
                location.href = $('#hf_base_url').val() + '/product/comparison';
              });
            }
						else if(data.status == 'error' && data.notice_type == 'already_saved'){
              swal({
                title: '',
                text: frontendLocalizationString.compare_data_exists_msg,
                showCancelButton: true,
                cancelButtonText: frontendLocalizationString.continue_label,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: frontendLocalizationString.compare_items_label,
                closeOnConfirm: false,
                type:'warning'
              },
              function(){
                location.href = $('#hf_base_url').val() + '/product/comparison';
              });
            }
            else if(data.status == 'error' && data.notice_type == 'compare_data_exceed_limit'){
              swal({
                title: '',
                text: frontendLocalizationString.compare_data_exceed_msg,
                type:'warning'
              });
            }
            
            if($('#header_content').length>0){
              $('#header_content').find('.compare-value').html( '(' + data.item_count + ')' );
            }
          },
          error:function(){}
    });
  },
  
  wishlistItemDelete:function(data){
    $.ajax({
          url: $('#hf_base_url').val() + '/ajax/delete-item-from-wishlist',
          type: 'POST',
          cache: false,
          dataType: 'json',
          data: { data: data },
          headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
          success: function(data){
            if(data.status == 'success' && data.notice_type == 'deleted_item'){
							window.location.href = window.location.href;
            }
          },
          error:function(){}
    });
  },
  
  setMultiLangAndChangeView:function( data )
  {
    $('#shadow-layer, #loader-1').show();
    $.ajax({
        url: $('#hf_base_url').val() + '/ajax/multi-lang-processing',
        type: 'POST',
        cache: false,
        dataType: 'json',
        data: { data: data },
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
        success: function(data)
        {
          if(data.status == 'success'){
            window.location.href = window.location.href;
          }
        },
        error:function(){}
    });
  },
	
  setMultiCurrencyAndChangeView:function(data)
  {
    $('#shadow-layer, #loader-1').show();
    $.ajax({
      url: $('#hf_base_url').val() + '/ajax/multi-currency-processing',
      type: 'POST',
      cache: false,
      dataType: 'json',
      data: { data: data },
      headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') }, 
      success: function(data)
      {
        if(data.status == 'success')
        {
          window.location.href = window.location.href;
        }
      },
      error:function(){}
    });
  },
  
  getMiniCartContent:function(){
    $.ajax({
        url: $('#hf_base_url').val() + '/ajax/get-mini-cart-data',
        type: 'POST',
        cache: false,
        datatype: 'json',
        headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },

        success: function(data){
          if(data.status && data.status == 'success' && data.type == 'mini_cart_data' && data.html){

            $('.mini-cart-content').html( data.html );
            
            if($('.show-mini-cart').length>0){
              $('.show-mini-cart').off('click').on('click', function(e){
                e.preventDefault();
                e.stopPropagation();

                $('#list_popover').fadeToggle();return false;
              });
            }
          }
        },
        error:function(){}
    });
  }
}

function isValidEmail(emailText) {
  return /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test(emailText)
        && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test(emailText);
};

function validatePhone(txtPhone) {
    var a = txtPhone;
    var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
    if (filter.test(a)) {
			return true;
    }
    else {
			return false;
    }
}

function product_review_tab_control_with_hashtag(){
  $('#product_single_page').find('.product-description-bottom-tab ul.nav-tabs li.active').removeClass('active');
  $('#product_single_page').find('.product-description-bottom-tab ul.nav-tabs li:last-child').addClass('active');
  $('#product_single_page').find('.product-description-bottom-tab .tab-content .active').removeClass('active');
  $('#product_single_page').find('.product-description-bottom-tab .tab-content .in').removeClass('in');
  $('#product_single_page').find('.product-description-bottom-tab .tab-content #reviews').addClass('active in');
}

// Change progress bar action
function setProgress (currstep){
  var percent = parseFloat(100 / widget.length) * currstep;
  percent = percent.toFixed();
  $(".progress-bar").css("width",percent+"%").html(percent+"%");		
}

// Hide buttons according to the current step
function hideButtons (current){
  var limit = parseInt(widget.length); 
  var visible_step = $('#checkout_page .checkout-content .step:visible');
  
  $(".action").hide();

  if(current <= limit && visible_step.attr('id') != 'order_notes') btnnext.show();
  if (current == limit && visible_step.attr('id') == 'order_notes') { btnnext.hide(); btnsubmit.show(); }
}

function checkoutStepValidation(){
  var returnVal = true;
  var visible_step = $('#checkout_page .checkout-content .step:visible');
	var msgStr = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>'+ frontendLocalizationString.error_message_text +'</strong></div><p class="error-msg"></p></div>';
  var emailMsg = '';
  
  removeERRORMessageFromChekoutStep();
  if(visible_step.attr('id') && visible_step.attr('id') == 'user_mode'){
    if($('#selected_user_mode').val().length == 0){
      $('#' + visible_step.attr('id')).find('.checkout-process-user-mode').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html( frontendLocalizationString.user_mode_select_msg );
      returnVal =  false;
    }
  }
	else if(visible_step.attr('id') && visible_step.attr('id') == 'guest_user_address'){
		var errorStr = [];
    var isChecked = $("#different_shipping_address").prop("checked");
    
		if($('#account_bill_first_name').length>0 && $('#account_bill_first_name').val().length == 0 &&  $('#account_bill_first_name').val() == ''){
			errorStr.push('no_account_bill_first_name');
		}
    
    if(isChecked && $('#account_shipping_first_name').length>0 && $('#account_shipping_first_name').val().length == 0 &&  $('#account_shipping_first_name').val() == ''){
			errorStr.push('no_account_shipping_first_name');
		}
		
		if($('#account_bill_last_name').length>0 && $('#account_bill_last_name').val().length == 0 &&  $('#account_bill_last_name').val() == ''){
			errorStr.push('no_account_bill_last_name');
		}
    
    if(isChecked && $('#account_shipping_last_name').length>0 && $('#account_shipping_last_name').val().length == 0 &&  $('#account_shipping_last_name').val() == ''){
			errorStr.push('no_account_shipping_last_name');
		}
		
		if($('#account_bill_email_address').length>0 && $('#account_bill_email_address').val().length == 0 &&  $('#account_bill_email_address').val() == ''){
			errorStr.push('no_account_bill_email_address');
		}
    
    if(isChecked && $('#account_shipping_email_address').length>0 && $('#account_shipping_email_address').val().length == 0 &&  $('#account_shipping_email_address').val() == ''){
			errorStr.push('no_account_shipping_email_address');
		}
    
    if($('#account_bill_phone_number').length>0 && $('#account_bill_phone_number').val().length == 0 &&  $('#account_bill_phone_number').val() == ''){
			errorStr.push('no_account_bill_phone_number');
		}
    
    if(isChecked && $('#account_shipping_phone_number').length>0 && $('#account_shipping_phone_number').val().length == 0 &&  $('#account_shipping_phone_number').val() == ''){
			errorStr.push('no_account_shipping_phone_number');
		}
		
		var get_bill_country_name = '';
    var get_shipping_country_name = '';
    
		if($('#account_bill_select_country').length> 0){
			get_bill_country_name =  $('#account_bill_select_country :selected').val();
		}
    
    if(isChecked && $('#account_shipping_select_country').length> 0){
			get_shipping_country_name =  $('#account_shipping_select_country :selected').val();
		}
		
		if(get_bill_country_name == ''){
			errorStr.push('no_account_bill_select_country');
		}
    
    if(isChecked && get_shipping_country_name == ''){
			errorStr.push('no_get_shipping_country_name');
		}
		
		if($('#account_bill_adddress_line_1').length>0 && $('#account_bill_adddress_line_1').val().length == 0 &&  $('#account_bill_adddress_line_1').val() == ''){
			errorStr.push('no_account_bill_adddress_line_1');
		}
    
    if(isChecked && $('#account_shipping_adddress_line_1').length>0 && $('#account_shipping_adddress_line_1').val().length == 0 &&  $('#account_shipping_adddress_line_1').val() == ''){
			errorStr.push('no_account_shipping_adddress_line_1');
		}
		
		if($('#account_bill_town_or_city').length>0 && $('#account_bill_town_or_city').val().length == 0 &&  $('#account_bill_town_or_city').val() == ''){
			errorStr.push('no_account_bill_town_or_city');
		}
    
    if(isChecked && $('#account_shipping_town_or_city').length>0 && $('#account_shipping_town_or_city').val().length == 0 &&  $('#account_shipping_town_or_city').val() == ''){
			errorStr.push('no_account_shipping_town_or_city');
		}
		
		if($('#account_bill_zip_or_postal_code').length>0 && $('#account_bill_zip_or_postal_code').val().length == 0 &&  $('#account_bill_zip_or_postal_code').val() == ''){
			errorStr.push('no_account_bill_zip_or_postal_code');
		}
    
    if(isChecked && $('#account_shipping_zip_or_postal_code').length>0 && $('#account_shipping_zip_or_postal_code').val().length == 0 &&  $('#account_shipping_zip_or_postal_code').val() == ''){
			errorStr.push('no_account_shipping_zip_or_postal_code');
		}
    
    if($('#account_bill_email_address').val().length > 0 && !isValidEmail($('#account_bill_email_address').val())){
        emailMsg += '<p>'+ frontendLocalizationString.billing_email_not_valid_msg +'</p>';
      }
      
    if(isChecked && $('#account_shipping_email_address').val().length > 0 && !isValidEmail($('#account_shipping_email_address').val())){
        emailMsg += '<p>'+ frontendLocalizationString.shipping_email_not_valid_msg +'</p>';
      }  
		
    
    if(errorStr.length > 0){
      $('#' + visible_step.attr('id')).find('.user-address-content').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.required_field_still_empty_msg);
      returnVal =  false;
    }
    
    if(emailMsg && emailMsg != ''){
      $('#' + visible_step.attr('id')).find('.user-address-content').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html(emailMsg);
      returnVal =  false;
    }
	}
  else if(visible_step.attr('id') && visible_step.attr('id') == 'payment'){
    if($('#selected_payment_method').val().length == 0){
      $('#' + visible_step.attr('id')).find('.payment-options').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.select_payment_method_msg);
      returnVal =  false;
    }
    else if($('#selected_payment_method').val().length > 0 && $('#selected_payment_method').val() == 'stripe'){
      var errorStr = [];
      if($('#email_address').val().length == 0){
        errorStr.push('email_address');
      }
      else if($('#card_number').val().length == 0){
        errorStr.push('card_number');
      }
      else if($('#card_cvc').val().length == 0){
        errorStr.push('card_cvc');
      }
      else if($('#card_expiry_month').val().length == 0){
        errorStr.push('card_expiry_month');
      }
      else if($('#card_expiry_year').val().length == 0){
        errorStr.push('card_expiry_year');
      }
      
      if(errorStr.length > 0){
        $('#' + visible_step.attr('id')).find('.payment-options').before(msgStr);
        $('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.required_field_still_empty_msg);
        returnVal =  false;
      }
      
      if(errorStr.length == 0){
        var parseStripeApiData = JSON.parse($('#stripe_api_key').val());
        if(parseStripeApiData.secret_key && parseStripeApiData.secret_key != null && parseStripeApiData.secret_key != '' && parseStripeApiData.publishable_key && parseStripeApiData.publishable_key != null && parseStripeApiData.publishable_key != ''){
          Stripe.setPublishableKey(parseStripeApiData.publishable_key);
          Stripe.createToken({
            number: $('#card_number').val(),
            cvc: $('#card_cvc').val(),
            exp_month: $('#card_expiry_month').val(),
            exp_year: $('#card_expiry_year').val()
          }, stripeResponseHandler);
          
          $('#checkout_page .action').addClass('loading');
          returnVal =  false;
        }
        else{
          $('#' + visible_step.attr('id')).find('.payment-options').before(msgStr);
          $('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.stripe_api_empty_msg);
          returnVal =  false;
        }
      }
    }
    else if($('#selected_payment_method').val().length > 0 && $('#selected_payment_method').val() == '2checkout'){
      var errorStr = [];
      
      if($('#2checkout_card_number').val().length == 0){
        errorStr.push('card_number');
      }
      else if($('#2checkout_card_cvc').val().length == 0){
        errorStr.push('card_cvc');
      }
      else if($('#2checkout_card_expiry_month').val().length == 0){
        errorStr.push('card_expiry_month');
      }
      else if($('#2checkout_card_expiry_year').val().length == 0){
        errorStr.push('card_expiry_year');
      }
      
      if(errorStr.length > 0){
        $('#' + visible_step.attr('id')).find('.payment-options').before(msgStr);
        $('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.required_field_still_empty_msg);
        returnVal =  false;
      }
      
      if(errorStr.length == 0){
        var parseTwoCheckoutApiData = JSON.parse($('#2checkout_api_data').val());
        if(parseTwoCheckoutApiData.sellerId && parseTwoCheckoutApiData.sellerId != null && parseTwoCheckoutApiData.sellerId != '' && parseTwoCheckoutApiData.publishableKey && parseTwoCheckoutApiData.publishableKey != null && parseTwoCheckoutApiData.publishableKey != ''){
          var env = 'production';
          if(parseTwoCheckoutApiData.sandbox_enable_option && parseTwoCheckoutApiData.sandbox_enable_option == 'yes'){
            env = 'sandbox';
          }
          
          TCO.loadPubKey( env );
          var args = {
              sellerId: parseTwoCheckoutApiData.sellerId,
              publishableKey: parseTwoCheckoutApiData.publishableKey,
              ccNo: $("#2checkout_card_number").val(),
              cvv: $("#2checkout_card_cvc").val(),
              expMonth: $("#2checkout_card_expiry_month").val(),
              expYear: $("#2checkout_card_expiry_year").val()
          };
          
          TCO.requestToken(twoCheckoutSuccessCallback, twoCheckoutErrorCallback, args);
					
					$('#checkout_page .action').addClass('loading');
          returnVal =  false;
        }
        else{
          $('#' + visible_step.attr('id')).find('.payment-options').before(msgStr);
          $('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.twocheckout_api_empty_msg);
          returnVal =  false;
        }
      }
    }
  }
  else if(visible_step.attr('id') && visible_step.attr('id') == 'authentication'){
    if($('#is_user_login').val() == false){
      $('#' + visible_step.attr('id')).find('.user-login-content').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.signup_signin_checkout_msg);
      returnVal =  false;
    }
  }
  else if(visible_step.attr('id') && visible_step.attr('id') == 'login_user_address'){
    if($('#is_login_user_address_exists').length == 0 && $('#is_login_user_address_exists').val() != 'address_added'){
      $('#' + visible_step.attr('id')).find('.user-address-content').before(msgStr);
			$('#' + visible_step.attr('id')).find('.error-msg').html(frontendLocalizationString.billing_shipping_error_msg);
      returnVal =  false;
    }
  }
  
  return returnVal;
}

function removeERRORMessageFromChekoutStep(){
  if($('#checkout_page .checkout-content').find('.error-msg').length>0){
    $('#checkout_page .checkout-content').find('.error-msg').parent('.alert-danger').remove();
  }
}

// Numeric only control handler
jQuery.fn.ForceNumericOnly =
function()
{
    return this.each(function()
    {
        $(this).keydown(function(e)
        {
            var key = e.charCode || e.keyCode || 0;
            // allow backspace, tab, delete, enter, arrows, numbers and keypad numbers ONLY
            // home, end, period, and numpad decimal
            return (
                key == 8 || 
                key == 9 ||
                key == 13 ||
                key == 46 ||
                key == 110 ||
                key == 190 ||
                (key >= 35 && key <= 40) ||
                (key >= 48 && key <= 57) ||
                (key >= 96 && key <= 105));
        });
    });
};

function stripeResponseHandler(status, response) {
    $('#checkout_page .action').removeClass('loading');
    
    if (response.error) {
      var msgStr = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>'+ frontendLocalizationString.error_message_text +'</strong></div><p class="error-msg">'+ response.error.message +'</p></div>';
      $('.checkout-content .payment-options').before(msgStr);
      
    } else {
      var token = response['id'];
      $('form').append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
      $('#checkout_page .checkout-content').find('#payment').hide();
      $('#checkout_page .checkout-content').find('.action').hide();
      $('#checkout_page .checkout-content').find('#order_notes').show();
      $('#checkout_page .checkout-content').find('.place-order').show();
    }
}

function twoCheckoutSuccessCallback (data) {
	$('#checkout_page .action').removeClass('loading');
	
	var token = data.response.token.token;
	$('form').append("<input type='hidden' name='twoCheckoutToken' value='" + token + "'/>");
	$('#checkout_page .checkout-content').find('#payment').hide();
	$('#checkout_page .checkout-content').find('.action').hide();
	$('#checkout_page .checkout-content').find('#order_notes').show();
	$('#checkout_page .checkout-content').find('.place-order').show();
};

function twoCheckoutErrorCallback (data){
	$('#checkout_page .action').removeClass('loading');
	
	if(data.errorMsg){
		var msgStr = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><div class="message-header"><i class="fa fa-exclamation-triangle"></i>&nbsp;<strong>'+ frontendLocalizationString.error_message_text +'</strong></div><p class="error-msg">'+ data.errorMsg +'</p></div>';
    $('.checkout-content .payment-options').before(msgStr);
	}
}

function commonReplaceUrlParam(url, paramName, paramValue){
  if(paramValue == null)
      paramValue = '';
  var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
  if(url.search(pattern)>=0){
      return url.replace(pattern,'$1' + paramValue + '$2');
  }
  return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
}

function slickInit(){
  $('.special-items').slick({
    dots: true,
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows:false,
    lazyLoad: 'ondemand',
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 600,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });
  
  $('.slick-slider').slick('setPosition');
}