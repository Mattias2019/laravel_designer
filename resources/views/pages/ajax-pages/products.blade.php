@if(count($filter_data)>0)
<br><div class="features_items"><!--features_items-->
  <h2 class="title text-center">{{ trans('frontend.products') }}</h2>
  
  @foreach($filter_data as $products)
  <div class="col-sm-4">
    <div class="product-image-wrapper">
      <div class="single-products">
        <div class="productinfo text-center">
          @if(get_product_image($products->id))
          <img src="{{ get_image_url(get_product_image($products->id)) }}" alt="{{ basename(get_product_image($products->id)) }}" />
          @else
          <img src="{{ default_placeholder_img_src() }}" alt="" />
          @endif
          
          @if(get_product_type($products->id) == 'simple_product')
            <h2>{!! price_html( get_product_price($products->id) ) !!}</h2>
          @elseif(get_product_type($products->id) == 'configurable_product')
            <h2>{!! get_product_variations_min_to_max_price_html($_currency_symbol, $products->id) !!}</h2>
          @elseif(get_product_type($products->id) == 'customizable_product')
            @if(count(get_product_variations($products->id))>0)
              <h2>{!! get_product_variations_min_to_max_price_html($_currency_symbol, $products->id) !!}</h2>
            @else
              <h2>{!! price_html( get_product_price($products->id) ) !!}</h2>
            @endif
          @endif
          
          <p>{!! get_product_title($products->id) !!}</p>
          
          @if(get_product_type($products->id) == 'simple_product')
            <a href="#" data-id="{{ $products->id }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ trans('frontend.add_to_cart') }}</a>
          @elseif(get_product_type($products->id) == 'configurable_product')
            <a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default select-product-options"><i class="fa fa-hand-o-up"></i>{{ trans('frontend.select_options') }}</a>

          @elseif(get_product_type($products->id) == 'customizable_product')
            @if(is_design_enable_for_this_product($products->id))
              <a href="{{ route('customize-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default product-customize"><i class="fa fa-gears"></i>{{ trans('frontend.customize') }}</a>
            @else
              <a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default view-details"><i class="fa fa-eye"></i>{{ trans('frontend.select_options') }}</a>
            @endif
          @endif
          
        </div>
        <div class="product-overlay">
          <div class="overlay-content">
            
            @if(get_product_type($products->id) == 'simple_product')
              <h2>{!! price_html( get_product_price($products->id) ) !!}</h2>
            @elseif(get_product_type($products->id) == 'configurable_product')
              <h2>{!! get_product_variations_min_to_max_price_html($_currency_symbol, $products->id) !!}</h2>
            @elseif(get_product_type($products->id) == 'customizable_product')
              @if(count(get_product_variations($products->id))>0)
                <h2>{!! get_product_variations_min_to_max_price_html($_currency_symbol, $products->id) !!}</h2>
              @else
                <h2>{!! price_html( get_product_price($products->id) ) !!}</h2>
              @endif
            @endif
          
            <p>{!! get_product_title($products->id) !!}</p>
            
            @if(get_product_type($products->id) == 'simple_product')
              <a href="#" data-id="{{ $products->id }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>{{ trans('frontend.add_to_cart') }}</a>
            @elseif(get_product_type($products->id) == 'configurable_product')
              <a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default select-product-options"><i class="fa fa-hand-o-up"></i>{{ trans('frontend.select_options') }}</a>

            @elseif(get_product_type($products->id) == 'customizable_product')
              @if(is_design_enable_for_this_product($products->id))
                <a href="{{ route('customize-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default product-customize"><i class="fa fa-gears"></i>{{ trans('frontend.customize') }}</a>
              @else
                <a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}" class="btn btn-default view-details"><i class="fa fa-eye"></i>{{ trans('frontend.select_options') }}</a>
              @endif
            @endif
          
          </div>
        </div>
      </div>
      
      
      @if(get_product_type($products->id) == 'simple_product')
        <div class="choose">
          <ul class="nav nav-pills nav-justified">
            @if(get_product_review($products->id)['enable_reviews'] == 'yes' && get_product_review($products->id)['product_page_reviews'] == 'yes')
              @if(get_product_review($products->id)['totals_reviews'] == 'yes')
                <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-plus-square"></i>{{ trans('frontend.reviews') }} (100)</a></li>
              @else
                <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-plus-square"></i>{{ trans('frontend.reviews') }}</a></li>
              @endif
            @endif
            <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-eye"></i>{{ trans('frontend.view_details') }}</a></li>
          </ul>
        </div>
      @endif
      
      @if(get_product_type($products->id) == 'configurable_product' || get_product_type($products->id) == 'customizable_product')
        <div class="choose">
          <ul class="nav nav-pills nav-justified">
            @if(get_product_review($products->id)['enable_reviews'] == 'yes' && get_product_review($products->id)['product_page_reviews'] == 'yes')
              @if(get_product_review($products->id)['totals_reviews'] == 'yes')
                <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-plus-square"></i>{{ trans('frontend.reviews') }} (100)</a></li>
              @else
                <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-plus-square"></i>{{ trans('frontend.reviews') }}</a></li>
              @endif
            @endif
            <li><a href="{{ route('details-page', $products->id .'-'. string_slug_format(get_product_title($products->id))) }}"><i class="fa fa-eye"></i>{{ trans('frontend.view_details') }}</a></li>
          </ul>
        </div>
      @endif
      
    </div>
  </div>
  @endforeach
</div><!--features_items-->

{!! $filter_data->render() !!}
@else
<div class="alert-msg"><h4>{{ trans('frontend.no_product') }}</h4> </div>
@endif