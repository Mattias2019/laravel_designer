@extends('layouts.admin.master')
@section('title', trans('admin.add_new_shape') .' < '. get_site_title())

@section('content')

@include('pages-message.form-submit')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="post_type" id="post_type" value="save">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_shape') }} &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.shape_list_content') }}">{{ trans('admin.shape_lists') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputShapeName">{{ trans('admin.name') }}</label>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.name') }}" id="inputShapeName" name="inputShapeName" class="form-control">
            </div>
          </div>
            
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputShapeContent">{{ trans('admin.content_label') }}</label>
            <div class="col-sm-8">
              <div class="svg-display"></div>
              <textarea name="inputShapeContent" id="inputShapeContent" placeholder="{{ trans('admin.content_label') }}" class="form-control"></textarea>
              <span>{!! trans('admin.svg_content_label') !!}</span>
            </div>
          </div>  
          
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputShapeStatus">{{ trans('admin.status') }}</label>
            <div class="col-sm-8">
              <select name="inputShapeStatus" id="inputShapeStatus" class="form-control select2" style="width: 100%;">
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