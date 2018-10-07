@extends('layouts.admin.master')
@section('title', trans('admin.reports') .' < '. get_site_title())

@section('content')
<section class="content reports-parent">
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">{{ trans('admin.products_sales') }}</h3>
      </div>
    </div>
    <div class="col-md-4 col-sm-7 col-xs-12">
      <a href="{{ route('admin.reports_sales_by_product_title') }}">
        <div class="info-box">
          <span class="info-box-icon bg-grey"><i class="fa fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-number">{{ trans('admin.gross_sales_by_product_title') }}</span>
          </div>
        </div>
      </a>  
    </div>
  </div>
  <br>
  
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">{{ trans('admin.orders_sales') }}</h3>
      </div>
    </div>
    <div class="col-md-4 col-sm-7 col-xs-12">
      <a href="{{ route('admin.reports_sales_by_month') }}">
        <div class="info-box">
          <span class="info-box-icon bg-grey"><i class="fa fa-file-text-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-number">{{ trans('admin.sales_by_month') }}</span>
          </div>
        </div>
      </a>  
    </div>
    <div class="col-md-4 col-sm-7 col-xs-12">
      <a href="{{ route('admin.reports_sales_by_last_7_days') }}">
        <div class="info-box">
          <span class="info-box-icon bg-grey"><i class="fa fa-file-text-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-number">{{ trans('admin.sales_by_last_7_days') }}</span>
          </div>
        </div>
      </a>  
    </div>
    <div class="col-md-4 col-sm-7 col-xs-12">
      <a href="{{ route('admin.reports_sales_by_custom_days') }}">
        <div class="info-box">
          <span class="info-box-icon bg-grey"><i class="fa fa-file-text-o"></i></span>
          <div class="info-box-content">
            <span class="info-box-number">{{ trans('admin.sales_by_custom_date') }}</span>
          </div>
        </div>
      </a>  
    </div>
  </div>
  <br>
  
  @if(is_admin_login())
  <div class="row">
    <div class="box box-solid">
      <div class="box-header">
        <h3 class="box-title">{{ trans('admin.payments_sales') }}</h3>
      </div>
    </div>
    <div class="col-md-4 col-sm-7 col-xs-12">
      <a href="{{ route('admin.reports_sales_by_payment_method') }}">
        <div class="info-box">
          <span class="info-box-icon bg-grey"><i class="fa  fa-cc-mastercard"></i></span>
          <div class="info-box-content">
            <span class="info-box-number">{{ trans('admin.sales_by_payments_method') }}</span>
          </div>
        </div>
      </a>  
    </div>
  </div>
  @endif
</section>  
@endsection