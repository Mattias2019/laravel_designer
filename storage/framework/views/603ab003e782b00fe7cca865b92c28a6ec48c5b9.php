<a href="" class="main show-mini-cart"> <span class="hidden-xs"><?php echo trans('frontend.menu_my_cart'); ?></span> <span class="hidden-sm hidden-md hidden-lg fa fa-shopping-cart fa-lg"></span> <span class="cart-count"><span id="total_count_by_ajax"><?php echo Cart::count(); ?></span></span></a>
<div id="list_popover" class="bottom">
  <div class="arrow"></div>
  <?php if( Cart::count() >0 ): ?>
    <div id="cd-cart">
      <h2><?php echo trans('frontend.mini_cart_label_cart'); ?></h2>
      <ul class="cd-cart-items">
        <?php $__currentLoopData = Cart::items(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <span class="cd-qty"><?php echo $items->quantity; ?>x</span>&nbsp;<?php echo $items->name; ?>

            <div class="cd-price"><?php echo price_html( get_product_price_html_by_filter( Cart::getRowPrice($items->quantity, get_role_based_price_by_product_id($items ->id, $items->price))) ); ?></div>
            <a href="<?php echo e(route('removed-item-from-cart', $index)); ?>" class="cd-item-remove cd-img-replace cart_quantity_delete"></a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>

      <div class="cd-cart-total">
        <p><?php echo trans('frontend.total'); ?> <span><?php echo price_html( get_product_price_html_by_filter(Cart::getTotal()) ); ?></span></p>
      </div>

      <a href="<?php echo e(route('checkout-page')); ?>" class="checkout-btn"><?php echo trans('frontend.checkout'); ?></a>
    </div>
  <?php else: ?>
    <div class="empty-cart-msg"><?php echo e(trans('frontend.empty_cart_msg')); ?></div>
  <?php endif; ?>
</div>