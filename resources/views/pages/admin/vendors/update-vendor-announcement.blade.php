@extends('layouts.admin.master')
@section('title', trans('admin.update_announcement_label') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-error')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
        <h3 class="box-title">{{ trans('admin.add_new_post_top_title') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.announcement_list_content') }}">{{ trans('admin.posts_list') }}</a> &nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.announcement_content') }}">{{ trans('admin.add_new_post') }}</a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary btn-block" type="submit">{{ trans('admin.update') }}</button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.post_title') }}</h3>
        </div>
        <div class="box-body">
          <input type="text" placeholder="{{ trans('admin.post_title_placeholder') }}" class="form-control" name="vendor_announcement_post_title" id="vendor_announcement_post_title" value="{{ $vendor_announcement->post_title }}">
        </div>
      </div>
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.post_description') }}</h3>
        </div>
        <div class="box-body">
          <textarea id="announcement_description_editor" name="announcement_description_editor" class="dynamic-editor" placeholder="{{ trans('admin.post_description_placeholder') }}">{!! $vendor_announcement->post_content !!}</textarea>
        </div>
      </div>  
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title">{{ trans('admin.announcement_settings_label') }}</h3>
        </div>
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-3 control-label" for="inputSendAnnouncement">{{ trans('admin.send_announcement_to_label') }}</label>
            <div class="col-sm-9">
              <select id="send_announcement" name="send_announcement" class="form-control select2" style="width: 100%;">
                <option value="">{!! trans('admin.select_option_label') !!}</option>
                
                @if($vendor_announcement->announcement_receiver_name == 'all_vendor')
                <option selected="selected" value="all_vendor">{!! trans('admin.all_vendor_label') !!}</option>
                @else
                <option value="all_vendor">{!! trans('admin.all_vendor_label') !!}</option>
                @endif
                
                @if($vendor_announcement->announcement_receiver_name == 'selected_vendor')
                <option selected="selected" value="selected_vendor">{!! trans('admin.selected_vendor_label') !!}</option>
                @else
                <option value="selected_vendor">{!! trans('admin.selected_vendor_label') !!}</option>
                @endif
              </select>   
            </div>
          </div>
          @if($vendor_announcement->announcement_receiver_name == 'selected_vendor')  
          <div id="send_selected_vendor" class="form-group">
            <label class="col-sm-3 control-label" for="inputSelectVendor">{{ trans('admin.select_vendor_label') }}</label>
            <div class="col-sm-9">
              <input type="text" name="vendor_lists" placeholder="{{ trans('admin.vendor_search_placeholder_label') }}" class="typeahead vendor-lists-typeahead tm-input vendor-lists-input form-control tm-input-info"/>
            </div>
          </div>  
          @else
          <div id="send_selected_vendor" class="form-group" style="display:none;">
            <label class="col-sm-3 control-label" for="inputSelectVendor">{{ trans('admin.select_vendor_label') }}</label>
            <div class="col-sm-9">
              <input type="text" name="vendor_lists" placeholder="{{ trans('admin.vendor_search_placeholder_label') }}" class="typeahead vendor-lists-typeahead tm-input vendor-lists-input form-control tm-input-info"/>
            </div>
          </div>  
          @endif
        </div>
      </div>    
    </div>
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title">{{ trans('admin.visibility') }}</h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="inputVisibility">{{ trans('admin.status') }}</label>
                <div class="col-sm-9">
                  <select class="form-control select2" name="announcement_post_visibility" style="width: 100%;">
                    @if($vendor_announcement->post_status == 1)  
                    <option selected="selected" value="1">{{ trans('admin.enable') }}</option>
                    @else
                    <option value="1">{{ trans('admin.enable') }}</option>
                    @endif
                    
                    @if($vendor_announcement->post_status == 0)  
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
    </div>
  </div>
  <input type="hidden" name="selected_vendors" id="selected_vendors" value="{{ $vendor_announcement->post_json_data }}"> 
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
</form>
@endsection