@section('vendor-withdraw-request-page-content')
<div id="vendor_withdraw_request_content">
  <div class="box box-solid">
    <div class="row">
      <div class="col-md-12">
        <div class="box-body">
          <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="hf_withdraw_request_target_tab" id="hf_withdraw_request_target_tab" value="{{ $withdraw_update_target }}">
            <input type="hidden" name="target" id="target" value="add_withdraw_request">
            
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputSelectPaymentType">{{ trans('admin.select_payment_type_label') }}</label>
              <div class="col-sm-8">
                <div class="payment-type-options">  
                  <div class="payment-type-radio"><input type="radio" class="shopist-iCheck" name="payment_type" value="single_payment_with_custom_values"></div><div class="single-payment-values"><input type="number" placeholder="$0.00" id="single_payment_with_custom_values" name="single_payment_with_custom_values" class="form-control" style="width:200px;"></div> <div class="payment-type-label"> {!! trans('admin.single_with_custom_values_label') !!}</div>
                </div>
                <div class="payment-type-options">    
                  <div class="payment-type-radio"><input type="radio" class="shopist-iCheck" name="payment_type" value="single_payment_with_all_earnings"></div><div class="payment-type-label"> {!! trans('admin.single_with_all_earnings_label') !!}</div>
                </div>
              </div>
            </div> 
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputSelectPaymentMethod">{{ trans('admin.select_payment_method_label') }}</label>
              <div class="col-sm-8">
                <div class="payment-method-options">  
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="dbt"></div><div class="payment-method-label"> {!! trans('admin.direct_bank_transfer') !!}</div>
                </div>
                <div class="payment-method-options">    
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="cod"></div><div class="payment-method-label"> {!! trans('admin.cash_on_delivery') !!}</div>
                </div>  
                <div class="payment-method-options">      
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="paypal"></div><div class="payment-method-label"> {!! trans('admin.paypal') !!}</div>
                </div>
                <div class="payment-method-options">      
                  <div class="payment-method-radio"><input type="radio" class="shopist-iCheck" name="payment_method" value="stripe"></div><div class="payment-method-label"> {!! trans('admin.stripe') !!}</div>
                </div>  
              </div>
            </div> 
            <div class="clearfix">
              <button class="btn btn-primary pull-right" type="submit">{{ trans('admin.submit_request_label') }}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection