@extends('layouts.admin.master')
@section('title', trans('admin.update_free_shipping') .' < '. get_site_title())

@section('content')
@if($shipping_method_data)

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_shipping_method_name" value="save_free_shipping">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.shipping_method_free_shipping') }}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>
  
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.enable_disable') }}
            </div>
            <div class="col-sm-6">
              @if($shipping_method_data->free_shipping->enable_option == true)
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableFreeShipping" id="inputEnableFreeShipping">
               {{ trans('admin.enable_this_shipping_method') }}
              @else
                <input type="checkbox" class="shopist-iCheck" name="inputEnableFreeShipping" id="inputEnableFreeShipping">
               {{ trans('admin.enable_this_shipping_method') }}
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputFreeShippingTitle" id="inputFreeShippingTitle" value="{{ $shipping_method_data->free_shipping->method_title }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.minimum_order_amount') }}
            </div>
            <div class="col-sm-6">
              <input type="number" placeholder="{{ trans('admin.minimum_order_amount') }}" class="form-control" min="0" step="any" name="inputFreeShippingOrderAmount" id="inputFreeShippingOrderAmount" value="{{ $shipping_method_data->free_shipping->order_amount }}">
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection