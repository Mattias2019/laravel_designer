@extends('layouts.admin.master')
@section('title', trans('admin.add_clipart_category') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_art_category') }} &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.art_categories_list_content') }}">{{ trans('admin.art_categories_lists') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputCategoryName">{{ trans('admin.category_name') }}</label>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.category_name') }}" id="inputCategoryName" name="inputCategoryName" class="form-control">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputCategoryStatus">{{ trans('admin.category_status') }}</label>
            <div class="col-sm-8">
              <select name="inputCategoryStatus" id="inputCategoryStatus" class="form-control select2" style="width: 100%;">
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