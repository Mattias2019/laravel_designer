@extends('layouts.frontend.master')
@section('title', trans('frontend.vendor_details_title_label') .' < '. get_site_title())

@section('content')
<style>
  #location_map {
  height: 400px;
  width: 100%;
  }
 
  /* arrow buttons */
  .btn-arrow {
    position: relative;
  }
  .btn-arrow:after, .btn-arrow:before {
    position: absolute;
    line-height: 0;
    content: '';
  }
  .btn-arrow:before {
    z-index: 10;
  }
  .btn-arrow:after {
    z-index: 9;
  }

  .btn-arrow-bottom:before,
  .btn-arrow-up:before {
    border-right: 6px solid transparent;
    border-left: 6px solid transparent;
    left: 50%;
    margin-left: -6px;
  }
  .btn-arrow-bottom:after,
  .btn-arrow-up:after {
    border-right: 8px solid transparent;
    border-left: 8px solid transparent;
    left: 50%;
    margin-left: -8px;
  }
  .btn-default.btn-arrow-bottom:before {
    border-top: 6px solid #333;
    bottom: -6px;
  }
  .btn-default.btn-arrow-bottom:after {
    border-top: 8px solid #333;
    bottom: -8px;
  }
  .btn-default.btn-arrow-bottom.focus:before, .btn-default.btn-arrow-bottom:focus:before {
    border-top-color: #333;
  }
  .btn-default.btn-arrow-bottom.focus:after, .btn-default.btn-arrow-bottom:focus:after {
    border-top-color: #333;
  }
  .btn-default.btn-arrow-bottom:hover:before {
    border-top-color: #333;
  }
  .btn-default.btn-arrow-bottom:hover:after {
    border-top-color: #333;
  }
</style>

<script>
  @if($vendor_package_details->show_map_on_store_page == true)
    function initMap() {
      var position = { lat: {!! $vendor_settings->general_details->latitude !!}, lng: {!! $vendor_settings->general_details->longitude !!} };
      var map = new google.maps.Map(document.getElementById('location_map'), {
        zoom: 7,
        center: position
      });

      var marker = new google.maps.Marker({
        position: position,
        map: map
      });
    }
  @endif
</script>
@if($vendor_package_details->show_map_on_store_page == true)
<script async defer src="https://maps.googleapis.com/maps/api/js?key={{ $vendor_settings->general_details->google_map_app_key }}&callback=initMap"></script>
@endif

