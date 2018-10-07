<?php $__env->startSection('title', trans('admin.add_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?php echo trans('admin.add_new_page_top_title'); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.all_pages')); ?>"><?php echo trans('admin.all_pages_list'); ?></a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary" type="submit"><?php echo trans('admin.save'); ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.page_title'); ?></h3>
        </div>
        <div class="box-body">
          <input type="text" placeholder="<?php echo e(trans('admin.example_pages_placeholder')); ?>" class="form-control" name="page_title" id="page_title" value="<?php echo e(old('page_title')); ?>">
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.description'); ?></h3>
        </div>
        <div class="box-body">
          <textarea id="page_description_editor" name="page_description_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.post_description_placeholder')); ?>"></textarea>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title"><?php echo trans('admin.visibility'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="inputVisibility"><?php echo trans('admin.blog_post_status'); ?></label>
                <div class="col-sm-8">
                  <select class="form-control select2" name="pages_visibility" style="width: 100%;">
                    <option selected="selected" value="1"><?php echo trans('admin.enable'); ?></option>
                    <option value="0"><?php echo trans('admin.disable'); ?></option>                  
                  </select>                                         
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>  
  </div>
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add">
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>