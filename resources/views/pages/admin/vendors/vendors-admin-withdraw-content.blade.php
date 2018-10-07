@section('vendor-admin-withdraw-content')
<h4 class="box-title">{!! trans('admin.withdraw_requests_list_label') !!}</h4><hr class="text-border-bottom">
<div class="row">
  <div class="col-md-12">
    <div class="list-top-label">
      <ul>
        <li><a {{ $is_all }} href="{{ route('admin.withdraws_content')}}">{!! trans('admin.only_all_label') !!} ({!! $total_row !!}) </a></li> &nbsp; | &nbsp;  
        <li><a {{ $is_pending }} href="{{ route('admin.withdraws_status_change', 'pending')}}">{!! trans('admin.pending') !!} ({!! $total_pending !!}) </a></li> &nbsp; | &nbsp;
        <li><a {{ $is_completed }} href="{{ route('admin.withdraws_status_change', 'completed')}}">{!! trans('admin.completed') !!} ({!! $total_completed !!}) </a></li> &nbsp; | &nbsp;
        <li><a {{ $is_cancelled }} href="{{ route('admin.withdraws_status_change', 'cancelled')}}">{!! trans('admin.cancelled') !!} ({!! $total_cancelled !!}) </a></li>
      </ul>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('admin.only_ip_label') !!}</th>
              <th>{!! trans('admin.requested_date_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </thead>
          <tbody>
          @if(count($withdraw_request_data_all) > 0)
            @foreach($withdraw_request_data_all as $row)
            <tr>
              <td><a target="_blank" href="{{ route('store-details-page-content', get_vendor_name($row['user_id'])) }}">{!! get_vendor_name($row['user_id']) !!}</a></td>
              <td>
                @if($row['status'] == 'COMPLETED')  
                <span style="color:#00a65a;">{!! trans('admin.completed') !!}</span>
                @elseif($row['status'] == 'CANCELLED')
                <span style="color:#ff0084;">{!! trans('admin.cancelled') !!}</span>
                @elseif($row['status'] == 'ON_HOLD')
                <span style="color:#3c8dbc;">{!! trans('admin.pending') !!}</span>
                @endif
              </td>
              <td>{!! $row['ip'] !!}</td>
              <td>{!! Carbon\Carbon::parse(  $row['created_at'] )->format('d, M Y') !!}</td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-success btn-flat" type="button">{{ trans('admin.action') }}</button>
                  <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#vendors_withdraw_view" class="withdraw-requests-data-view" data-requested_id="{{ $row['id'] }}"><i class="fa fa-eye"></i>{{ trans('admin.view') }}</a></li>
                    @if(($row['status'] == 'ON_HOLD'))
                    <li><a href="#" class="requested-withdraw-status-change" data-target="completed" data-requested_id="{{ $row['id'] }}"><i class="fa fa-check"></i>{{ trans('admin.completed') }}</a></li>
                    <li><a href="#" class="requested-withdraw-status-change" data-target="cancelled" data-requested_id="{{ $row['id'] }}"><i class="fa fa-close"></i>{{ trans('admin.cancelled') }}</a></li>
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
            <tr>
              <th>{!! trans('admin.vendor_name_label') !!}</th>
              <th>{!! trans('admin.status') !!}</th>
              <th>{!! trans('admin.only_ip_label') !!}</th>
              <th>{!! trans('admin.requested_date_label') !!}</th>
              <th>{!! trans('admin.action') !!}</th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination">{!! $withdraw_request_data_all->appends(Request::capture()->except('page'))->render() !!}</div>  
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vendors_withdraw_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
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