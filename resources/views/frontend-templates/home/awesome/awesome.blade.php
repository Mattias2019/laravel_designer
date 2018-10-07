<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="single-box">
        <div class="all-service-main">
          <div class="all-service service-style">
            <ul class="service-list">
              <li><span class="service-name service-name-earth"></span><p>{!! trans('frontend.worldwide_service_label') !!}</p></li>
              <li><span class="service-name service-name-users"></span><p>{!! trans('frontend.24_7_help_center_label') !!}</p></li>
              <li><span class="service-name service-name-checkmark-circle"></span><p>{!! trans('frontend.safe_payment_label') !!}</p></li>
              <li><span class="service-name service-name-bicycle"></span><p>{!! trans('frontend.quick_delivery_label') !!}</p></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="clear_both"></div>  
    </div>
  </div>      
  
  @if(!empty($appearance_all_data['home_details']['collection_cat_list']) && count($appearance_all_data['home_details']['collection_cat_list']) > 0)
  <div class="row">
    <div id="categories_collection" class="categories-collection">
      @foreach($appearance_all_data['home_details']['collection_cat_list'] as $collection_cat_details)
        @if($collection_cat_details['status'] == 1)
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="category">
            <a href="{{ route('categories-page', $collection_cat_details['slug']) }}">
              @if(!empty($collection_cat_details['category_img_url']))  
              <img class="img-responsive" src="{{ get_image_url($collection_cat_details['category_img_url']) }}">
              @else
              <img class="img-responsive" src="{{ default_placeholder_img_src() }}">
              @endif
              <div class="category-collection-mask"></div>
              <h3 class="category-title">{!! $collection_cat_details['name'] !!} <span>{!! trans('frontend.collection_label') !!}</span></h3>
            </a>
          </div>
        </div>
        @endif
      @endforeach
    </div>
    <div class="clear_both"></div>
  </div>
  @endif
  
  @if(!empty($appearance_all_data['home_details']['cat_name_and_products']) && count($appearance_all_data['home_details']['cat_name_and_products']) > 0) 
  <div class="row">
    <div class="top-cat-content">
    @foreach($appearance_all_data['home_details']['cat_name_and_products'] as $cat_details)
      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <div class="single-mini-box2">
          <div class="top-cat-list-sub clearfix">
            <div class="img-div">
              @if(!empty($cat_details['cat_deails']['category_img_url']))  
              <img class="img-responsive" src="{{ get_image_url($cat_details['cat_deails']['category_img_url']) }}">
              @else
              <img class="img-responsive" src="{{ default_placeholder_img_src() }}">
              @endif
            </div>  
            <div class="img-title">
              <h4>{!! trans('frontend.super_deal_label') !!}</h4>  
              <h2>{!! $cat_details['cat_deails']['name'] !!}</h2>
              <span>{!! trans('frontend.exclusive_collection_label') !!}</span>
              <div class="cat-shop-now">
                <a href="{{ route('categories-page', $cat_details['cat_deails']['slug']) }}">{!! trans('frontend.shop_now_label') !!}</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      @if($cat_details['cat_products']->count() > 0)
        @foreach($cat_details['cat_products'] as $items)
          <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="single-mini-box2">
              <div class="hover-product">
                <div class="hover">
                  @if(!empty($items->image_url)) 
                    <img class="img-responsive" src="{{ get_image_url( $items->image_url ) }}" alt="{{ basename( get_image_url( $items->image_url ) ) }}" />
                  @else
                    <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                  @endif
                  <div class="overlay">
                    <div class="overlay-content">
                      <button class="info quick-view-popup" data-id="{{ $items->id }}">{{ trans('frontend.quick_view_label') }}</button>  
                      <h2>{!! $items->title !!}</h2> 
                      @if( $items->type == 'simple_product' )
                        <h3>{!! price_html( $items->price, get_frontend_selected_currency() ) !!}</h3>
                      @elseif( $items->type == 'configurable_product')
                        <h3>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $items->id) !!}</h3>
                      @elseif( $items->type == 'customizable_product' || $items->type == 'downloadable_product')
                        @if(count(get_product_variations($items->id))>0)
                          <h3>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $items->id) !!}</h3>
                        @else
                          <h3>{!! price_html( $items->price, get_frontend_selected_currency() ) !!}</h3>
                        @endif
                      @endif
                      <ul>
                          @if( $items->type == 'simple_product' )  
                          <li><a href="" data-id="{{ $items->id }}" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a></li>
                          <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                          <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                          <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                          @elseif( $items->type == 'configurable_product' )
                            <li><a href="{{ route( 'details-page', $items->slug ) }}" class="select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a></li>
                            <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                            <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                            <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                          @elseif( $items->type == 'customizable_product')  
                            @if(is_design_enable_for_this_product( $items->id ))
                              <li><a href="{{ route('customize-page', $items->slug) }}" class="product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a></li>
                              <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                              <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                              <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                            @else
                                <li><a href="" data-id="{{ $items->id }}" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a></li>
                                <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                                <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                                <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                            @endif

                          @elseif( $items->type == 'downloadable_product' ) 

                            @if(count(get_product_variations($items->id))>0)
                              <li><a href="{{ route( 'details-page', $items->slug ) }}" class="select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a></li>
                            <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                            <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                            <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                            @else
                              <li><a href="" data-id="{{ $items->id }}" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a></li>
                          <li><a href="" class="product-wishlist" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a></li>
                          <li><a href="" class="product-compare" data-id="{{ $items->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a></li>
                          <li><a href="{{ route('details-page', $items->slug ) }}" class="product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a></li>
                            @endif

                          @endif
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>    
          </div>
        @endforeach
      @endif
      <div class="clear_both"></div> <br><br>
    @endforeach
    </div>
  </div>    
  @endif
    
  <div class="row">
    <div id="latest" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2> <span>{!! trans('frontend.latest_label') !!}</span></h2> 
      <div class="special-products-slider-control">
        <a href="#slider-carousel-latest" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel-latest" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>

      <div class="single-mini-box">
        <div class="latest">
          @if(count($advancedData['latest_items']) > 0)
          <div id="slider-carousel-latest" class="carousel slide" data-ride="carousel">
            <?php $latest_numb = 1;?>
            <div class="carousel-inner">
              @foreach($advancedData['latest_items'] as $key => $latest_product)
                @if($latest_numb == 1)
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($latest_product->image_url))
                        <img class="img-responsive" src="{{ get_image_url( $latest_product->image_url ) }}" alt="{{ basename( get_image_url( $latest_product->image_url ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $latest_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $latest_product->title !!}</h3>

                        @if( $latest_product->type == 'simple_product' )
                          <p>{!! price_html( $latest_product->price, get_frontend_selected_currency() ) !!}</p>
                        @elseif( $latest_product->type == 'configurable_product')
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id) !!}</p>
                        @elseif( $latest_product->type == 'customizable_product' || $latest_product->type == 'downloadable_product')
                          @if(count(get_product_variations($latest_product->id))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id) !!}</p>
                          @else
                            <p>{!! price_html( $latest_product->price, get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $latest_product->type == 'simple_product' )
                            <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $latest_product->type == 'configurable_product' )
                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $latest_product->type == 'customizable_product' )
                            @if(is_design_enable_for_this_product($latest_product->id))
                              <a href="{{ route('customize-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif

                          @elseif( $latest_product->type == 'downloadable_product' ) 
                            @if(count(get_product_variations( $latest_product->id ))>0)
                            <a href="{{ route( 'details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @else
                            <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif  
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>  
                @else
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($latest_product->image_url))
                        <img class="img-responsive" src="{{ get_image_url( $latest_product->image_url ) }}" alt="{{ basename( get_image_url( $latest_product->image_url ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $latest_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $latest_product->title !!}</h3>

                        @if( $latest_product->type == 'simple_product' )
                          <p>{!! price_html( $latest_product->price, get_frontend_selected_currency() ) !!}</p>
                        @elseif( $latest_product->type == 'configurable_product' )
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id) !!}</p>
                        @elseif( $latest_product->type == 'customizable_product' || $latest_product->type == 'downloadable_product')
                          @if(count(get_product_variations($latest_product->id))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id) !!}</p>
                          @else
                            <p>{!! price_html( $latest_product->price, get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $latest_product->type == 'simple_product' )
                            <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $latest_product->type == 'configurable_product' )
                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $latest_product->type == 'customizable_product')
                            @if(is_design_enable_for_this_product($latest_product->id))
                              <a href="{{ route('customize-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $latest_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                          @elseif( $latest_product->type == 'downloadable_product') 
                            @if(count(get_product_variations( $latest_product->id ))>0)
                            <a href="{{ route( 'details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @else
                            <a href="" data-id="{{ $latest_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $latest_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                            <a href="{{ route('details-page', $latest_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif    
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                <?php $latest_numb ++ ;?>
              @endforeach
            </div>  
          </div>
          @else
            <p class="not-available">{!! trans('frontend.latest_products_empty_label') !!}</p>
          @endif
        </div>
      </div>
    </div> 

    <div id="best-sales" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2> <span>{!! trans('frontend.best_sales_label') !!}</span></h2>  
      <div class="special-products-slider-control">
        <a href="#slider-carousel-best-sales" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel-best-sales" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
      <div class="single-mini-box">
        <div class="best-sales">
          @if(count($advancedData['best_sales']) > 0)
          <div id="slider-carousel-best-sales" class="carousel slide" data-ride="carousel">
            <?php $best_sales_numb = 1;?>
            <div class="carousel-inner">
              @foreach($advancedData['best_sales'] as $key => $best_sales_product)
                @if($best_sales_numb == 1)
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($best_sales_product['post_image_url']))
                        <img class="img-responsive" src="{{ get_image_url( $best_sales_product['post_image_url'] ) }}" alt="{{ basename( get_image_url( $best_sales_product['post_image_url'] ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $best_sales_product['id'] }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $best_sales_product['post_title'] !!}</h3>

                        @if( $best_sales_product['post_type'] == 'simple_product' )
                          <p>{!! price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                        @elseif( $best_sales_product['post_type'] == 'configurable_product' )
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']) !!}</p>
                        @elseif( $best_sales_product['post_type'] == 'customizable_product' || $best_sales_product['post_type'] == 'downloadable_product')
                          @if(count(get_product_variations($best_sales_product['id']))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']) !!}</p>
                          @else
                            <p>{!! price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $best_sales_product['post_type'] == 'simple_product' )
                            <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $best_sales_product['post_type'] == 'configurable_product' )
                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $best_sales_product['post_type'] == 'customizable_product' )
                            @if(is_design_enable_for_this_product($best_sales_product['id']))
                              <a href="{{ route('customize-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                            @elseif( $best_sales_product['post_type'] == 'downloadable_product' ) 
                              @if(count(get_product_variations( $best_sales_product['id'] ))>0)
                              <a href="{{ route( 'details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @else
                              <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif      
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>  
                @else
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($best_sales_product['post_image_url']))
                        <img class="img-responsive" src="{{ get_image_url( $best_sales_product['post_image_url'] ) }}" alt="{{ basename( get_image_url( $best_sales_product['post_image_url'] ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $best_sales_product['id'] }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $best_sales_product['post_title'] !!}</h3>

                        @if( $best_sales_product['post_type'] == 'simple_product' )
                          <p>{!! price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                        @elseif( $best_sales_product['post_type'] == 'configurable_product' )
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']) !!}</p>
                        @elseif( $best_sales_product['post_type'] == 'customizable_product' || $best_sales_product['post_type'] == 'downloadable_product')
                          @if(count(get_product_variations($best_sales_product['id']))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']) !!}</p>
                          @else
                            <p>{!! price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $best_sales_product['post_type'] == 'simple_product' )
                            <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $best_sales_product['post_type'] == 'configurable_product' )
                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $best_sales_product['post_type'] == 'customizable_product' )
                            @if(is_design_enable_for_this_product($best_sales_product['id']))
                              <a href="{{ route('customize-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $best_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                            @elseif( $best_sales_product['post_type'] == 'downloadable_product' ) 
                              @if(count(get_product_variations( $best_sales_product['id'] ))>0)
                              <a href="{{ route( 'details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @else
                              <a href="" data-id="{{ $best_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $best_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif        
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                <?php $best_sales_numb ++ ;?>
              @endforeach
            </div>
          </div>
          @else
            <p class="not-available">{!! trans('frontend.best_sales_products_empty_label') !!}</p>
          @endif
        </div>
      </div>
    </div>  

    <div id="todays-sales" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2><span>{!! trans('frontend.todays_sale_label') !!}</span></h2>
      <div class="special-products-slider-control">
        <a href="#slider-carousel-todays-sales" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel-todays-sales" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
      <div class="single-mini-box">
        <div class="todays-sales">
          @if(count($advancedData['todays_deal']) > 0)
          <div id="slider-carousel-todays-sales" class="carousel slide" data-ride="carousel">
            <?php $todays_sales_numb = 1;?>
            <div class="carousel-inner">
              @foreach($advancedData['todays_deal'] as $key => $todays_sales_product)
                @if($todays_sales_numb == 1)
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($todays_sales_product['post_image_url']))
                        <img class="img-responsive" src="{{ get_image_url( $todays_sales_product['post_image_url'] ) }}" alt="{{ basename( get_image_url( $todays_sales_product['post_image_url'] ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $todays_sales_product['id'] }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $todays_sales_product['post_title'] !!}</h3>

                        @if( $todays_sales_product['post_type'] == 'simple_product' )
                          <p>{!! price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                        @elseif( $todays_sales_product['post_type'] == 'configurable_product' )
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']) !!}</p>
                        @elseif( $todays_sales_product['post_type'] == 'customizable_product' || $todays_sales_product['post_type'] == 'downloadable_product')
                          @if(count(get_product_variations($todays_sales_product['id']))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']) !!}</p>
                          @else
                            <p>{!! price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $todays_sales_product['post_type'] == 'simple_product' )
                            <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $todays_sales_product['post_type'] == 'configurable_product' )
                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-md btn-style  product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $todays_sales_product['post_type'] == 'customizable_product' )
                            @if(is_design_enable_for_this_product($todays_sales_product['id']))
                              <a href="{{ route('customize-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                            @elseif( $todays_sales_product['post_type'] == 'downloadable_product' ) 
                              @if(count(get_product_variations( $todays_sales_product['id'] ))>0)
                              <a href="{{ route( 'details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @else
                              <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif          
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>  
                @else
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        @if(!empty($todays_sales_product['post_image_url']))
                        <img class="img-responsive" src="{{ get_image_url( $todays_sales_product['post_image_url'] ) }}" alt="{{ basename( get_image_url( $todays_sales_product['post_image_url'] ) ) }}" />
                        @else
                        <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                        @endif

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="{{ $todays_sales_product['id'] }}">{{ trans('frontend.quick_view_label') }}</button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3>{!! $todays_sales_product['post_title'] !!}</h3>

                        @if( $todays_sales_product['post_type'] == 'simple_product' )
                          <p>{!! price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                        @elseif( $todays_sales_product['post_type'] == 'configurable_product' )
                          <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']) !!}</p>
                        @elseif( $todays_sales_product['post_type'] == 'customizable_product' || $todays_sales_product['post_type'] == 'downloadable_product')
                          @if(count(get_product_variations($todays_sales_product['id']))>0)
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']) !!}</p>
                          @else
                            <p>{!! price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ) !!}</p>
                          @endif
                        @endif

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          @if( $todays_sales_product['post_type'] == 'simple_product' )
                            <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $best_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $todays_sales_product['post_type'] == 'configurable_product' )
                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                            <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                          @elseif( $todays_sales_product['post_type'] == 'customizable_product ')
                            @if(is_design_enable_for_this_product($todays_sales_product['id']))
                              <a href="{{ route('customize-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @else
                              <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $todays_sales_product['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                            @endif
                            @elseif( $todays_sales_product['post_type'] == 'downloadable_product' ) 
                              @if(count(get_product_variations( $todays_sales_product['id'] ))>0)
                              <a href="{{ route( 'details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @else
                              <a href="" data-id="{{ $todays_sales_product['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $todays_sales_product['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                              <a href="{{ route('details-page', $todays_sales_product['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif            
                          @endif
                        </div>
                      </div>
                    </div>
                  </div>
                @endif
                <?php $todays_sales_numb ++ ;?>
              @endforeach
            </div>
          </div>
          @else
            <p class="not-available">{!! trans('frontend.todays_products_empty_label') !!}</p>
          @endif
        </div>
      </div>
    </div> 
    <div class="clear_both"></div>  
  </div>          
    
    <div class="row">
    <div class="advanced-products-tab">  
      <ul class="nav nav-tabs">
        <li class="active"><a href="#featured_items" data-toggle="tab">{!! trans('frontend.featured_products_label') !!}</a></li>
        <li><a href="#recommended_items" data-toggle="tab">{!! trans('frontend.recommended_items') !!}</a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="featured_items" >  
          @if(count($advancedData['features_items']) > 0)
          <div class="special-products-slider-control">
            <a href="#slider-carousel-featured" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a href="#slider-carousel-featured" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          <div id="slider-carousel-featured" class="carousel slide" data-ride="carousel">
            <?php $features_numb =1; $features_flag =1; $is_last_tag_added_for_features = false;?>
            <div class="carousel-inner">
              @foreach($advancedData['features_items'] as $key => $features_product)
                  @if($features_numb == 1)
                    @if($features_flag == 1)
                      <div class="item active">
                    @else
                      <div class="item">
                    @endif
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($features_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $features_product->image_url ) }}" alt="{{ basename( get_image_url( $features_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $features_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $features_product->title !!}</h3>

                          @if( $features_product->type == 'simple_product' )
                            <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $features_product->type == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                          @elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product')
                            @if(count(get_product_variations($features_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $features_product->type == 'simple_product' )
                              <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($features_product->id))
                                <a href="{{ route('customize-page', $features_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $features_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $features_product->id ))>0)
                                <a href="{{ route( 'details-page', $features_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif              
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_features = false;?>
                  @elseif($features_numb == 4)
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($features_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $features_product->image_url ) }}" alt="{{ basename( get_image_url( $features_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $features_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $features_product->title !!}</h3>

                          @if( $features_product->type == 'simple_product' )
                            <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $features_product->type == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                          @elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product' )
                            @if(count(get_product_variations($features_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $features_product->type == 'simple_product' )
                              <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($features_product->id))
                                <a href="{{ route('customize-page', $features_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $features_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $features_product->id ))>0)
                                <a href="{{ route( 'details-page', $features_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->id ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif                
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $features_numb = 0; $is_last_tag_added_for_features = true;?>
                    </div>
                  @else
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($features_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $features_product->image_url ) }}" alt="{{ basename( get_image_url( $features_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $features_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $features_product->title !!}</h3>

                          @if( $features_product->type == 'simple_product' )
                            <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $features_product->type  == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                          @elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product')
                            @if(count(get_product_variations($features_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $features_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $features_product->type == 'simple_product' )
                              <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $features_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($features_product->id))
                                <a href="{{ route('customize-page', $features_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $features_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $features_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $features_product->id ))>0)
                                <a href="{{ route( 'details-page', $features_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $features_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $features_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $features_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif                  
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_features = false;?>
                  @endif

                  <?php 
                   $features_numb++;
                   $features_flag++;
                  ?>
                @endforeach

                @if(!$is_last_tag_added_for_features)
                  </div>
                @endif
            </div>                
          </div>
          @endif
        </div>

        <div class="tab-pane" id="recommended_items">
          @if(count($advancedData['recommended_items']) > 0)
          <div class="special-products-slider-control">
            <a href="#slider-carousel-recommended" data-slide="prev">
              <i class="fa fa-angle-left"></i>
            </a>
            <a href="#slider-carousel-recommended" data-slide="next">
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
          <div id="slider-carousel-recommended" class="carousel slide" data-ride="carousel">
            <?php $recommended_numb =1; $recommended_flag =1; $is_last_tag_added_for_recommended = false;?>
            <div class="carousel-inner">
              @foreach($advancedData['recommended_items'] as $key => $recommended_product)
                  @if($recommended_numb == 1)
                    @if($recommended_flag == 1)
                      <div class="item active">
                    @else
                      <div class="item">
                    @endif
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($recommended_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $recommended_product->image_url ) }}" alt="{{ basename( get_image_url( $recommended_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $recommended_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $recommended_product->title !!}</h3>

                          @if( $recommended_product->type == 'simple_product' )
                            <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $recommended_product->type == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                          @elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product')
                            @if(count(get_product_variations($recommended_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $recommended_product->type == 'simple_product' )
                              <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($recommended_product->id))
                                <a href="{{ route('customize-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $recommended_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $recommended_product->id ))>0)
                                <a href="{{ route( 'details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif                 
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_recommended = false;?>
                  @elseif($recommended_numb == 4)
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($recommended_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $recommended_product->image_url ) }}" alt="{{ basename( get_image_url( $recommended_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $recommended_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $recommended_product->title !!}</h3>

                          @if( $recommended_product->type == 'simple_product' )
                            <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $recommended_product->type == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                          @elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product')
                            @if(count(get_product_variations($recommended_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $recommended_product->type == 'simple_product' )
                              <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($recommended_product->id))
                                <a href="{{ route('customize-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $recommended_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $recommended_product->id ))>0)
                                <a href="{{ route( 'details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif                   
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $recommended_numb = 0; $is_last_tag_added_for_recommended = true;?>
                    </div>
                  @else
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          @if(!empty($recommended_product->image_url))
                          <img class="img-responsive" src="{{ get_image_url( $recommended_product->image_url ) }}" alt="{{ basename( get_image_url( $recommended_product->image_url ) ) }}" />
                          @else
                          <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                          @endif

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="{{ $recommended_product->id }}">{{ trans('frontend.quick_view_label') }}</button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3>{!! $recommended_product->title !!}</h3>

                          @if( $recommended_product->type == 'simple_product')
                            <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                          @elseif( $recommended_product->type == 'configurable_product' )
                            <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                          @elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product' )
                            @if(count(get_product_variations($recommended_product->id))>0)
                              <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id) !!}</p>
                            @else
                              <p>{!! price_html( $recommended_product->price, get_frontend_selected_currency() ) !!}</p>
                            @endif
                          @endif

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            @if( $recommended_product->type == 'simple_product' )
                              <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'configurable_product' )
                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                              <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                            @elseif( $recommended_product->type == 'customizable_product' )
                              @if(is_design_enable_for_this_product($recommended_product->id))
                                <a href="{{ route('customize-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.customize') }}"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                              @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>

                                <a href="{{ route('details-page', $recommended_product->slug) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                              @endif
                              @elseif( $recommended_product->type == 'downloadable_product' ) 
                                @if(count(get_product_variations( $recommended_product->id ))>0)
                                <a href="{{ route( 'details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @else
                                <a href="" data-id="{{ $recommended_product->id }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $recommended_product->id }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                                <a href="{{ route('details-page', $recommended_product->slug ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                                @endif                       
                            @endif
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_recommended = false;?>
                  @endif

                  <?php 
                   $recommended_numb++;
                   $recommended_flag++;
                  ?>
                @endforeach

                @if(!$is_last_tag_added_for_recommended)
                  </div>
                @endif
            </div>                
          </div> 
          @endif
        </div>           				
      </div>
    </div>  
    </div>    
    
    @if(count($testimonials_data) > 0)
    <div class="row">
      <div class="testimonials-slider">
        <div class="content-title text-center">
          <h2> <span>{!! trans('frontend.testimonials_label') !!}</span></h2>
        </div>

        <div class="special-products-slider-control">
          <a href="#slider-carousel-testimonials" data-slide="prev">
            <i class="fa fa-angle-left"></i>
          </a>
          <a href="#slider-carousel-testimonials" data-slide="next">
            <i class="fa fa-angle-right"></i>
          </a>
        </div>  
      <div id="slider-carousel-testimonials" class="carousel slide" data-ride="carousel">
        <?php $numb = 0; ?>
        <div class="carousel-inner">
        @foreach($testimonials_data as $row)
          @if($numb == 0)
            <div class="item active">
              <div class="col-xs-12 col-sm-2 col-sm-offset-3">
                <div class="testimonials-img text-right">
                  @if(!empty($row['testimonial_image_url']))
                  <img src="{{ get_image_url($row['testimonial_image_url']) }}" alt="" width="170" height="169">
                  @else
                  <img src="{{ default_placeholder_img_src() }}" alt="" width="170" height="169">
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-sm-5">
                <div class="testimonials-text">
                  <h2>{!! $row['post_title'] !!}</h2>
                  <p>{!! get_limit_string( string_decode($row['post_content']), 200 ) !!}</p>
                  <a href="{{ route('testimonial-single-page', $row['post_slug'])}}" class="btn btn-sm testimonials-read">{!! trans('frontend.read_more_label') !!}</a>
                </div>
              </div>
            </div>
          @else
            <div class="item">
              <div class="col-xs-12 col-sm-2 col-sm-offset-3">
                <div class="testimonials-img text-right">
                  @if(!empty($row['testimonial_image_url']))
                  <img src="{{ get_image_url($row['testimonial_image_url']) }}" alt="" width="170" height="169">
                  @else
                  <img src="{{ default_placeholder_img_src() }}" alt="" width="170" height="169">
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-sm-5">
                <div class="testimonials-text">
                  <h2>{!! $row['post_title'] !!}</h2>
                  <p>{!! get_limit_string(string_decode($row['post_content']), 200) !!}</p>
                  <a href="{{ route('testimonial-single-page', $row['post_slug'])}}" class="btn btn-sm testimonials-read">{!! trans('frontend.read_more_label') !!}</a>
                </div>
              </div>
            </div>
          @endif
          <?php $numb ++ ;?>
        @endforeach
        </div>
      </div>
    </div>
  </div>
  @endif  
  
  @if(count($blogs_data) > 0)
  <div class="row">
    <div class="recent-blog">
      <div class="content-title text-center">
        <h2> <span>{!! trans('frontend.latest_from_the_blog') !!}</span></h2>
      </div>
      <div class="recent-blog-content">
        @foreach($blogs_data as $rows)
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4  blog-box extra-padding">
          <a href="{{ route('blog-single-page', $rows['post_slug'])}}">
            @if(!empty($rows['blog_image']))
            <img class="img-responsive" src="{{ get_image_url($rows['blog_image']) }}"  alt="{{basename( $rows['blog_image'] )}}">
            @else
            <img class="img-responsive" src="{{ default_placeholder_img_src() }}"  alt="no image">
            @endif
            <div class="blog-bottom-text">
              <p class="blog-title">{{ $rows['post_title'] }}</p>
              <p><span class="blog-date"><i class="fa fa-calendar"></i>&nbsp; {{ Carbon\Carbon::parse($rows['created_at'])->format('d F, Y') }}</span>&nbsp;&nbsp;<span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; {!! $rows['comments_details']['total'] !!} {!! trans('frontend.comments_label') !!}</span></p>
            </div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
  </div>    
  @endif
    
  <div class="row">
    <div class="brands-list">
      <div class="content-title text-center">
        <h2> <span>{!! trans('frontend.brands') !!}</span></h2>
      </div>
    
      <div class="special-products-slider-control">
        <a href="#slider-carousel-brands" data-slide="prev">
          <i class="fa fa-angle-left"></i>
        </a>
        <a href="#slider-carousel-brands" data-slide="next">
          <i class="fa fa-angle-right"></i>
        </a>
      </div>
      
    <div class="brands-list-content">
      @if(count($brands_data) > 0)
        <div id="slider-carousel-brands" class="carousel slide" data-ride="carousel">
        <?php $brands_numb =1; $brands_flag =1; $is_last_tag_added_for_brands = false;?>
        <div class="carousel-inner">    
          @foreach($brands_data as $brand)
            @if($brands_numb == 1)
              @if($brands_flag == 1)
              <div class="item active">
              @else
              <div class="item">
              @endif

              <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                <div class="brands-images">  
                  @if(!empty($brand['brand_logo_img_url']))
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ get_image_url($brand['brand_logo_img_url']) }}" alt="{{ basename($brand['brand_logo_img_url']) }}" /></a>
                  @else
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ default_placeholder_img_src() }}" alt="" /></a>
                  @endif
                </div>
              </div>
              <?php $is_last_tag_added_for_brands = false;?>
            @elseif($brands_numb == 6)  
              <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                <div class="brands-images">   
                  @if(!empty($brand['brand_logo_img_url']))
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ get_image_url($brand['brand_logo_img_url']) }}" alt="{{ basename($brand['brand_logo_img_url']) }}" /></a>
                  @else
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ default_placeholder_img_src() }}" alt="" /></a>
                  @endif
                </div>
              </div>
              <?php $brands_numb = 0; $is_last_tag_added_for_brands = true;?>
              </div>
            @else  
              <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                <div class="brands-images">  
                  @if(!empty($brand['brand_logo_img_url']))
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ get_image_url($brand['brand_logo_img_url']) }}" alt="{{ basename($brand['brand_logo_img_url']) }}" /></a>
                  @else
                  <a href="{{ route('brands-single-page', $brand['slug']) }}"><img  src="{{ default_placeholder_img_src() }}" alt="" /></a>
                  @endif
                </div>
              </div>
            <?php $is_last_tag_added_for_brands = false;?>
            @endif

            <?php 
             $brands_numb++;
             $brands_flag++;
            ?>
          @endforeach

          @if(!$is_last_tag_added_for_brands)
            </div>
          @endif
          </div> 
        </div>  
      @endif
    </div>  
    </div>    
  </div> 
  
  <div class="row">  
    <div class="extra-message-tab">
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <ul class="nav nav-tabs tabs-left">
          <li class="active"><a href="#latest_news" data-toggle="tab">Latest News</a></li>
          <li><a href="#winter_collection" data-toggle="tab">Winter Collection 2017</a></li>
          <li><a href="#summer_collection" data-toggle="tab">Summer Collection 2017</a></li>
          <li><a href="#newslatter" data-toggle="tab">Newslatter</a></li>
        </ul>
      </div>

      <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
        <div class="tab-content">
          <div class="tab-pane active" id="latest_news">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>
          <div class="tab-pane" id="winter_collection">
            <div class="row">
              <div class="col-sm-8">
                <h3>Winter Collection 2017</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              </div>
              <div class="col-sm-4">
                <img src="{{ asset('public/images/add-sample/winter.jpg') }}" class="img-responsive" alt="">
              </div>
            </div>
          </div>
        <div class="tab-pane" id="summer_collection">
          <div class="row">
            <div class="col-sm-8">
              <h3>Summer Collection 2017</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div class="col-sm-4">
               <img src="{{ asset('public/images/add-sample/summer.jpg') }}" class="img-responsive" alt="">
            </div>
          </div>  
        </div>
        <div class="tab-pane" id="newslatter">
          <div class="row">
            <div class="col-sm-9">
              <div class="newsletter-body">
                <h3>Newsletter</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                <form>
                    <div class="input-group input-group-lg">
                        <input class="form-control" placeholder="Enter email address" type="text">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="button">Sign Up</button>
                        </span>
                    </div>
                </form>
              </div>
            </div>
            <div class="col-sm-3 newsletter-badge">
              <span>Subsribe &amp; Get </span>
              <span class="price">$35</span>
              <span>discount</span>
            </div>
          </div>  
        </div>
        </div>
      </div>
      <div class="clear_both"></div>    
    </div>
  </div> 
</div>