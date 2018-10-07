<?php $__env->startSection('title', trans('admin.email_content_label') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div id="email_details_content">
  <?php if(Request::is('admin/settings/emails/details/new-order')): ?>
    <?php echo $__env->make('pages.admin.settings.email-new-order-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/cancelled-order')): ?>
    <?php echo $__env->make('pages.admin.settings.email-order-cancelled-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/processing-order')): ?>
    <?php echo $__env->make('pages.admin.settings.email-order-processing-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/completed-order')): ?>
    <?php echo $__env->make('pages.admin.settings.email-order-completed-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/user-new-account')): ?>
    <?php echo $__env->make('pages.admin.settings.email-new-user-account-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/vendor-new-account')): ?>
    <?php echo $__env->make('pages.admin.settings.email-vendor-new-account-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
  <?php elseif(Request::is('admin/settings/emails/details/vendor-activation')): ?>
    <?php echo $__env->make('pages.admin.settings.email-vendor-account-activation-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>   
  <?php elseif(Request::is('admin/settings/emails/details/withdraw-request')): ?>
    <?php echo $__env->make('pages.admin.settings.email-withdraw-request-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php elseif(Request::is('admin/settings/emails/details/withdraw-cancelled')): ?>
    <?php echo $__env->make('pages.admin.settings.email-withdraw-request-cancelled-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
  <?php elseif(Request::is('admin/settings/emails/details/withdraw-completed')): ?>
    <?php echo $__env->make('pages.admin.settings.email-withdraw-request-completed-content', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>