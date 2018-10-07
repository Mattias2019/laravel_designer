@extends('layouts.frontend.master')
@if(Request::is('user/account'))
  @section('title',  trans('frontend.frontend_user_dashboard_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/dashboard'))
  @section('title',  trans('frontend.frontend_user_dashboard_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/my-address'))
  @section('title',  trans('frontend.frontend_user_address_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/my-address/add'))
  @section('title',  trans('frontend.frontend_user_address_add_title') .' < '. get_site_title() ) 
@elseif (Request::is('user/account/my-address/edit'))
  @section('title',  trans('frontend.frontend_user_address_edit_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/my-profile'))
  @section('title',  trans('frontend.frontend_user_profile_edit_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/my-orders'))
  @section('title',  trans('frontend.frontend_my_order_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/my-saved-items'))
  @section('title',  trans('frontend.frontend_wishlist_items_title') .' < '. get_site_title() ) 
@elseif (Request::is('user/account/my-coupons'))
  @section('title',  trans('frontend.frontend_coupons_items_title') .' < '. get_site_title() )
@elseif (Request::is('user/account/download'))
  @section('title',  trans('frontend.frontend_download_options_title') .' < '. get_site_title() )  
@elseif(Request::is('user/account/order-details/*'))
  @section('title',  trans('frontend.user_order_details_page_title') .' < '. get_site_title() )  
@endif

@section('content')
<div id="user_account" class="container new-container">
  <br> 
  <div class="row">
    <div class="col-md-12 account-type"><h4><i class="fa fa-user-plus"></i> {!! trans('frontend.user_account_label') !!}</h4><hr></div>
    <div class="col-xs-12 col-sm-2 col-md-2">
      <div class="account-tab-main">
        <ul class="nav nav-pills nav-stacked">
          @if(Request::is('user/account/dashboard') || Request::is('user/account'))
          <li class="active"><a href="{{ route('user-dashboard-page') }}"><i class="fa fa-dashboard"></i> {{ trans('frontend.dashboard') }}</a></li>
          @else
          <li><a href="{{ route('user-dashboard-page') }}"><i class="fa fa-dashboard"></i> {{ trans('frontend.dashboard') }}</a></li>
          @endif
          
          @if( Request::is('user/account/my-address') ||  Request::is('user/account/my-address/add') ||  Request::is('user/account/my-address/edit') )
            <li class="active"><a href="{{ route('my-address-page') }}"><i class="fa fa-map-marker"></i> {{ trans('frontend.my_address') }}</a></li>
          @else
            <li><a href="{{ route('my-address-page') }}"><i class="fa fa-map-marker"></i> {{ trans('frontend.my_address') }}</a></li>
          @endif
          
          @if(Request::is('user/account/my-orders') || Request::is('user/account/order-details/**'))
            <li class="active"><a href="{{ route('my-orders-page') }}"><i class="fa fa-file-text-o"></i> {{ trans('frontend.my_orders') }}</a></li>
          @else
            <li><a href="{{ route('my-orders-page') }}"><i class="fa fa-file-text-o"></i> {{ trans('frontend.my_orders') }}</a></li>
          @endif
          
          @if(Request::is('user/account/my-saved-items'))
            <li class="active"><a href="{{ route('my-saved-items-page') }}"><i class="fa fa-save"></i> {{ trans('frontend.my_saved_items') }}</a></li>
          @else
            <li><a href="{{ route('my-saved-items-page') }}"><i class="fa fa-save"></i> {{ trans('frontend.my_saved_items') }}</a></li>
          @endif
          
          @if(Request::is('user/account/my-coupons'))
            <li class="active"><a href="{{ route('my-coupons-page') }}"><i class="fa fa-scissors"></i> {{ trans('frontend.my_coupons') }}</a></li>
          @else
            <li><a href="{{ route('my-coupons-page') }}"><i class="fa fa-scissors"></i> {{ trans('frontend.my_coupons') }}</a></li>
          @endif
          
          @if(Request::is('user/account/download'))
            <li class="active"><a href="{{ route('download-page') }}"><i class="fa fa-download"></i> {{ trans('frontend.user_account_download_title') }}</a></li>
          @else
            <li><a href="{{ route('download-page') }}"><i class="fa fa-download"></i> {{ trans('frontend.user_account_download_title') }}</a></li>
          @endif
          
          @if(Request::is('user/account/my-profile'))
            <li class="active"><a href="{{ route('my-profile-page') }}"><i class="fa fa-user"></i> {{ trans('frontend.my_profile') }}</a></li>
          @else
            <li><a href="{{ route('my-profile-page') }}"><i class="fa fa-user"></i> {{ trans('frontend.my_profile') }}</a></li>
          @endif
          
          @if(is_frontend_user_logged_in())
          <form method="post" action="{{ route('user-logout') }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">  
            <li><button type="submit" class="btn btn-default btn-block"><i class="fa fa-circle-o-notch"></i> {!! trans('admin.sign_out') !!}</button>  </li>
          </form>
          @endif
        </ul>
      </div>  
    </div>
    <div class="col-xs-12 col-sm-12 col-md-10">
      <div class="panel panel-default">
        <div class="panel-heading text-right">
          <div class="new-media">
            <div class="new-media-left">
              @if($login_user_details['user_photo_url'])
                <img class="new-media-object" src="{{ get_image_url($login_user_details['user_photo_url']) }}" alt="">
              @else
                <img class="new-media-object" src="{{ default_avatar_img_src() }}" alt="">
              @endif
            </div>
              
            <div class="new-media-body">
              <h5 class="new-media-heading">{{ $login_user_details['user_display_name'] }}</h5>
              <h6 class="new-media-heading">{!! trans('frontend.member_since_label') !!} {!! Carbon\Carbon::parse($login_user_details['member_since'])->format('d, M Y') !!}</h6>
             </div>
          </div>
        </div>
        <div class="panel-body">
          @if(Request::is('user/account/dashboard') || Request::is('user/account'))
            @include('pages.frontend.user-account.my-dashboard')
          @elseif(Request::is('user/account/my-address'))  
            @include('pages.frontend.user-account.my-address')
          @elseif(Request::is('user/account/my-address/add'))  
            @include('pages.frontend.user-account.add-address')
          @elseif(Request::is('user/account/my-address/edit'))  
            @include('pages.frontend.user-account.edit-address')
          @elseif(Request::is('user/account/my-profile') )  
            @include('pages.frontend.user-account.user-profile')  
          @elseif(Request::is('user/account/my-orders') )
            @include('pages.frontend.user-account.my-orders') 
          @elseif(Request::is('user/account/view-orders-details/*') )
            @include('pages.frontend.user-account.user-order-details')
          @elseif(Request::is('user/account/my-saved-items') )
            @include('pages.frontend.user-account.my-wishlist') 
          @elseif(Request::is('user/account/my-coupons') )
            @include('pages.frontend.user-account.my-coupons')
          @elseif(Request::is('user/account/download') )
            @include('pages.frontend.user-account.download')  
          @elseif(Request::is('user/account/order-details/*') )
            @include('pages.frontend.user-account.order-details')  
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection  