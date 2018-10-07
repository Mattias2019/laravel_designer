<div class="variation-view-data-content">
  <div class="variation-view-img">
    <?php if($variation_view_data['_variation_post_img_url']): ?>
    <img src="<?php echo e(get_image_url($variation_view_data['_variation_post_img_url'])); ?>" alt="<?php echo e(basename ($variation_view_data['_variation_post_img_url'])); ?>">
    <?php else: ?> 
    <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="">
    <?php endif; ?>
  </div><hr>
  <div class="variation-view-combination">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.variation_combination')); ?></b></div>
    <div class="variation-view-comnination-list">
      <?php $__currentLoopData = json_decode($variation_view_data['_variation_post_data']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php if(count(json_decode($variation_view_data['_variation_post_data']))-1 == $key): ?>
      <?php echo $val->attr_name .' &#8658; '. $val->attr_val; ?>

      <?php else: ?>
      <?php echo $val->attr_name .' &#8658; '. $val->attr_val . ', '; ?>

      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div><hr>
  <div class="variation-view-enable-status">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.enable_status')); ?></b></div>
    <div class="variation-view-enable-content">
      <?php if($variation_view_data['post_status'] == 1): ?>
      <?php echo e(trans('frontend.yes')); ?>

      <?php else: ?>
      <?php echo e(trans('frontend.no')); ?>

      <?php endif; ?>
    </div>
  </div><hr>
  <div class="variation-view-sku">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.sku')); ?></b></div>
    <div class="variation-view-sku-content">
      <?php echo $variation_view_data['_variation_post_sku']; ?>

    </div>
  </div><hr>
  <div class="variation-view-price">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.price')); ?></b></div>
    <div class="variation-price-content">
      <div class="variation-view-regular-price-content">
        <?php echo e(trans('frontend.regular_price')); ?>: <?php echo price_html( $variation_view_data['_variation_post_regular_price'] ); ?>

      </div>
      <div class="variation-view-sale-price-content">&nbsp;&nbsp;&nbsp;&nbsp;
        <?php echo e(trans('frontend.sale_price')); ?>: <?php echo price_html( $variation_view_data['_variation_post_sale_price'] ); ?>

      </div>
    </div>
  </div><hr>
  <div class="variation-view-sale-price-date">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.sale_price_date_range')); ?></b></div>
    <div class="variation-sale-price-date-content">
      <div class="variation-view-sale-price-start-date-content">
        <?php if($variation_view_data['_variation_post_sale_price_start_date']): ?>
        <?php echo e(trans('frontend.start_date')); ?>: <?php echo date("F j, Y", strtotime($variation_view_data['_variation_post_sale_price_start_date'])); ?>

        <?php else: ?>
        <?php echo e(trans('frontend.start_date')); ?>: <?php echo e(trans('frontend.no_date_selected')); ?>

        <?php endif; ?>
      </div>
      <div class="variation-view-sale-price-end-date-content">&nbsp;&nbsp;&nbsp;&nbsp;
        <?php if($variation_view_data['_variation_post_sale_price_end_date']): ?>
        <?php echo e(trans('frontend.end_date')); ?>: <?php echo date("F j, Y", strtotime($variation_view_data['_variation_post_sale_price_end_date'])); ?>

        <?php else: ?>
        <?php echo e(trans('frontend.end_date')); ?>: <?php echo e(trans('frontend.no_date_selected')); ?>

        <?php endif; ?>
      </div>
    </div>
  </div><hr>
  <div class="variation-view-enable-stock-management">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.enable_stock_management')); ?></b></div>
    <div class="variation-view-enable-stock-management-content">
      <?php if($variation_view_data['_variation_post_manage_stock'] == 1): ?>
      <?php echo e(trans('frontend.yes')); ?>

      <?php else: ?>
      <?php echo e(trans('frontend.no')); ?>

      <?php endif; ?>
    </div>
  </div><hr>
  <div class="variation-view-stock-qty">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.stock_quantity')); ?></b></div>
    <div class="variation-view-stock-qty-content">
      <?php echo $variation_view_data['_variation_post_manage_stock_qty']; ?>

    </div>
  </div><hr>
  <div class="variation-view-back-to-order">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.back_to_order_status')); ?></b></div>
    <div class="variation-view-back-to-order-content">
      <?php if($variation_view_data['_variation_post_back_to_order'] == 'variation_not_allow'): ?>
      <?php echo e(trans('frontend.not_allow')); ?>

      <?php elseif($variation_view_data['_variation_post_back_to_order'] == 'variation_allow_notify_customer'): ?>
      <?php echo e(trans('frontend.allow_and_notify_customer')); ?>

      <?php elseif($variation_view_data['_variation_post_back_to_order'] == 'variation_only_allow'): ?>
      <?php echo e(trans('frontend.only_allow')); ?>

      <?php endif; ?>
    </div>
  </div><hr>
  <div class="variation-view-stock-availability">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.stock_availability')); ?></b></div>
    <div class="variation-view-stock-availability-content">
      <?php if($variation_view_data['_variation_post_stock_availability'] == 'variation_in_stock'): ?>
      <?php echo e(trans('frontend.in_stock')); ?>

      <?php elseif($variation_view_data['_variation_post_stock_availability'] == 'variation_out_of_stock'): ?>
      <?php echo e(trans('frontend.out_of_stock')); ?>

      <?php endif; ?>
    </div>
  </div><hr>
  <div class="variation-view-tax">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.enable_tax_status')); ?></b></div>
    <div class="variation-view-enable-tax-content">
      <?php if($variation_view_data['_variation_post_enable_tax'] == 1): ?>
      <?php echo e(trans('frontend.yes')); ?>

      <?php else: ?>
      <?php echo e(trans('frontend.no')); ?>

      <?php endif; ?>
    </div>
  </div><hr>
  <div class="variation-view-variation-description">
    <div class="variation-view-title"><b><?php echo e(trans('frontend.variation_description')); ?></b></div>
    <div class="variation-view-variation-description-content">
     <?php echo $variation_view_data['post_content']; ?>

    </div>
  </div>
</div>