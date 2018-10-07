@section('vendor-withdrawal-account-page-content')
<div id="vendor_withdraw_request_content">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
          <div class="box-body">
            <div class="col-md-6">
              <h4>{!! trans('admin.default_withdrawals_type_label') !!}</h4><hr>
              <div class="default-withdraw-type-content">
                @if(count($withdraw_request_data) > 0)
                <p><i class="fa fa-check"></i> {!! $withdraw_request_data['selected_payment_type'] !!}</p>
                @if($withdraw_request_data['payment_type'] == 'single_payment_with_custom_values')
                <p><i class="fa fa-check"></i> {!! trans('admin.custom_values_label') !!} {!! get_current_currency_symbol() !!}{!! $withdraw_request_data['custom_amount'] !!}</p>
                @endif
                <p><i class="fa fa-check"></i> {!! trans('admin.requested_label') !!} {!! Carbon\Carbon::parse( $withdraw_request_data['created_at'] )->format('d, M Y') !!}</p><br>
                @else
                <p><i class="fa fa-close"></i> {!! trans('admin.default_no_withdraw_for_processing_msg') !!}</p>
                @endif
              </div>
            </div>
            <div class="col-md-6">
              <h4>{!! trans('admin.default_withdrawals_method_label') !!}</h4><hr>
              <div class="default-withdraw-method-content">
                @if(count($withdraw_request_data) > 0)
                <p><i class="fa fa-check"></i> {!! $withdraw_request_data['selected_payment_method'] !!}</p>
                <p><i class="fa fa-check"></i> {!! trans('admin.requested_label') !!} {!! Carbon\Carbon::parse( $withdraw_request_data['created_at'] )->format('d, M Y') !!}</p><br>
                @else
                <p><i class="fa fa-close"></i> {!! trans('admin.default_no_withdraw_paymenthod_method_for_processing_msg') !!}</p>
                @endif
              </div>
            </div>
            @if(count($withdraw_request_data) > 0)  
            <div class="col-md-12">
              <div class="clearfix">
                <div class="pull-right">
                  <a class="btn btn-primary btn-md" href="{{ route('admin.withdraws_content_update', $withdraw_request_data['id']) }}">{!! trans('admin.change_withdraw_request_label') !!}</a>
                  <a class="btn btn-primary btn-md" href="{{ route('admin.delete_withdraws_request', $withdraw_request_data['id']) }}">{!! trans('admin.delete_withdraw_request_label') !!}</a>
                </div>  
              </div><br>
            </div>  
            @endif
          </div>
      </div>
    </div>
  </div>
</div> 
@endsection