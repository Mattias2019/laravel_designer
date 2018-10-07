@section('vendor-products-content')

@if($vendor_products['products']->count() > 0)
  @if($vendor_products['selected_view'] == 'grid')
    <div class="product-content clearfix">
      @foreach($vendor_products['products'] as $products)
        <?php 
        $reviews          = get_comments_rating_details($products->id, 'product');
        $reviews_settings = get_reviews_settings_data($products->id);      
        ?>
        <div class="col-xs-12 col-sm-4 col-md-6 extra-padding grid-view">
          <div class="hover-product">
            <div class="hover">
              @if(!empty($products->image_url))
              <img class="img-responsive" src="{{ get_image_url( $products->image_url ) }}" alt="{{ basename( get_image_url( $products->image_url ) ) }}" />
              @else
              <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
              @endif

              <div class="overlay">
                <button class="info quick-view-popup" data-id="{{ $products->id }}">{{ trans('frontend.quick_view_label') }}</button>
              </div>
            </div> 

            <div class="single-product-bottom-section">
              <h3>{!! $products->title !!}</h3>

              @if($products->type == 'simple_product')
                <p>{!! price_html( $products->price, get_frontend_selected_currency() ) !!}</p>
              @elseif($products->type == 'configurable_product')
                <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
              @elseif($products->type == 'customizable_product' || $products->type == 'downloadable_product')
                @if(count(get_product_variations($products->id))>0)
                  <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
                @else
                  <p>{!! price_html( $products->price, get_frontend_selected_currency() ) !!}</p>
                @endif
              @endif
              
              @if($reviews_settings['enable_reviews_add_link_to_product_page'] && $reviews_settings['enable_reviews_add_link_to_product_page'] == 'yes')
                <div class="text-center">
                  <div class="star-rating">
                    <span style="width:{{ $reviews['percentage'] }}%"></span>
                  </div>

                  <div class="comments-advices">
                    <ul>
                      <li class="read-review"><a href="{{ route('details-page', $products->slug) }}#product_description_bottom_tab" class="reviews selected"> {{ trans('frontend.single_product_read_review_label') }} (<span itemprop="reviewCount">{!! $reviews['total'] !!}</span>) </a></li>
                      <li class="write-review"><a class="open-comment-form" href="{{ route('details-page', $products->slug) }}#new_comment_form">&nbsp;<span>|</span>&nbsp; {{ trans('frontend.single_product_write_review_label') }} </a></li>
                    </ul>
                  </div>
                </div>
              @endif
              
              <div class="title-divider"></div>
              <div class="single-product-add-to-cart">
                @if($products->type == 'simple_product')
                  <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                @elseif($products->type == 'configurable_product')
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                @elseif($products->type == 'customizable_product')
                  @if(is_design_enable_for_this_product($products->id))
                    <a href="{{ route('customize-page', $products->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                  @else
                    <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @endif
                @elseif($products->type == 'downloadable_product')
                  @if(count(get_product_variations_with_data($products->id)) > 0)
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @else
                    <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @endif  
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
  
  @if($vendor_products['selected_view'] == 'list')
    <div class="row">
      @foreach($vendor_products['products'] as $products)
        <?php 
        $reviews          = get_comments_rating_details($products->id, 'product');
        $reviews_settings = get_reviews_settings_data($products->id);      
        ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="box effect list-view-box">
            <div class="col-xs-5 col-sm-5 col-md-5">
              <div class="list-view-image-container">
                @if(!empty($products->image_url))
                <img class="img-responsive" src="{{ get_image_url( $products->image_url ) }}" alt="{{ basename( get_image_url( $products->image_url ) ) }}" />
                @else
                <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                @endif
                <div class="overlay">
                  <button class="info quick-view-popup" data-id="{{ $products->id }}">{{ trans('frontend.quick_view_label') }}</button>
                </div>
              </div>
            </div>
            <div class="col-xs-7 col-sm-7 col-md-7">
              <h3>{!! $products->title !!}</h3>

              @if($products->type == 'simple_product')
                <p>{!! price_html( $products->price, get_frontend_selected_currency() ) !!}</p>
              @elseif($products->type == 'configurable_product')
                <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
              @elseif($products->type == 'customizable_product' || $products->type == 'downloadable_product')
                @if(count(get_product_variations($products->id))>0)
                  <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id) !!}</p>
                @else
                  <p>{!! price_html( $products->price, get_frontend_selected_currency() ) !!}</p>
                @endif
              @endif
              
               @if($reviews_settings['enable_reviews_add_link_to_product_page'] && $reviews_settings['enable_reviews_add_link_to_product_page'] == 'yes')
                <div class="list-view-reviews-main">
                  <div class="star-rating">
                    <span style="width:{{ $reviews['percentage'] }}%"></span>
                  </div>

                  <div class="comments-advices">
                    <ul>
                      <li class="read-review"><a href="{{ route('details-page', $products->slug) }}#product_description_bottom_tab" class="reviews selected"> {{ trans('frontend.single_product_read_review_label') }} (<span itemprop="reviewCount">{!! $reviews['total'] !!}</span>) </a></li>
                      <li class="write-review"><a class="open-comment-form" href="{{ route('details-page', $products->slug) }}#new_comment_form">&nbsp;<span>|</span>&nbsp; {{ trans('frontend.single_product_write_review_label') }} </a></li>
                    </ul>
                  </div>
                </div>
              @endif 
              
              <div class="title-divider"></div>

              <div class="single-product-add-to-cart">
                @if($products->type == 'simple_product')
                  <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                @elseif($products->type == 'configurable_product')
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                  <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                @elseif($products->type == 'customizable_product')
                  @if(is_design_enable_for_this_product($products->id))
                    <a href="{{ route('customize-page', $products->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                  @else
                    <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @endif
                @elseif($products->type == 'downloadable_product')
                  @if(count(get_product_variations_with_data($products->id)) > 0)
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @else
                    <a href="" data-id="{{ $products->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                    <a href="{{ route('details-page', $products->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                  @endif    
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
  <div class="products-pagination">{!! $vendor_products['products']->appends(Request::capture()->except('page'))->render() !!}</div>
@else
<p class="not-available">{!! trans('frontend.product_not_available') !!}</p>
@endif
@endsection