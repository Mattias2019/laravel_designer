@extends('layouts.frontend.master')
@section('title',  trans('frontend.shopist_order_received_title') .' < '. get_site_title() )

@section('content')
  @if( count($order_details_for_thank_you_page) > 0)
  <section id="order-received-content">
    <div class="container new-container">
      <h3>{{ trans('frontend.order_received') }}</h3><br>
      <p>{{ trans('frontend.thank_you_msg') }}</p>
      <br>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-3">
            <div class="order-received-label-1 text-uppercase"><strong>{{ trans('frontend.order_number') }}</strong></div>
            <div class="order-received-label-2"><em>#{!! $order_details_for_thank_you_page['order_id'] !!}</em></div>
          </div>
          <div class="col-sm-3">
            <div class="order-received-label-1"><strong>{{ trans('frontend.date') }}</strong></div>
            <div class="order-received-label-2"><em>{!! $order_details_for_thank_you_page['order_date'] !!}</em></div>
          </div>
          <div class="col-sm-3">
            <div class="order-received-label-1"><strong>{{ trans('frontend.total') }}</strong></div>
            <div class="order-received-label-2"><em>{!! price_html( $order_details_for_thank_you_page['_final_order_total'], $order_details_for_thank_you_page['_order_currency'] ) !!}</em></div>
          </div>
          <div class="col-sm-3">
            <div class="order-received-label-1"><strong>{{ trans('frontend.payment_method') }}</strong></div>
            <div class="order-received-label-2"><em>{!! get_payment_method_title($order_details_for_thank_you_page['_payment_method']) !!}</em></div>
          </div>
          <div class="clearfix"></div><br>
          
        @if(isset($order_details_for_thank_you_page['_payment_details']['method_instructions']))  
        <p class="payment_ins">{!! $order_details_for_thank_you_page['_payment_details']['method_instructions'] !!}</p>
        @endif
        
        @if(isset($order_details_for_thank_you_page['_payment_details']['account_details']))  
          <h3>{{ trans('frontend.our_bank_details') }}</h3><br>
          <p>{{ trans('frontend.account_name') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['account_name'] }}</p>
          <p>{{ trans('frontend.account_number') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['account_number'] }}</p>
          <p>{{ trans('frontend.bank_name') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['bank_name'] }}</p>
          <p>{{ trans('frontend.bank_short_code') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['short_code'] }}</p>
          <p>{{ trans('frontend.iban') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['iban'] }}</p>
          <p>{{ trans('frontend.bic_swift') }}: {{ $order_details_for_thank_you_page['_payment_details']['account_details']['swift'] }}</p>
        @endif
        
        <h3>{{ trans('frontend.order_details') }}</h3><br>
        <div class="table-responsive cart_info">
          @if(count($order_details_for_thank_you_page['ordered_items'])>0)   
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
                @foreach($order_details_for_thank_you_page['ordered_items'] as $items)
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
                    
                    @if($items['product_type'] == 'downloadable_product' && $order_details_for_thank_you_page['_customer_ip_address'] == get_ip_address() && (($order_details_for_thank_you_page['settings']['general_settings']['downloadable_products_options']['login_restriction'] == true && is_frontend_user_logged_in() && $order_details_for_thank_you_page['settings']['general_settings']['downloadable_products_options']['grant_access_from_thankyou_page'] == true) || ($order_details_for_thank_you_page['settings']['general_settings']['downloadable_products_options']['login_restriction'] == false && $order_details_for_thank_you_page['settings']['general_settings']['downloadable_products_options']['grant_access_from_thankyou_page'] == true)))
                    {!! download_file_html( $items['id'], $items['download_data'], $order_details_for_thank_you_page['order_id']) !!}
                    @endif
                    
                    @if( count(get_vendor_details_by_product_id($items['product_id'])) >0 )
                    <p class="vendor-title"><strong>{!! trans('frontend.vendor_label') !!}</strong> : {!! get_vendor_name_by_product_id( $items['product_id'] ) !!}</p>
                    @endif
                  </td>
                  <td class="cart_price">
                    <p> {!! price_html( $items['order_price'], $order_details_for_thank_you_page['_order_currency'] ) !!} </p>
                  </td>
                  <td class="cart_quantity">
                      <p> {!! $items['quantity'] !!} </p>
                  </td>
                  <td class="cart_total">
                    <p>{!! price_html( ($items['quantity']*$items['order_price']), $order_details_for_thank_you_page['_order_currency'] ) !!}</p>
                  </td>
                </tr>
                @endforeach
                
                <tr class="order-items-data">
                  <td colspan="4" class="order-total">
                    <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.tax') }}</strong></div> <div class="items-value">{!! price_html( $order_details_for_thank_you_page['_final_order_tax'], $order_details_for_thank_you_page['_order_currency'] ) !!}</div></div>
                    
                    <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.shipping_cost') }}</strong></div> <div class="items-value">{!! price_html( $order_details_for_thank_you_page['_final_order_shipping_cost'], $order_details_for_thank_you_page['_order_currency'] ) !!}</div></div>
                    
                    @if($order_details_for_thank_you_page['_is_order_coupon_applyed'] == true)
                    <div class="items-div-main order-discount-label"><div class="items-label"><strong>{{ trans('frontend.coupon_discount_label') }}</strong></div> <div class="items-value"> - {!! price_html( $order_details_for_thank_you_page['_final_order_discount'], $order_details_for_thank_you_page['_order_currency'] ) !!}</div></div>
                    @endif
                    
                    <div class="items-div-main"><div class="items-label"><strong>{{ trans('frontend.order_total') }}</strong></div> <div class="items-value">{!! price_html( $order_details_for_thank_you_page['_final_order_total'], $order_details_for_thank_you_page['_order_currency'] ) !!}</div></div>
                  </td>
                </tr>
              </tbody>
            </table>
            @endif
          </div>
          <div class="col-sm-6">
            <h4>{{ trans('frontend.billing_address') }}</h4><hr>
            @if(!empty($order_details_for_thank_you_page['customer_address']))
              <p>{!! $order_details_for_thank_you_page['customer_address']['_billing_first_name'].' '. $order_details_for_thank_you_page['customer_address']['_billing_last_name']!!}</p>
              @if($order_details_for_thank_you_page['customer_address']['_billing_company'])
                <p><strong>{{ trans('frontend.company') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_company'] !!}</p>
              @endif
              <p><strong>{{ trans('frontend.address_1') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_address_1'] !!}</p>
              @if($order_details_for_thank_you_page['customer_address']['_billing_address_2'])
                <p><strong>{{ trans('frontend.address_2') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_address_2'] !!}</p>
              @endif
              <p><strong>{{ trans('frontend.city') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_city'] !!}</p>
              <p><strong>{{ trans('frontend.postCode') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_postcode'] !!}</p>
              <p><strong>{{ trans('frontend.country') }}:</strong> {!! get_country_by_code( $order_details_for_thank_you_page['customer_address']['_billing_country'] ) !!}</p>


              <br>

              <p><strong>{{ trans('frontend.phone') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_phone'] !!}</p>

              @if($order_details_for_thank_you_page['customer_address']['_billing_fax'])
                <p><strong>{{ trans('frontend.fax') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_fax'] !!}</p>
              @endif
              <p><strong>{{ trans('frontend.email') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_billing_email'] !!}</p>
            @endif
          </div>
          
          <div class="col-sm-6">
            <h4>{{ trans('frontend.shipping_address') }}</h4><hr>
            @if(!empty($order_details_for_thank_you_page['customer_address']))
              <p>{!! $order_details_for_thank_you_page['customer_address']['_shipping_first_name'].' '. $order_details_for_thank_you_page['customer_address']['_shipping_last_name']!!}</p>
              @if($order_details_for_thank_you_page['customer_address']['_shipping_company'])
                <p><strong>{{ trans('frontend.company') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_company'] !!}</p>
              @endif
              <p><strong>{{ trans('frontend.address_1') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_address_1'] !!}</p>
              @if($order_details_for_thank_you_page['customer_address']['_shipping_address_2'])
                <p><strong>{{ trans('frontend.address_2') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_address_2'] !!}</p>
              @endif
              <p><strong>{{ trans('frontend.city') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_city'] !!}</p>
              <p><strong>{{ trans('frontend.postCode') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_postcode'] !!}</p>
              <p><strong>{{ trans('frontend.country') }}:</strong> {!! get_country_by_code( $order_details_for_thank_you_page['customer_address']['_shipping_country'] ) !!}</p>

              <br>

              <p><strong>{{ trans('frontend.phone') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_phone'] !!}</p>

              @if($order_details_for_thank_you_page['customer_address']['_shipping_fax'])
                <p><strong>{{ trans('frontend.fax') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_fax'] !!}</p>
              @endif

              <p><strong>{{ trans('frontend.email') }}:</strong> {!! $order_details_for_thank_you_page['customer_address']['_shipping_email'] !!}</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>
  <br>
  @else
  <section id="order-received-content">
    <div class="container new-container">
      <h5>{{ trans('frontend.no_content_yet') }}</h5>
    </div>
  </section>  
  @endif  
@endsection  