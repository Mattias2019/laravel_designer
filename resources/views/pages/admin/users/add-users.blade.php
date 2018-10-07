@extends('layouts.admin.master')
@section('title', trans('admin.add_user_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')
@include('pages-message.notify-msg-success')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add">
 
  <div class="box box-solid">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_new_user_title') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.users_list') }}">{{ trans('admin.user_list_title') }}</a></h3>
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
            <div class="col-sm-4">
              <label class="control-label" for="inputUserDisplayName">{{ trans('admin.user_display_name_title') }}</label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.user_display_name_title') }}" class="form-control" value="" id="user_display_name" name="user_display_name">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputUserName">{{ trans('admin.user_name_title') }}</label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.user_name_title') }}" class="form-control" value="" id="user_name" name="user_name">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputEmail">{{ trans('admin.email') }}</label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.email') }}" class="form-control" value="" id="user_email" name="user_email">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputPassword">{{ trans('admin.password') }}</label>
            </div>
            <div class="col-sm-8">
              <input type="password" placeholder="{{ trans('admin.password') }}" class="form-control" value="" id="user_password" name="user_password">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputSecretKey">{{ trans('admin.secret_key') }}</label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="{{ trans('admin.secret_key') }}" class="form-control" value="" id="user_secret_key" name="user_secret_key">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputUserRole">{{ trans('admin.user_role_title') }}</label>
            </div>
            <div class="col-sm-8">
              <select id="user_role" name="user_role" class="form-control select2" style="width: 100%;">
                @if(count(get_available_user_roles()) > 0)
                  @foreach(get_available_user_roles() as $val)
                  <option value="{{ $val['slug'] }}"> {{ ucwords($val['role_name']) }} </option>
                  @endforeach
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