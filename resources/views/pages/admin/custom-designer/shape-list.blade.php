@extends('layouts.admin.master')
@section('title', trans('admin.shape_list') .' < '. get_site_title())

@section('content')
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{{ trans('admin.designer_shape_list') }}</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('admin.shape_add_content') }}" class="btn btn-primary pull-right">{{ trans('admin.add_new_shape') }}</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.shape_list_content') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_shape" class="search-query form-control" placeholder="Enter your shape name to search" value="{{ $search_value }}" />
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
        <table class="table table-bordered table-striped admin-data-table custom-shape">
          <thead>
            <tr>
              <th>{{ trans('admin.name') }}</th>
              <th>{{ trans('admin.content_label') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if($designer_shape_list->count() > 0)
              @foreach($designer_shape_list as $row)
              <tr>
                <td>{!! $row['post_title'] !!}</td>
                <td>{!! base64_decode($row['post_content']) !!}</td>

                @if($row['post_status'] == 1)
                <td>{{ trans('admin.enable') }}</td>
                @else
                <td>{{ trans('admin.disable') }}</td>
                @endif

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="{{ route('admin.shape_update_content', $row['post_slug']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="designer_shape_list" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="4"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('admin.name') }}</th>
              <th>{{ trans('admin.content_label') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $designer_shape_list->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>
@endsection