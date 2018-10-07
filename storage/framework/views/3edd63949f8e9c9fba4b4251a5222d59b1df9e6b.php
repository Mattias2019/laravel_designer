<?php $__env->startSection('categories-products-content'); ?>
  <?php if(count($product_by_cat_id['products'])>0): ?>
    <?php if($product_by_cat_id['selected_view'] == 'grid'): ?>
      <div class="categories-products-content clearfix">
        <?php $__currentLoopData = $product_by_cat_id['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12 col-sm-6 col-md-6 extra-padding">
          <div class="hover-product">
            <div class="hover">
              <?php if(get_product_image($products['id'])): ?>
              <img class="img-responsive" src="<?php echo e(get_image_url(get_product_image($products['id']))); ?>" alt="<?php echo e(basename(get_product_image($products['id']))); ?>" />
              <?php else: ?>
              <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
              <?php endif; ?>

              <div class="overlay">
                <button class="info quick-view-popup" data-id="<?php echo e($products['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
              </div>
            </div> 
            
            <div class="single-product-bottom-section">
              <h3><?php echo get_product_title($products['id']); ?></h3>
              
              <?php if(get_product_type($products['id']) == 'simple_product'): ?>
                <p><?php echo price_html( get_product_price($products['id']), get_frontend_selected_currency() ); ?></p>
              <?php elseif(get_product_type($products['id']) == 'configurable_product'): ?>
                <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']); ?></p>
              <?php elseif(get_product_type($products['id']) == 'customizable_product' || get_product_type($products['id']) == 'downloadable_product'): ?>
                <?php if(count(get_product_variations($products['id']))>0): ?>
                  <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']); ?></p>
                <?php else: ?>
                  <p><?php echo price_html( get_product_price($products['id']), get_frontend_selected_currency() ); ?></p>
                <?php endif; ?>
              <?php endif; ?>
              
              <div class="title-divider"></div>
              <div class="single-product-add-to-cart">
                <?php if(get_product_type($products['id']) == 'simple_product'): ?>
                  <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                  <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                <?php elseif(get_product_type($products['id']) == 'configurable_product'): ?>
                  <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                  <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                <?php elseif(get_product_type($products['id']) == 'customizable_product'): ?>
                  <?php if(is_design_enable_for_this_product($products['id'])): ?>
                    <a href="<?php echo e(route('customize-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-gears"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                  <?php else: ?>
                    <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                  <?php endif; ?>
                <?php elseif(get_product_type( $products['id'] ) == 'downloadable_product'): ?> 
                  <?php if(count(get_product_variations( $products['id'] ))>0): ?>
                  <a href="<?php echo e(route( 'details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                  <a href="<?php echo e(route('details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                  <?php else: ?>
                  <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                  <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                  <a href="<?php echo e(route('details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                  <?php endif; ?>             
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
    
    <?php if($product_by_cat_id['selected_view'] == 'list'): ?>
      <div class="row">
        <?php $__currentLoopData = $product_by_cat_id['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="col-md-12">
            <div class="box effect list-view-box">
              <div class="col-md-5">
                <div class="list-view-image-container">
                  <?php if(get_product_image($products['id'])): ?>
                    <img class="img-responsive" src="<?php echo e(get_image_url(get_product_image($products['id']))); ?>" alt="<?php echo e(basename(get_product_image($products['id']))); ?>" />
                  <?php else: ?>
                    <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                  <?php endif; ?>
                  <div class="overlay">
                    <button class="info quick-view-popup" data-id="<?php echo e($products['id']); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                  </div>
                </div>
              </div>
              <div class="col-md-7">
                <h3><?php echo get_product_title($products['id']); ?></h3>
                
                <?php if(get_product_type($products['id']) == 'simple_product'): ?>
                  <p><?php echo price_html( get_product_price($products['id']), get_frontend_selected_currency() ); ?></p>
                <?php elseif(get_product_type($products['id']) == 'configurable_product'): ?>
                  <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']); ?></p>
                <?php elseif(get_product_type($products['id']) == 'customizable_product' || get_product_type($products['id']) == 'downloadable_product'): ?>
                  <?php if(count(get_product_variations($products['id']))>0): ?>
                    <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products['id']); ?></p>
                  <?php else: ?>
                    <p><?php echo price_html( get_product_price($products['id']), get_frontend_selected_currency() ); ?></p>
                  <?php endif; ?>
                <?php endif; ?>
                
                <div class="title-divider"></div>
                <br>
                <div class="single-product-add-to-cart">
                  <?php if(get_product_type($products['id']) == 'simple_product'): ?>
                    <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                  <?php elseif(get_product_type($products['id']) == 'configurable_product'): ?>
                    <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                  <?php elseif(get_product_type($products['id']) == 'customizable_product'): ?>
                    <?php if(is_design_enable_for_this_product($products['id'])): ?>
                      <a href="<?php echo e(route('customize-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.customize')); ?>"><i class="fa fa-gears"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                      <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                    <?php else: ?>
                      <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                      <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                      <a href="<?php echo e(route('details-page', $products['slug'])); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                    <?php endif; ?>
                  <?php elseif(get_product_type( $products['id'] ) == 'downloadable_product'): ?> 
                    <?php if(count(get_product_variations( $products['id'] ))>0): ?>
                    <a href="<?php echo e(route( 'details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                    <?php else: ?>
                    <a href="" data-id="<?php echo e($products['id']); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                    <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products['id']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                    <a href="<?php echo e(route('details-page', $products['slug'] )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                    <?php endif; ?>             
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endif; ?>
    <div class="col-md-12">
      <div class="products-pagination"><?php echo $product_by_cat_id['products']->appends(Request::capture()->except('page'))->render(); ?></div>
    </div>
  <?php else: ?>
    <div class="col-md-12">
      <div class="alert-msg"><span><?php echo e(trans('frontend.no_product_of_this_category')); ?></span> </div>
    </div>
  <?php endif; ?>
<?php $__env->stopSection(); ?>