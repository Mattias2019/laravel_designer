<?php $__env->startSection('title', trans('frontend.shopist_shop_title') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
<div id="shop_page">
  <?php echo $__env->make( 'frontend-templates.product.' .$appearance_settings['products']. '.' .$appearance_settings['products'] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>	
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>