@extends('layouts.admin.master')
@section('title', trans('admin.withdraw_title_label') .' < '. get_site_title())

@section('content')
  @if(is_vendor_login())
    @include('pages.admin.vendors.vendors-withdraw-content')
    @yield('vendor-withdraw-content')
  @else
    @include('pages.admin.vendors.vendors-admin-withdraw-content')
    @yield('vendor-admin-withdraw-content')
  @endif
@endsection