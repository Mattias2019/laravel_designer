<?php $__env->startSection('title', trans('admin.manage_seo_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header">
          <h3 class="box-title"><?php echo e(trans('admin.seo_info_insert_top_label')); ?></h3>
          <div class="box-tools pull-right">
            <button class="btn btn-block btn-primary" type="submit"><?php echo e(trans('admin.save')); ?></button>
          </div>
        </div>
      </div>
    </div>

    <div class="col-md-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo e(trans('admin.manage_metatag_label')); ?></h3>
        </div> 
        <div class="box-body">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMetaKeywords"><?php echo e(trans('admin.meta_keywords_label')); ?></label>
            <div class="col-sm-10">
              <input type="text" placeholder="<?php echo e(trans('admin.meta_keywords_example_label')); ?>" id="inputMetaKeywords" name="inputMetaKeywords" class="form-control" value="<?php echo e($seo_data['meta_tag']['meta_keywords']); ?>">
              <p>[<?php echo e(trans('admin.keywords_entry_label')); ?>]</p>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="inputMetaDescription"><?php echo e(trans('admin.meta_description_label')); ?></label>
            <div class="col-sm-10">
              <textarea id="inputMetaDescription" name="inputMetaDescription" placeholder="<?php echo e(trans('admin.meta_description_label')); ?>" class="form-control"><?php echo e($seo_data['meta_tag']['meta_description']); ?></textarea>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>