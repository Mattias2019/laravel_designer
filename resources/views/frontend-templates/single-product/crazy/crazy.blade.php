<div id="single_product">
  <div class="container">
    <div class="visible-xs visible-sm"><h1 class="product-title">{{ $single_product_details['post_title'] }}</h1><hr></div>  
    @if(!empty($single_product_details['_product_related_images_url']->shop_banner_image))  
    <div class="row extra-margin-bottom">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <img src="{{ get_image_url($single_product_details['_product_related_images_url']->shop_banner_image) }}" alt="" class="img-responsive" />
      </div>
    </div> 
    @endif
    
    <div class="row">
      <div class="col-xs-12 col-sm-5 col-md-5">
        <div class="product-main-content">
          <div class="product-main-image">
            @if(get_product_image($single_product_details['id']))
              <img src="{{ get_image_url($single_product_details['_product_related_images_url']->product_image) }}" id="product_image_zoom" data-zoom-image="{{ get_image_url($product_zoom_image) }}" alt="{{ basename($single_product_details['_product_related_images_url']->product_image) }}" class="img-responsive"/>
              <div class="zoom-icon"></div>
            @else
              <img style="margin-left:100px !important;" src="{{ default_placeholder_img_src() }}" alt="">
            @endif
          </div>
        
          @if(count($single_product_details['_product_related_images_url']->product_gallery_images) > 0)
          <?php $count = 1;?>

          <div id="product_gallery_image" class="product-gallery-image">
            @foreach($single_product_details['_product_related_images_url']->product_gallery_images as $key => $row)
              @if($count == 1)
              <a  href="#" class="elevatezoom-gallery active" data-image="{{ get_image_url($row->url) }}" data-zoom-image="{{ get_image_url($row->zoom_img_url) }}">
                @if(!empty($row->url) && (basename($row->url) !== 'no-image.png'))  
                <img src="{{ get_image_url($row->url) }}" width="100"  />
                @else
                <img src="{{ default_placeholder_img_src() }}" width="100"  />
                @endif
              </a>
              @else
              <a  href="#" class="elevatezoom-gallery" data-image="{{ get_image_url($row->url) }}" data-zoom-image="{{ get_image_url($row->zoom_img_url) }}">
                @if(!empty($row->url) && (basename($row->url) !== 'no-image.png'))  
                <img src="{{ get_image_url($row->url) }}" width="100"  />
                @else
                <img src="{{ default_placeholder_img_src() }}" width="100"  />
                @endif
              </a>
              @endif
              <?php $count ++;?>
            @endforeach
          </div>
          @endif
        </div> 
          
        <div class="selected-variation-product">
          <img src=""  class="img-responsive"/>
        </div> 
          
        @if($single_product_details['_product_enable_video_feature'] == 'yes')
        <br>
          @if($single_product_details['_product_video_feature_display_mode'] == 'popup')
            <div class="product-video-content">
              <button class="btn btn-default product-video" type="button">
                <i class="fa fa-video-camera"></i>
                {{ trans('frontend.product_video') }}
              </button>
              @include('modal.product-video')  
            </div>
          @elseif($single_product_details['_product_video_feature_display_mode'] == 'content')
            <h4> {!! $single_product_details['_product_video_feature_title'] !!} </h4>
            <div class="product-video-content-panel">
              @if($single_product_details['_product_video_feature_source'] == 'embedded_code')
                @include('pages.frontend.frontend-pages.video-source-embedded-url')
                @yield('embedded-content')
              @elseif($single_product_details['_product_video_feature_source'] == 'online_url')
                @include('pages.frontend.frontend-pages.video-source-online-url')
                @yield('online-url-content')
              @endif
            </div>  
          @endif
        @endif
        
      </div>
      <div class="col-xs-12 col-sm-7 col-md-7">
        <h1 class="product-title visible-md visible-lg">{{ $single_product_details['post_title'] }}</h1>
        
        @if( count(get_vendor_details_by_product_id($single_product_details['id'])) >0 )
        <p class="vendor-title"><strong>{!! trans('frontend.sold_by_label') !!}</strong> - {!! get_vendor_name_by_product_id( $single_product_details['id'] ) !!}</p>
        @endif
        
        <?php $reviews_settings = get_reviews_settings_data($single_product_details['id']);?>
        @if($reviews_settings['enable_reviews_add_link_to_details_page'] && $reviews_settings['enable_reviews_add_link_to_details_page'] == 'yes')
          <div class="comments-advices">
            <ul>
              <li class="review-stars"><div class="star-rating"><span style="width:{{ $comments_rating_details['percentage'] }}%"></span></div></li>
              <li class="read-review"><a href="#product_description_bottom_tab" class="reviews selected"> {{ trans('frontend.single_product_read_review_label') }} (<span itemprop="reviewCount">{{ $comments_rating_details['total'] }}</span>) </a></li>
              <li class="write-review"><a class="open-comment-form" href="#new_comment_form">&nbsp;<span>|</span>&nbsp; {{ trans('frontend.single_product_write_review_label') }} </a></li>
            </ul>
          </div>
        @endif
        
        <div class="product-pricing">
          @if( get_product_type($single_product_details['id']) == 'simple_product' || (get_product_type($single_product_details['id']) == 'downloadable_product' && count(get_product_variations($single_product_details['id'])) == 0 ) || (get_product_type($single_product_details['id']) == 'customizable_product' && count(get_product_variations($single_product_details['id'])) == 0 ) )
            @if(!is_null($single_product_details['offer_price']))
            <span class="offer-price">{!! price_html( $single_product_details['offer_price'] ) !!}</span>
            @endif
            
            <span class="solid-price">{!! price_html( $single_product_details['solid_price'] ) !!}</span>

            @if($single_product_details['post_regular_price'] && $single_product_details['post_sale_price'] && $single_product_details['post_regular_price'] > $single_product_details['post_sale_price'] && $single_product_details['_product_sale_price_start_date'] && $single_product_details['_product_sale_price_end_date'] && $single_product_details['_product_sale_price_end_date'] >= date("Y-m-d"))
            <p class="offer-message-label"><i class="fa fa-bell" aria-hidden="true"></i> {{ trans('frontend.offer_msg') }}  <i>{!! date("F j, Y", strtotime($single_product_details['_product_sale_price_start_date'])) !!} {{ trans('frontend.to') }} {!! date("F j, Y", strtotime($single_product_details['_product_sale_price_end_date'])) !!} </i></p>
            @endif
            
          @elseif( (get_product_type($single_product_details['id']) == 'configurable_product' || get_product_type($single_product_details['id']) == 'customizable_product' || get_product_type($single_product_details['id']) == 'downloadable_product') && count(get_product_variations($single_product_details['id'])) > 0 )
            <span class="solid-price">{!! get_product_variations_min_to_max_price_html($currency_symbol, $single_product_details['id']) !!} </span>
          @endif
        </div>
        
        @if(( get_product_type($single_product_details['id']) == 'simple_product' || ( ( get_product_type($single_product_details['id']) == 'customizable_product' || get_product_type($single_product_details['id']) == 'downloadable_product' ) && count(get_product_variations($single_product_details['id'])) == 0) ))
          @if( $single_product_details['post_stock_availability'] == 'in_stock' || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock') )
            <p class="availability-status"><span>{{ trans('frontend.single_product_availability_label') }}: </span> <span class="in-stock">{{ trans('frontend.single_product_availability_status_instock_label') }}</span></p>
          @else
            <p class="availability-status"><span>{{ trans('frontend.single_product_availability_label') }}: </span> <span class="in-stock">{{ trans('frontend.single_product_availability_status_outstock_label') }}</span></p>
            <button class="btn btn-default request-product" type="button">{{ trans('frontend.request_product') }}</button>
            @include('modal.request-products', array('product_id' => $single_product_details['id']))
          @endif
          
          @if( ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock') )
            <p class="availability-status"><span>{{ trans('frontend.single_product_available_stock_label') }}: </span> <span class="stock-amount">{{ $single_product_details['post_stock_qty'] }}</span></p>
          @endif
          
          @if($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock')
            <p class="stock-notify-msg"><i class="fa fa-bell" aria-hidden="true"></i> {{ trans('frontend.product_available_msg') }}</p>
          @endif
        @endif
        <hr>
        
        @if($single_product_details['post_content'])
        <div class="product-description">
        {!! string_decode($single_product_details['post_content']) !!}
        </div><hr>
        @endif
        
        @if( (get_product_type($single_product_details['id']) == 'configurable_product' || get_product_type($single_product_details['id']) == 'downloadable_product'))
          @if(count($attr_lists) >0 && count(get_product_variations_with_data($single_product_details['id']))>0)
            @include('includes.frontend.variations-html', array('attr_lists' => $attr_lists, 'single_product_details' => $single_product_details))
          @endif
        @endif
        
        @if(( get_product_type($single_product_details['id']) == 'simple_product' || ( get_product_type($single_product_details['id']) == 'downloadable_product' && count(get_product_variations($single_product_details['id'])) == 0 )) && ($single_product_details['post_stock_availability'] == 'in_stock' || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock')))
        <div class="product-add-to-cart-content add-to-cart-content">
          <ul>
            <li>
              <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                      <span class="fa fa-minus"></span>
                    </button>
                  </span>
                  <input type="text" id="quantity" name="quant[1]" class="form-control input-number" value="1" min="1" max="10"/>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                      <span class="fa fa-plus"></span>
                    </button>
                  </span>
              </div>
            </li>
            <li>
              <a href="" class="btn btn-sm btn-style add-to-cart-bg" data-id="{{ $single_product_details['id'] }}"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; {{ trans('frontend.add_to_cart') }}</a>
            </li>
          </ul>
        </div>
        @endif
        
        @if(get_product_type($single_product_details['id']) == 'customizable_product')
        <a href="{{ route('customize-page', $single_product_details['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg"><i class="fa fa-gears"></i> {!! trans('frontend.customize_it') !!}</a>
        @endif
        
        <div class="product-extra-data">
          @if($single_product_details['post_sku'])  
            <p><label>{{ trans('frontend.sku') }}:</label><span>{{ $single_product_details['post_sku'] }}</span></p>
          @endif
          
          @if($single_product_details['_product_enable_as_latest'] == 'yes')
            <p><label>{{ trans('frontend.condition_label') }}:</label><span>{{ trans('frontend.new_label') }}</span></p>
          @endif
          
          @if(count(get_product_brands_lists($single_product_details['id'])) > 0)
            <p><label>{{ trans('frontend.brand_label') }}:</label><span>{{ get_single_page_product_brands_lists( get_product_brands_lists($single_product_details['id']) ) }}</span></p>
          @endif
          <!-- daizheng -->
          @if(get_single_page_product_categories_lists($single_product_details['id']))
            <p><label>{{ trans('frontend.category_label') }}:</label><span>{{ get_single_page_product_categories_lists($single_product_details['id']) }}</span></p>
          @endif
          
          @if(count(get_product_tags_lists($single_product_details['id']))>0)
            <p><label>{{ trans('frontend.tag_label') }}:</label><span>{{ get_single_page_product_tags_lists(get_product_tags_lists($single_product_details['id'])) }}</span></p>
          @endif
        </div>
        
        <div class="single-page-btn">
          <ul>
            <li>
              <a href="" class="btn btn-default btn-sm product-wishlist" data-id="{{ $single_product_details['id'] }}"><i class="fa fa-heart"></i> {{ trans('frontend.add_to_wishlist_label') }}</a>
            </li>
            <li>
              <a href="" class="btn btn-default btn-sm product-compare" data-id="{{ $single_product_details['id'] }}"><i class="fa fa-exchange"></i> {{ trans('frontend.add_to_compare_list_label') }}</a>
            </li>
          </ul>  
        </div>
        
        <div class="product-share-content">
          <ul>
            <li><a class="facebook btn btn-default btn-sm" data-name="fb" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.share_with_fb_label') }}"><i class="fa fa-facebook"></i> {!! trans('frontend.share_label') !!}</a></li>
            <li><a class="twitter btn btn-default btn-sm" data-name="tweet" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.share_with_twitter_label') }}"><i class="fa fa-twitter"></i> {!! trans('frontend.tweet_label') !!}</a></li>
            <li><a class="google-plus btn btn-default btn-sm" data-name="gplus" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.share_with_google_plus_label') }}"><i class="fa fa-google-plus"></i> {!! trans('frontend.share_label') !!}</a></li>
            <li><a class="linkedin btn btn-default btn-sm" data-name="lin" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.share_with_linkedin_label') }}"><i class="fa fa-linkedin"></i> {!! trans('frontend.share_label') !!}</a></li>
						<li><a class="pinterest btn btn-default btn-sm" data-name="pi" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.share_with_pin_it_label') }}"><i class="fa fa-pinterest"></i> {!! trans('frontend.share_pin_it_label') !!}</a></li>
						<li><a class="print btn btn-default btn-sm" data-name="print" href="#" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.print_label') }}"><i class="fa fa-print"></i> {!! trans('frontend.print_label') !!}</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="row">
      <div id="product_description_bottom_tab" class="product-description-bottom-tab">
        <ul class="nav nav-tabs">
          <li <?php if(!old('comments_target')){?>class="active" <?php }?>><a href="#features" data-toggle="tab">{{ trans('frontend.features_label') }}</a></li>  
          <li><a href="#shippingInfo" data-toggle="tab">{{ trans('frontend.shipping_info_label') }}</a></li>

          @if($single_product_details['_product_enable_reviews'] == 'yes')
            <li <?php if(old('comments_target')){?>class="active" <?php }?>><a href="#reviews" data-toggle="tab">{{ trans('frontend.reviews_label') }} ({!! $comments_rating_details['total'] !!})</a></li>
          @endif

          @if( count(get_vendor_details_by_product_id($single_product_details['id'])) >0 )
            <li><a href="#vendorInfo" data-toggle="tab">{{ trans('frontend.vendor_info_label') }}</a></li>
          @endif
        </ul>

        <div class="tab-content">
          <div class="tab-pane fade <?php if(!old('comments_target')){?>active in<?php }?>" id="features">
            @if($single_product_details['_product_extra_features'])  
              {!! string_decode($single_product_details['_product_extra_features']) !!}
            @else
              {!! trans('frontend.no_features_label') !!}
            @endif
          </div>

          <div class="tab-pane fade" id="shippingInfo" >
            {{ trans('frontend.no_shippingInfo_label') }}
          </div>

          @if($single_product_details['_product_enable_reviews'] == 'yes')
          <div class="tab-pane fade <?php if(old('comments_target')){?>active in<?php }?>" id="reviews">
              <div class="product-reviews-content">
                <div class="rating-box clearfix">
                    <div class="score-box">
                      <div class="score">{{ $comments_rating_details['average'] }}</div>
                      <div class="star-rating"><span style="width:{{ $comments_rating_details['percentage'] }}%"></span></div>
                      <div class="total-users"><i class="fa fa-user"></i>&nbsp;<span class="total">{{ $comments_rating_details['total'] }}</span>&nbsp;{{ trans('frontend.totals_label') }}</div>
                    </div>
                    <div class="individual-score-graph">
                      <ul>
                        <li>
                          <div class="rating-progress-content clearfix">
                            <div class="individual-rating-score">
                              <span><i class="fa fa-star"></i> 5</span>
                            </div>
                            <div class="individual-rating-progress">
                              <div class="progress">
                                <div class="progress-bar progress-bar-five" role="progressbar" aria-valuenow="{{ $comments_rating_details[5] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[5] }}%">
                                {!! $comments_rating_details[5] !!}%
                                </div>
                              </div>
                            </div>
                          </div>
                        </li>
                        <li>
                            <div class="rating-progress-content clearfix">
                                <div class="individual-rating-score">
                                    <span><i class="fa fa-star"></i> 4</span>
                                </div>
                                <div class="individual-rating-progress">
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-four" role="progressbar" aria-valuenow="{{ $comments_rating_details[4] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[4] }}%">
                                      {!! $comments_rating_details[4] !!}%
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="rating-progress-content clearfix">
                                <div class="individual-rating-score">
                                    <span><i class="fa fa-star"></i> 3</span>
                                </div>
                                <div class="individual-rating-progress">
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-three" role="progressbar" aria-valuenow="{{ $comments_rating_details[3] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[3] }}%">
                                      {!! $comments_rating_details[3] !!}%
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="rating-progress-content clearfix">
                                <div class="individual-rating-score">
                                    <span><i class="fa fa-star"></i> 2</span>
                                </div>
                                <div class="individual-rating-progress">
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-two" role="progressbar" aria-valuenow="{{ $comments_rating_details[2] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[2] }}%">
                                      {!! $comments_rating_details[2] !!}%
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="rating-progress-content clearfix">
                                <div class="individual-rating-score">
                                    <span><i class="fa fa-star"></i> 1</span>
                                </div>
                                <div class="individual-rating-progress">
                                    <div class="progress">
                                      <div class="progress-bar progress-bar-one" role="progressbar" aria-valuenow="{{ $comments_rating_details[1] }}" aria-valuemin="0" aria-valuemax="100" style="width:{{ $comments_rating_details[1] }}%">
                                      {!! $comments_rating_details[1] !!}%
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                      </ul>
                    </div>
                </div>
                <div class="user-reviews-content">
                    <h2 class="user-reviews-title">{{ $comments_rating_details['total'] }} {{ trans('frontend.reviews_for_label') }} <i><span>{{ $single_product_details['post_title'] }}</span></i></h2>
                      @if(count($comments_details) > 0)
                      <ol class="commentlist">
                         @foreach($comments_details as $comment) 
                          <li class="comment">
                            <div class="comment-container clearfix">
                              <div class="user-img">
                                @if(!empty($comment->user_photo_url))
                                <img alt="" src="{{ get_image_url( $comment->user_photo_url ) }}" class="avatar photo" width="60" height="60">
                                @else
                                <img alt="" src="{{ default_avatar_img_src() }}" class="avatar photo" width="60" height="60">
                                @endif
                              </div>
                              <div class="comment-text">
                                <div class="star-rating">
                                  <span style="width:{{ $comment->percentage }}%"><strong itemprop="ratingValue"></strong></span>
                                </div>
                                <p class="meta">
                                  <span class="comment-date">{{ Carbon\Carbon::parse(  $comment->created_at )->format('F d, Y') }}</span> &nbsp; - <span class="comment-user-role"><strong >{{ trans('frontend.by_label') }} {{ $comment->display_name }}</strong></span>
                                </p><hr>
                                <div class="description">
                                  <p>{{ $comment->content }}</p>
                                </div>
                              </div>
                            </div>
                          </li>
                          @endforeach
                      </ol>
                      @else
                      <p>{{ trans('frontend.no_review_label') }}</p>
                      @endif
                </div>

                <br>

                @include('pages-message.notify-msg-success')
                @include('pages-message.notify-msg-error')
                @include('pages-message.form-submit')

                <form id="new_comment_form" method="post" action="" enctype="multipart/form-data">
                  <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="comments_target" id="comments_target" value="product">
                  <input type="hidden" name="selected_rating_value" id="selected_rating_value" value="">
                  <input type="hidden" name="object_id" id="object_id" value="{{ $single_product_details['id'] }}">

                  <div class="add-user-review">
                    <h2 class="add-reviews-title">{{ trans('frontend.add_a_review_label') }}</h2>
                    <hr>
                    <h2 class="rating-title">{{ trans('frontend.select_your_rating_label') }}</h2>
                    <div class="rating-select">
                      <div class="btn btn-default btn-sm" data-rating_value="1"><span class="glyphicon glyphicon-star-empty"></span></div>
                      <div class="btn btn-default btn-sm" data-rating_value="2"><span class="glyphicon glyphicon-star-empty"></span></div>
                      <div class="btn btn-default btn-sm" data-rating_value="3"><span class="glyphicon glyphicon-star-empty"></span></div>
                      <div class="btn btn-default btn-sm" data-rating_value="4"><span class="glyphicon glyphicon-star-empty"></span></div>
                      <div class="btn btn-default btn-sm" data-rating_value="5"><span class="glyphicon glyphicon-star-empty"></span></div>
                    </div>
                    <br>
                    <div class="review-content">
                      <fieldset>
                        <legend>{{ trans('frontend.write_your_review_label') }}</legend>
                        <p><textarea name="product_review_content" id="product_review_content"></textarea></p>
                      </fieldset>
                    </div>
                    <br>
                    <div class="review-submit">
                      <input name="review_submit" id="review_submit" class="btn btn-sm btn-style" value="{{ trans('frontend.submit_label') }}" type="submit">
                    </div>
                  </div>
                </form>
            </div>
          </div>
          @endif
          
          @if( count(get_vendor_details_by_product_id($single_product_details['id'])) >0 )
          <div class="tab-pane fade" id="vendorInfo">
            <?php  $vendor_details = get_vendor_details_by_product_id($single_product_details['id']); $parse_json = json_decode($vendor_details['details']);?>
            <table>
              <tr>
                <th>{!! trans('frontend.store_name_label') !!}</th>
                @if(!empty($parse_json->profile_details->store_name))
                <td>{!! $parse_json->profile_details->store_name !!}</td>
                @else
                <td>{!! $vendor_details['user_name'] !!}</td>
                @endif
              </tr>
              
              <tr><th>{!! trans('frontend.vendor_label') !!}</th><td><a target="_blank" href="{{ route('store-details-page-content', $vendor_details['user_name']) }}"><i>{!!  $vendor_details['user_name'] !!}</i></a></td></tr>
              
              @if(!empty($parse_json->profile_details->country))
              <tr><th>{!! trans('frontend.country') !!}</th><td>{!! $parse_json->profile_details->country !!}</td></tr>
              @endif
              
              <tr><th>{!! trans('frontend.vendor_rating_label') !!}</th><td><div class="review-stars"><div class="star-rating" style="text-align:left !important; margin:0px !important;"><span style="width:{{ $vendor_reviews_rating_details['percentage'] }}%"></span></div></div></td></tr>  
            </table>
          </div>  
          @endif
        </div>
      </div>
    </div>  
          
    @if(count($related_items) > 0 && get_product_type($single_product_details['id']) != 'customizable_product')   
    <div class="row">
      <div id="related_products">
        <div class="content-title">
          <h2 class="text-center title-under">{{ trans('frontend.related_products_label') }}</h2>
        </div>
        
        <div class="related-products-content">
          @foreach($related_items as $products)
            <?php 
            $reviews          = get_comments_rating_details($products['id'], 'product');
            $reviews_settings = get_reviews_settings_data($products['id']);      
            ?>
            <div class="col-xs-12 col-sm-3 col-md-3 extra-padding grid-view">
              <div class="hover-product">
                <div class="hover">
                  @if($products['_product_related_images_url']->product_image)
                  <img class="img-responsive" src="{{ get_image_url($products['_product_related_images_url']->product_image) }}" alt="{{ basename($products['_product_related_images_url']->product_image) }}" />
                  @else
                  <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                  @endif

                  <div class="overlay">
                    <button class="info quick-view-popup" data-id="{{ $products['id'] }}">{{ trans('frontend.quick_view_label') }}</button>
                  </div>
                </div> 

                <div class="single-product-bottom-section">
                  <h3>{!! get_product_title($products['id']) !!} </h3>

                  @if(get_product_type($products['id']) == 'simple_product')
                    <p>{!! price_html( get_product_price($products['id']), get_frontend_selected_currency() ) !!}</p>
                  @elseif(get_product_type($products['id']) == 'configurable_product')
                    <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']) !!}</p>
                  @elseif(get_product_type($products['id']) == 'customizable_product' || get_product_type($products['id']) == 'downloadable_product')
                    @if(count(get_product_variations($products['id']))>0)
                      <p>{!! get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']) !!}</p>
                    @else
                      <p>{!! price_html( get_product_price($products['id']), get_frontend_selected_currency() ) !!}</p>
                    @endif
                  @endif

                  @if($reviews_settings['enable_reviews_add_link_to_product_page'] && $reviews_settings['enable_reviews_add_link_to_product_page'] == 'yes')
                    <div class="text-center">
                      <div class="star-rating">
                        <span style="width:{{ $reviews['percentage'] }}%"></span>
                      </div>

                      <div class="comments-advices">
                        <ul>
                          <li class="read-review"><a href="{{ route('details-page', $products['post_slug']) }}#product_description_bottom_tab" class="reviews selected"> {{ trans('frontend.single_product_read_review_label') }} (<span itemprop="reviewCount">{!! $reviews['total'] !!}</span>) </a></li>
                          <li class="write-review"><a class="open-comment-form" href="{{ route('details-page', $products['post_slug']) }}#new_comment_form">&nbsp;<span>|</span>&nbsp; {{ trans('frontend.single_product_write_review_label') }} </a></li>
                        </ul>
                      </div>
                    </div>
                  @endif

                  <div class="title-divider"></div>
                  <div class="single-product-add-to-cart">
                    @if(get_product_type($products['id']) == 'simple_product')
                      <a href="" data-id="{{ $products['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                      <a href="{{ route('details-page', $products['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                    @elseif(get_product_type($products['id']) == 'configurable_product')
                      <a href="{{ route('details-page', $products['post_slug']) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                      <a href="{{ route('details-page', $products['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                    @elseif(get_product_type($products['id']) == 'customizable_product')
                      @if(is_design_enable_for_this_product($products['id']))
                        <a href="{{ route('customize-page', $products['post_slug']) }}" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-gears"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                        <a href="{{ route('details-page', $products['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>

                      @else
                        <a href="" data-id="{{ $products['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange"></i></a>
                        <a href="{{ route('details-page', $products['post_slug']) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                      @endif
                    @elseif(get_product_type( $products['id'] ) == 'downloadable_product') 
                      @if(count(get_product_variations( $products['id'] ))>0)
                      <a href="{{ route( 'details-page', $products['post_slug'] ) }}" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.select_options') }}"><i class="fa fa-hand-o-up"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                      <a href="{{ route('details-page', $products['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                      @else
                      <a href="" data-id="{{ $products['id'] }}" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_cart_label') }}"><i class="fa fa-shopping-cart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_wishlist_label') }}"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="{{ $products['id'] }}" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.add_to_compare_list_label') }}"><i class="fa fa-exchange" ></i></a>
                      <a href="{{ route('details-page', $products['post_slug'] ) }}" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="{{ trans('frontend.product_details_label') }}"><i class="fa fa-eye"></i></a>
                      @endif                         
                    @endif
                  </div>
                </div>
              </div>
            </div>
          
          @endforeach
        </div>      
      </div>
    </div>
    @endif
<!-- 900 -->
  <!-- backside product -->
     @if(count($backside_items) > 0 && get_product_type($single_product_details['id']) == 'customizable_product')   
    <div class="row">
      <div id="related_products">
        <div class="content-title">
          <h2 class="text-center title-under">Select your '{!!
            
            explode(",",get_single_page_product_categories_lists($single_product_details['id']))[0] 
             !!}' BackSide</h2>
        </div>
        
        <div class="related-products-content">
          @foreach($backside_items as $products)
            <?php 
            $reviews          = get_comments_rating_details($products['id'], 'product');
            $reviews_settings = get_reviews_settings_data($products['id']);      
            ?>
            <div class="col-xs-12 col-sm-3 col-md-3 extra-padding grid-view">
              <div class="hover-product">
                <div class="hover">
                  @if($products['_product_related_images_url']->product_image)
                  <img class="img-responsive" src="{{ get_image_url($products['_product_related_images_url']->product_image) }}" alt="{{ basename($products['_product_related_images_url']->product_image) }}" />
                  @else
                  <img class="img-responsive" src="{{ default_placeholder_img_src() }}" alt="" />
                  @endif

                 
                  <div class="overlay">
                    <!-- <button class="info quick-view-popup" data-id="{{ $products['id'] }}">{{ trans('frontend.quick_view_label') }}</button> -->
                
                    <input type="radio" name="sbs" value="{{ $products['id'] }}" id="{{ $products['id'] }}" class="form-radio" checked></label>
                  </div>
                </div> 

                <div class="single-product-bottom-section">
                  <h3>{!! get_product_title($products['id']) !!} </h3>

                 
                </div>
              </div>
            </div>
          
          @endforeach
        </div>      
      </div>
    </div>
   
    <!-- <a disabled href="{{ route('customize-page', $single_product_details['post_slug']) }}" class="btn btn-lg btn-success  product-customize-bg continue"><i class="fa fa-wrench"></i>  {!! trans('Continue') !!}</a> -->
    <a disabled href="javascript:void()" onclick="gotopage()" class="btn btn-lg btn-success  product-customize-bg continue"><i class="fa fa-wrench"></i>  {!! trans('Continue') !!}</a>

    @endif
<script type="text/javascript">
  function gotopage(){
    var backside_id=$("input[name='sbs']:checked"). val()
    location.href="/product/customize/{{str_replace(" ","-", $single_product_details['post_title']) }}/"+backside_id;
  }  
$(document).ready(function() {
   $('.form-radio').click(function(){
       $("a").removeAttr('disabled');

       $('.continue').removeClass('btn-success');
       $('.continue').addClass('btn-style');
      //  $('a').attr('enabled','enabled'); 
   });
});


</script>      





    
    @if(count($upsell_products) > 0)
    <br>
    <div class="row upsell-products-content">
      <div class="col-md-12">
        <h3>{!! trans('frontend.upsell_title_label') !!}</h3><br>  
        <div class="upsell-products">
          @foreach($upsell_products as $products)
          <div class="col-xs-12 col-sm-4 col-md-3">
            <div class="upsell-img"><img src="{{ get_image_url(get_product_image( $products )) }}" alt="{{ basename( get_product_image( $products ) )}}"></div>
            <div class="upsell-products-info">
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
  </div>
  <input type="hidden" name="product_title" id="product_title" value="{{ $single_product_details['post_title'] }}"> 
  <input type="hidden" name="product_img" id="product_img" value="{{ $single_product_details['_product_related_images_url']->product_image }}"> 
</div>