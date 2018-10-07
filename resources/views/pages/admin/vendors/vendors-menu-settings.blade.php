@extends('layouts.admin.master')
@section('title', trans('admin.vendors_settings_page_title') .' < '. get_site_title())

@section('content')
<style type="text/css">
 @media (min-width: 768px) {
  .sidebar-nav .navbar .navbar-collapse {
    padding: 0;
    max-height: none;
  }
  .sidebar-nav .navbar ul {
    float: none;
  }
  .sidebar-nav .navbar ul:not {
    display: block;
  }
  .sidebar-nav .navbar li {
    float: none;
    display: block;
  }
  .sidebar-nav .navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
  }
}

.sidebar-nav .navbar li.active{
    border-left:3px solid #333; 
}
</style>
<div class="row">
  <div class="col-md-12">
    @include('pages-message.notify-msg-success') 
    <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
      
    <div class="col-md-12">
      <div class="clearfix">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
      <br>  
    </div>
     
    <div class="col-md-3">
      <div class="sidebar-nav">
        <div class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <span class="visible-xs navbar-brand">{!! trans('admin.sidebar_menu_label') !!}</span>
          </div>
          <div id="settings_tab" class="navbar-collapse collapse sidebar-navbar-collapse">
            <ul class="nav navbar-nav">
              <li @if (Session::has('update-target') && Session::get('update-target') == 'general')class="active" @endif data-target="general"><a href="#general" data-toggle="tab">{!! trans('admin.general') !!}</a></li>
              <li @if (Session::has('update-target') && Session::get('update-target') == 'social_media')class="active" @endif data-target="social_media"><a href="#social_media" data-toggle="tab">{!! trans('admin.social_media_label') !!}</a></li>
              <li @if (Session::has('update-target') && Session::get('update-target') == 'profile')class="active" @endif data-target="profile"><a href="#profile" data-toggle="tab">{!! trans('admin.profile') !!}</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="tab-content">
        <div class="tab-pane @if (Session::has('update-target') && Session::get('update-target') == 'general')active @endif" id="general">
          @include('pages.admin.vendors.vendors-general-settings')
          @yield('vendors-general-settings-page-content')
        </div>
        <div class="tab-pane @if (Session::has('update-target') && Session::get('update-target') == 'social_media')active @endif" id="social_media">
          @include('pages.admin.vendors.vendors-social-media')
          @yield('vendors-social-media-settings-page-content')
        </div>  
        <div class="tab-pane @if (Session::has('update-target') && Session::get('update-target') == 'profile')active @endif" id="profile" >
          @include('pages.admin.vendors.update-vendors-profile')
          @yield('vendors-profile-page-content')
        </div>
      </div>
    </div>
    <input type="hidden" name="hf_settings_target_tab" id="hf_settings_target_tab" value="{{ $update_target }}">
    </form>      
  </div>
</div>
@endsection