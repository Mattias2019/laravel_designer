@extends('layouts.admin.master')
@section('title', trans('admin.update_bacs_payment') .' < '. get_site_title())

@section('content')
@if(!empty($payment_method_data))

@include('pages-message.notify-msg-success')
  
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_payment_method_type" value="bacs">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.direct_bank_transfer') }}</h3>
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
              @if($payment_method_data->dbt->status == 'yes')
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentBACSMethod" id="inputEnablePaymentBACSMethod"> {{ trans('admin.enable_bank_transfer') }}
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentBACSMethod" id="inputEnablePaymentBACSMethod"> {{ trans('admin.enable_bank_transfer') }}
              @endif
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_title') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.title') }}" class="form-control" name="inputBACSTitle" id="inputBACSTitle" value="{{ $payment_method_data->dbt->title }}">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_description') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputBACSDescription" name="inputBACSDescription" placeholder="{{ trans('admin.description') }}" class="form-control">{!! $payment_method_data->dbt->description  !!}</textarea>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.method_instructions') }}
            </div>
            <div class="col-sm-7">
                <textarea id="inputBACSInstructions" name="inputBACSInstructions" placeholder="{{ trans('admin.instructions') }}" class="form-control">{!! $payment_method_data->dbt->instructions !!}</textarea>
            </div>
          </div>
          
          <h5>{{ trans('admin.account_details') }}</h5><hr>
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.account_name') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.account_name') }}" class="form-control" name="inputBACSAccountName" id="inputBACSAccountName" value="{{ $payment_method_data->dbt->account_name }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.account_number') }}
            </div>
            <div class="col-sm-7">
              <input type="number" placeholder="{{ trans('admin.account_number') }}" step="any" class="form-control" name="inputBACSAccountNumber" id="inputBACSAccountNumber" value="{{ $payment_method_data->dbt->account_number }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.bank_name') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.bank_name') }}" class="form-control" name="inputBACSBankName" id="inputBACSBankName" value="{{ $payment_method_data->dbt->bank_name }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.bank_short_code') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.bank_short_code') }}" class="form-control" name="inputBACSShortCode" id="inputBACSShortCode" value="{{ $payment_method_data->dbt->short_code }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.bank_iban') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.bank_iban') }}" class="form-control" name="inputBACSIBAN" id="inputBACSIBAN" value="{{ $payment_method_data->dbt->IBAN }}">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              {{ trans('admin.bank_swift') }}
            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="{{ trans('admin.bank_swift') }}" class="form-control" name="inputBACSSwift" id="inputBACSSwift" value="{{ $payment_method_data->dbt->SWIFT }}">
            </div>
          </div> 
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection