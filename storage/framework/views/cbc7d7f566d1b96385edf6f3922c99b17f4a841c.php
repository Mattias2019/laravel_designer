<div class="variations-content-main" data-is_login="<?php echo e($single_product_details['is_user_login']); ?>" data-login_user_slug="<?php echo e($single_product_details['login_user_slug']); ?>" data-current_currency_value="<?php echo e(get_product_price_html_by_filter(1)); ?>" data-variations_details="<?php echo e(json_encode(get_product_variations_with_data($single_product_details['id']))); ?>">
  <div class="variations-data row">
    <div class="clearfix">
      <?php $__currentLoopData = $attr_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-sm-12 variations-line">
          <div class="variation-attr-name"><?php echo $row['attr_name']; ?></div>
          <div class="variation-attr-value">
            <div class="variation-choose-option"><i class="fa fa-hand-o-up"></i> <?php echo e(trans('frontend.choose_an_options')); ?></div>
            <?php $__currentLoopData = explode(',', $row['attr_values']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(is_variation_exist_in_combination($single_product_details['id'], array(string_slug_format( $row['attr_name'] ), string_slug_format( $val )))): ?>
              <div class="variation-options-lists"><input  type="radio" name="<?php echo e(string_slug_format( $row['attr_name'] )); ?>" value="<?php echo e(string_slug_format( $val )); ?>"> &nbsp;&nbsp; <?php echo ucwords($val); ?></div>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
  
  <div class="product-add-to-cart-content add-to-cart-content" style="display:none;">
    <div class="variation-price-label"></div>  
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
      <?php if(Request::is('product/customize/*')): ?>
      <li>
        <a href="" class="btn btn-sm btn-style cart customize-page-add-to-cart" data-id="<?php echo e($single_product_details['id']); ?>"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; <?php echo e(trans('frontend.add_to_cart')); ?></a>
      </li>
      <?php else: ?>
      <li>
        <a href="" class="btn btn-sm btn-style cart single-page-add-to-cart" data-id="<?php echo e($single_product_details['id']); ?>"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp; <?php echo e(trans('frontend.add_to_cart')); ?></a>
      </li>
      <?php endif; ?>
    </ul>
  </div>  
</div><br>