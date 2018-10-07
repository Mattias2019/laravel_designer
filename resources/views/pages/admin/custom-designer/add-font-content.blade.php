@extends('layouts.admin.master')
@section('title', trans('admin.add_new_font') .' < '. get_site_title())

@section('content')

@include('pages-message.form-submit')
@include('pages-message.notify-msg-success')
@include('pages-message.notify-msg-error')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="post_type" id="post_type" value="save">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_font') }} &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.fonts_list_content') }}">{{ trans('admin.font_lists') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputFontName">{{ trans('admin.name') }}</label>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.name') }}" id="inputFontName" name="inputFontName" class="form-control">
            </div>
          </div>
            
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="uploadFont">{{ trans('admin.upload_font_label') }}</label>
            <div class="col-sm-8">
                <input type="file" name="font_upload" id="font_upload"><br>
                <span class="font-msg-style">
                *{!! trans('admin.font_format_msg') !!} <br>
                *{!! trans('admin.font_converter_msg') !!}
                </span>
            </div>
          </div>  
          
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputFontStatus">{{ trans('admin.status') }}</label>
            <div class="col-sm-8">
              <select name="inputFontStatus" id="inputFontStatus" class="form-control select2" style="width: 100%;">
                <option value="1">{{ trans('admin.enable') }}</option>
                <option value="0">{{ trans('admin.disable') }}</option>
              </select>
            </div>
          </div>
          
        </div>
      </div>  
    </div>
  </div>
</form>
@endsection