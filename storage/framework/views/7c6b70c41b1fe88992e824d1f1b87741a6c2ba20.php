<?php $__env->startSection('title', trans('frontend.product_comparison_title_label') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="span12 product-comparison-list">
        <div class="page-header cm14"><h2><?php echo trans('frontend.product_comparison_title_label'); ?></h2></div>
        <div class="cm14">
          <?php if(count($compare_product_data) > 0): ?>
          <h4 class="cm14"><?php echo trans('frontend.product_comparison_details_title_label'); ?></h4>
          <table class="table table-hover table-bordered table-condensed">
            <tbody>
              <?php $__currentLoopData = $compare_product_label; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo $label; ?></td>
                <?php $__currentLoopData = $compare_product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($label == 'Image'): ?>
                  <td><img src="<?php echo e(get_image_url( get_product_image( $products['id'] ))); ?>" alt="<?php echo e(basename( get_image_url( get_product_image( $products['id'] )) )); ?>"></td>
                  <?php endif; ?>

                  <?php if($label == 'Product'): ?>
                  <td><a href="<?php echo e(route('details-page', $products['post_slug'])); ?>" target="_blank"><?php echo get_product_title( $products['id'] ); ?></a></td>
                  <?php endif; ?>

                  <?php if($label == 'Price'): ?>
                  <td><?php echo price_html( get_product_price($products['id']), get_frontend_selected_currency() ); ?></td>
                  <?php endif; ?>

                  <?php if(($label !== 'Image' && $label !== 'Product' && $label !== 'Price') && !empty($products['_product_compare_data'])): ?>
                  <td><?php echo $products['_product_compare_data'][$key]; ?></td>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

              <tr>
                <td></td>
                <?php $__currentLoopData = $compare_product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <td class="text-center"><a class="btn btn-danger" href="<?php echo e(route('remove-compare-product-from-list', $products['id'])); ?>"><i class="icon-white icon-trash"></i><span class="hidden-phone"> <?php echo trans('frontend.remove'); ?></span></a></td>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </tr>
            </tbody>
          </table>
          <?php else: ?>
          <div class="no-comparison-label"><?php echo trans('frontend.product_comparison_no_label'); ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>      
	</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>