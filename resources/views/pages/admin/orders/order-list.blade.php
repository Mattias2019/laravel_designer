@extends('layouts.admin.master')
@section('title', trans('admin.orders_list') .' < '. get_site_title())

@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th>{{ trans('admin.orders') }}</th>
              <th>{{ trans('admin.order_totals') }}</th>
              <th>{{ trans('admin.vendor_name_label') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </thead>
          <tbody>
            @if(count($orders_list_data)>0)
              @foreach($orders_list_data as $row)
              <tr>
                <td><a href="{{ route('admin.view_order_details', $row['_post_id']) }}">{{ trans('admin.order') }} #{!! $row['_post_id'] !!}</a>@if($row['_order_status'] == 'on-hold')<span class="on-hold-label">{{ trans('admin.on_hold') }}</span>@elseif($row['_order_status'] == 'refunded') <span class="refunded-label">{{ trans('admin.refunded') }}</span>@elseif($row['_order_status'] == 'cancelled') <span class="cancelled-label">{{ trans('admin.cancelled') }}</span> @elseif($row['_order_status'] == 'pending') <span class="pending-label">{{ trans('admin.pending') }}</span> @elseif($row['_order_status'] == 'processing') <span class="processing-label">{{ trans('admin.processing') }}</span> @elseif($row['_order_status'] == 'completed') <span class="completed-label">{{ trans('admin.completed') }}</span> @elseif($row['_order_status'] == 'shipping') <span class="shipping-label">{{ trans('admin.shipping') }}</span> @endif <br><span class="order-date-format">{!! $row['_order_date'] !!}</span></td>
                <td>{!! price_html( $row['_final_order_total'], $row['_order_currency'] ) !!}</td>
                <td>{!! get_vendor_name(get_vendor_id_by_order_id( $row['_post_id'] )) !!}</td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="{{ route('admin.view_order_details', $row['_post_id']) }}"><i class="fa  fa-search"></i>{{ trans('admin.view_order') }}</a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="order_list" data-id="{{ $row['_post_id'] }}" href="#"><i class="fa fa-remove"></i>{{ trans('admin.delete') }}</a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              @endforeach
            @else
              <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
            @endif
          </tbody>
          <tfoot>
            <tr>
              <th>{{ trans('admin.orders') }}</th>
              <th>{{ trans('admin.order_totals') }}</th>
              <th>{{ trans('admin.vendor_name_label') }}</th>
              <th>{{ trans('admin.action') }}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $orders_list_data->appends(Request::capture()->except('page'))->render() !!}</div>   
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
@endsection