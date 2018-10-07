@extends('layouts.admin.master')
@section('title', trans('admin.update_cod_payment') .' < '. get_site_title())

@section('content')
@if(!empty($payment_method_data))

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_payment_method_type" value="cod">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.cash_on_delivery') }}</h3>
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
              @if($payment_method_data->cod->status == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentCODMethod" id="inputEnablePaymentCODMethod"> {{ trans('admin.enable_cash_on_delivery') }}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentCODMethod" id="inputEnablePaymentCODMethod"> {{ trans('admin.enable_cash_on_delivery') }}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputCODTitle" id="inputCODTitle" value="{{ $payment_method_data->cod->title }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
              <textarea id="inputCODDescription" name="inputCODDescription" placeholder="{{ trans('admin.description') }}" class="form-control">{{ $payment_method_data->cod->description }}</textarea>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_instructions') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputCODInstructions" name="inputCODInstructions" placeholder="{{ trans('admin.instructions') }}" class="form-control">{{ $payment_method_data->cod->instructions }}</textarea>
            </div>
          </div>
          
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection