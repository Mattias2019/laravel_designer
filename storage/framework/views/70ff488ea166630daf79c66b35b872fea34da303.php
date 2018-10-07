<?php if( Cart::count() >0 ): ?>
  <?php if(count($cross_sell_products) > 0): ?>
  <br>
  <div class="row crosssell-products-content">
    <div class="col-md-12">
      <h3><?php echo trans('frontend.crosssell_title_label'); ?></h3><br>  
      <div class="crosssell-products">
        <?php $__currentLoopData = $cross_sell_products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xs-12 col-sm-4 col-md-3">
          <div class="crosssell-img"><img src="<?php echo e(get_image_url(get_product_image( $products ))); ?>" alt="<?php echo e(basename( get_product_image( $products ) )); ?>"></div>
          <div class="crosssell-products-info">
            <a href="<?php echo e(route('details-page', get_product_slug($products) )); ?>"><span><?php echo get_product_title( $products ); ?></span></a><br>
            <span>
              <?php if(get_product_type( $products ) == 'simple_product'): ?>
                <?php echo price_html( get_product_price( $products ), get_frontend_selected_currency() ); ?>

              <?php elseif(get_product_type( $products ) == 'configurable_product'): ?>
                <?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products); ?>

              <?php elseif(get_product_type( $products ) == 'customizable_product' || get_product_type( $products ) == 'downloadable_product'): ?>
                <?php if(count(get_product_variations( $products ))>0): ?>
                  <?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $products); ?>

                <?php else: ?>
                  <?php echo price_html( get_product_price( $products ), get_frontend_selected_currency() ); ?>

                <?php endif; ?>
              <?php endif; ?>
            </span>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>  
  </div>    
  <?php endif; ?>
<?php endif; ?>