@extends('layouts.admin.master')
@section('title', trans('admin.shipping_options') .' < '. get_site_title())

@section('content')
@if($shipping_method_data)

@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_shipping_method_name" value="save_options">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.shipping_options') }}</h3>
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
              {{ trans('admin.enable_shipping') }}
            </div>
            <div class="col-sm-6">
              @if($shipping_method_data->shipping_option->enable_shipping == true)
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableShipping" id="inputEnableShipping">
              @else
              <input type="checkbox" class="shopist-iCheck" name="inputEnableShipping" id="inputEnableShipping">
              @endif
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              {{ trans('admin.shipping_display_mode') }}
            </div>
            <div class="col-sm-6">
              @if($shipping_method_data->shipping_option->display_mode == 'radio_buttons')
              <div><input type="radio" checked="checked" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayRadioBtn" value="radio_buttons">&nbsp; {{ trans('admin.display_shipping_methods_with_radio_buttons') }}</div>
              @else
              <div><input type="radio" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayRadioBtn" value="radio_buttons">&nbsp; {{ trans('admin.display_shipping_methods_with_radio_buttons') }}</div>
              @endif

              @if($shipping_method_data->shipping_option->display_mode == 'dropdown')
              <div><input type="radio" checked="checked" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayDropDown" value="dropdown">&nbsp; {{ trans('admin.display_shipping_methods_in_a_dropdown') }}</div>
              @else
              <div><input type="radio" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayDropDown" value="dropdown">&nbsp; {{ trans('admin.display_shipping_methods_in_a_dropdown') }}</div>
              @endif
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
</form>

@endif
@endsection