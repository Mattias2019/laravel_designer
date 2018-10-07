@extends('layouts.admin.master')
@section('title', trans('admin.add_new_art') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_art') }} &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.clipart_list_content') }}">{{ trans('admin.art_lists') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputArtName">{{ trans('admin.art_name') }}</label>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.art_name') }}" id="inputArtName" name="inputArtName" class="form-control">
            </div>
          </div>  
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputSelectCategory">{{ trans('admin.select_category') }} </label>
            <div class="col-sm-8">
              <select name="inputSelectCategory" id="inputSelectCategory" class="form-control select2" style="width: 100%;">
                @if(count($getArtCatByFilter)>0)
                  @foreach($getArtCatByFilter as $row)
                  <option value="{{ $row['term_id'] }}">{!! $row['name'] !!}</option>
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputArtStatus">{{ trans('admin.art_status') }}</label>
            <div class="col-sm-8">
              <select name="inputArtStatus" id="inputArtStatus" class="form-control select2" style="width: 100%;">
                <option value="1">{{ trans('admin.enable') }}</option>
                <option value="0">{{ trans('admin.disable') }}</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputCategoryName">{{ trans('admin.upload_your_art_image') }}</label>
            <div class="col-sm-8">
              <div class="uploadform dropzone no-margin dz-clickable art-dropzone-file-upload" id="art_dropzone_file_upload" name="art_dropzone_file_upload">
                <div class="dz-default dz-message">
                  <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
                </div>
              </div>
              [{{ trans('admin.you_can_upload_10_image') }}]
              <br>
              <div class="uploaded-all-art-images"></div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
  <input type="hidden" name="ht_art_all_uploaded_images" id="ht_art_all_uploaded_images" value="">
  <input type="hidden" name="ht_art_upload_status" id="ht_art_upload_status" value="new_add">
</form>

@endsection