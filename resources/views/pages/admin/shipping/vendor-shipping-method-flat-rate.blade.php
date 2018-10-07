@extends('layouts.admin.master')
@section('title', trans('admin.update_flat_rate') .' < '. get_site_title())

@section('content')
@if($shipping_method_data)

@include('pages-message.notify-msg-success')
  
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_shipping_method_name" value="save_flat_rate">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.shipping_method_flat_rate') }}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>
  
 <p>{{ trans('admin.flat_rate_shipping_title') }}</p>
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.enable_disable') }}
            </div>
            <div class="col-sm-6"> 
               @if($shipping_method_data->flat_rate->enable_option == true)
               <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableFlatRate" id="inputEnableFlatRate">
                {{ trans('admin.enable_this_shipping_method') }}
              @else
                <input type="checkbox" class="shopist-iCheck" name="inputEnableFlatRate" id="inputEnableFlatRate">
                {{ trans('admin.enable_this_shipping_method') }}
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputFlatRateTitle" id="inputFlatRateTitle" value="{{ $shipping_method_data->flat_rate->method_title }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.cost') }}
            </div>
            <div class="col-sm-6">
              <input type="number" placeholder="{{ trans('admin.cost') }}" class="form-control" min="0" step="any" name="inputFlatRateCost" id="inputFlatRateCost" value="{{ $shipping_method_data->flat_rate->method_cost }}">
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection