<!doctype html>
<html>
<head>
    @include('includes.frontend.head')
</head>
<body>
  <div class="wrapper">
    @if(get_appearance_settings()['general']['custom_css'] == true)
    @include('includes.frontend.content-custom-css')
    @endif
    
    @include('includes.frontend.header')
    
    <section class="content">
        @yield('content')
    </section>
    
    @include('includes.frontend.footer')
    
    <input type="hidden" name="hf_base_url" id="hf_base_url" value="{{ url('/') }}">
    <input type="hidden" name="cart_url" id="cart_url" value="{{ route('cart-page') }}">
    <input type="hidden" name="currency_symbol" id="currency_symbol" value="{{ $_currency_symbol }}">
    
    <div id="shadow-layer"></div>
    <div id="loader-1"></div>
    <div id="loader-2"></div>
    <div id="loader-3"></div>
    
    @if(Request::is('product/customize/*') || Request::is('product/details/*'))
      @if(get_product_type($single_product_details['id']) == 'configurable_product' || get_product_type($single_product_details['id']) == 'customizable_product' || get_product_type($single_product_details['id']) == 'downloadable_product')
        <input type="hidden" name="selected_variation_id" id="selected_variation_id">
      @endif
    @endif
    
    @if(Request::is('checkout') || Request::is('cart'))
      <div class="modal fade" id="customizeImages" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
              <br>
              <i class="icon-credit-card icon-7x"></i>
              <p class="no-margin">{{ trans('frontend.all_design_images') }}</p>
            </div>
            <div class="modal-body" style="text-align: center;"></div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">{{ trans('frontend.close') }}</button>
            </div>
          </div>
        </div>
      </div>
    @endif
    
    @include('modal.quick-view')
    @include('modal.subscribe-content')
    
    <div class="add-to-cart-loader">
      <img src="{{ asset('public/images/ajax-loader.gif') }}" id="img-load" />
      <div class="cart-updating-msg">{{ trans('frontend.cart_updating_msg') }}</div>
    </div>
  </div>
  
  <input type="hidden" name="frontend_all_msg_with_localization" id="frontend_all_msg_with_localization" value="{{ $frontend_js_localization }}">  
  <input type="hidden" name="subscription_type" id="subscription_type" value="{{ $subscriptions_data['subscribe_type'] }}">
  
  <style type="text/css">
    #subscriptions_modal .modal__window{
      background: #{!! $subscriptions_data['popup_bg_color'] !!} !important;    
    }
  </style>
  
  <script type="text/javascript">
    var modalRequestProduct   = document.getElementById('request_product_modal');
    var modalQuickView        = document.getElementById('quick_view_modal');
    var modalProductVideo     = document.getElementById('product_video_modal');
    var modalSubscription     = document.getElementById('subscriptions_modal');

    if (typeof(modalRequestProduct) != 'undefined' && modalRequestProduct != null){
      var modalRequestProductInst = new Modal( modalRequestProduct );
      modalRequestProductInst.init();
    }
    
    if (typeof(modalQuickView) != 'undefined' && modalQuickView != null){
      var modalQuickViewInst = new Modal( modalQuickView );
      modalQuickViewInst.init();
    }
    
    if (typeof(modalProductVideo) != 'undefined' && modalProductVideo != null){
      var modalProductVideoInst = new Modal( modalProductVideo, {
        openCallback:function(){
          if($('#product_youtube_video').length>0 && $('#product_youtube_video_url').length>0 && !$('#product_youtube_video').attr('src')){
            $('#product_youtube_video').attr('src', $('#product_youtube_video_url').val());
          }
          
          if($('#product_video').length>0 && $('#product_video_url').length>0){
            if($('#product_video_extension').val() == 'mp4'){
              $("#product_video").html('<source src="'+ $('#product_video_url').val() +'" type="video/mp4"></source>' );
            }
            else if($('#product_video_extension').val() == 'ogv'){
              $("#product_video").html('<source src="'+ $('#product_video_url').val() +'" type="video/ogg"></source>' );
            }
          } 
        },
        closeCallback:function(){
          if($('#product_youtube_video').length>0 && $('#product_youtube_video').attr('src')){
            $('#product_youtube_video').attr('src', '');
          }
          
          if($('#product_video').length>0 && $('#product_video').find('source')){
            $('#product_video').html('');
          }
        }
      });
      modalProductVideoInst.init();
    }
    
    if (typeof(modalSubscription) != 'undefined' && modalSubscription != null){
      var modalSubscriptionInst = new Modal( modalSubscription );
      modalSubscriptionInst.init();
    }
    
    $(document).ready(function(){
      if($('.request-product').length>0){
        $('.request-product').on('click', function(){
          if($('#request_product_name').length>0){
            $('#request_product_name').val('');
          }
          if($('#request_product_email').length>0){
            $('#request_product_email').val('');
          }
          if($('#request_product_phone_number').length>0){
            $('#request_product_phone_number').val('');
          }
          if($('#request_product_description').length>0){
            $('#request_product_description').val('');
          }
          if($('.request-field-message').length>0){
            $('.request-field-message').remove();
          }
          
          modalRequestProductInst.openModal();
        });
      }
      
      if($('.quick-view-popup').length>0){
        $('.quick-view-popup').on('click', function(){
          
          $.ajax({
              url: $('#hf_base_url').val() + '/ajax/get-quick-view-data-by-product-id',
              type: 'POST',
              cache: false,
              datatype: 'json',
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              data: { product_id: $(this).data('id') },
              success: function(data){
                if(data.success == true){
                  $('#quick_view_modal').find('.modal__content').html( data.html );
                   modalQuickViewInst.openModal();
                }
              },
              error:function(){}
          });
        });
      }
      
      if($('.product-video').length>0){
        $('.product-video').on('click', function(){
           modalProductVideoInst.openModal();
        });
      }
      
      if($('#subscriptions_modal').length>0){
        @if($subscriptions_data['subscription_visibility'] == true && !$is_subscribe_cookie_exists && (!empty(get_current_page_name()) && is_array($subscriptions_data['popup_display_page']) && count($subscriptions_data['popup_display_page']) > 0 && in_array(get_current_page_name(), $subscriptions_data['popup_display_page'])))
          setTimeout(function(){ modalSubscriptionInst.openModal(); }, 3000);
        @endif
      }
      
      if($('.set-popup-cookie').length>0){
        $('.set-popup-cookie').on('click', function(e){
          e.preventDefault();
          setCookieForSubscriptionPopup();
        });
      }
      
       var setCookieForSubscriptionPopup = function(){
        $.ajax({
              url: $('#hf_base_url').val() + '/ajax/set_subscription_popup_cookie',
              type: 'POST',
              cache: false,
              dataType: 'json',
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              success: function(data)
              {
                if(data.status == 'saved'){
                  modalSubscriptionInst.closeModal();
                }
              },
              error:function(){}
        });
      }
    });
  </script>
</body>
</html>