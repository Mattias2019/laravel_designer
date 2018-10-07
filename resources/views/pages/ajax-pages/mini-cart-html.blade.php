<a href="" class="main show-mini-cart"> <span class="hidden-xs">{!! trans('frontend.menu_my_cart') !!}</span> <span class="hidden-sm hidden-md hidden-lg fa fa-shopping-cart fa-lg"></span> <span class="cart-count"><span id="total_count_by_ajax">{!! Cart::count() !!}</span></span></a>
<div id="list_popover" class="bottom">
  <div class="arrow"></div>
  @if( Cart::count() >0 )
    <div id="cd-cart">
      <h2>{!! trans('frontend.mini_cart_label_cart') !!}</h2>
      <ul class="cd-cart-items">
        @foreach(Cart::items() as $index => $items)
          <li>
            <span class="cd-qty">{!! $items->quantity !!}x</span>&nbsp;{!! $items->name !!}
            <div class="cd-price">{!! price_html( get_product_price_html_by_filter( Cart::getRowPrice($items->quantity, get_role_based_price_by_product_id($items ->id, $items->price))) ) !!}</div>
            <a href="{{ route('removed-item-from-cart', $index)}}" class="cd-item-remove cd-img-replace cart_quantity_delete"></a>
          </li>
        @endforeach
      </ul>

      <div class="cd-cart-total">
        <p>{!! trans('frontend.total') !!} <span>{!! price_html( get_product_price_html_by_filter(Cart::getTotal()) ) !!}</span></p>
      </div>

      <a href="{{ route('checkout-page') }}" class="checkout-btn">{!! trans('frontend.checkout') !!}</a>
    </div>
  @else
    <div class="empty-cart-msg">{{ trans('frontend.empty_cart_msg') }}</div>
  @endif
</div>