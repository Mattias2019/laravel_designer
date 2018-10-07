{!! Session::get('eBazar_shipping_method') !!}
<li class="row cart-total-main">
  <div class="cart-total-area-overlay"></div>  
  <div id="loader-1-cart"></div>
  <div class="cart-total-content">
      <div class="cart-sub-total"><div class="label">{!! trans('frontend.cart_sub_total') !!}:</div><div class="value">{!! price_html( get_product_price_html_by_filter(Cart::getTotal()), get_frontend_selected_currency() ) !!}</div></div>
      
      <div class="cart-tax"><div class="label">{!! trans('frontend.tax') !!}:</div><div class="value">{!! price_html( get_product_price_html_by_filter(Cart::getTax()), get_frontend_selected_currency() ) !!}</div></div>
      
        @if((!$shipping_data['shipping_option']['enable_shipping']) || ($shipping_data['shipping_option']['enable_shipping'] && !$shipping_data['flat_rate']['enable_option'] && !$shipping_data['free_shipping']['enable_option'] && !$shipping_data['local_delivery']['enable_option']))
        
        <div class="cart-shipping-total"><div class="label">{!! trans('frontend.shipping_cost') !!}:</div><div class="value">{!! trans('frontend.free') !!}</div></div>

        @elseif(($shipping_data['shipping_option']['enable_shipping']) && ($shipping_data['flat_rate']['enable_option'] || $shipping_data['free_shipping']['enable_option'] || $shipping_data['local_delivery']['enable_option']) )
          <?php $str = '';?>
          @if($shipping_data['shipping_option']['display_mode'] == 'radio_buttons')

            @if($shipping_data['flat_rate']['enable_option'] && $shipping_data['flat_rate']['method_cost'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'flat_rate')
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" checked name="shipping_method" value="flat_rate">&nbsp;&nbsp; <span>'. Lang::get('frontend.flat_rate') .': '. price_html( get_product_price_html_by_filter($shipping_data['flat_rate']['method_cost']), get_frontend_selected_currency() ).'</span></div>';?>
              @else
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" name="shipping_method" value="flat_rate">&nbsp;&nbsp; <span>' . Lang::get('frontend.flat_rate') .': ' . price_html( get_product_price_html_by_filter($shipping_data['flat_rate']['method_cost']), get_frontend_selected_currency() ).'</span></div>';?>
              @endif
            @endif

            @if( $shipping_data['free_shipping']['enable_option'] && ( Cart::getSubTotalAndTax() <= $shipping_data['free_shipping']['order_amount'] ) )
              @if(Cart::getShippingMethod()['shipping_method'] == 'free_shipping')
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" checked name="shipping_method" value="free_shipping">&nbsp;&nbsp; <span>'. Lang::get('frontend.free_shipping') .'</span></div>';?>
              @else
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" name="shipping_method" value="free_shipping">&nbsp;&nbsp; <span>'. Lang::get('frontend.free_shipping') .'</span></div>';?>
              @endif
            @endif

            @if($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'fixed_amount' && $shipping_data['local_delivery']['delivery_fee'] )
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" checked name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter($shipping_data['local_delivery']['delivery_fee']), get_frontend_selected_currency() ) .'</span></div>';?>
              @else
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter($shipping_data['local_delivery']['delivery_fee']), get_frontend_selected_currency() ) .'</span></div>';?>
              @endif
            @elseif($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'cart_total' && $shipping_data['local_delivery']['delivery_fee'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" checked name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPercentageTotal()), get_frontend_selected_currency() ) .'</span></div>';?>
              @else
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPercentageTotal()), get_frontend_selected_currency() ) .'</span></div>';?>
              @endif
            @elseif($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'per_product' && $shipping_data['local_delivery']['delivery_fee'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" checked name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPerProductTotal()), get_frontend_selected_currency() ) .'</span></div>';?>
              @else
                <?php $str .= '<div><input type="radio" class="shopist-iCheck" name="shipping_method" value="local_delivery">&nbsp;&nbsp; <span>'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPerProductTotal()), get_frontend_selected_currency() ) .'</span></div>';?>
              @endif
            @endif

            @if($str)
              <div class="cart-shipping-total"><div class="label">{!! trans('frontend.shipping_cost') !!}:</div><div class="value"><?php echo $str;?></div></div><div class="clearfix"></div>
            @else
              <div class="cart-shipping-total"><div class="label">{!! trans('frontend.shipping_cost') !!}:</div><div class="value">{!! trans('frontend.free') !!}</div></div>
            @endif
          @elseif($shipping_data['shipping_option']['display_mode'] == 'dropdown')

            @if($shipping_data['flat_rate']['enable_option'] && $shipping_data['flat_rate']['method_cost'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'flat_rate')
                <?php $str .= '<option selected value="flat_rate">'. Lang::get('frontend.flat_rate') .': '. price_html( get_product_price_html_by_filter($shipping_data['flat_rate']['method_cost']), get_frontend_selected_currency() ) .'</option>';?>
              @else
                <?php $str .= '<option value="flat_rate">' . Lang::get('frontend.flat_rate') .': '. price_html( get_product_price_html_by_filter($shipping_data['flat_rate']['method_cost']), get_frontend_selected_currency() ) .'</option>';?>
              @endif
            @endif
            @if( $shipping_data['free_shipping']['enable_option'] && ( Cart::getSubTotalAndTax() <= $shipping_data['free_shipping']['order_amount'] ) )
              @if(Cart::getShippingMethod()['shipping_method'] == 'free_shipping')
                <?php $str .= '<option selected value="free_shipping">'. Lang::get('frontend.free_shipping') .'</option>';?>
              @else
                <?php $str .= '<option value="free_shipping">'. Lang::get('frontend.free_shipping') .'</option>';?>
              @endif
            @endif

            @if($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'fixed_amount' && $shipping_data['local_delivery']['delivery_fee'] )
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                <?php $str .= '<option selected value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter($shipping_data['local_delivery']['delivery_fee']), get_frontend_selected_currency() ) .'</option>';?>
              @else
                <?php $str .= '<option value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter($shipping_data['local_delivery']['delivery_fee']), get_frontend_selected_currency() ) .'</option>';?>
              @endif
            @elseif($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'cart_total' && $shipping_data['local_delivery']['delivery_fee'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                <?php $str .= '<option selected value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPercentageTotal()), get_frontend_selected_currency() ) .'</option>';?>
              @else
                <?php $str .= '<option value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPercentageTotal()), get_frontend_selected_currency() ) .'</option>';?>
              @endif
            @elseif($shipping_data['local_delivery']['enable_option'] && $shipping_data['local_delivery']['fee_type'] === 'per_product' && $shipping_data['local_delivery']['delivery_fee'])
              @if(Cart::getShippingMethod()['shipping_method'] == 'local_delivery')
                 <?php $str .= '<option selected value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPerProductTotal()), get_frontend_selected_currency() ) .'</option>';?>
              @else
                 <?php $str .= '<option value="local_delivery">'. Lang::get('frontend.local_delivery') .': '. price_html( get_product_price_html_by_filter(Cart::getLocalDeliveryShippingPerProductTotal()), get_frontend_selected_currency() ) .'</option>';?>
              @endif
            @endif
            @if($str)
            <div class="cart-shipping-total"><div class="label">{!! trans('frontend.shipping_cost') !!}:</div><div class="value"><select name="shipping_method_dropdown" id="shipping_method_dropdown"><?php echo $str;?></select></div></div><div class="clearfix"></div>
            @else
            <div class="cart-shipping-total"><div class="label">{!! trans('frontend.shipping_cost') !!}:</div><div class="value">{!! trans('frontend.free') !!}</div></div>
            @endif
          @endif
        @endif
        
      @if(Cart::is_coupon_applyed())  
      <div class="cart-coupon"><div class="label">{!! trans('frontend.coupon_label') !!}:</div><div class="value">- {!! price_html( get_product_price_html_by_filter(Cart::couponPrice()), get_frontend_selected_currency() ) !!}</div> <div><button class="remove-coupon btn btn-default btn-xs" type="button">{!! trans('frontend.remove_coupon_label') !!}</button></div></div>
      @endif
      
      <div class="cart-grand-total"><div class="label">{{ trans('frontend.grand_total') }}:</div><div class="value">{!! price_html( get_product_price_html_by_filter(Cart::getCartTotal()), get_frontend_selected_currency() ) !!}</div></div>
      
      @if(Request::is('cart'))
        <input type="submit" name="checkout" class="btn btn-primary check_out" value="{{ trans('frontend.check_out') }}">
      @endif
  </div>
</li>

@if(Request::is('cart'))
  @include('pages.frontend.frontend-pages.crosssell-products')
@endif
