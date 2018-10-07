@if( Cart::count() >0 )
  @if(count($cross_sell_products) > 0)
  <br>
  <div class="row crosssell-products-content">
    <div class="col-md-12">
      <h3>{!! trans('frontend.crosssell_title_label') !!}</h3><br>  
      <div class="crosssell-products">
        @foreach($cross_sell_products as $products)
        <div class="col-xs-12 col-sm-4 col-md-3">
          <div class="crosssell-img"><img src="{{ get_image_url(get_product_image( $products )) }}" alt="{{ basename( get_product_image( $products ) )}}"></div>
          <div class="crosssell-products-info">
            <a href="{{ route('details-page', get_product_slug($products) ) }}"><span>{!! get_product_title( $products ) !!}</span></a><br>
            <span>
              @if(get_product_type( $products ) == 'simple_product')
                {!! price_html( get_product_price( $products ), get_frontend_selected_currency() ) !!}
              @elseif(get_product_type( $products ) == 'configurable_product')
                {!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products) !!}
              @elseif(get_product_type( $products ) == 'customizable_product' || get_product_type( $products ) == 'downloadable_product')
                @if(count(get_product_variations( $products ))>0)
                  {!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products) !!}
                @else
                  {!! price_html( get_product_price( $products ), get_frontend_selected_currency() ) !!}
                @endif
              @endif
            </span>
          </div>
        </div>
        @endforeach
      </div>
    </div>  
  </div>    
  @endif
@endif