<div class="container">
  <div id="store_details">
    <div class="row">
      <div class="col-md-12">
        <div class="store-banner">
          @if( !empty($vendor_settings) && !empty($vendor_settings->general_details->cover_img) )  
          <img class="img-responsive" src="{{ get_image_url( $vendor_settings->general_details->cover_img ) }}">
          @else
          <img class="img-responsive" src="{{ default_vendor_cover_img_src() }}">
          @endif
          <div class="profile-overlay">
            <div class="profile-details-content">
                <div class="profile-image">
                  @if(!empty($vendor_info) && !empty($vendor_info->user_photo_url))
                  <img src="{{ get_image_url( $vendor_info->user_photo_url ) }}">
                  @else
                  <img src="{{ default_placeholder_img_src() }}">
                  @endif
                </div>
                <div class="profile-details">
                  <div class="vendor-name"><h3>{!! $vendor_settings->profile_details->store_name !!}</h3></div>
                  <table>
                      <tr class="vendor-address"><td><i class="fa fa-map-marker" aria-hidden="true"></i></td><td>{!! $vendor_settings->profile_details->address_line_1 !!}</td></tr>
                      <tr class="vendor-phone"><td><i class="fa fa-mobile-phone" aria-hidden="true"></i></td><td>{!! $vendor_settings->profile_details->phone !!}</td></tr>
                      <tr class="vendor-email"><td><i class="fa fa-envelope-open" aria-hidden="true"></i></td><td>{!! $vendor_info->email !!}</td></tr>
                  </table>
                  <div class="vendor-created"><strong><i class="fa fa-calendar" aria-hidden="true"></i> {!! trans('frontend.member_since_label') !!}:</strong> &nbsp;{!! Carbon\Carbon::parse( $vendor_info->created_at )->format('F d, Y') !!}</div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @if($vendor_package_details->show_social_media_follow_btn_on_store_page == true)  
    <div class="row"> 
      <div class="col-md-6">
        <div class="vendor-social-media">
          <ul class="social-media">
            <li><a class="facebook" href="//{{ $vendor_settings->social_media->fb_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Facebook"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="//{{ $vendor_settings->social_media->twitter_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Twitter"><i class="fa fa-twitter"></i></a></li>
            <li><a class="linkedin" href="//{{ $vendor_settings->social_media->linkedin_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Linkedin"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="dribbble" href="//{{ $vendor_settings->social_media->dribbble_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Dribbble"><i class="fa fa-dribbble"></i></a></li>
            <li><a class="google-plus" href="//{{ $vendor_settings->social_media->google_plus_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Google Plus"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="instagram" href="//{{ $vendor_settings->social_media->instagram_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Instagram"><i class="fa fa-instagram"></i></a></li>
            <li><a class="youtube-play" href="//{{ $vendor_settings->social_media->youtube_follow_us_url }}" data-toggle="tooltip" data-placement="top" title="" data-original-title="Follow on Youtube"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
      </div>
      <div class="col-md-6">
        <div class="vendor-review clearfix"><div class="review-stars"><div class="star-rating pull-right" style="text-align:left !important; margin:0px !important;"><span style="width:{{ $vendor_reviews_rating_details['percentage'] }}%"></span></div></div>
        </div>
      </div>  
    </div> 
    <hr><br>
    @endif
    <div class="row">
      <div class="col-md-3">
        <div class="vendor-details-left-panel">
          @if(Request::is('store/details/products/*') || Request::is('store/details/cat/products/*'))  

          @if(Request::is('store/details/products/*'))
          <div class="product-categories-list">
              @include('includes.frontend.vendor-categories', array('user_name' => $vendor_info->name))
              @yield('vendor-categories-content')  
          </div>
          @elseif(Request::is('store/details/cat/products/*'))
          <div class="product-categories-list">
              @include('includes.frontend.vendor-categories-page')
              @yield('vendor-categories-page-content')
          </div>		
          @endif

            <div class="filter-panel">
              <div class="filter-option-title">{{ trans('frontend.filter_options_label') }}</div>
              <form action="{{ $vendor_products['action_url'] }}" method="get">
                <div class="price-filter">
                  <h2><span>{!! trans('frontend.price_range_label') !!}</span></h2>
                  <div class="price-slider-option">
                    <input type="text" class="span2" value="" data-slider-min="{{ get_appearance_settings()['general']['filter_price_min'] }}" data-slider-max="{{ get_appearance_settings()['general']['filter_price_max'] }}" data-slider-step="5" data-slider-value="[{{ $vendor_products['min_price'] }},{{ $vendor_products['max_price'] }}]" id="price_range" ><br />
                    <b>{!! price_html(get_appearance_settings()['general']['filter_price_min'], get_frontend_selected_currency()) !!}</b> <b class="pull-right">{!! price_html(get_appearance_settings()['general']['filter_price_max'], get_frontend_selected_currency()) !!}</b>

                    <input name="price_min" id="price_min" value="{{ $vendor_products['min_price'] }}" type="hidden">
                    <input name="price_max" id="price_max" value="{{ $vendor_products['max_price'] }}" type="hidden">
                  </div>
                </div>  
																
                @if(count($colors_list_data) > 0)
                <div class="colors-filter">
                  <h2><span>{!! trans('frontend.choose_color_label') !!}</span></h2>
                  <div class="colors-filter-option">
                    @foreach($colors_list_data as $terms)
                    <div class="colors-filter-elements">
                      <div class="chk-filter">
                        @if(count($vendor_products['selected_colors']) > 0 && in_array($terms['slug'], $vendor_products['selected_colors']))  
                        <input type="checkbox" checked class="shopist-iCheck chk-colors-filter" value="{{ $terms['slug'] }}">
                        @else
                        <input type="checkbox" class="shopist-iCheck chk-colors-filter" value="{{ $terms['slug'] }}">
                        @endif
                      </div>
                      <div class="filter-terms">
                        <div class="filter-terms-appearance"><span style="background-color:#{{ $terms['color_code'] }};width:21px;height:20px;display:block;"></span></div>
                        <div class="filter-terms-name">&nbsp; {!! $terms['name'] !!}</div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                  @if($vendor_products['selected_colors_hf'])
                  <input name="selected_colors" id="selected_colors" value="{{ $vendor_products['selected_colors_hf'] }}" type="hidden">
                  @endif
                </div>
                @endif
																
                @if(count($sizes_list_data) > 0)
                <div class="size-filter">
                  <h2><span>{!! trans('frontend.choose_size_label') !!}</span></h2>
                  <div class="size-filter-option">
                    @foreach($sizes_list_data as $terms)
                    <div class="size-filter-elements">
                      <div class="chk-filter">
                        @if(count($vendor_products['selected_sizes']) > 0 && in_array($terms['slug'], $vendor_products['selected_sizes']))  
                        <input type="checkbox" checked class="shopist-iCheck chk-size-filter" value="{{ $terms['slug'] }}">
                        @else
                        <input type="checkbox" class="shopist-iCheck chk-size-filter" value="{{ $terms['slug'] }}">
                        @endif
                      </div>
                      <div class="filter-terms">
                        <div class="filter-terms-name">{!! $terms['name'] !!}</div>
                      </div>
                    </div>
                    @endforeach
                  </div> 
                  @if($vendor_products['selected_sizes_hf'])
                  <input name="selected_sizes" id="selected_sizes" value="{{ $vendor_products['selected_sizes_hf'] }}" type="hidden">
                  @endif
                </div>
                @endif
																
                <div class="btn-filter clearfix">
                  <button class="btn btn-sm" type="submit"><i class="fa fa-filter" aria-hidden="true"></i> {!! trans('frontend.filter_label') !!}</button>
                  <a class="btn btn-sm" href="{{ route('store-products-page-content', $vendor_info->name) }}"><i class="fa fa-close" aria-hidden="true"></i> {!! trans('frontend.clear_filter_label') !!}</a>  
                </div>
              </form>
            </div>
          @else
            @if($vendor_package_details->show_map_on_store_page == true)
            <div class="vendor-location">
              <div class="vendor-location-content">
                <h2><span>{!! trans('frontend.store_location_label') !!}</span></h2>
                <div id="location_map"></div>
              </div>    
            </div>  
            <br><br>
            @endif
            
            @if($vendor_package_details->show_contact_form_on_store_page == true)
            <div class="contact-vendor">
              <div class="contact-vendor-content clearfix">
                <h2><span>{!! trans('frontend.contact_vendor_label') !!}</span></h2>
                <div class="form-group">
                  <input class="form-control" name="contact_name" id="contact_name" placeholder="{{ trans('frontend.enter_name_label') }}" type="text">
                </div>
                <div class="form-group">
                  <input class="form-control" name="contact_email_id" id="contact_email_id" placeholder="{{ trans('frontend.enter_email_label') }}" type="text">
                </div>
                <div class="form-group">
                  <textarea class="form-control" name="contact_message" id="contact_message" placeholder="{{ trans('frontend.enter_your_message_label') }}"></textarea>
                </div>  
                <button class="pull-right btn btn-default btn-style" type="button" id="sendVendorContactMessage" name="sendVendorContactMessage">{!! trans('frontend.send_label') !!} <i class="fa fa-arrow-circle-right"></i></button>  
              </div>
            </div> 
            @endif
          @endif
        </div>
      </div>
      <div class="col-md-9">
        <div class="row">
          <div class="clearfix">  
            <div class="col-md-8">
              <div class="vendor-page-menu">
                <ul>
                  <li>
                    @if(Request::is('store/details/home/*'))  
                      <a class="btn btn-arrow btn-arrow-bottom btn-default vendor-menu-hover" href="{{ route('store-details-page-content', $vendor_info->name) }}">{!! trans('frontend.shopist_home_title') !!}</a>
                    @else
                      <a class="btn btn-default btn-style" href="{{ route('store-details-page-content', $vendor_info->name) }}">{!! trans('frontend.shopist_home_title') !!}</a>
                    @endif
                  </li>
                  <li>
                    @if(Request::is('store/details/products/*'))  
                      <a class="btn btn-arrow btn-arrow-bottom btn-default vendor-menu-hover" href="{{ route('store-products-page-content', $vendor_info->name) }}">{!! trans('frontend.all_products_label') !!}</a>
                    @else
                      <a class="btn btn-default btn-style" href="{{ route('store-products-page-content', $vendor_info->name) }}">{!! trans('frontend.all_products_label') !!}</a>
                    @endif  
                  </li>  
                  <li>
                    @if(Request::is('store/details/reviews/*'))  
                      <a class="btn btn-arrow btn-arrow-bottom btn-default vendor-menu-hover" href="{{ route('store-reviews-page-content', $vendor_info->name) }}">{!! trans('frontend.reviews_label') !!}</a>
                    @else
                      <a class="btn btn-default btn-style" href="{{ route('store-reviews-page-content', $vendor_info->name) }}">{!! trans('frontend.reviews_label') !!}</a>
                    @endif 
                  </li>
                </ul>
              </div>
            </div> 
            @if($vendor_package_details->show_social_media_share_btn_on_store_page == true)  
            <div class="col-md-4">
              <div class="vendor-share-list">
                <ul>
                  <li>{!! trans('frontend.share_label') !!}</li>
                  <li><a href="" data-name="fb"><i class="fa fa-facebook"></i></a></li>
                  <li><a href="" data-name="gplus"><i class="fa fa-google-plus"></i></a></li>
                  <li><a href="" data-name="tweet"><i class="fa fa-twitter"></i></a></li>
                  <li><a href="" data-name="pi"><i class="fa fa-pinterest"></i></a></li>
                </ul>
              </div>
            </div> 
            @endif
          </div>    
          <hr>    
        </div>  
        <div class="row">
          <div class="col-md-12">
            <div class="vendor-menu-content">
              @if(Request::is('store/details/home/*'))
                @include('pages.frontend.vendors.vendors-home')
                @yield('vendors-home-page-content')
              @endif

              @if(Request::is('store/details/products/*'))
                @include('pages.frontend.vendors.vendors-products')
                @yield('vendors-products-page-content')
              @endif
              
              @if(Request::is('store/details/cat/products/*'))
                @include('pages.frontend.vendors.vendors-category-products')
                @yield('vendors-categoty-products-page-content')
              @endif

              @if(Request::is('store/details/reviews/*'))
                @include('pages.frontend.vendors.vendors-reviews')
                @yield('vendors-reviews-page-content')  
              @endif
            </div>  
          </div>      
        </div>
      </div>
    </div>
    <input type="hidden" name="product_title" id="product_title" value="{{ trans('frontend.vendor_details_title_label') }}">
    @if( !empty($vendor_settings) && !empty($vendor_settings->general_details->cover_img) )  
    <input type="hidden" name="product_img" id="product_img" value="{{ get_image_url( $vendor_settings->general_details->cover_img ) }}">
    @else
    <input type="hidden" name="product_img" id="product_img" value="{{ default_vendor_cover_img_src() }}">
    @endif
  </div>
