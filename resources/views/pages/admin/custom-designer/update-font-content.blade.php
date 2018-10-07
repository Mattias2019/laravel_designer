@extends('layouts.admin.master')
@section('title', trans('admin.update_font') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-success')
@include('pages-message.notify-msg-error')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="post_type" id="post_type" value="update">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_font') }} &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.fonts_list_content') }}">{{ trans('admin.font_lists') }}</a> &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.font_add_content') }}">{{ trans('admin.add_new_font') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputFontName">{{ trans('admin.name') }}</label>
            <div class="col-sm-8">
                <input type="text" placeholder="{{ trans('admin.name') }}" id="inputFontName" name="inputFontName" class="form-control" value="{{ $designer_font_data->post_title }}">
            </div>
          </div>
            
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="uploadFont">{{ trans('admin.upload_font_label') }}</label>
            <div class="col-sm-8">
                <input type="file" name="font_upload" id="font_upload"><br>
                <span><strong>{!! trans('admin.uploaded_file_name_label') !!}: {!! $designer_font_data->font_url !!}</strong></span><br><br>
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
                @if($designer_font_data->post_status == 1)
                <option selected="selected" value="1">{!! trans('admin.enable') !!}</option>
                @else
                  <option value="1">{!! trans('admin.enable') !!}</option>
                @endif

                @if($designer_font_data->post_status == 0)
                  <option selected="selected" value="0">{!! trans('admin.disable') !!}</option>          
                @else
                  <option value="0">{!! trans('admin.disable') !!}</option>
                @endif
              </select>
            </div>
          </div>
          
        </div>
      </div>  
    </div>
  </div>
</form>
@endsection