<?php $__env->startSection('title',  trans('frontend.tag_details_page_label') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
<br>
<div class="container new-container">
  <div id="tag_single_page_main">
    <div class="row">
      <div class="col-md-4 extra-padding">
        <?php if(count($popular_tags_list) > 0): ?>
        <div class="tags-product-list">
          <h2><?php echo e(trans('frontend.popular_tags_label')); ?> <span class="responsive-accordian"></span></h2>
          <div class="tag-list">
            <ul>
              <?php $__currentLoopData = $popular_tags_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($tags['slug'] == $tag_single_details['tag_details']['slug']): ?>
                  <li><a class="tag-active" href="<?php echo e(route('tag-single-page', $tags['slug'])); ?>"><i class="fa fa-angle-right"></i> <?php echo e(ucfirst($tags['name'])); ?></a></li>
                <?php else: ?>
                  <li><a href="<?php echo e(route('tag-single-page', $tags['slug'])); ?>"><i class="fa fa-angle-right"></i> <?php echo e(ucfirst($tags['name'])); ?></a></li>
                <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <div class="col-md-8">
        <?php if($tag_single_details['products']->count() > 0): ?>
          <div class="product-content clearfix">
            <?php $__currentLoopData = $tag_single_details['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-xs-12 col-sm-6 col-md-6 extra-padding">
                <div class="hover-product">
                  <div class="hover">
                    <?php if(get_product_image($products->id)): ?>
                    <img class="img-responsive" src="<?php echo e(get_image_url(get_product_image($products->id))); ?>" alt="<?php echo e(basename(get_product_image($products->id))); ?>" />
                    <?php else: ?>
                    <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                    <?php endif; ?>

                    <div class="overlay">
                      <button class="info quick-view-popup" data-id="<?php echo e($products->id); ?>"><?php echo e(trans('frontend.quick_view_label')); ?></button>
                    </div>
                  </div> 

                  <div class="single-product-bottom-section">
                    <h3><?php echo get_product_title($products->id); ?></h3>

                    <?php if(get_product_type($products->id) == 'simple_product'): ?>
                      <p><?php echo price_html( get_product_price($products->id), get_frontend_selected_currency() ); ?></p>
                    <?php elseif(get_product_type($products->id) == 'configurable_product'): ?>
                      <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id); ?></p>
                    <?php elseif(get_product_type($products->id) == 'customizable_product' || get_product_type($products->id) == 'downloadable_product'): ?>
                      <?php if(count(get_product_variations($products->id))>0): ?>
                        <p><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products->id); ?></p>
                      <?php else: ?>
                        <p><?php echo price_html( get_product_price($products->id), get_frontend_selected_currency() ); ?></p>
                      <?php endif; ?>
                    <?php endif; ?>

                    <div class="title-divider"></div>
                    <div class="single-product-add-to-cart">
                      <?php if(get_product_type($products->id) == 'simple_product'): ?>
                        <a href="" data-id="<?php echo e($products->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                        <a href="<?php echo e(route('details-page', $products->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                      <?php elseif(get_product_type($products->id) == 'configurable_product'): ?>
                        <a href="<?php echo e(route('details-page', $products->slug)); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                        <a href="<?php echo e(route('details-page', $products->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                      <?php elseif(get_product_type($products->id) == 'customizable_product'): ?>
                        <?php if(is_design_enable_for_this_product($products->id)): ?>
                          <a href="<?php echo e(route('customize-page', $products->slug)); ?>" class="btn btn-sm btn-style product-customize-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-gears"></i></a>
                          <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                          <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                          <a href="<?php echo e(route('details-page', $products->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>

                        <?php else: ?>
                          <a href="" data-id="<?php echo e($products->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                          <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                          <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange"></i></a>
                          <a href="<?php echo e(route('details-page', $products->slug)); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                        <?php endif; ?>
                      <?php elseif(get_product_type( $products->id ) == 'downloadable_product'): ?> 
                        <?php if(count(get_product_variations( $products->id ))>0): ?>
                        <a href="<?php echo e(route( 'details-page', $products->slug )); ?>" class="btn btn-sm btn-style select-options-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.select_options')); ?>"><i class="fa fa-hand-o-up"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                        <a href="<?php echo e(route('details-page', $products->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                        <?php else: ?>
                        <a href="" data-id="<?php echo e($products->id); ?>" class="btn btn-sm btn-style add-to-cart-bg" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_cart_label')); ?>"><i class="fa fa-shopping-cart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-wishlist" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_wishlist_label')); ?>"><i class="fa fa-heart"></i></a>
                        <a href="" class="btn btn-sm btn-style product-compare" data-id="<?php echo e($products->id); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.add_to_compare_list_label')); ?>"><i class="fa fa-exchange" ></i></a>
                        <a href="<?php echo e(route('details-page', $products->slug )); ?>" class="btn btn-sm btn-style product-details-view" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.product_details_label')); ?>"><i class="fa fa-eye"></i></a>
                        <?php endif; ?>                         
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
          <div class="products-pagination"><?php echo $tag_single_details['products']->appends(Request::capture()->except('page'))->render(); ?></div>
        <?php else: ?>
        <br><p><?php echo e(trans('frontend.no_product_for_tag_label')); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>