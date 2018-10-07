@extends('layouts.admin.master')
@section('title', trans('admin.update_2checkout_payment') .' < '. get_site_title())

@section('content')
@if(!empty($payment_method_data))

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_payment_method_type" value="2checkout">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.two_checkout') }}</h3>
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
              @if($payment_method_data->twocheckout->status == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePayment2CheckoutMethod" id="inputEnablePayment2CheckoutMethod">  {{ trans('admin.enable_2checkout') }}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePayment2CheckoutMethod" id="inputEnablePayment2CheckoutMethod"> {{ trans('admin.enable_2checkout') }}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="input2CheckoutTitle" id="input2CheckoutTitle" value="{{ $payment_method_data->twocheckout->title }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_number') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_number') }}" class="form-control" name="input2CheckoutCardNumber" id="input2CheckoutCardNumber" value="{{ $payment_method_data->twocheckout->card_number }}">
            </div>
          </div>  
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_cvc') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_cvc') }}" class="form-control" name="input2CheckoutCardCVC" id="input2CheckoutCardCVC" value="{{ $payment_method_data->twocheckout->cvc }}">
            </div>
          </div>   
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_expiration_month') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_expiration_month') }}" class="form-control" name="input2CheckoutCardExpirationMonth" id="input2CheckoutCardExpirationMonth" value="{{ $payment_method_data->twocheckout->expiration_month }}">
            </div>
          </div>    
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_expiration_year') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_expiration_year') }}" class="form-control" name="input2CheckoutCardExpirationYear" id="input2CheckoutCardExpirationYear" value="{{ $payment_method_data->twocheckout->expiration_year }}">
            </div>
          </div>    
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="input2CheckoutDescription" name="input2CheckoutDescription" placeholder="{{ trans('admin.method_description') }}" class="form-control">{{ $payment_method_data->twocheckout->description }}</textarea>
            </div>
          </div>
            
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection