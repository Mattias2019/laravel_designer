<script type="text/javascript">
  $(document).ready(function(){
    $('.model__quick_view_product_info .btn-number').click(function(e){
      e.preventDefault();
      fieldName = $(this).attr('data-field');
      type      = $(this).attr('data-type');
      var input = $("input[name='"+fieldName+"']");
      var currentVal = parseInt(input.val());
      if (!isNaN(currentVal)) {
          if(type == 'minus') {

              if(currentVal > input.attr('min')) {
                  input.val(currentVal - 1).change();
              } 
              if(parseInt(input.val()) == input.attr('min')) {
                  $(this).attr('disabled', true);
              }

          } else if(type == 'plus') {

              if(currentVal < input.attr('max')) {
                  input.val(currentVal + 1).change();
              }
              if(parseInt(input.val()) == input.attr('max')) {
                  $(this).attr('disabled', true);
              }

          }
      } else {
          input.val(0);
      }
    });
	
    $('.model__quick_view_product_info .input-number').focusin(function(){
       $(this).data('oldValue', $(this).val());
    });
	
    $('.model__quick_view_product_info .input-number').change(function() {

        minValue =  parseInt($(this).attr('min'));
        maxValue =  parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".model__quick_view_product_info .btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".model__quick_view_product_info .btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
	
    $(".model__quick_view_product_info .input-number").keydown(function (e) {
      // Allow: backspace, delete, tab, escape, enter and .
      if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
           // Allow: Ctrl+A
          (e.keyCode == 65 && e.ctrlKey === true) || 
           // Allow: home, end, left, right
          (e.keyCode >= 35 && e.keyCode <= 39)) {
               // let it happen, don't do anything
               return;
      }
      // Ensure that it is a number and stop the keypress
      if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
      }
    });
    
//    if($('.add-to-cart-bg').length>0 || $('.single-page-add-to-cart').length>0){
//      dynamicAddToCart();
//    }
  });
</script>
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12 col-sm-5 col-md-5">
      <div class="model__quick_view_product_image">
        @if( !empty($single_product_details['post_image_url']) && $single_product_details['_product_related_images_url']->product_image != '/images/upload.png')
          <img src="{{ get_image_url($single_product_details['post_image_url']) }}" alt="{{ basename($single_product_details['post_image_url']) }}" class="img-responsive"/>
        @else
          <img src="{{ default_placeholder_img_src() }}" alt="" class="img-responsive" />
        @endif

        @if(count($single_product_details['_product_related_images_url']->product_gallery_images) > 0)
        <div class="product-gallery-image">
          <div id="gallery-image-slider-carousel" class="carousel slide" data-ride="carousel">
            <?php $numb =1; $flag =1; $is_last_tag_added = false;?>
            <div class="carousel-inner">
              @foreach($single_product_details['_product_related_images_url']->product_gallery_images as $key => $row)
                    @if($numb == 1)
                      @if($flag == 1)
                        <div class="item active">
                      @else
                        <div class="item">
                      @endif
                      <div class="col-xs-4 col-sm-4">
                        <div class="text-center">
                          <img src="{{ get_image_url($row->url) }}"  alt="{{ basename( $row->url ) }}" />
                        </div>
                      </div>

                      <?php $is_last_tag_added = false;?>
                    @elseif($numb == 3)
                      <div class="col-xs-4 col-sm-4">
                        <div class="text-center">
                          <img src="{{ get_image_url($row->url) }}"  alt="{{ basename( $row->url ) }}" />
                        </div>
                      </div>
                      <?php $numb = 0; $is_last_tag_added = true;?>
                      </div>
                    @else
                      <div class="col-xs-4 col-sm-4">
                        <div class="text-center">
                          <img src="{{ get_image_url($row->url) }}"  alt="{{ basename( $row->url ) }}" />
                        </div>
                      </div>
                      <?php $is_last_tag_added = false;?>
                    @endif

                    <?php 
                     $numb++;
                     $flag++;
                    ?>
                  @endforeach

                  @if(!$is_last_tag_added)
                     </div>
                  @endif 
            </div>
            <div class="slider-control-main text-center">
              <div class="prev-btn">
                <a href="#gallery-image-slider-carousel" class="control-carousel" data-slide="prev">
                  <i class="fa fa-angle-left"></i>
                </a>
              </div>

              <div class="next-btn">
                <a href="#gallery-image-slider-carousel" class="control-carousel" data-slide="next">
                  <i class="fa fa-angle-right"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>      

    <div class="col-xs-12 col-sm-7 col-md-7">
      <div class="model__quick_view_product_info">
        <h2 class="product-title">{{ $single_product_details['post_title'] }}</h2>
        <div class="star-rating"><span style="width:{{ $comments_rating_details['percentage'] }}%"></span></div>

        <div class="model__quick_view_product_price">
          @if(get_product_type($single_product_details['id']) == 'simple_product')
          @if($single_product_details['post_regular_price'] && $single_product_details['post_regular_price'] >0 && $single_product_details['post_sale_price'] && $single_product_details['post_sale_price']>0 && $single_product_details['post_regular_price'] > $single_product_details['post_sale_price'] )
          <span class="offer-price">{!! price_html( $single_product_details['post_regular_price'] ) !!}</span>
          @endif
          <span class="solid-price">{!! price_html( $single_product_details['post_price'] ) !!}</span>

          @if($single_product_details['post_regular_price'] && $single_product_details['post_sale_price'] && $single_product_details['post_regular_price'] > $single_product_details['post_sale_price'] && $single_product_details['_product_sale_price_start_date'] && $single_product_details['_product_sale_price_end_date'] && $single_product_details['_product_sale_price_end_date'] >= date("Y-m-d"))
          <p class="offer-message-label">&#10148; {{ trans('frontend.offer_msg') }}  <i>{!! date("F j, Y", strtotime($single_product_details['_product_sale_price_start_date'])) !!} {{ trans('frontend.to') }} {!! date("F j, Y", strtotime($single_product_details['_product_sale_price_end_date'])) !!} </i></p>
          @endif

        @elseif(get_product_type($single_product_details['id']) == 'configurable_product' || get_product_type($single_product_details['id']) == 'customizable_product')
          <span class="solid-price">{!! get_product_variations_min_to_max_price_html($currency_symbol, $single_product_details['id']) !!} </span>
        @endif
        </div> 

        <div class="model__quick_view_product_stock">
          @if( get_product_type($single_product_details['id']) == 'simple_product' || (get_product_type($single_product_details['id']) == 'customizable_product' && count(get_product_variations($single_product_details['id'])) == 0))

            @if( $single_product_details['post_stock_availability'] == 'in_stock' || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock') )
              <p class="availability-status"><span>{{ trans('frontend.single_product_availability_label') }}: </span> <span class="in-stock">{{ trans('frontend.single_product_availability_status_instock_label') }}</span></p>
            @else
              <p class="availability-status"><span>{{ trans('frontend.single_product_availability_label') }}: </span> <span class="in-stock">{{ trans('frontend.single_product_availability_status_outstock_label') }}</span></p>
            @endif

            @if( ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock') )
              <p class="availability-status"><span>{{ trans('frontend.single_product_available_stock_label') }}: </span> <span class="stock-amount">{{ $single_product_details['post_stock_qty'] }}</span></p>
            @endif

            @if($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock')
              <p class="stock-notify-msg">&#10148; {{ trans('frontend.product_available_msg') }}</p>
            @endif
          @endif
        </div> <hr>

        @if($single_product_details['post_content'])
        <p class="product-description">{!! get_limit_string(string_decode($single_product_details['post_content']), 200) !!}</p>
        <hr>
        @endif

        @if(get_product_type($single_product_details['id']) == 'configurable_product')
          <a href="{{ route('details-page', $single_product_details['post_slug']) }}" class="btn btn-xs select-options-bg"><i class="fa fa-hand-o-up"></i> {{ trans('frontend.select_options') }}</a>
        @endif
        
        @if(get_product_type($single_product_details['id']) == 'customizable_product')
          <a href="{{ route('customize-page', $single_product_details['post_slug']) }}" class="btn btn-xs product-customize-bg"><i class="fa fa-gears"></i> {{ trans('frontend.customize') }}</a>
        @endif

        @if(get_product_type($single_product_details['id']) == 'simple_product' && ($single_product_details['post_stock_availability'] == 'in_stock' || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'only_allow' && $single_product_details['post_stock_availability'] == 'in_stock') || ($single_product_details['_product_manage_stock'] == 'yes' && $single_product_details['_product_manage_stock_back_to_order'] == 'allow_notify_customer' && $single_product_details['post_stock_availability'] == 'in_stock')))
<!--        <div class="product-add-to-cart-content add-to-cart-content">  
          <div class="product-add-to-cart-button-content">
            <ul>
              <li>
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" disabled="disabled" data-type="minus" data-field="quant[1]">
                      <span class="fa fa-minus"></span>
                    </button>
                  </span>
                    <input type="text" id="quantity" name="quant[1]" class="form-control input-number" value="1" min="1" max="10" style="width:55px;"/>
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-default btn-number" data-type="plus" data-field="quant[1]">
                      <span class="fa fa-plus"></span>
                    </button>
                  </span>
                </div>
              </li>  
              <li>
                <a href="" class="btn btn-default btn-md add-to-cart-bg" data-target="quick_view" data-id=""><i class="fa fa-shopping-cart"></i></a>
              </li>
              <li>
                <a href="" class="btn btn-default btn-md product-wishlist" data-id=""><i class="fa fa-heart"></i></a>
              </li>
            </ul>
          </div>  
        </div>-->
        @endif

        <div class="model__quick_view_product_meta">
          @if($single_product_details['post_sku'])  
            <p><label>{{ trans('frontend.sku') }}:</label> <span>{{ $single_product_details['post_sku'] }}</span></p>
          @endif

          @if($single_product_details['_product_enable_as_latest'] == 'yes')
            <p><label>{{ trans('frontend.condition_label') }}:</label> <span>{{ trans('frontend.new_label') }}</span></p>
          @endif

          @if(count(get_product_brands_lists($single_product_details['id'])) > 0)
            <p><label>{{ trans('frontend.brand_label') }}:</label> <span>{{ get_single_page_product_brands_lists( get_product_brands_lists($single_product_details['id']) ) }}</span></p>
          @endif

          @if(get_single_page_product_categories_lists($single_product_details['id']))
            <p><label>{{ trans('frontend.category_label') }}:</label> <span>{{ get_single_page_product_categories_lists($single_product_details['id']) }}</span></p>
          @endif

          @if(count(get_product_tags_lists($single_product_details['id']))>0)
            <p><label>{{ trans('frontend.tag_label') }}:</label> <span>{{ get_single_page_product_tags_lists(get_product_tags_lists($single_product_details['id'])) }}</span></p>
          @endif
        </div>
      </div>
    </div>    
  </div>      
</div>