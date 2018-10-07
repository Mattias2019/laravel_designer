<?php $__env->startSection('title', $single_product_details['_product_seo_title'] .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
  <div id="product_single_page">
    <?php echo $__env->make( 'frontend-templates.single-product.' .$appearance_settings['single_product']. '.' .$appearance_settings['single_product'] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>