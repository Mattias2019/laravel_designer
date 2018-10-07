<?php $__env->startSection('title',  trans('frontend.shopist_customize_page') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
<div id="product_designer" class="container new-container">
  <?php if(count($designer_hf_data)>0 && count($single_product_details['_product_custom_designer_data'])>0): ?>  
  <br>
  <div class="row">
    <div class="col-sm-12">
      <?php if(isset($designer_hf_databackside)): ?>
      <?php echo $__env->make('pages.frontend.frontend-pages.frontend-designer-html', array('designer_hf_data' => $designer_hf_data,'designer_hf_databackside'=> $designer_hf_databackside, 'designer_img_elments' => $single_product_details['_product_custom_designer_data'],'designer_img_elmentsback' => $single_product_detailsbackside['_product_custom_designer_data'], 'design_save_data' => $design_json_data,'design_save_databackside' => $design_json_databackside), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
      <?php echo $__env->make('pages.frontend.frontend-pages.frontend-designer-html', array('designer_hf_data' => $designer_hf_data, 'designer_img_elments' => $single_product_details['_product_custom_designer_data'], 'design_save_data' => $design_json_data), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php endif; ?>
    </div>
  </div>
  <br>
  <div class="row"> 
    <div class="col-sm-12">
      <h1 class="product-title"><?php echo e($single_product_details['post_title']); ?></h1>
      <?php if(count($attr_lists) >0 && count(get_product_variations_with_data($single_product_details['id']))>0): ?>
      <div class="product-pricing"><span class="solid-price"><?php echo get_product_variations_min_to_max_price_html($currency_symbol, $single_product_details['id']); ?> </span></div><hr>
        <?php echo $__env->make('includes.frontend.variations-html', array('attr_lists' => $attr_lists, 'single_product_details' => $single_product_details), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php else: ?>
      <div class="clearfix">
        <div class="product-pricing">
          <?php if(get_product_type($single_product_details['id']) == 'customizable_product' && count(get_product_variations($single_product_details['id'])) == 0 ): ?>
            <?php if(!is_null($single_product_details['offer_price'])): ?>
            <span class="offer-price"><?php echo price_html( $single_product_details['offer_price'] ); ?></span>
            <?php endif; ?>

            <span class="solid-price"><?php echo price_html( $single_product_details['solid_price'] ); ?></span>
          <?php endif; ?>
        </div> 
        <hr>  
        <button class="btn btn-sm btn-style cart customize-page-add-to-cart" type="button" data-id="<?php echo e($single_product_details['id']); ?>">
          <i class="fa fa-shopping-cart"></i>
          <?php echo e(trans('frontend.add_to_cart')); ?>

        </button>
      </div>
      <?php endif; ?>
    </div>  
  </div>
  <input type="hidden" name="hf_custom_designer_data" id="hf_custom_designer_data" value="<?php echo e($single_product_details['product_custom_designer_json']); ?>">
  <br>
  <?php else: ?>
  <br>
  <div class="row">
    <div class="col-sm-12">
      <h5><?php echo e(trans('frontend.no_content_yet')); ?></h5>
    </div>
  </div>
  <?php endif; ?>
</div>
	
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>