@section('vendors-home-page-content')
<style type="text/css">
.slick-dots li.slick-active button::before, .slick-dots li button::before{
  color:#1FC0A0;
}
</style>

<div id="vendor_home_content">
  <h2 class="cat-box-top">{!! trans('frontend.shop_by_cat_label') !!} <span class="responsive-accordian"></span></h2>
  @if(count($vendor_home_page_cats) > 0)  
  <div class="vendor-categories">
    <div class="row">
      <div class="col-md-12">
        <div class="vendor-top-collection">
          @foreach($vendor_home_page_cats as $cats)
          <div class="col-md-4">
            <div class="vendor-category-content clearfix">
              <div class="vendor-category-name">
                <h2>{!! $cats['parent_cat']['name'] !!} <span class="responsive-accordian"></span></h2>
                <div class="vendor-categories-list">
                  @if(count($cats['child_cat']) > 0)  
                    <ul>
                      @foreach($cats['child_cat'] as $child_cat)
                      <li><a href="{{ route('store-products-cat-page-content', array($child_cat['slug'], $vendor_info->name)) }}">{!! $child_cat['name'] !!}</a></li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              </div>
              <div class="vendor-category-image">
                @if(!empty(get_image_url($cats['parent_cat']['category_img_url'])))
                  <img class="img-responsive" src="{{ get_image_url($cats['parent_cat']['category_img_url']) }}">
                @else
                  <img class="img-responsive" src="{{ default_placeholder_img_src() }}">
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>  
      </div>
    </div>
  </div>
  @else
  <p style="text-align:center;padding-top:25px;">{!! trans('frontend.product_not_available') !!}</p>
  @endif
  
  <div class="row">
    <div class="col-md-12">
      <div class="vendor-special-products">
        <ul class="vendor-special-products-menu">
            <li><a class="active" href="#latest_items" data-toggle="tab">{!! trans('frontend.only_latest_label') !!}</a></li>
            <li><a href="#best_sales_items" data-toggle="tab">{!! trans('frontend.best_sales_label') !!}</a></li>
            <li><a href="#featured_items" data-toggle="tab">{!! trans('frontend.featured_products_label') !!}</a></li>
            <li><a href="#recommended_items" data-toggle="tab">{!! trans('frontend.recommended_items') !!}</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="latest_items">
            @if(count($vendor_advanced_items['latest_items']) > 0)  
              <div class="latest-items special-items">
                @foreach($vendor_advanced_items['latest_items'] as $latest)
                <?php $reviews  = get_comments_rating_details($latest['id'], 'product');?>
                <div class="col-xs-12 col-sm-4 col-md-3">
                  <div class="hover-product">
                    <div class="hover">
                      @if(!empty($latest['_product_related_images_url']->product_image))  
                      <img src="{{ get_image_url($latest['_product_related_images_url']->product_image) }}" alt="">
                      @else
                      <img src="{{ default_placeholder_img_src() }}" alt="">
                      @endif
                      <div class="overlay">
                        <button class="info quick-view-popup" data-id="{{ $latest['id'] }}">{!! trans('frontend.quick_view_label') !!}</button>
                      </div>
                    </div> 
                    <div class="single-product-bottom-section">
                      <a href="{{ route('details-page', $latest['post_slug']) }}"><h3>{!! get_product_title( $latest['id'] ) !!}</h3></a>
                      @if(get_product_type($latest['id']) == 'simple_product')
                        <p><strong>{!! price_html( get_product_price($latest['id']), get_frontend_selected_currency() ) !!}</strong></p>
                      @elseif(get_product_type($latest['id']) == 'configurable_product')
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest['id']) !!}</strong></p>
                      @elseif(get_product_type($latest['id']) == 'customizable_product' || get_product_type($latest['id']) == 'downloadable_product')
                        @if(count(get_product_variations($latest['id']))>0)
                          <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest['id']) !!}</strong></p>
                        @else
                          <p><strong>{!! price_html( get_product_price($latest['id']), get_frontend_selected_currency() ) !!}</strong></p>
                        @endif
                      @endif
                      <div class="text-center rating-content">
                        <div class="star-rating">
                          <span style="width:{{ $reviews['percentage'] }}%"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
          </div> 
            
          <div class="tab-pane" id="best_sales_items" >
            @if(count($vendor_advanced_items['best_sales']) > 0)  
            <div class="best-sales-items special-items">
              @foreach($vendor_advanced_items['best_sales'] as $best_sales)
              <?php $reviews  = get_comments_rating_details($best_sales['id'], 'product');?>
              <div class="col-md-4">
                <div class="hover-product">
                  <div class="hover">
                    @if(!empty($best_sales['_product_related_images_url']->product_image))  
                    <img src="{{ get_image_url($best_sales['_product_related_images_url']->product_image) }}" alt="">
                    @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                    @endif
                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="{{ $best_sales['id'] }}">{!! trans('frontend.quick_view_label') !!}</button>
                    </div>
                  </div> 
                  <div class="single-product-bottom-section">
                    <a href="{{ route('details-page', $best_sales['post_slug']) }}"><h3>{!! get_product_title( $best_sales['id'] ) !!}</h3></a>
                    @if(get_product_type($best_sales['id']) == 'simple_product')
                      <p><strong>{!! price_html( get_product_price($best_sales['id']), get_frontend_selected_currency() ) !!}</strong></p>
                    @elseif(get_product_type($best_sales['id']) == 'configurable_product')
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales['id']) !!}</strong></p>
                    @elseif(get_product_type($best_sales['id']) == 'customizable_product' || get_product_type($best_sales['id']) == 'downloadable_product')
                      @if(count(get_product_variations($best_sales['id']))>0)
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales['id']) !!}</strong></p>
                      @else
                        <p><strong>{!! price_html( get_product_price($best_sales['id']), get_frontend_selected_currency() ) !!}</strong></p>
                      @endif
                    @endif
                    <div class="text-center rating-content">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
          </div> 
          <div class="tab-pane" id="featured_items" >
            @if(count($vendor_advanced_items['features_items']) > 0)  
            <div class="featured-items special-items">
              @foreach($vendor_advanced_items['features_items'] as $features_items)
              <?php $reviews  = get_comments_rating_details($features_items['id'], 'product');?>
              <div class="col-md-4">
                <div class="hover-product">
                  <div class="hover">
                    @if(!empty($features_items['_product_related_images_url']->product_image))  
                    <img src="{{ get_image_url($features_items['_product_related_images_url']->product_image) }}" alt="">
                    @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                    @endif
                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="{{ $features_items['id'] }}">{!! trans('frontend.quick_view_label') !!}</button>
                    </div>
                  </div> 
                  <div class="single-product-bottom-section">
                    <a href="{{ route('details-page', $features_items['post_slug']) }}"><h3>{!! get_product_title( $features_items['id'] ) !!}</h3></a>
                    @if(get_product_type($features_items['id']) == 'simple_product')
                      <p><strong>{!! price_html( get_product_price($features_items['id']), get_frontend_selected_currency() ) !!}</strong></p>
                    @elseif(get_product_type($features_items['id']) == 'configurable_product')
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_items['id']) !!}</strong></p>
                    @elseif(get_product_type($features_items['id']) == 'customizable_product' || get_product_type($features_items['id']) == 'downloadable_product')
                      @if(count(get_product_variations($features_items['id']))>0)
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_items['id']) !!}</strong></p>
                      @else
                        <p><strong>{!! price_html( get_product_price($features_items['id']), get_frontend_selected_currency() ) !!}</strong></p>
                      @endif
                    @endif
                    <div class="text-center rating-content">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
          </div> 
          <div class="tab-pane" id="recommended_items" >
            @if(count($vendor_advanced_items['recommended_items']) > 0)  
            <div class="recommended-items special-items">
              @foreach($vendor_advanced_items['recommended_items'] as $recommended_items)
              <?php $reviews  = get_comments_rating_details($recommended_items['id'], 'product');?>
              <div class="col-md-4">
                <div class="hover-product">
                  <div class="hover">
                    @if(!empty($recommended_items['_product_related_images_url']->product_image))  
                    <img src="{{ get_image_url($recommended_items['_product_related_images_url']->product_image) }}" alt="">
                    @else
                    <img src="{{ default_placeholder_img_src() }}" alt="">
                    @endif
                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="{{ $recommended_items['id'] }}">{!! trans('frontend.quick_view_label') !!}</button>
                    </div>
                  </div> 
                  <div class="single-product-bottom-section">
                    <a href="{{ route('details-page', $recommended_items['post_slug']) }}"><h3>{!! get_product_title( $recommended_items['id'] ) !!}</h3></a>
                    @if(get_product_type($recommended_items['id']) == 'simple_product')
                      <p><strong>{!! price_html( get_product_price($recommended_items['id']), get_frontend_selected_currency() ) !!}</strong></p>
                    @elseif(get_product_type($recommended_items['id']) == 'configurable_product')
                      <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_items['id']) !!}</strong></p>
                    @elseif(get_product_type($recommended_items['id']) == 'customizable_product' || get_product_type($recommended_items['id']) == 'downloadable_product')
                      @if(count(get_product_variations($recommended_items['id']))>0)
                        <p><strong>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_items['id']) !!}</strong></p>
                      @else
                        <p><strong>{!! price_html( get_product_price($recommended_items['id']), get_frontend_selected_currency() ) !!}</strong></p>
                      @endif
                    @endif
                    <div class="text-center rating-content">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              </div>
            @else
            <p style="text-align:center;">{!! trans('frontend.product_not_available') !!}</p>
            @endif
          </div> 
        </div>
      </div>    
    </div>
  </div>  
</div>
@endsection