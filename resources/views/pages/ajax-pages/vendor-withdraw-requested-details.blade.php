<div id="vendor_withdraw_requested_data_process">
  <table style="width:100%;">
    <tr>
      <th style="padding:10px 0px;">{!! trans('admin.status') !!}</th>
      <td style="padding:10px 0px;">
      @if($withdraw_details->status == 'ON_HOLD')  
        {!! trans('admin.pending') !!}
      @elseif($withdraw_details->status == 'COMPLETED')
        {!! trans('admin.completed') !!}
      @elseif($withdraw_details->status == 'CANCELLED')
        {!! trans('admin.cancelled') !!}
      @endif
      </td>
    </tr>
    <tr>
      <th style="padding:10px 0px;">{!! trans('admin.requested_amount_label') !!}</th>
      <td style="padding:10px 0px;">{!! price_html($withdraw_details->amount) !!}</td>
    </tr>
    <tr>
      <th style="padding:10px 0px;">{!! trans('admin.default_withdrawals_type_label') !!}</th>
      <td style="padding:10px 0px;">
        @if($withdraw_details->payment_type == 'single_payment_with_custom_values')
          {!! trans('admin.single_with_custom_values_label') !!}
        @elseif($withdraw_details->payment_type == 'single_payment_with_all_earnings')
          {!! trans('admin.single_with_all_earnings_label') !!}
        @endif
      </td>
    </tr>
    <tr>
      <th style="padding:10px 0px;">{!! trans('admin.default_withdrawals_method_label') !!}</th>
      <td style="padding:10px 0px;">
        @if($withdraw_details->payment_method == 'dbt')
          {!! trans('admin.direct_bank_transfer') !!}
        @elseif($withdraw_details->payment_method == 'cod')
          {!! trans('admin.cash_on_delivery') !!}
        @elseif($withdraw_details->payment_method == 'paypal')
          {!! trans('admin.paypal') !!}
        @elseif($withdraw_details->payment_method == 'stripe')
          {!! trans('admin.stripe') !!}
        @endif
      </td>
    </tr>
    <tr>
      <th style="padding:20px 0px 10px 0px;">{!! trans('admin.requested_payment_method_details_label') !!}</th>
      <td style="padding:20px 0px 10px 0px;">
          @if($withdraw_details->payment_method == 'dbt')
          <p>{!! trans('admin.product_name') !!}: {!! $payment_details->dbt->title !!}</p>
          <p>{!! trans('admin.description') !!}:  {!! $payment_details->dbt->description !!}</p>
          <p>{!! trans('admin.instructions') !!}: {!! $payment_details->dbt->instructions !!}</p>
          <p>{!! trans('admin.account_name') !!}: {!! $payment_details->dbt->account_name !!}</p>
          <p>{!! trans('admin.account_number') !!}: {!! $payment_details->dbt->account_number !!}</p>
          <p>{!! trans('admin.bank_name') !!}: {!! $payment_details->dbt->bank_name !!}</p>
          <p>{!! trans('admin.bank_short_code') !!}: {!! $payment_details->dbt->short_code !!}</p>
          <p>{!! trans('admin.bank_iban') !!}: {!! $payment_details->dbt->IBAN !!}</p>
          <p>{!! trans('admin.bank_swift') !!}: {!! $payment_details->dbt->SWIFT !!}</p>
          
          @elseif($withdraw_details->payment_method == 'cod')
          <p>{!! trans('admin.product_name') !!}: {!! $payment_details->cod->title !!}</p>
          <p>{!! trans('admin.description') !!}: {!! $payment_details->cod->description !!}</p>
          <p>{!! trans('admin.instructions') !!}: {!! $payment_details->cod->instructions !!}</p>
          
          @elseif($withdraw_details->payment_method == 'paypal')
          <p>{!! trans('admin.product_name') !!}: {!! $payment_details->paypal->title !!}</p>
          <p>{!! trans('admin.email') !!}: {!! $payment_details->paypal->email_id !!}</p>
          <p>{!! trans('admin.description') !!}: {!! $payment_details->paypal->description !!}</p>
          
          @elseif($withdraw_details->payment_method == 'stripe')
          <p>{!! trans('admin.product_name') !!}: {!! $payment_details->stripe->title !!}</p>
          <p>{!! trans('admin.email') !!}: {!! $payment_details->stripe->email_id !!}</p>
          <p>{!! trans('admin.card_number_label') !!}: {!! $payment_details->stripe->card_number !!}</p>
          <p>{!! trans('admin.only_cvc_label') !!}: {!! $payment_details->stripe->cvc !!}</p>
          <p>{!! trans('admin.expiration_month') !!}: {!! $payment_details->stripe->expiration_month !!}</p>
          <p>{!! trans('admin.expiration_year') !!}: {!! $payment_details->stripe->expiration_year !!}</p>
          <p>{!! trans('admin.description') !!}: {!! $payment_details->stripe->description !!}</p>
          @endif
      </td>
    </tr>
  </table>
</div>