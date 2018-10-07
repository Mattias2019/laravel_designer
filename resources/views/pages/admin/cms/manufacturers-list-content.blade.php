@extends('layouts.admin.master')
@section('title', trans('admin.manufacturers_list') .' < '. get_site_title())

@section('content')
@if($manufacturerslist)

<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{{ trans('admin.manufacturers_list') }}</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('admin.add_manufacturers_content') }}" class="btn btn-primary pull-right">{{ trans('admin.add_new_manufacturers') }}</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.manufacturers_list_content') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_brand" class="search-query form-control" placeholder="Enter your brand name to search" value="{{ $search_value }}" />
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
        <table class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th>{{ trans('admin.image') }}</th>
              <th>{{ trans('admin.name') }}</th>
              <th>{{ trans('admin.country_name') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($manufacturerslist)>0)
              @foreach($manufacturerslist as $row)
              <tr>
                @if($row['brand_logo_img_url'])
                <td><img src="{{ get_image_url($row['brand_logo_img_url']) }}" alt="{{ basename ($row['brand_logo_img_url']) }}"></td>
                @else
                <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!! $row['name'] !!}</td>
                <td>{!! $row['brand_country_name'] !!}</td>

                @if($row['status'] == 1)
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
                      <li><a target="_blank" href="{{ route('brands-single-page', $row['slug']) }}"><i class="fa fa-eye"></i>{!! trans('admin.view') !!}</a></li>  
                      @if(in_array('add_edit_delete_brands', $user_permission_list))
                      <li><a href="{{ route('admin.update_manufacturers_content', $row['slug']) }}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="manufacturers_list" data-id="{{ $row['term_id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                      @endif
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
												@else
              <tr><td colspan="5"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>		
            @endif
          </tbody>
          <tfoot>
            <th>{{ trans('admin.image') }}</th>
            <th>{{ trans('admin.name') }}</th>
            <th>{{ trans('admin.country_name') }}</th>
            <th>{{ trans('admin.status') }}</th>
            <th>{{ trans('admin.action') }}</th>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $manufacturerslist->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>

@endif
@endsection