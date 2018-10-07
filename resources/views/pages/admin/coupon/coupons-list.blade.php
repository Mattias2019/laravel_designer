@extends('layouts.admin.master')
@section('title', trans('admin.coupon_manager_list_page_title') .' < '. get_site_title())

@section('content')
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title">{!! trans('admin.coupon_list_label') !!}</h3>
    <div class="box-tools pull-right">
      <a href="{{ route('admin.coupon_manager_content') }}" class="btn btn-primary">{!! trans('admin.create_new_coupon_label') !!}</a>
    </div>
  </div>
</div>

<div class="row"> 
  <div class="col-xs-12">
    <h3></h3>  
    <div class="box">
      <div class="box-body">
				<div id="table_search_option">
          <form action="{{ route('admin.coupon_manager_list') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_coupon" class="search-query form-control" placeholder="Enter your title to search" value="{{ $search_value }}" />
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
        <table class="table table-striped table-bordered dt-responsive nowrap data-table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>{!! trans('admin.coupon_code_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_type_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_amount_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_description_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_usage_limit_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_usage_selected_role_tbl_title') !!}</th>
              <th>{!! trans('admin.coupon_expiry_date_tbl_title') !!}</th>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($coupon_all_data) > 0)  
              @foreach($coupon_all_data as $row )
                <tr>
                  <td>{!! $row['post_title'] !!}</td>
                  
                  @if($row['coupon_condition_type'] == 'discount_from_product')
                    <td>{!! trans('admin.discount_from_product_label') !!}</td>
                  @elseif($row['coupon_condition_type'] == 'percentage_discount_from_product') 
                    <td>{!! trans('admin.percentage_discount_from_product_label') !!}</td>
                  @elseif($row['coupon_condition_type'] == 'discount_from_total_cart') 
                    <td>{!! trans('admin.discount_from_total_cart_label') !!}</td>
                  @elseif($row['coupon_condition_type'] == 'percentage_discount_from_total_cart') 
                    <td>{!! trans('admin.percentage_discount_from_total_cart_label') !!}</td>  
                  @endif
                  
                  <td>{!! $row['coupon_amount'] !!}</td>
                  <td>{!! string_decode($row['post_content']) !!}</td>
                  <td>{!! $row['usage_limit_per_coupon'] !!}</td>
                  <td>{!! $row['coupon_allow_role_name'] !!}</td>
                  <td>{{ Carbon\Carbon::parse(  $row['usage_range_end_date'] )->format('F d, Y') }}</td>
                  <td>{!! get_vendor_name( $row['post_author_id'] ) !!}</td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="{{ route('admin.update_coupon_manager_content', $row['post_slug']) }}"><i class="fa fa-edit"></i>{!! trans('admin.edit') !!}</a></li>
                        <li><a class="remove-selected-data-from-list" data-track_name="coupon_list" data-id="{{ $row['id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              @endforeach
            @else
              <tr><td colspan="9"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('admin.coupon_code_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_type_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_amount_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_description_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_usage_limit_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_usage_selected_role_tbl_title') }}</th>
              <th>{{ trans('admin.coupon_expiry_date_tbl_title') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
				<div class="products-pagination">{!! $coupon_all_data->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>
@endsection