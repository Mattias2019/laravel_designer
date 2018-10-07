@extends('layouts.admin.master')
@section('title', trans('admin.clipart_list') .' < '. get_site_title())

@section('content')
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{{ trans('admin.art_lists') }}</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('admin.add_new_art_content') }}" class="btn btn-primary pull-right">{{ trans('admin.add_new_art') }}</a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.clipart_list_content') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_art_cat" class="search-query form-control" placeholder="Enter your cat name to search" value="{{ $search_value }}" />
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
              <th>{{ trans('admin.images') }}</th>
              <th>{{ trans('admin.category_name') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($art_lists)>0)
              @foreach($art_lists as $row)
              <tr>              
                @if(!empty($row->art_img))
                <td><img src="{{ get_image_url($row->art_img) }}" alt="{{ basename ($row->art_img) }}"></td>
                @else
                <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                @endif

                <td>{!!  $row->cat_name !!}</td>

                @if($row->post_status == 1)
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
                      <li><a href="{{ route('admin.update_clipart_content', $row->post_slug)}}"><i class="fa fa-edit"></i>{{ trans('admin.edit') }}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="art_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
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
              <th>{{ trans('admin.images') }}</th>
              <th>{{ trans('admin.category_name') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $art_lists->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>

@endsection