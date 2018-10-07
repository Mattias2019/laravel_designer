<div class="variation-view-data-content">
  <div class="variation-view-img">
    @if($variation_view_data['_variation_post_img_url'])
    <img src="{{ get_image_url($variation_view_data['_variation_post_img_url']) }}" alt="{{ basename ($variation_view_data['_variation_post_img_url']) }}">
    @else 
    <img src="{{ default_placeholder_img_src() }}" alt="">
    @endif
  </div><hr>
  <div class="variation-view-combination">
    <div class="variation-view-title"><b>{{ trans('frontend.variation_combination') }}</b></div>
    <div class="variation-view-comnination-list">
      @foreach(json_decode($variation_view_data['_variation_post_data']) as $key => $val)
      @if(count(json_decode($variation_view_data['_variation_post_data']))-1 == $key)
      {!! $val->attr_name .' &#8658; '. $val->attr_val !!}
      @else
      {!! $val->attr_name .' &#8658; '. $val->attr_val . ', ' !!}
      @endif
      @endforeach
    </div>
  </div><hr>
  <div class="variation-view-enable-status">
    <div class="variation-view-title"><b>{{ trans('frontend.enable_status') }}</b></div>
    <div class="variation-view-enable-content">
      @if($variation_view_data['post_status'] == 1)
      {{ trans('frontend.yes') }}
      @else
      {{ trans('frontend.no') }}
      @endif
    </div>
  </div><hr>
  <div class="variation-view-sku">
    <div class="variation-view-title"><b>{{ trans('frontend.sku') }}</b></div>
    <div class="variation-view-sku-content">
      {!! $variation_view_data['_variation_post_sku'] !!}
    </div>
  </div><hr>
  <div class="variation-view-price">
    <div class="variation-view-title"><b>{{ trans('frontend.price') }}</b></div>
    <div class="variation-price-content">
      <div class="variation-view-regular-price-content">
        {{ trans('frontend.regular_price') }}: {!! price_html( $variation_view_data['_variation_post_regular_price'] ) !!}
      </div>
      <div class="variation-view-sale-price-content">&nbsp;&nbsp;&nbsp;&nbsp;
        {{ trans('frontend.sale_price') }}: {!! price_html( $variation_view_data['_variation_post_sale_price'] ) !!}
      </div>
    </div>
  </div><hr>
  <div class="variation-view-sale-price-date">
    <div class="variation-view-title"><b>{{ trans('frontend.sale_price_date_range') }}</b></div>
    <div class="variation-sale-price-date-content">
      <div class="variation-view-sale-price-start-date-content">
        @if($variation_view_data['_variation_post_sale_price_start_date'])
        {{ trans('frontend.start_date') }}: {!! date("F j, Y", strtotime($variation_view_data['_variation_post_sale_price_start_date'])) !!}
        @else
        {{ trans('frontend.start_date') }}: {{ trans('frontend.no_date_selected') }}
        @endif
      </div>
      <div class="variation-view-sale-price-end-date-content">&nbsp;&nbsp;&nbsp;&nbsp;
        @if($variation_view_data['_variation_post_sale_price_end_date'])
        {{ trans('frontend.end_date') }}: {!! date("F j, Y", strtotime($variation_view_data['_variation_post_sale_price_end_date'])) !!}
        @else
        {{ trans('frontend.end_date') }}: {{ trans('frontend.no_date_selected') }}
        @endif
      </div>
    </div>
  </div><hr>
  <div class="variation-view-enable-stock-management">
    <div class="variation-view-title"><b>{{ trans('frontend.enable_stock_management') }}</b></div>
    <div class="variation-view-enable-stock-management-content">
      @if($variation_view_data['_variation_post_manage_stock'] == 1)
      {{ trans('frontend.yes') }}
      @else
      {{ trans('frontend.no') }}
      @endif
    </div>
  </div><hr>
  <div class="variation-view-stock-qty">
    <div class="variation-view-title"><b>{{ trans('frontend.stock_quantity') }}</b></div>
    <div class="variation-view-stock-qty-content">
      {!! $variation_view_data['_variation_post_manage_stock_qty'] !!}
    </div>
  </div><hr>
  <div class="variation-view-back-to-order">
    <div class="variation-view-title"><b>{{ trans('frontend.back_to_order_status') }}</b></div>
    <div class="variation-view-back-to-order-content">
      @if($variation_view_data['_variation_post_back_to_order'] == 'variation_not_allow')
      {{ trans('frontend.not_allow') }}
      @elseif($variation_view_data['_variation_post_back_to_order'] == 'variation_allow_notify_customer')
      {{ trans('frontend.allow_and_notify_customer') }}
      @elseif($variation_view_data['_variation_post_back_to_order'] == 'variation_only_allow')
      {{ trans('frontend.only_allow') }}
      @endif
    </div>
  </div><hr>
  <div class="variation-view-stock-availability">
    <div class="variation-view-title"><b>{{ trans('frontend.stock_availability') }}</b></div>
    <div class="variation-view-stock-availability-content">
      @if($variation_view_data['_variation_post_stock_availability'] == 'variation_in_stock')
      {{ trans('frontend.in_stock') }}
      @elseif($variation_view_data['_variation_post_stock_availability'] == 'variation_out_of_stock')
      {{ trans('frontend.out_of_stock') }}
      @endif
    </div>
  </div><hr>
  <div class="variation-view-tax">
    <div class="variation-view-title"><b>{{ trans('frontend.enable_tax_status') }}</b></div>
    <div class="variation-view-enable-tax-content">
      @if($variation_view_data['_variation_post_enable_tax'] == 1)
      {{ trans('frontend.yes') }}
      @else
      {{ trans('frontend.no') }}
      @endif
    </div>
  </div><hr>
  <div class="variation-view-variation-description">
    <div class="variation-view-title"><b>{{ trans('frontend.variation_description') }}</b></div>
    <div class="variation-view-variation-description-content">
     {!! $variation_view_data['post_content'] !!}
    </div>
  </div>
</div>