</div>    
<input type="hidden" name="vendor_email" id="vendor_email" value="{{ $vendor_info->email}}">

<script type="text/javascript">
  $(document).ready(function(){
    $('#sendVendorContactMessage').on('click', function(){
      if($('#contact_name').val() == '' || $('#contact_name').val() == null){
        alert('please insert name!');
        return false;
      }
      
      if($('#contact_email_id').val() == '' || $('#contact_email_id').val() == null){
        alert('please insert valid email id!');
        return false;
      }
      
      if($('#contact_message').val() == '' || $('#contact_message').val() == null){
        alert('please insert message!');
        return false;
      }
      
      if($('#contact_name').val().length> 0 && $('#contact_email_id').val().length> 0 && $('#contact_message').val().length>0){
        $.ajax({
              url: $('#hf_base_url').val() + '/ajax/contact-with-vendor',
              type: 'POST',
              cache: false,
              datatype: 'json',
              data: {vendor_mail:Base64.encode($('#vendor_email').val()), name: Base64.encode($('#contact_name').val()), customer_email: Base64.encode($('#contact_email_id').val()), message: Base64.encode($('#contact_message').val())},
              headers: { 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content') },
              success: function(data){
                if(data && data.status == 'success'){
                  alert("your message successfully sent to the vendor");
                }
              },
              error:function(){alert('Something wrong!');}
        });
      }
    });
    
    if($('#store_details #price_range').length>0){
      $('#store_details #price_range').slider();
    }
    
    if($('#store_details .price-slider-option #price_range').length>0){
      $('#store_details .price-slider-option #price_range') .slider()
        .on('slideStop', function(ev){
          $('#price_min').val(ev.value[0]);
          $('#price_max').val(ev.value[1]);
          $('.price-slider-option .tooltip-inner').html(ev.value[0] + ':' + ev.value[1]);
        });
    }
  });
</script>
@endsection 