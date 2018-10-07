<?php $__env->startSection('title', trans('admin.withdraw_title_label') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
  <?php if(is_vendor_login()): ?>
    <?php echo $__env->make('pages.admin.vendors.vendors-withdraw-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('vendor-withdraw-content'); ?>
  <?php else: ?>
    <?php echo $__env->make('pages.admin.vendors.vendors-admin-withdraw-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->yieldContent('vendor-admin-withdraw-content'); ?>
  <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>