@extends('layouts.admin.master')
@section('title', trans('admin.withdraw_title_label') .' < '. get_site_title())

@section('content')
<div class="clearfix">
  <a href="{{ route('admin.withdraws_content') }}" class="btn btn-primary pull-right">{!! trans('admin.back_request_panel_btn_label') !!}</a><hr>
</div>
@include('pages-message.notify-msg-success')
@include('pages-message.form-submit') 
@include('pages-message.notify-msg-error')  
<div id="vendor_withdraw_request_content">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="target" id="target" value="update_withdraw_request">
            
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputSelectPaymentType">{{ trans('admin.select_payment_type_label') }}</label>
              <div class="col-sm-8">
                <div class="payment-type-options">  
                  @if($withdraw_request_data_by_update_id->payment_type == 'single_payment_with_custom_values')  
                  <div class="payment-type-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_type" value="single_payment_with_custom_values"></div><div class="single-payment-values"><input type="number" placeholder="$0.00" id="single_payment_with_custom_values" name="single_payment_with_custom_values" class="form-control" style="width:200px;" value="{{ $withdraw_request_data_by_update_id->custom_amount }}"></div> <div class="payment-type-label"> {!! trans('admin.single_with_custom_values_label') !!}</div>
                  @else
                  <div class="payment-type-radio"><input type="radio" class="shopist-iCheck" name="payment_type" value="single_payment_with_custom_values"></div><div class="single-payment-values"><input type="number" placeholder="$0.00" id="single_payment_with_custom_values" name="single_payment_with_custom_values" class="form-control" style="width:200px;"></div> <div class="payment-type-label"> {!! trans('admin.single_with_custom_values_label') !!}</div>
                  @endif
                </div>
                <div class="payment-type-options">
                  @if($withdraw_request_data_by_update_id->payment_type == 'single_payment_with_all_earnings')    
                  <div class="payment-type-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_type" value="single_payment_with_all_earnings"></div><div class="payment-type-label"> {!! trans('admin.single_with_all_earnings_label') !!}</div>
                  @else
                  <div class="payment-type-radio"><input type="radio" class="shopist-iCheck" name="payment_type" value="single_payment_with_all_earnings"></div><div class="payment-type-label"> {!! trans('admin.single_with_all_earnings_label') !!}</div>
                  @endif
                </div>
              </div>
            </div> 
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputSelectPaymentMethod">{{ trans('admin.select_payment_method_label') }}</label>
              <div class="col-sm-8">
                <div class="payment-method-options"> 
                  @if($withdraw_request_data_by_update_id->payment_method == 'dbt')     
                  <div class="payment-method-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_method" value="dbt"></div><div class="payment-method-label"> {!! trans('admin.direct_bank_transfer') !!}</div>
                  @else
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="dbt"></div><div class="payment-method-label"> {!! trans('admin.direct_bank_transfer') !!}</div>
                  @endif
                </div>
                <div class="payment-method-options">  
                  @if($withdraw_request_data_by_update_id->payment_method == 'cod')    
                  <div class="payment-method-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_method" value="cod"></div><div class="payment-method-label"> {!! trans('admin.cash_on_delivery') !!}</div>
                  @else
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="cod"></div><div class="payment-method-label"> {!! trans('admin.cash_on_delivery') !!}</div>
                  @endif
                </div>  
                <div class="payment-method-options"> 
                  @if($withdraw_request_data_by_update_id->payment_method == 'paypal')   
                  <div class="payment-method-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_method" value="paypal"></div><div class="payment-method-label"> {!! trans('admin.paypal') !!}</div>
                  @else
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="paypal"></div><div class="payment-method-label"> {!! trans('admin.paypal') !!}</div>
                  @endif
                </div>
                <div class="payment-method-options">  
                  @if($withdraw_request_data_by_update_id->payment_method == 'stripe')    
                  <div class="payment-method-radio"><input type="radio" checked="checked" class="shopist-iCheck" name="payment_method" value="stripe"></div><div class="payment-method-label"> {!! trans('admin.stripe') !!}</div>
                  @else
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="stripe"></div><div class="payment-method-label"> {!! trans('admin.stripe') !!}</div>
                  @endif
                </div>  
              </div>
            </div> 
            <div class="clearfix">
              <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.update_request_label') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection