<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="single-box">
        <div class="all-service-main">
          <div class="all-service service-style">
            <ul class="service-list">
              <li><span class="service-name service-name-earth"></span><p><?php echo trans('frontend.worldwide_service_label'); ?></p></li>
              <li><span class="service-name service-name-users"></span><p><?php echo trans('frontend.24_7_help_center_label'); ?></p></li>
              <li><span class="service-name service-name-checkmark-circle"></span><p><?php echo trans('frontend.safe_payment_label'); ?></p></li>
              <li><span class="service-name service-name-bicycle"></span><p><?php echo trans('frontend.quick_delivery_label'); ?></p></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="clear_both"></div>  
    </div>
  </div>    
  
  <div class="row">
    <div class="design-tool-workflow">
      <div class="divider-wrapper">
        <h2 class="divider-home"><?php echo trans('frontend.design_tools_work_label'); ?></h2>
      </div>
      <div class="work-img">
        <div class="featureblock fone">
          <div class="featureimg"></div>
          <a class="green feature" href="javascript:void(0)">
            <h3><?php echo trans('frontend.design_tools_work_upload_top_label'); ?></h3>
            <p><?php echo trans('frontend.design_tools_work_upload_bottom_label'); ?></p>
          </a>
        </div>
        <div class="featureblock fsec">
          <div class="featureimg"></div>
          <a class="center grey feature" href="javascript:void(0)">
            <h3><?php echo trans('frontend.design_tools_work_design_top_label'); ?></h3>
            <p><?php echo trans('frontend.design_tools_work_design_bottom_label'); ?></p>
          </a>
        </div>
        <div class="featureblock fthr">
          <div class="featureimg"></div>
          <a class="last orange feature" href="javascript:void(0)">
            <h3><?php echo trans('frontend.design_tools_work_order_top_label'); ?></h3>
            <p><?php echo trans('frontend.design_tools_work_order_bottom_label'); ?></p>
          </a>
        </div>
        <div class="featureblock ftls">
          <div class="featureimg"></div>
          <a class="last orange feature" href="javascript:void(0)">
            <h3><?php echo trans('frontend.design_tools_work_receive_top_label'); ?></h3>
            <p><?php echo trans('frontend.design_tools_work_receive_bottom_label'); ?></p>
          </a>
        </div>
      </div>  
    </div>
  </div>
    
  <?php if(!empty($appearance_all_data['home_details']['collection_cat_list']) && count($appearance_all_data['home_details']['collection_cat_list']) > 0): ?>
  <div class="row">
    <div id="categories_collection" class="categories-collection">
      <?php $__currentLoopData = $appearance_all_data['home_details']['collection_cat_list']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collection_cat_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($collection_cat_details['status'] == 1): ?>
        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
          <div class="category">
            <a href="<?php echo e(route('categories-page', $collection_cat_details['slug'])); ?>">
              <?php if(!empty($collection_cat_details['category_img_url'])): ?>  
              <img class="img-responsive" src="<?php echo e(get_image_url($collection_cat_details['category_img_url'])); ?>">
              <?php else: ?>
              <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>">
              <?php endif; ?>
              <div class="category-collection-mask"></div>
              <h3 class="category-title"><?php echo $collection_cat_details['name']; ?> <span><?php echo trans('frontend.collection_label'); ?></span></h3>
            </a>
          </div>
        </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="clear_both"></div>
  </div>
  <?php endif; ?>
    
  <?php if(!empty($appearance_all_data['home_details']['cat_name_and_products']) && count($appearance_all_data['home_details']['cat_name_and_products']) > 0): ?>  
    <div class="row">
      <div class="top-cat-content">
      <?php $__currentLoopData = $appearance_all_data['home_details']['cat_name_and_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
          <div class="single-mini-box2">
            <div class="top-cat-list-sub clearfix">
              <div class="img-div">
                <?php if(!empty($cat_details['cat_deails']['category_img_url'])): ?>  
                <img class="img-responsive" src="<?php echo e(get_image_url($cat_details['cat_deails']['category_img_url'])); ?>">
                <?php else: ?>
                <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>">
                <?php endif; ?>
              </div>  
              <div class="img-title">
                <h4><?php echo trans('frontend.super_deal_label'); ?></h4>  
                <h2><?php echo $cat_details['cat_deails']['name']; ?></h2>
                <span><?php echo trans('frontend.exclusive_collection_label'); ?></span>
                <div class="cat-shop-now">
                  <a href="<?php echo e(route('categories-page', $cat_details['cat_deails']['slug'])); ?>"><?php echo trans('frontend.shop_now_label'); ?></a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php if($cat_details['cat_products']->count() > 0): ?>
          <?php $__currentLoopData = $cat_details['cat_products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
              <div class="single-mini-box2">
                <div class="hover-product">
                  <div class="hover">
                    <?php if(!empty( $items->image_url )): ?> 
                      <img class="img-responsive" src="<?php echo e(get_image_url( $items->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $items->image_url ) )); ?>" />
                    <?php else: ?>
                      <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                    <?php endif; ?>
                    <div class="overlay">
                      <div class="overlay-content">
                        <button class="info quick-view-popup" data-id="<?php echo e($items->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>  
                        <h2><?php echo $items->title; ?></h2> 
                        <?php if( $items->type == 'simple_product' ): ?>
                          <h3><?php echo price_html( $items->price, get_frontend_selected_currency() ); ?></h3>
                        <?php elseif( $items->type == 'configurable_product'): ?>
                          <h3><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $items->id); ?></h3>
                        <?php elseif( $items->type == 'customizable_product' || $items->type == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($items->id))>0): ?>
                            <h3><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $items->id); ?></h3>
                          <?php else: ?>
                            <h3><?php echo price_html( $items->price, get_frontend_selected_currency() ); ?></h3>
                          <?php endif; ?>
                        <?php endif; ?>
                        <ul>
                          <?php if( $items->type == 'simple_product' ): ?>   
                            <li><a href="" data-id="<?php echo e($items->id); ?>" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                            <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                            <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                            <?php elseif( $items->type == 'configurable_product' ): ?>
                              <li><a href="<?php echo e(route( 'details-page', $items->slug )); ?>" class="select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a></li>
                              <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                              <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                              <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                            <?php elseif( $items->type == 'customizable_product'): ?>  
                              <?php if(is_design_enable_for_this_product( $items->id )): ?>
                                <li><a href="<?php echo e(route('customize-page', $items->slug)); ?>" class="product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a></li>
                                <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                                <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                                <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                              <?php else: ?>
                                  <li><a href="" data-id="<?php echo e($items->id); ?>" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                                  <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                                  <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                                  <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                              <?php endif; ?>
                            <?php elseif( $items->type == 'downloadable_product' ): ?> 
                            
                              <?php if(count(get_product_variations($items->id))>0): ?>
                                <li><a href="<?php echo e(route( 'details-page', $items->slug )); ?>" class="select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a></li>
                              <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                              <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                              <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                              <?php else: ?>
                                <li><a href="" data-id="<?php echo e($items->id); ?>" class="add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a></li>
                            <li><a href="" class="product-wishlist" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a></li>
                            <li><a href="" class="product-compare" data-id="<?php echo e($items->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a></li>
                            <li><a href="<?php echo e(route('details-page', $items->slug )); ?>" class="product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a></li>
                              <?php endif; ?>  
                            <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </div>
              </div>    
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <div class="clear_both"></div> <br><br>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>    
  <?php endif; ?>
  
  <div class="row">
    <div id="latest" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2> <span><?php echo trans('frontend.latest_label'); ?></span></h2> 
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
          <?php if(count($advancedData['latest_items']) > 0): ?>
          <div id="slider-carousel-latest" class="carousel slide" data-ride="carousel">
            <?php $latest_numb = 1;?>
            <div class="carousel-inner">
              <?php $__currentLoopData = $advancedData['latest_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $latest_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($latest_numb == 1): ?>
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($latest_product->image_url)): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $latest_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $latest_product->image_url ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($latest_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $latest_product->title; ?></h3>

                        <?php if( $latest_product->type == 'simple_product' ): ?>
                          <p><?php echo price_html( $latest_product->price, get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $latest_product->type == 'configurable_product'): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id); ?></p>
                        <?php elseif( $latest_product->type == 'customizable_product' || $latest_product->type == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($latest_product->id))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $latest_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          <?php if( $latest_product->type == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $latest_product->type == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $latest_product->type == 'customizable_product' ): ?>
                            <?php if(is_design_enable_for_this_product($latest_product->id)): ?>
                              <a href="<?php echo e(route('customize-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>

                          <?php elseif( $latest_product->type == 'downloadable_product' ): ?> 
                            <?php if(count(get_product_variations( $latest_product->id ))>0): ?>
                            <a href="<?php echo e(route( 'details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                            <a href="<?php echo e(route('details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php else: ?>
                            <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                            <a href="<?php echo e(route('details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>  
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>  
                <?php else: ?>
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($latest_product->image_url)): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $latest_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $latest_product->image_url ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($latest_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $latest_product->title; ?></h3>

                        <?php if( $latest_product->type == 'simple_product' ): ?>
                          <p><?php echo price_html( $latest_product->price, get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $latest_product->type == 'configurable_product' ): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id); ?></p>
                        <?php elseif( $latest_product->type == 'customizable_product' || $latest_product->type == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($latest_product->id))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $latest_product->id); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $latest_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>

                        <div class="single-product-add-to-cart">
                          <?php if( $latest_product->type == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $latest_product->type == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $latest_product->type == 'customizable_product'): ?>
                            <?php if(is_design_enable_for_this_product($latest_product->id)): ?>
                              <a href="<?php echo e(route('customize-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $latest_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>
                          <?php elseif( $latest_product->type == 'downloadable_product'): ?> 
                            <?php if(count(get_product_variations( $latest_product->id ))>0): ?>
                            <a href="<?php echo e(route( 'details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                            <a href="<?php echo e(route('details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php else: ?>
                            <a href="" data-id="<?php echo e($latest_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($latest_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                            <a href="<?php echo e(route('details-page', $latest_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>    
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <?php $latest_numb ++ ;?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>  
          </div>
          <?php else: ?>
            <p class="not-available"><?php echo trans('frontend.latest_products_empty_label'); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>   
  
    <div id="best-sales" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2> <span><?php echo trans('frontend.best_sales_label'); ?></span></h2>  
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
          <?php if(count($advancedData['best_sales']) > 0): ?>
          <div id="slider-carousel-best-sales" class="carousel slide" data-ride="carousel">
            <?php $best_sales_numb = 1;?>
            <div class="carousel-inner">
              <?php $__currentLoopData = $advancedData['best_sales']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $best_sales_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($best_sales_numb == 1): ?>
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($best_sales_product['post_image_url'])): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $best_sales_product['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $best_sales_product['post_image_url'] ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($best_sales_product['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $best_sales_product['post_title']; ?></h3>

                        <?php if( $best_sales_product['post_type'] == 'simple_product' ): ?>
                          <p><?php echo price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $best_sales_product['post_type'] == 'configurable_product' ): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']); ?></p>
                        <?php elseif( $best_sales_product['post_type'] == 'customizable_product' || $best_sales_product['post_type'] == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($best_sales_product['id']))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>
                        
                        <div class="single-product-add-to-cart">
                          <?php if( $best_sales_product['post_type'] == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $best_sales_product['post_type'] == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $best_sales_product['post_type'] == 'customizable_product' ): ?>
                            <?php if(is_design_enable_for_this_product($best_sales_product['id'])): ?>
                              <a href="<?php echo e(route('customize-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>
                              
                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>
                            <?php elseif( $best_sales_product['post_type'] == 'downloadable_product' ): ?>  
                                <?php if(count(get_product_variations( $best_sales_product['id'] ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>        
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>  
                <?php else: ?>
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($best_sales_product['post_image_url'])): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $best_sales_product['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $best_sales_product['post_image_url'] ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($best_sales_product['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $best_sales_product['post_title']; ?></h3>

                        <?php if( $best_sales_product['post_type'] == 'simple_product' ): ?>
                          <p><?php echo price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $best_sales_product['post_type'] == 'configurable_product' ): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']); ?></p>
                        <?php elseif( $best_sales_product['post_type'] == 'customizable_product' || $best_sales_product['post_type'] == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($best_sales_product['id']))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $best_sales_product['id']); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $best_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>
                        
                        <div class="single-product-add-to-cart">
                          <?php if( $best_sales_product['post_type'] == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $best_sales_product['post_type'] == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                            <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $best_sales_product['post_type'] == 'customizable_product' ): ?>
                            <?php if(is_design_enable_for_this_product($best_sales_product['id'])): ?>
                              <a href="<?php echo e(route('customize-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>
                              
                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>
                            <?php elseif( $best_sales_product['post_type'] == 'downloadable_product' ): ?> 
                              <?php if(count(get_product_variations( $best_sales_product['id'] ))>0): ?>
                              <a href="<?php echo e(route( 'details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php else: ?>
                              <a href="" data-id="<?php echo e($best_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $best_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>          
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <?php $best_sales_numb ++ ;?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <?php else: ?>
            <p class="not-available"><?php echo trans('frontend.best_sales_products_empty_label'); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div>  
  
    <div id="todays-sales" class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h2><span><?php echo trans('frontend.todays_sale_label'); ?></span></h2>
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
          <?php if(count($advancedData['todays_deal']) > 0): ?>
          <div id="slider-carousel-todays-sales" class="carousel slide" data-ride="carousel">
            <?php $todays_sales_numb = 1;?>
            <div class="carousel-inner">
              <?php $__currentLoopData = $advancedData['todays_deal']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $todays_sales_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($todays_sales_numb == 1): ?>
                  <div class="item active">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($todays_sales_product['post_image_url'])): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $todays_sales_product['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $todays_sales_product['post_image_url'] ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($todays_sales_product['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $todays_sales_product['post_title']; ?></h3>

                        <?php if( $todays_sales_product['post_type'] == 'simple_product' ): ?>
                          <p><?php echo price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $todays_sales_product['post_type'] == 'configurable_product' ): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']); ?></p>
                        <?php elseif( $todays_sales_product['post_type'] == 'customizable_product' || $todays_sales_product['post_type'] == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($todays_sales_product['id']))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>
                        
                        <div class="single-product-add-to-cart">
                          <?php if( $todays_sales_product['post_type'] == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $todays_sales_product['post_type'] == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            
                            <a href="" class="btn btn-md btn-style  product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $todays_sales_product['post_type'] == 'customizable_product' ): ?>
                            <?php if(is_design_enable_for_this_product($todays_sales_product['id'])): ?>
                              <a href="<?php echo e(route('customize-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>
                              
                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>
                            <?php elseif( $todays_sales_product['post_type'] == 'downloadable_product' ): ?>
                              <?php if(count(get_product_variations( $todays_sales_product['id'] ))>0): ?>
                              <a href="<?php echo e(route( 'details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php else: ?>
                              <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>            
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>  
                <?php else: ?>
                  <div class="item">
                    <div class="hover-product">
                      <div class="hover">
                        <?php if(!empty($todays_sales_product['post_image_url'])): ?>
                        <img class="img-responsive" src="<?php echo e(get_image_url( $todays_sales_product['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $todays_sales_product['post_image_url'] ) )); ?>" />
                        <?php else: ?>
                        <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                        <?php endif; ?>

                        <div class="overlay">
                          <button class="info quick-view-popup" data-id="<?php echo e($todays_sales_product['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                        </div>
                      </div> 

                      <div class="single-product-bottom-section">
                        <h3><?php echo $todays_sales_product['post_title']; ?></h3>

                        <?php if( $todays_sales_product['post_type'] == 'simple_product' ): ?>
                          <p><?php echo price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                        <?php elseif( $todays_sales_product['post_type'] == 'configurable_product' ): ?>
                          <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']); ?></p>
                        <?php elseif( $todays_sales_product['post_type'] == 'customizable_product' || $todays_sales_product['post_type'] == 'downloadable_product'): ?>
                          <?php if(count(get_product_variations($todays_sales_product['id']))>0): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $todays_sales_product['id']); ?></p>
                          <?php else: ?>
                            <p><?php echo price_html( $todays_sales_product['post_price'], get_frontend_selected_currency() ); ?></p>
                          <?php endif; ?>
                        <?php endif; ?>

                        <div class="title-divider"></div>
                        
                        <div class="single-product-add-to-cart">
                          <?php if( $todays_sales_product['post_type'] == 'simple_product' ): ?>
                            <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($best_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $todays_sales_product['post_type'] == 'configurable_product' ): ?>
                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                            <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                            <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                          <?php elseif( $todays_sales_product['post_type'] == 'customizable_product '): ?>
                            <?php if(is_design_enable_for_this_product($todays_sales_product['id'])): ?>
                              <a href="<?php echo e(route('customize-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>
                              
                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                            
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                            
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php else: ?>
                              <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                            <?php endif; ?>
                            <?php elseif( $todays_sales_product['post_type'] == 'downloadable_product' ): ?> 
                              <?php if(count(get_product_variations( $todays_sales_product['id'] ))>0): ?>
                              <a href="<?php echo e(route( 'details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php else: ?>
                              <a href="" data-id="<?php echo e($todays_sales_product['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($todays_sales_product['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                              <a href="<?php echo e(route('details-page', $todays_sales_product['post_slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>          
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
                <?php $todays_sales_numb ++ ;?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
          </div>
          <?php else: ?>
            <p class="not-available"><?php echo trans('frontend.todays_products_empty_label'); ?></p>
          <?php endif; ?>
        </div>
      </div>
    </div> 
  </div>    
  <div class="clear_both"></div><br><br>
  
  <div class="row">
    <div class="advanced-products-tab">  
      <ul class="nav nav-tabs">
        <li class="active"><a href="#featured_items" data-toggle="tab"><?php echo trans('frontend.featured_products_label'); ?></a></li>
        <li><a href="#recommended_items" data-toggle="tab"><?php echo trans('frontend.recommended_items'); ?></a></li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane active" id="featured_items" >  
          <?php if(count($advancedData['features_items']) > 0): ?>
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
              <?php $__currentLoopData = $advancedData['features_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $features_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($features_numb == 1): ?>
                    <?php if($features_flag == 1): ?>
                      <div class="item active">
                    <?php else: ?>
                      <div class="item">
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($features_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $features_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $features_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($features_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $features_product->title; ?></h3>

                          <?php if( $features_product->type == 'simple_product' ): ?>
                            <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $features_product->type == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                          <?php elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($features_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $features_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($features_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $features_product->type == 'downloadable_product' ): ?> 
                                <?php if(count(get_product_variations( $features_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>              
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_features = false;?>
                  <?php elseif($features_numb == 4): ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($features_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $features_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $features_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($features_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $features_product->title; ?></h3>

                          <?php if( $features_product->type == 'simple_product' ): ?>
                            <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $features_product->type == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                          <?php elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product' ): ?>
                            <?php if(count(get_product_variations($features_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $features_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($features_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $features_product->type == 'downloadable_product' ): ?> 
                                <?php if(count(get_product_variations( $features_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->id )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>                
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $features_numb = 0; $is_last_tag_added_for_features = true;?>
                    </div>
                  <?php else: ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($features_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $features_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $features_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($features_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $features_product->title; ?></h3>

                          <?php if( $features_product->type == 'simple_product' ): ?>
                            <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $features_product->type  == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                          <?php elseif( $features_product->type == 'customizable_product' || $features_product->type == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($features_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $features_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $features_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $features_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $features_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($features_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $features_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $features_product->type == 'downloadable_product' ): ?> 
                                <?php if(count(get_product_variations( $features_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($features_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($features_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $features_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>                  
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_features = false;?>
                  <?php endif; ?>

                  <?php 
                   $features_numb++;
                   $features_flag++;
                  ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(!$is_last_tag_added_for_features): ?>
                  </div>
                <?php endif; ?>
            </div>                
          </div>
          <?php endif; ?>
        </div>

        <div class="tab-pane" id="recommended_items">
          <?php if(count($advancedData['recommended_items']) > 0): ?>
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
              <?php $__currentLoopData = $advancedData['recommended_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $recommended_product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($recommended_numb == 1): ?>
                    <?php if($recommended_flag == 1): ?>
                      <div class="item active">
                    <?php else: ?>
                      <div class="item">
                    <?php endif; ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($recommended_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $recommended_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $recommended_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($recommended_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $recommended_product->title; ?></h3>

                          <?php if( $recommended_product->type == 'simple_product' ): ?>
                            <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                          <?php elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($recommended_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $recommended_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($recommended_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $recommended_product->type == 'downloadable_product' ): ?>  
                                <?php if(count(get_product_variations( $recommended_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>                 
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_recommended = false;?>
                  <?php elseif($recommended_numb == 4): ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($recommended_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $recommended_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $recommended_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($recommended_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $recommended_product->title; ?></h3>

                          <?php if( $recommended_product->type == 'simple_product' ): ?>
                            <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                          <?php elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($recommended_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $recommended_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($recommended_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $recommended_product->type == 'downloadable_product' ): ?> 
                                <?php if(count(get_product_variations( $recommended_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>                   
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $recommended_numb = 0; $is_last_tag_added_for_recommended = true;?>
                    </div>
                  <?php else: ?>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 extra-padding">
                      <div class="hover-product">
                        <div class="hover">
                          <?php if(!empty($recommended_product->image_url)): ?>
                          <img class="img-responsive" src="<?php echo e(get_image_url( $recommended_product->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $recommended_product->image_url ) )); ?>" />
                          <?php else: ?>
                          <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>

                          <div class="overlay">
                            <button class="info quick-view-popup" data-id="<?php echo e($recommended_product->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                          </div>
                        </div> 

                        <div class="single-product-bottom-section">
                          <h3><?php echo $recommended_product->title; ?></h3>

                          <?php if( $recommended_product->type == 'simple_product'): ?>
                            <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                          <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                            <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                          <?php elseif( $recommended_product->type == 'customizable_product' || $recommended_product->type == 'downloadable_product' ): ?>
                            <?php if(count(get_product_variations($recommended_product->id))>0): ?>
                              <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $recommended_product->id); ?></p>
                            <?php else: ?>
                              <p><?php echo price_html( $recommended_product->price, get_frontend_selected_currency() ); ?></p>
                            <?php endif; ?>
                          <?php endif; ?>

                          <div class="title-divider"></div>
                          <div class="single-product-add-to-cart">
                            <?php if( $recommended_product->type == 'simple_product' ): ?>
                              <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'configurable_product' ): ?>
                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>

                              <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                              <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                              <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                            <?php elseif( $recommended_product->type == 'customizable_product' ): ?>
                              <?php if(is_design_enable_for_this_product($recommended_product->id)): ?>
                                <a href="<?php echo e(route('customize-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>

                                <a href="" class="btn btn-sm btn-style  product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>

                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                              <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>

                                <a href="<?php echo e(route('details-page', $recommended_product->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                              <?php endif; ?>
                              <?php elseif( $recommended_product->type == 'downloadable_product' ): ?> 
                                <?php if(count(get_product_variations( $recommended_product->id ))>0): ?>
                                <a href="<?php echo e(route( 'details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php else: ?>
                                <a href="" data-id="<?php echo e($recommended_product->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                                <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($recommended_product->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                                <a href="<?php echo e(route('details-page', $recommended_product->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                                <?php endif; ?>                       
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <?php $is_last_tag_added_for_recommended = false;?>
                  <?php endif; ?>

                  <?php 
                   $recommended_numb++;
                   $recommended_flag++;
                  ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php if(!$is_last_tag_added_for_recommended): ?>
                  </div>
                <?php endif; ?>
            </div>                
          </div> 
          <?php endif; ?>
        </div>          				
      </div>
    </div> 
  </div>    
  
  <?php if(count($testimonials_data) > 0): ?>
  <div class="row">
    <div class="testimonials-slider">
      <div class="content-title text-center">
        <h2> <span><?php echo trans('frontend.testimonials_label'); ?></span></h2>
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
      <?php $__currentLoopData = $testimonials_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($numb == 0): ?>
          <div class="item active">
            <div class="col-xs-12 col-sm-2 col-sm-offset-3">
              <div class="testimonials-img text-right">
                <?php if(!empty($row['testimonial_image_url'])): ?>
                <img src="<?php echo e(get_image_url($row['testimonial_image_url'])); ?>" alt="" width="170" height="169">
                <?php else: ?>
                <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" width="170" height="169">
                <?php endif; ?>
              </div>
            </div>
            <div class="col-xs-12 col-sm-5">
              <div class="testimonials-text">
                <h2><?php echo $row['post_title']; ?></h2>
                <p><?php echo get_limit_string( string_decode($row['post_content']), 200); ?></p>
                <a href="<?php echo e(route('testimonial-single-page', $row['post_slug'])); ?>" class="btn btn-sm testimonials-read"><?php echo trans('frontend.read_more_label'); ?></a>
              </div>
            </div>
          </div>
        <?php else: ?>
          <div class="item">
            <div class="row">
              <div class="col-xs-12 col-sm-2 col-sm-offset-3">
                <div class="testimonials-img text-right">
                  <?php if(!empty($row['testimonial_image_url'])): ?>
                  <img src="<?php echo e(get_image_url($row['testimonial_image_url'])); ?>" alt="" width="170" height="169">
                  <?php else: ?>
                  <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" width="170" height="169">
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-xs-12 col-sm-5">
                <div class="testimonials-text">
                  <h2><?php echo $row['post_title']; ?></h2>
                  <p><?php echo get_limit_string(string_decode($row['post_content']), 200); ?></p>
                  <a href="<?php echo e(route('testimonial-single-page', $row['post_slug'])); ?>" class="btn btn-sm testimonials-read"><?php echo trans('frontend.read_more_label'); ?></a>
                </div>
              </div>
            </div>
          </div>
        <?php endif; ?>
        <?php $numb ++ ;?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    </div>
  </div>  
  <?php endif; ?>  
  
  <?php if(count($blogs_data) > 0): ?>
  <div class="row">
    <div class="recent-blog">
      <div class="content-title text-center">
        <h2> <span><?php echo trans('frontend.latest_from_the_blog'); ?></span></h2>
      </div>
      <div class="recent-blog-content">
        <?php $__currentLoopData = $blogs_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4  blog-box extra-padding">
          <div class="custom-mask">
            <a href="<?php echo e(route('blog-single-page', $rows['post_slug'])); ?>">
              <?php if(!empty($rows['blog_image'])): ?>
              <img class="img-responsive" src="<?php echo e(get_image_url($rows['blog_image'])); ?>"  alt="<?php echo e(basename( $rows['blog_image'] )); ?>">
              <?php else: ?>
              <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>"  alt="no image">
              <?php endif; ?>
              <div class="blog-bottom-text">
                <p class="blog-title"><?php echo e($rows['post_title']); ?></p>
                <p><span class="blog-date"><i class="fa fa-calendar"></i>&nbsp; <?php echo e(Carbon\Carbon::parse($rows['created_at'])->format('d F, Y')); ?></span>&nbsp;&nbsp;<span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; <?php echo $rows['comments_details']['total']; ?> <?php echo trans('frontend.comments_label'); ?></span></p>
              </div>
            </a>
          </div>      
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>    
  <?php endif; ?>
    
  <div class="row">
    <div class="brands-list">
      <div class="content-title text-center">
        <h2> <span><?php echo trans('frontend.brands'); ?></span></h2>
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
        <?php if(count($brands_data) > 0): ?>
          <div id="slider-carousel-brands" class="carousel slide" data-ride="carousel">
          <?php $brands_numb =1; $brands_flag =1; $is_last_tag_added_for_brands = false;?>
          <div class="carousel-inner">    
            <?php $__currentLoopData = $brands_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if($brands_numb == 1): ?>
                <?php if($brands_flag == 1): ?>
                <div class="item active">
                <?php else: ?>
                <div class="item">
                <?php endif; ?>

                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                  <div class="brands-images">  
                    <?php if(!empty($brand['brand_logo_img_url'])): ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(get_image_url($brand['brand_logo_img_url'])); ?>" alt="<?php echo e(basename($brand['brand_logo_img_url'])); ?>" /></a>
                    <?php else: ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(default_placeholder_img_src()); ?>" alt="" /></a>
                    <?php endif; ?>
                  </div>
                </div>
                <?php $is_last_tag_added_for_brands = false;?>
              <?php elseif($brands_numb == 6): ?>  
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                  <div class="brands-images">   
                    <?php if(!empty($brand['brand_logo_img_url'])): ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(get_image_url($brand['brand_logo_img_url'])); ?>" alt="<?php echo e(basename($brand['brand_logo_img_url'])); ?>" /></a>
                    <?php else: ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(default_placeholder_img_src()); ?>" alt="" /></a>
                    <?php endif; ?>
                  </div>
                </div>
                <?php $brands_numb = 0; $is_last_tag_added_for_brands = true;?>
                </div>
              <?php else: ?>  
                <div class="col-xs-6 col-sm-6 col-md-2 col-lg-2 extra-padding">
                  <div class="brands-images">  
                    <?php if($brand['brand_logo_img_url']): ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(get_image_url($brand['brand_logo_img_url'])); ?>" alt="<?php echo e(basename($brand['brand_logo_img_url'])); ?>" /></a>
                    <?php else: ?>
                    <a href="<?php echo e(route('brands-single-page', $brand['slug'])); ?>"><img  src="<?php echo e(default_placeholder_img_src()); ?>" alt="" /></a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php $is_last_tag_added_for_brands = false;?>
              <?php endif; ?>

              <?php 
               $brands_numb++;
               $brands_flag++;
              ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <?php if(!$is_last_tag_added_for_brands): ?>
              </div>
            <?php endif; ?>
            </div> 
          </div>  
        <?php endif; ?>
      </div>  
    </div>    
  </div>    
</div>