@extends('layouts.admin.master')
@section('title', trans('admin.earning_reports_label') .' < '. get_site_title())

@section('content')
<div id="reports_type_list">
  <h3>{!! trans('admin.reports') !!}</h3><hr>  
  <ul>
    <li><a {!! $tab_activation['day'] !!} href="{{ route('admin.earning_reports_content_by_tab', 'by-day') }}">{!! trans('admin.by_day_label') !!} </a> | </li>
    <li><a {!! $tab_activation['year'] !!}  href="{{ route('admin.earning_reports_content_by_tab', 'by-year') }}">{!! trans('admin.by_year_label') !!} </a> | </li>
    <li><a {!! $tab_activation['vendor'] !!}  href="{{ route('admin.earning_reports_content_by_tab', 'by-vendor') }}">{!! trans('admin.by_vendor_label') !!} </a></li>
  </ul><br> 
  
  @if(Request::is('admin/vendors/earning-reports') || Request::is('admin/vendors/earning-reports/by-day'))
    @include('pages.admin.vendors.report-by-day')
  @elseif(Request::is('admin/vendors/earning-reports/by-year'))
    @include('pages.admin.vendors.report-by-year')
  @elseif(Request::is('admin/vendors/earning-reports/by-vendor'))
    @include('pages.admin.vendors.report-by-vendor')
  @endif
</div>
@endsection