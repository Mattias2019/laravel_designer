@extends('layouts.admin.master')
@section('title', trans('admin.update_local_delivery') .' < '. get_site_title())

@section('content')
@if($shipping_method_data)

@include('pages-message.notify-msg-success')
  
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_shipping_method_name" value="save_local_delivery">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.shipping_method_local_delivery') }}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.save') }}</button>
      </div>
    </div>
  </div>
  
  <p>{{ trans('admin.local_delivery_title') }}</p> 
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.enable_disable') }}
            </div>
            <div class="col-sm-6">
               @if($shipping_method_data->local_delivery->enable_option == true)
               <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableLocalDelivery" id="inputEnableLocalDelivery">
               {{ trans('admin.enable_this_shipping_method') }}
              @else
                <input type="checkbox" class="shopist-iCheck" name="inputEnableLocalDelivery" id="inputEnableLocalDelivery">
               {{ trans('admin.enable_this_shipping_method') }}
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-6">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputLocalDeliveryTitle" id="inputLocalDeliveryTitle" value="{{ $shipping_method_data->local_delivery->method_title }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.fee_type') }}
            </div>
            <div class="col-sm-6">
              <select name="inputLocalDeliveryFeeType" id="inputLocalDeliveryFeeType" class="form-control select2" style="width: 100%;">
                
                @if($shipping_method_data->local_delivery->fee_type == 'fixed_amount')
                <option selected="selected" value="fixed_amount">{{ trans('admin.fixed_amount') }}</option>
                @else
                <option value="fixed_amount">{{ trans('admin.fixed_amount') }}</option>
                @endif
                
                @if($shipping_method_data->local_delivery->fee_type == 'cart_total')
                <option selected="selected" value="cart_total">{{ trans('admin.percentage_of_cart_total') }}</option>
                @else
                <option value="cart_total">{{ trans('admin.percentage_of_cart_total') }}</option>
                @endif
                
                @if($shipping_method_data->local_delivery->fee_type == 'per_product')
                 <option selected="selected" value="per_product">{{ trans('admin.fixed_amount_per_product') }}</option>
                @else
                 <option value="per_product">{{ trans('admin.fixed_amount_per_product') }}</option>
                @endif
               
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.delivery_fee') }}
            </div>
            <div class="col-sm-6">
              <input type="number" placeholder="{{ trans('admin.delivery_fee') }}" class="form-control" min="0" step="any" name="inputLocalDeliveryDeliveryFee" id="inputLocalDeliveryDeliveryFee" value="{{ $shipping_method_data->local_delivery->delivery_fee }}">
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection