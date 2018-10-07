@extends('layouts.admin.master')
@section('title', trans('admin.add_roles_page_title') .' < '. get_site_title())

@section('content')
@include('pages-message.form-submit')

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add">
 
  <div class="box box-solid">
    <div class="box-header">
      <h3 class="box-title">{{ trans('admin.add_user_role_title') }} &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="{{ route('admin.users_roles_list') }}">{{ trans('admin.user_role_list_title') }}</a></h3>
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
            <div class="col-sm-2">
              <label class="control-label" for="inputEnterRoleName">{{ trans('admin.enter_role_name') }}</label>
            </div>
            <div class="col-sm-10">
              <input type="text" placeholder="{{ trans('admin.enter_role_name') }}" class="form-control" value="" id="user_role_name" name="user_role_name">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-2">
              <label class="control-label" for="inputAccessList">{{ trans('admin.access_list_by_role') }}</label>
            </div>
            <div class="col-sm-10 permissions-file">
              <div class="col-md-12">
                <?php $i = 1; ?>  
                @foreach( get_permissions_files_list() as $key=>$val)
                <div class="col-md-4">
                    <div class="allow-btn">  
                        <label class="shopist-switch">
                            <input type="checkbox" name="allow_permissions[]" class="file-name" id="allow_permissions_{{ $i }}" value="{{ $key }}">
                            <span></span>
                            &nbsp; {!! $val !!}
                        </label>    
                    </div>
                </div>
                <?php $i++; ?>
                @endforeach
                <div class="col-md-4">
                    <div class="allow-btn">  
                        <label class="shopist-switch">
                            <input type="checkbox" name="allow_permissions_all" id="allow_permissions_all" value="all_checkbox_enable">
                            <span></span>
                            &nbsp; {!! trans('admin.access_list_allow_for_all') !!}
                        </label>    
                    </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>
  
</form>

@endsection