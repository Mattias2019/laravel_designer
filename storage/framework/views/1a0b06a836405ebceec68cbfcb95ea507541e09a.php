<div class="extra-margin-top-for-content"></div>
<div id="cart_page" class="container">
  <?php if( Cart::count() >0 ): ?>
  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">  
    
    <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-centered clearfix">
      <h2 class="cart-shopping-label"><?php echo e(trans('frontend.shopping_cart')); ?></h2>
      
      <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <ul class="cart-data">
        <li class="row list-inline columnCaptions">
          <div class="header-items"><?php echo trans('frontend.cart_item'); ?></div>
          <div class="header-price"><?php echo trans('frontend.price'); ?></div>
          <div class="header-qty"><?php echo trans('frontend.quantity'); ?></div>
          <div class="header-line-total last-total"><?php echo trans('frontend.total'); ?></div>
        </li>
        <?php $__currentLoopData = Cart::items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="row items-inline">
            <div class="itemName">
              <?php if($items->img_src): ?>
                <div class="product-img">
                  <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>">
                    <img src="<?php echo e(get_image_url($items->img_src)); ?>" alt="product">
                  </a>
                </div>
              <?php else: ?>
                <div class="product-img">
                  <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>">
                    <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="no_image">
                  </a>
                </div>
              <?php endif; ?>
              <div class="item-name">
                <a href="<?php echo e(route('details-page', get_product_slug($items->id))); ?>"><?php echo $items->name; ?></a>
                <?php $count = 1; ?>
                <?php if(count($items->options) > 0): ?>
                <p>
                  <?php $__currentLoopData = $items->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($count == count($items->options)): ?>
                      <?php echo $key .' &#8658; '. $val; ?>

                    <?php else: ?>
                      <?php echo $key .' &#8658; '. $val. ' , '; ?>

                    <?php endif; ?>
                    <?php $count ++ ; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </p>
                <?php endif; ?>
                
                <?php if(get_product_type($items->id) === 'customizable_product'): ?>
                  <?php if($items->acces_token): ?>
                    <?php if(count(get_customize_images_by_access_token($items->acces_token))>0): ?>
                      <button class="btn btn-block btn-sm view-customize-images" data-images="<?php echo e(json_encode( get_customize_images_by_access_token($items->acces_token) )); ?>"><?php echo e(trans('frontend.design_images')); ?></button>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
                
                <?php if( count(get_vendor_details_by_product_id($items->product_id)) >0 ): ?>
                <p class="vendor-title"><strong><?php echo trans('frontend.vendor_label'); ?></strong> : <?php echo get_vendor_name_by_product_id( $items->product_id); ?></p>
                <?php endif; ?>
              </div>
            </div>  
              
            <div class="price"><?php echo price_html( get_product_price_html_by_filter( $items->price ), get_frontend_selected_currency() ); ?></div>
            <div class="quantity"><input type="number" class="form-control cart_quantity_input" name="cart_quantity[<?php echo e($index); ?>]" value="<?php echo e($items->quantity); ?>" min="1"></div>
            <div class="price line-total extra-padding"><?php echo price_html(  get_product_price_html_by_filter(Cart::getRowPrice($items->quantity, $items->price)), get_frontend_selected_currency() ); ?></div>
            <div class="popbtn"><a class="cart_quantity_delete delete-extra-padding" href="<?php echo e(route('removed-item-from-cart', $index)); ?>"><i class="fa fa-close"></i></a></div>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <li class="row cart-button-main">
          <div class="apply-coupon">
            <input type="text" class="form-control" id="apply_coupon_code" name="apply_coupon" placeholder="<?php echo e(trans('frontend.coupon_code_placeholder_text')); ?>">
            <button class="btn btn-primary" name="apply_coupon_post" id="apply_coupon_post"><?php echo trans('frontend.apply_coupon_label'); ?></button>
            <div class="clearfix visible-xs"></div>
          </div>
          <div class="btn-cart-action">
            <input type="submit" name="empty_cart" class="btn btn-primary empty" value="<?php echo e(trans('frontend.empty_cart')); ?>">  
            <input type="submit" name="update_cart" class="btn btn-primary update" value="<?php echo e(trans('frontend.update_cart')); ?>">
          </div>
        </li>
        
        <?php echo $__env->make('pages.ajax-pages.cart-total-html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </ul>
    </div>
  </form>    
  <?php else: ?>
    <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <h2 class="cart-shopping-label2"><?php echo e(trans('frontend.shopping_cart')); ?></h2>
    <div class="empty-cart-msg"><?php echo e(trans('frontend.empty_cart_msg')); ?></div>
    <div class="cart-return-shop"><a class="btn btn-default check_out" href="<?php echo e(route('shop-page')); ?>"><?php echo e(trans('frontend.return_to_shop')); ?></a></div>
  <?php endif; ?>
</div>