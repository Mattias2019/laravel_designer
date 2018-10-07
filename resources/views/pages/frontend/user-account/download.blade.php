<div id="user_download">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <h4><label>{{ trans('admin.frontend_user_download_list') }}</label></h4><hr>
      <br>
      <table id="table_user_account_download_list" class="table table-bordered table-striped">
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
                <td>
                  @if(count($row['_download_history']) > 0)  
                    @foreach($row['_download_history'] as $items)
                      @if(!empty($items['download_data']))
                        {!! download_file_html( $items['id'], $items['download_data'], $row['_post_id']) !!}
                      @endif
                    @endforeach
                  @else
                  {!! trans('frontend.no_downloaded_file_label') !!}
                  @endif
                </td>
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
</div>