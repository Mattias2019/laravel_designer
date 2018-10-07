<?php $__env->startSection('title',  trans('frontend.blogs_page_title') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
<br>
<div id="blogs_main" class="container new-container">
  <?php echo $__env->make( 'frontend-templates.blog.' .$appearance_settings['blogs']. '.' .$appearance_settings['blogs'] , array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>