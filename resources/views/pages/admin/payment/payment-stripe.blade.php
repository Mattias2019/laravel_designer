@extends('layouts.admin.master')
@section('title', trans('admin.update_stripe_payment') .' < '. get_site_title())

@section('content')
@if(count($payment_method_data) > 0)

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_payment_method_type" value="stripe">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.stripe') }}</h3>
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
              @if($payment_method_data['stripe']['enable_option'] == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentStripeMethod" id="inputEnablePaymentStripeMethod">  {{ trans('admin.enable_stripe') }}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentStripeMethod" id="inputEnablePaymentStripeMethod"> {{ trans('admin.enable_stripe') }}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputStripeTitle" id="inputStripeTitle" value="{{ $payment_method_data['stripe']['method_title'] }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.test_secret_key') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.test_secret_key') }}" class="form-control" name="inputTestSecretKey" id="inputTestSecretKey" value="{{ $payment_method_data['stripe']['test_secret_key'] }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.test_publishable_key') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.test_publishable_key') }}" class="form-control" name="inputTestPublishableKey" id="inputTestPublishableKey" value="{{ $payment_method_data['stripe']['test_publishable_key'] }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.live_secret_key') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.live_secret_key') }}" class="form-control" name="inputLiveSecretKey" id="inputLiveSecretKey" value="{{ $payment_method_data['stripe']['live_secret_key'] }}">
            </div>
          </div>  
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.live_publishable_key') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.live_publishable_key') }}" class="form-control" name="inputLivePublishableKey" id="inputLivePublishableKey" value="{{ $payment_method_data['stripe']['live_publishable_key'] }}">
            </div>
          </div>  
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.enable_disable_stripe_test_mode') }}
            </div>
            <div class="col-sm-7">
              @if($payment_method_data['stripe']['stripe_test_enable_option'] == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableStripeTestOption" id="inputEnableStripeTestOption">
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnableStripeTestOption" id="inputEnableStripeTestOption">
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputStripeDescription" name="inputStripeDescription" placeholder="{{ trans('admin.method_description') }}" class="form-control">{{ $payment_method_data['stripe']['method_description'] }}</textarea>
            </div>
          </div>
            
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection