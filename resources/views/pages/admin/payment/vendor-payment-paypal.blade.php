@extends('layouts.admin.master')
@section('title', trans('admin.update_paypal_payment') .' < '. get_site_title())

@section('content')
@if(!empty($payment_method_data))

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
              @if($payment_method_data->paypal->status == 'yes')
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
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputPaypalTitle" id="inputPaypalTitle" value="{{ $payment_method_data->paypal->title }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.vendor_paypal_email') }}
            </div>
            <div class="col-sm-7">
              <input type="email" placeholder="{{ trans('admin.email') }}" class="form-control" name="inputPaypalEmail" id="inputPaypalEmail" value="{{ $payment_method_data->paypal->email_id }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputPaypalDescription" name="inputPaypalDescription" placeholder="{{ trans('admin.method_description') }}" class="form-control">{{ $payment_method_data->paypal->description }}</textarea>
            </div>
          </div>
            
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection