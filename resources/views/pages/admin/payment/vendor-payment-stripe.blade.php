@extends('layouts.admin.master')
@section('title', trans('admin.update_stripe_payment') .' < '. get_site_title())

@section('content')
@if(!empty($payment_method_data))

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
              @if($payment_method_data->stripe->status == 'yes')
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
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputStripeTitle" id="inputStripeTitle" value="{{ $payment_method_data->stripe->title }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_email') }}
            </div>
            <div class="col-sm-7">
              <input type="email" placeholder="{{ trans('admin.email') }}" class="form-control" name="inputStripeEmail" id="inputStripeEmail" value="{{ $payment_method_data->stripe->email_id }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_number') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_number') }}" class="form-control" name="inputStripeCardNumber" id="inputStripeCardNumber" value="{{ $payment_method_data->stripe->card_number }}">
            </div>
          </div>  
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_cvc') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_cvc') }}" class="form-control" name="inputStripeCardCVC" id="inputStripeCardCVC" value="{{ $payment_method_data->stripe->cvc }}">
            </div>
          </div>   
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_expiration_month') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_expiration_month') }}" class="form-control" name="inputStripeCardExpirationMonth" id="inputStripeCardExpirationMonth" value="{{ $payment_method_data->stripe->expiration_month }}">
            </div>
          </div>    
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_stripe_card_expiration_year') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.vendor_stripe_card_expiration_year') }}" class="form-control" name="inputStripeCardExpirationYear" id="inputStripeCardExpirationYear" value="{{ $payment_method_data->stripe->expiration_year }}">
            </div>
          </div>    
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputStripeDescription" name="inputStripeDescription" placeholder="{{ trans('admin.method_description') }}" class="form-control">{{ $payment_method_data->stripe->description }}</textarea>
            </div>
          </div>
            
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection