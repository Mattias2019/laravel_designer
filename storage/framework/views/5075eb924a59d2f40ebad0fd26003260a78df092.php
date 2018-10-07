<?php $__env->startSection('title', trans('frontend.shopist_home_title') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
  <div id="home_page">
    <?php echo $__env->make( 'frontend-templates.home.' .$appearance_settings['home']. '.' .$appearance_settings['home'] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
<?php $__env->stopSection(); ?>

 
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>