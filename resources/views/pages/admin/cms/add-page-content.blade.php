@extends('layouts.admin.master')
@section('title', trans('admin.add_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-error')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{!! trans('admin.add_new_page_top_title') !!} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.all_pages') }}">{!! trans('admin.all_pages_list') !!}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary" type="submit">{!! trans('admin.save') !!}</button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{!! trans('admin.page_title') !!}</h3>
        </div>
        <div class="box-body">
          <input type="text" placeholder="{{ trans('admin.example_pages_placeholder') }}" class="form-control" name="page_title" id="page_title" value="{{ old('page_title') }}">
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{!! trans('admin.description') !!}</h3>
        </div>
        <div class="box-body">
          <textarea id="page_description_editor" name="page_description_editor" class="dynamic-editor" placeholder="{{ trans('admin.post_description_placeholder') }}"></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title">{!! trans('admin.visibility') !!}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="inputVisibility">{!! trans('admin.blog_post_status') !!}</label>
                <div class="col-sm-8">
                  <select class="form-control select2" name="pages_visibility" style="width: 100%;">
                    <option selected="selected" value="1">{!! trans('admin.enable') !!}</option>
                    <option value="0">{!! trans('admin.disable') !!}</option>                  
                  </select>                                         
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add">
</form>

@endsection