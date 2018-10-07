@extends('layouts.admin.master')
@section('title', trans('admin.manage_seo_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-error')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title">{{ trans('admin.seo_info_insert_top_label') }}</h3>
          <div class="box-tools pull-right">
            <button class="btn btn-block btn-primary" type="submit">{{ trans('admin.save') }}</button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title">{{ trans('admin.manage_metatag_label') }}</h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMetaKeywords">{{ trans('admin.meta_keywords_label') }}</label>
            <div class="col-sm-10">
              <input type="text" placeholder="{{ trans('admin.meta_keywords_example_label') }}" id="inputMetaKeywords" name="inputMetaKeywords" class="form-control" value="{{ $seo_data->meta_keywords }}">
              <p>[{{ trans('admin.keywords_entry_label') }}]</p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMetaDescription">{{ trans('admin.meta_description_label') }}</label>
            <div class="col-sm-10">
              <textarea id="inputMetaDescription" name="inputMetaDescription" placeholder="{{ trans('admin.meta_description_label') }}" class="form-control">{!! $seo_data->meta_decription !!}</textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection