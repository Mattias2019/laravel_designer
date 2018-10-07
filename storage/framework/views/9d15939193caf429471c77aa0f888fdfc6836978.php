<?php $__env->startSection('title', trans('frontend.shopist_cart_title') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
  <?php echo $__env->make('pages.ajax-pages.cart-html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>