<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12">
    <h4><label>{{ trans('admin.frontend_user_order_list') }}</label></h4><hr>
    <br>
    <table id="table_user_account_order_list" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>{{ trans('admin.user_account_order_id') }}</th>
          <th>{{ trans('admin.user_account_order_status') }}</th>
          <th>{{ trans('admin.user_account_order_total') }}</th>
          <th>{{ trans('admin.user_account_order_date') }}</th> 
          <th>{{ trans('admin.user_account_order_action') }}</th>  
        </tr>
      </thead>
      <tbody>
        @if(count($orders_list_data) > 0) 
          @foreach($orders_list_data as $row)
            <tr>
              <td>#{!! $row['_post_id'] !!}</td>
              <td>{!!  $row['_order_status'] !!}</td>
              <td>{!!  price_html($row['_final_order_total'], $row['_order_currency']) !!}</td>  
              <td>{!!  Carbon\Carbon::parse($row['_order_date'])->format('F d, Y') !!}</td>  
              <td><a class="btn btn-default btn-sm" href="{{ route('account-order-details-page', [$row['_post_id'], $row['_order_process_key']]) }}">{!! trans('frontend.user_account_view_label') !!}</a></td>
            </tr>
          @endforeach
        @endif
      </tbody>
      <tfoot>
        <tr>
          <th>{{ trans('admin.user_account_order_id') }}</th>
          <th>{{ trans('admin.user_account_order_status') }}</th>
          <th>{{ trans('admin.user_account_order_total') }}</th>
          <th>{{ trans('admin.user_account_order_date') }}</th> 
          <th>{{ trans('admin.user_account_order_action') }}</th>  
        </tr>
      </tfoot>
    </table>
  </div>
</div>