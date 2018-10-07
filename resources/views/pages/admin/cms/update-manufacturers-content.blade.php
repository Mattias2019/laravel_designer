@extends('layouts.admin.master')
@section('title', trans('admin.update_manufacturers') .' < '. get_site_title())

@section('content')
@if($manufacturers_update_data)

@include('pages-message.notify-msg-success')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_manufacturers') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.manufacturers_list_content') }}">{{ trans('admin.manufacturers_list') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.add_manufacturers_content') }}">{{ trans('admin.add_more_manufacturers') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" target="_blank" href="{{ route('brands-single-page', $manufacturers_update_data['slug']) }}">{{ trans('admin.view') }}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.update') }}</button>
      </div>
    </div>
  </div>
  
<div class="box box-solid">
 <div class="row">
    <div class="col-md-12">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputManufacturersName">{{ trans('admin.manufacturers_name') }}</label>
          <div class="col-sm-9">
            <input type="text" placeholder="{{ trans('admin.manufacturers_name') }}" id="inputManufacturersName" name="inputManufacturersName" class="form-control" value="{{ $manufacturers_update_data['name'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputCountryName">{{ trans('admin.country_name') }}</label>
          <div class="col-sm-9">
            <input type="text" placeholder="{{ trans('admin.country_name') }}" id="inputCountryName" name="inputCountryName" class="form-control" value="{{ $manufacturers_update_data['brand_country_name'] }}">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputShortDescription">{{ trans('admin.short_description') }}</label>
          <div class="col-sm-9">
            <textarea id="inputShortDescription" name="inputShortDescription" class="dynamic-editor" placeholder="{{ trans('admin.short_description') }}">
             {!! string_decode( $manufacturers_update_data['brand_short_description'] ) !!}
            </textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputStatus">{{ trans('admin.status') }}</label>
          <div class="col-sm-9">
            <select class="form-control select2" name="inputStatus" style="width: 100%;">
              
              @if($manufacturers_update_data['status'] == 1)
              <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
              @else
              <option value="1">{{ trans('admin.enable') }}</option>
              @endif
              
              @if($manufacturers_update_data['status'] == 0)
              <option selected="selected" value="0">{{ trans('admin.disable') }}</option>
              @else
              <option value="0">{{ trans('admin.disable') }}</option>
              @endif
              
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputUploadLogo">{{ trans('admin.upload_logo') }}</label>
          <div class="col-sm-9">
            <div class="uploadform dropzone no-margin dz-clickable upload-manufacturers-logo" id="inputUploadLogo" name="inputUploadLogo">
              <div class="dz-default dz-message">
                <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
              </div>
            </div>
            <br>
            <div class="manufacturers-img-content">
              <div class="manufacturers-sample-img" {!! $manufacturers_logo_control['sample_img'] !!}><img class="img-responsive" src="{{ default_upload_sample_img_src() }}" alt=""></div>
              <div class="manufacturers-img" {!! $manufacturers_logo_control['manufacturers_logo'] !!}><img class="img-responsive" src="{{ get_image_url($manufacturers_update_data['brand_logo_img_url']) }}" alt=""></div>
              <br>
              <div class="manufacturers-img-remove-btn" {!! $manufacturers_logo_control['manufacturers_logo'] !!}>
                <button type="button" class="btn btn-default attachtopost remove-manufacturers-img">{{ trans('admin.remove_image') }}</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<input type="hidden" name="logo_img" id="logo_img" value="{{ $manufacturers_update_data['brand_logo_img_url'] }}">
</form>

@endif
@endsection