@extends('layouts.admin.master')
@section('title', trans('admin.settings') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-success')
	
<div id="vendor_settings_content">
  <div class="row">
    <div class="col-md-12">
      <h3>{!! trans('admin.terms_and_conditions_label') !!}</h3><hr>
      <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
        <div class="box box-solid"> 
          <div class="box-body">
            <div><textarea id="terms_and_conditions_content" name="terms_and_conditions_content" class="dynamic-editor" placeholder="{{ trans('admin.terms_and_conditions_label') }}">{!! string_decode($vendor_settings_data['term_n_conditions']) !!}</textarea></div>
          </div>
          <div class="clearfix">
            <div class="pull-right" style="padding:10px;">
              <button class="btn btn-block btn-primary" type="submit">{{ trans('admin.save') }}</button>
            </div>
          </div>      
        </div>
      </form>    
    </div>
  </div>
</div>
@endsection