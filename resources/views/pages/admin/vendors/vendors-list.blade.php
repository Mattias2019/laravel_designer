@extends('layouts.admin.master')
@section('title', trans('admin.vendors_list_page_title') .' < '. get_site_title())

@section('content')
<h4 class="box-title">{!! trans('admin.vendors_list_label') !!}</h4><hr class="text-border-bottom">
<div class="row">
  <div class="col-md-12">
    <div class="vendor-list-status">
      <ul>
        <li><a {{ $vendor_all }} href="{{ route('admin.vendors_list_content')}}">{!! trans('admin.only_all_label') !!}  </a></li> &nbsp; | &nbsp;  
        <li><a {{ $vendor_active }} href="{{ route('admin.vendors_list_with_status', 'active')}}">{!! trans('admin.user_account_active_title') !!}  </a></li> &nbsp; | &nbsp;
        <li><a {{ $vendor_pending }} href="{{ route('admin.vendors_list_with_status', 'pending')}}">{!! trans('admin.pending') !!}  </a></li>
      </ul>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="{{ route('admin.vendors_list_content') }}" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_vendors" class="search-query form-control" placeholder="{{ trans('admin.vendors_list_search_place_holder') }}" value="{{ $search_value }}" />
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
        <table id="table_for_vendors_list" class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th>{{ trans('admin.image') }}</th>
              <th>{{ trans('admin.user_display_name') }}</th>
              <th>{{ trans('admin.vendors_table_header_shop_name') }}</th>
              <th>{{ trans('admin.email') }}</th>
              <th>{{ trans('admin.vendors_table_header_products') }}</th>
              <th>{{ trans('admin.vendors_table_header_phone_number') }}</th>
              <th>{{ trans('admin.status') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($vendors_list_data)>0)
              @foreach($vendors_list_data as $row)
                <?php $details = json_decode($row->details);?>
                <tr>
                  @if(!empty($row->user_photo_url))
                  <td><img src="{{ get_image_url($row->user_photo_url) }}" alt="{{ basename ($row->user_photo_url) }}"></td>
                  @else
                  <td><img src="{{ default_placeholder_img_src() }}" alt=""></td>
                  @endif
                  
                  <td>{!! $row->name !!}</td>
                  <td><a target="_blank" href="{{ route('store-details-page-content', $row->name) }}">{!! $details->profile_details->store_name !!}</a></td>
                  <td>{!! $row->email !!}</td>
                  <td><a href="{{ route('admin.product_list', $row->id) }}">{!! get_author_total_products( $row->id ) !!}</a></td>
                  <td>{!! $details->profile_details->phone !!}</td>
                  
                  @if($row->user_status == 1)
                  <td class="status-enable">{{ trans('admin.enable') }}</td>
                  @else
                  <td class="status-disable">{{ trans('admin.disable') }}</td>
                  @endif

                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="#" data-toggle="modal" data-target="#vendors_profile" class="vendors-profile" data-id="{{ $row->id }}"><i class="fa fa-user"></i>{{ trans('admin.profile') }}</a></li>  
                        
                        @if($row->user_status == 1)
                        <li><a href="#" class="vendor-status-change" data-id="{{ $row->id }}" data-target="disable"><i class="fa fa-times-rectangle-o"></i>{{ trans('admin.disable') }}</a></li>
                        @else
                        <li><a href="#" class="vendor-status-change" data-id="{{ $row->id }}" data-target="enable"><i class="fa fa-check-square-o"></i>{{ trans('admin.enable') }}</a></li>
                        @endif
                        
                        <li><a class="remove-selected-data-from-list" data-track_name="vendors_list" data-id="{{ $row->id }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.remove_label') }}</a></li>
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
            <th>{{ trans('admin.image') }}</th>
            <th>{{ trans('admin.user_display_name') }}</th>
            <th>{{ trans('admin.vendors_table_header_shop_name') }}</th>
            <th>{{ trans('admin.email') }}</th>
            <th>{{ trans('admin.vendors_table_header_products') }}</th>
            <th>{{ trans('admin.vendors_table_header_phone_number') }}</th>
            <th>{{ trans('admin.status') }}</th>
            <th>{{ trans('admin.action') }}</th>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $vendors_list_data->appends(Request::capture()->except('page'))->render() !!}</div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vendors_profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h4 class="modal-title" id="myModalLabel">{!! trans('admin.vendors_user_profile_label') !!}</h4>
			</div>
      <div class="modal-body">
        <div class="eb-overlay-loader"></div>
      </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">{!! trans('admin.close') !!}</button>
			</div>
		</div>
	</div>
</div>
@endsection