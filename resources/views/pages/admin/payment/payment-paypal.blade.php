@extends('layouts.admin.master')
@section('title', trans('admin.update_paypal_payment') .' < '. get_site_title())

@section('content')
@if(count($payment_method_data) > 0)

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_payment_method_type" value="paypal">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.paypal') }}</h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.update') }}</button>
      </div>
    </div>
  </div>
  
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.enable_disable') }}
            </div>
            <div class="col-sm-7">
              @if($payment_method_data['paypal']['enable_option'] == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentPaypalMethod" id="inputEnablePaymentPaypalMethod">  {!! trans('admin.enable_payPal') !!}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentPaypalMethod" id="inputEnablePaymentPaypalMethod"> {!! trans('admin.enable_payPal') !!}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputPaypalTitle" id="inputPaypalTitle" value="{{ $payment_method_data['paypal']['method_title'] }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.paypal_app_client_id') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.paypal_app_client_id') }}" class="form-control" name="inputPaypalClientId" id="inputPaypalClientId" value="{{ $payment_method_data['paypal']['paypal_client_id'] }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.paypal_app_secret') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.paypal_app_secret') }}" class="form-control" name="inputPaypalSecret" id="inputPaypalSecret" value="{{ $payment_method_data['paypal']['paypal_secret'] }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.enable_disable_paypal_sandbox') }}
            </div>
            <div class="col-sm-7">
              @if($payment_method_data['paypal']['paypal_sandbox_enable_option'] == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaypalSandboxOption" id="inputEnablePaypalSandboxOption">  {{ trans('admin.enable_payPal_sandbox') }}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaypalSandboxOption" id="inputEnablePaypalSandboxOption">  {{ trans('admin.enable_payPal_sandbox') }}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputPaypalDescription" name="inputPaypalDescription" placeholder="{{ trans('admin.method_description') }}" class="form-control">{{ $payment_method_data['paypal']['method_description'] }}</textarea>
            </div>
          </div>
            
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection