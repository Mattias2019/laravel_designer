@extends('layouts.frontend.master')
@section('title', trans('frontend.shopist_home_title') .' < '. get_site_title() )

@section('content')
  <div id="home_page">
    @include( 'frontend-templates.home.' .$appearance_settings['home']. '.' .$appearance_settings['home'] )
  </div>
@endsection

 