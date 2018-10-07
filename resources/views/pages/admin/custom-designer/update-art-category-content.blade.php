@extends('layouts.admin.master')
@section('title', trans('admin.update_clipart_category') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-success')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_art_category') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.art_categories_list_content') }}">{{ trans('admin.art_categories_lists') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.art_new_category_content') }}">{{ trans('admin.add_more_category') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputCategoryName">{{ trans('admin.category_name') }}</label>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.category_name') }}" id="inputCategoryName" name="inputCategoryName" class="form-control" value="{{$art_cat_update_data_by_id['name'] }}">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputCategoryStatus">{{ trans('admin.category_status') }}</label>
            <div class="col-sm-8">
              <select name="inputCategoryStatus" id="inputCategoryStatus" class="form-control select2" style="width: 100%;">
                @if($art_cat_update_data_by_id['status'] == 1)
                <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                @else
                <option value="1">{{ trans('admin.enable') }}</option>
                @endif
                
                @if($art_cat_update_data_by_id['status'] == 0)
                <option selected="selected" value="0">{{ trans('admin.disable') }}</option>
                @else
                <option value="0">{{ trans('admin.disable') }}</option>
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