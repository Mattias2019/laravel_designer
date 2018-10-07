@extends('layouts.frontend.master')
@section('title', trans('frontend.shopist_shop_title') .' < '. get_site_title() )

@section('content')
<div id="shop_page">
  @include( 'frontend-templates.product.' .$appearance_settings['products']. '.' .$appearance_settings['products'] )
</div>	
@endsection  