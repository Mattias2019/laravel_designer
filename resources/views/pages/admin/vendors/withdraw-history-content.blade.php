@section('vendor-withdraw-history-page-content')
<div id="vendor_withdraw_history_content">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <table id="table_for_products_list" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>{!! trans('admin.amount_solid_label') !!}</th>
                <th>{!! trans('admin.payment_method_label') !!}</th>
                <th>{!! trans('admin.processed_date_label') !!}</th>
                <th>{!! trans('admin.status') !!}</th>
              </tr>
            </thead>
            <tbody>
              @if(count($withdraw_history_data) > 0)  
                @foreach($withdraw_history_data as $row)
                <tr>
                  <td>{!! price_html($row['amount']) !!}</td>
                  
                  @if($row['payment_method'] == 'dbt')
                  <td>{!! trans('admin.direct_bank_transfer') !!}</td>
                  @elseif($row['payment_method'] == 'cod')
                  <td>{!! trans('admin.cash_on_delivery') !!}</td>
                  @elseif($row['payment_method'] == 'paypal')
                  <td>{!! trans('admin.paypal') !!}</td>
                  @elseif($row['payment_method'] == 'stripe')
                 <td>{!! trans('admin.stripe') !!}</td>
                  @endif
                  
                  <td>{{ Carbon\Carbon::parse($row['updated_at'])->format('d, M Y') }}</td>
                  <td>
                    @if($row['status'] == 'COMPLETED')  
                    <span style="color:#00a65a;">{!! trans('admin.completed') !!}</span>
                    @elseif($row['status'] == 'CANCELLED')
                    <span style="color:#ff0084;">{!! trans('admin.cancelled') !!}</span>
                    @elseif($row['status'] == 'ON_HOLD')
                    <span style="color:#3c8dbc;">{!! trans('admin.pending') !!}</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              @else
                <tr><td colspan="4"><i class="fa fa-exclamation-triangle"></i> {!! trans('admin.no_data_found_label') !!}</td></tr>  
              @endif
            </tbody>
            <tfoot>
              <tr>
                <th>{!! trans('admin.amount_solid_label') !!}</th>
                <th>{!! trans('admin.payment_method_label') !!}</th>
                <th>{!! trans('admin.processed_date_label') !!}</th>
                <th>{!! trans('admin.status') !!}</th>
              </tr>
            </tfoot>
          </table>
          <div class="products-pagination">{!! $withdraw_history_data->appends(Request::capture()->except('page'))->render() !!}</div>  
        </div>
      </div>
    </div>
  </div>
</div>
@endsection