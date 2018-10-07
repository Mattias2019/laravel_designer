@extends('layouts.admin.master')
@section('title', trans('admin.update_art') .' < '. get_site_title())

@section('content')
@include('pages-message.notify-msg-success')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.update_art') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.clipart_list_content') }}">{{ trans('admin.art_lists') }}</a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.add_new_art_content') }}">{{ trans('admin.add_more_art') }}</a></h3>
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
            <label class="col-sm-4 control-label pull-left" for="inputArtName">{{ trans('admin.art_name') }}</label>
            <div class="col-sm-8">
                <input type="text" placeholder="{{ trans('admin.art_name') }}" id="inputArtName" name="inputArtName" class="form-control" value="{{ $art_update_data_by_id['post_title'] }}">
            </div>
          </div>   
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputSelectCategory">{{ trans('admin.select_category') }} </label>
            <div class="col-sm-8">
              <select name="inputSelectCategory" id="inputSelectCategory" class="form-control select2" style="width: 100%;">
                @if(count($getArtCatByFilter)>0)
                  @foreach($getArtCatByFilter as $row)
                    @if($row['term_id'] == $art_update_data_by_id['art_cat_id'])
                      <option selected="selected" value="{{ $row['term_id'] }}">{!! $row['name'] !!}</option>
                    @else
                      <option value="{{ $row['term_id'] }}">{!! $row['name'] !!}</option>
                    @endif
                  @endforeach
                @endif
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputArtStatus">{{ trans('admin.art_status') }}</label>
            <div class="col-sm-8">
              <select name="inputArtStatus" id="inputArtStatus" class="form-control select2" style="width: 100%;">
                @if($art_update_data_by_id['post_status'] == 1)
                <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                @else
                <option value="1">{{ trans('admin.enable') }}</option>
                @endif
                
                @if($art_update_data_by_id['post_status'] == 0)
                <option selected="selected" value="0">{{ trans('admin.disable') }}</option>
                @else
                <option value="0">{{ trans('admin.disable') }}</option>
                @endif
                
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-4 control-label pull-left" for="inputCategoryName">{{ trans('admin.upload_your_art_image') }}</label>
            <div class="col-sm-8">
              <div class="uploadform dropzone no-margin dz-clickable update-art-dropzone-file-upload" id="update_art_dropzone_file_upload" name="update_art_dropzone_file_upload">
                <div class="dz-default dz-message">
                  <span>{{ trans('admin.drop_your_cover_picture_here') }}</span>
                </div>
              </div>
              [{{ trans('admin.you_can_upload_1_image') }}]
              <br>
              <div class="uploaded-all-art-images">
                @if($art_update_data_by_id['art_img_url'])
                <div class="art-image-single-container"><img class="img-responsive" src="{{ get_image_url($art_update_data_by_id['art_img_url']) }}"><div data-id="{{ $art_update_data_by_id['id'] }}" class="remove-art-img-link"></div></div>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
  <input type="hidden" name="ht_art_all_uploaded_images" id="ht_art_all_uploaded_images" value="{{ $art_update_img_json }}">
  <input type="hidden" name="ht_art_upload_status" id="ht_art_upload_status" value="update">
</form>

@endsection