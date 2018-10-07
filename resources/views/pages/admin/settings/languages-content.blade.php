@extends('layouts.admin.master')
@section('title', trans('admin.manage_languages') .' < '. get_site_title())

@section('content')
<form class="form-horizontal lang-settings" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="_settings_name" value="language_settings">
  
  @include('pages-message.notify-msg-success')
  @include('pages-message.notify-msg-error')
  @include('pages-message.form-submit')
          
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-flag"></i>
      @if(Request::is('admin/settings/languages'))
        <h3 class="box-title">{{ trans('admin.upload_lang_file') }}</h3>
      @elseif(Request::is('admin/settings/languages/update/*'))
        <h3 class="box-title">{{ trans('admin.edit_upload_lang_file') }}</h3>
      @endif
    </div>
    <br>
    <div class="box-body">
      <div class="row">
        
        @if(Request::is('admin/settings/languages'))
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputLanguageName">{{ trans('admin.lang_name') }}</label></div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.lang_name_placeholder') }}" id="inputLangName" name="inputLangName" class="form-control" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputUploadLanguageZip">{{ trans('admin.upload_languages_zip') }}</label></div>
            <div class="col-sm-8">
              <div><input type="file" name="lang_file_upload" id="lang_file_upload"></div><br>
              <div><span>{{ trans('admin.zip_file_confirmation') }}</span> &nbsp;&nbsp; <span>[<a href="{{ url('/resources/lang/en.zip') }}" download>{{ trans('admin.download_sample_language_file') }}</a>]</span></div>
            </div>
          </div>  
          <div class="text-right">
            <input type="submit" name="post_lang_file_upload" class="btn btn-primary" value="{{ trans('admin.upload_lang_zip_file') }}">
          </div>
        </div>
        @elseif(Request::is('admin/settings/languages/update/*'))
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputLanguageName">{{ trans('admin.lang_name') }}</label></div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.lang_name_placeholder') }}" id="inputLangName" name="inputLangName" class="form-control" value="{{ $lang_data_by_id['lang_name'] }}">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputUploadLanguageZip">{{ trans('admin.upload_languages_zip') }}</label></div>
            <div class="col-sm-8">
              <div><input type="file" name="lang_file_upload" id="lang_file_upload"></div><br>
              <div><span>{{ trans('admin.zip_file_confirmation') }}</span> &nbsp;&nbsp; <span>[<a href="{{ url('/resources/lang/en.zip') }}" download>{{ trans('admin.download_sample_language_file') }}</a>]</span></div>
            </div>
          </div>  
          <div class="text-right">
            <input type="submit" name="post_lang_file_edit_option" class="btn btn-primary" value="{{ trans('admin.update_lang_zip_file') }}">
          </div>
        </div>
        @endif
        
      </div>
    </div>
  </div>  
  
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-flag"></i>
      <h3 class="box-title">{{ trans('admin.lang_manage_option') }}</h3>
    </div>
    <br>
    <div class="box-body">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <table class="table table-bordered table-striped admin-data-table">
            <thead>
              <tr>
                <th>{{ trans('admin.lang_name') }}</th>
                <th>{{ trans('admin.lang_status') }}</th>
                <th>{{ trans('admin.lang_default_status') }}</th>
                <th>{{ trans('admin.action') }}</th>
              </tr>
            </thead>
            <tbody>
              @if(count($lang_data)>0)
              <?php $i = 1;?>
               @foreach($lang_data as $row)
               <tr>
                 <td>
                   @if($row['lang_code'] == 'en')
                    <img src="{{ asset('public/images/'. $row['lang_sample_img']) }}"> &nbsp;&nbsp;{{ $row['lang_name'] }}
                   @else
                    <img src="{{ get_image_url($row['lang_sample_img']) }}"> &nbsp;&nbsp;{{ $row['lang_name'] }}
                   @endif
                 </td>
                 
                 @if($row['status'] == 1)
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_frontend[]" id="enable_switching_for_frontend_{{ $i }}" checked value="{{ $row['id'] }}">
                    <span></span>
                  </label>       
                 </td>
                 @else
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_frontend[]" id="disable_switching_for_frontend_{{ $i }}" value="{{ $row['id'] }}">
                    <span></span>
                  </label>   
                 </td>
                 @endif
                 
                 @if($row['default_lang'] == 1)
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_default[]" class="switching-for-default onoffswitch-checkbox" id="enable_switching_for_default_{{ $i }}" checked value="{{ $row['id'] }}">
                    <span></span>
                  </label>     
                 </td>
                 @else
                 <td>
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_default[]" class="switching-for-default onoffswitch-checkbox" id="disable_switching_for_default_{{ $i }}" value="{{ $row['id'] }}">
                    <span></span>
                  </label>    
                 </td>
                 @endif
                 
                 <td>
                    @if($row['lang_code'] !== 'en')
                      <div class="btn-group">
                        <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                        <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                          <li><a href="{{ route('admin.update_languages_settings_content', $row['id']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                          <li><a href="{{ url('/resources/lang/'.$row['lang_code'].'.zip') }}" download><i class="fa fa-download"></i>{{ trans('admin.download_file') }}</a></li>
                          <li><a class="remove-selected-data-from-list" data-track_name="manage_languages" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                        </ul>
                      </div>
                    @endif
                 </td>
               </tr>
               <?php $i ++;?>
               @endforeach
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{{ trans('admin.lang_name') }}</th>
                <th>{{ trans('admin.lang_status') }}</th>
                <th>{{ trans('admin.lang_default_status') }}</th>
                <th>{{ trans('admin.action') }}</th>
              </tr>
            </tfoot>
          </table>
          <br>
          <div class="text-right">
            <input type="submit" name="post_lang_settings" class="btn btn-primary" value="{{ trans('admin.update_language_settings') }}">
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
@endsection