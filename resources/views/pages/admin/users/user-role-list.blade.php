@extends('layouts.admin.master')
@section('title', trans('admin.user_role_list_title') .' < '. get_site_title())

@section('content')
<div class="box box-solid">
  <div class="box-header">
    <h3 class="box-title">{{ trans('admin.user_role_list_title') }}</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('admin.add_roles') }}" class="btn btn-primary pull-right">{{ trans('admin.add_new_role_title') }}</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.users_roles_list') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_user_role" class="search-query form-control" placeholder="Enter user role to search" value="{{ $search_value }}" />
                  <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        </div>      
        <table id="table_for_user_list" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>{{ trans('admin.user_role_list_table_header_title_1') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($user_role_list_data)>0)
            @foreach($user_role_list_data as $row)
            <tr>
              <td>{!! $row['role_name'] !!}</td> 
              <td>
                @if($row['slug'] !== 'vendor')  
                <div class="btn-group">
                  <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                  <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="{{ route('admin.update_roles', $row['id']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                    <li><a class="remove-selected-data-from-list" data-track_name="user_roles" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                  </ul>
                </div>
                @else
                {!! trans('admin.no_permission_label') !!}
                @endif
              </td>
            </tr>
            @endforeach
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('admin.user_role_list_table_header_title_1') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $user_role_list_data->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>
<div class="eb-overlay"></div>
<div class="eb-overlay-loader"></div>

<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
@endsection