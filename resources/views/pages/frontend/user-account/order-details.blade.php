@if( count($order_details_by_order_id) > 0)
<div id="user_order_details">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="col-sm-3">
        <div class="order-received-label-1 text-uppercase"><strong>{{ trans('frontend.order_number') }}</strong></div>
        <div class="order-received-label-2"><em>#{!! $order_details_by_order_id['order_id'] !!}</em></div>
      </div>
      <div class="col-sm-3">
        <div class="order-received-label-1"><strong>{{ trans('frontend.date') }}</strong></div>
        <div class="order-received-label-2"><em>{!! $order_details_by_order_id['order_date'] !!}</em></div>
      </div>
      <div class="col-sm-3">
        <div class="order-received-label-1"><strong>{{ trans('frontend.total') }}</strong></div>
        <div class="order-received-label-2"><em>{!! price_html( $order_details_by_order_id['_final_order_total'], $order_details_by_order_id['_order_currency'] ) !!}</em></div>
      </div>
      <div class="col-sm-3">
        <div class="order-received-label-1"><strong>{{ trans('frontend.payment_method') }}</strong></div>
        <div class="order-received-label-2"><em>{{ get_payment_method_title($order_details_by_order_id['_payment_method']) }}</em></div>
      </div>
      <div class="clearfix"></div><br>

    @if(isset($order_details_by_order_id['_payment_details']['method_instructions']))  
    <p class="payment_ins">{{ $order_details_by_order_id['_payment_details']['method_instructions'] }}</p>
    @endif

    @if(isset($order_details_by_order_id['_payment_details']['account_details']))  
      <h3>{{ trans('frontend.our_bank_details') }}</h3><br>
      <p>{{ trans('frontend.account_name') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['account_name'] }}</p>
      <p>{{ trans('frontend.account_number') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['account_number'] }}</p>
      <p>{{ trans('frontend.bank_name') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['bank_name'] }}</p>
      <p>{{ trans('frontend.bank_short_code') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['short_code'] }}</p>
      <p>{{ trans('frontend.iban') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['iban'] }}</p>
      <p>{{ trans('frontend.bic_swift') }}: {{ $order_details_by_order_id['_payment_details']['account_details']['swift'] }}</p>
    @endif

    <h3>{{ trans('frontend.order_details') }}</h3><br>
    <div style="width: 100%;">
      <div class="table-responsive cart_info">
        @if(count($order_details_by_order_id['ordered_items'])>0)   
          <table class="table table-condensed">
            <thead>
              <tr class="cart_menu">
                <td class="Item">{{ trans('frontend.item') }}</td>
                <td class="price">{{ trans('frontend.price') }}</td>
                <td class="quantity">{{ trans('frontend.quantity') }}</td>
                <td class="total">{{ trans('frontend.total') }}</td>
              </tr>
            </thead>
            <tbody> 
              @foreach($order_details_by_order_id['ordered_items'] as $items)
              <tr>
                <td class="cart_description">
                  <h5>{!! $items['name'] !!}</h5>
                  <?php $count = 1; ?>
                  @if(count($items['options']) > 0)
                  <p>
                    @foreach($items['options'] as $key => $val)
                      @if($count == count($items['options']))
                        {!! $key .' &#8658; '. $val !!}
                      @else
                        {!! $key .' &#8658; '. $val. ' , ' !!}
                      @endif
                      <?php $count ++ ; ?>
                    @endforeach
                  </p>
                  @endif
                </td>
                <td class="cart_price">
                  <p> {!! price_html( $items['order_price'], $order_details_by_order_id['_order_currency'] ) !!} </p>
                </td>
                <td class="cart_quantity">
                    <p> {!! $items['quantity'] !!} </p>
                </td>
                <td class="cart_total">
                  <p>{!! price_html( $items['quantity']*$items['order_price'], $order_details_by_order_id['_order_currency'] ) !!}</p>
                </td>
              </tr>
              @endforeach

              <tr class="order-items-data">
                <td colspan="4" class="order-total">
                  <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.tax') }}</strong></div> <div class="items-value">{!! price_html( $order_details_by_order_id['_final_order_tax'], $order_details_by_order_id['_order_currency'] ) !!}</div></div>
                  
                  <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.shipping_cost') }}</strong></div> <div class="items-value">{!! price_html( $order_details_by_order_id['_final_order_shipping_cost'], $order_details_by_order_id['_order_currency'] ) !!}</div></div>

                  @if($order_details_by_order_id['_is_order_coupon_applyed'] == true)
                  <div class="items-div-main order-discount-label"><div class="items-label"><strong>{{ trans('frontend.coupon_discount_label') }}</strong></div> <div class="items-value"> - {!! price_html( $order_details_by_order_id['_final_order_discount'], $order_details_by_order_id['_order_currency'] ) !!}</div></div>
                  @endif

                  <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.order_total') }}</strong></div> <div class="items-value">{!! price_html( $order_details_by_order_id['_final_order_total'], $order_details_by_order_id['_order_currency'] ) !!}</div></div>
                </td>
              </tr>
            </tbody>
          </table>
          @endif
        </div>
      </div>  
      <br>
        <div class="col-sm-6">
          <h4>{{ trans('frontend.billing_address') }}</h4><hr>
          <p>{!! $order_details_by_order_id['customer_address']['_billing_first_name'].' '. $order_details_by_order_id['customer_address']['_billing_last_name']!!}</p>
          @if($order_details_by_order_id['customer_address']['_billing_company'])
            <p><strong>{{ trans('frontend.company') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_company'] !!}</p>
          @endif
          <p><strong>{{ trans('frontend.address_1') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_address_1'] !!}</p>
          @if($order_details_by_order_id['customer_address']['_billing_address_2'])
            <p><strong>{{ trans('frontend.address_2') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_address_2'] !!}</p>
          @endif
          <p><strong>{{ trans('frontend.city') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_city'] !!}</p>
          <p><strong>{{ trans('frontend.postCode') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_postcode'] !!}</p>
          <p><strong>{{ trans('frontend.country') }}:</strong> {!! get_country_by_code( $order_details_by_order_id['customer_address']['_billing_country'] ) !!}</p>

          <br>

          <p><strong>{{ trans('frontend.phone') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_phone'] !!}</p>

          @if($order_details_by_order_id['customer_address']['_billing_fax'])
            <p><strong>{{ trans('frontend.fax') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_fax'] !!}</p>
          @endif
          <p><strong>{{ trans('frontend.email') }}:</strong> {!! $order_details_by_order_id['customer_address']['_billing_email'] !!}</p>
        </div>

        <div class="col-sm-6">
          <h4>{{ trans('frontend.shipping_address') }}</h4><hr>
          <p>{!! $order_details_by_order_id['customer_address']['_shipping_first_name'].' '. $order_details_by_order_id['customer_address']['_shipping_last_name']!!}</p>
          @if($order_details_by_order_id['customer_address']['_shipping_company'])
            <p><strong>{{ trans('frontend.company') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_company'] !!}</p>
          @endif
          <p><strong>{{ trans('frontend.address_1') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_address_1'] !!}</p>
          @if($order_details_by_order_id['customer_address']['_shipping_address_2'])
            <p><strong>{{ trans('frontend.address_2') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_address_2'] !!}</p>
          @endif
          <p><strong>{{ trans('frontend.city') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_city'] !!}</p>
          <p><strong>{{ trans('frontend.postCode') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_postcode'] !!}</p>
          <p><strong>{{ trans('frontend.country') }}:</strong> {!! get_country_by_code( $order_details_by_order_id['customer_address']['_shipping_country'] ) !!}</p>

          <br>

          <p><strong>{{ trans('frontend.phone') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_phone'] !!}</p>

          @if($order_details_by_order_id['customer_address']['_shipping_fax'])
            <p><strong>{{ trans('frontend.fax') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_fax'] !!}</p>
          @endif

          <p><strong>{{ trans('frontend.email') }}:</strong> {!! $order_details_by_order_id['customer_address']['_shipping_email'] !!}</p>
        </div>
    </div>
  </div>
  <br>
  @else
  <section id="order-received-content">
    <div class="container new-container">
      <h5>{{ trans('frontend.no_content_yet') }}</h5>
    </div>
  </section> 
</div>  
@endif