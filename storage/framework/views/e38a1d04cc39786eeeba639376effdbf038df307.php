<?php $__env->startSection('title', trans('admin.designer_settings') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($custom_designer_settings_data) > 0): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.custom_designer_settings')); ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.update')); ?></button>
      </div>
    </div>
  </div>
  
<div class="box box-solid">
  <div class="row">
    <div class="col-md-12">
      <div class="box-body">
        <h4><b><i><?php echo e(trans('admin.general_settings')); ?></i></b></h4><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" style="text-align:left;" for="inputDesignPanelDimension"><?php echo e(trans('admin.canvas_size')); ?></label>
          <div class="col-sm-8">
            <div class="form-group">
                <br><p><b><i><?php echo e(trans('admin.small_devices_dimension')); ?></i></b></p>
                <div class="col-sm-6">
                  <input type="number" class="form-control" name="global_canvas_small_devices_width" id="global_canvas_small_devices_width" placeholder="<?php echo e(trans('admin.width')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['small_devices']['width']); ?>">
                </div>
                <div class="col-sm-6">
                  <input type="number" class="form-control" name="global_canvas_small_devices_height" id="global_canvas_small_devices_height" placeholder="<?php echo e(trans('admin.height')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['small_devices']['height']); ?>">
                </div>
            </div><hr> 
              
            <div class="form-group">
                <br><p><b><i><?php echo e(trans('admin.medium_devices_dimension')); ?></i></b></p> 
                <div class="col-sm-6">
                  <input type="number" class="form-control" name="global_canvas_medium_devices_width" id="global_canvas_medium_devices_width" placeholder="<?php echo e(trans('admin.width')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['medium_devices']['width']); ?>">
                </div>
                <div class="col-sm-6">
                  <input type="number" class="form-control" name="global_canvas_medium_devices_height" id="global_canvas_medium_devices_height" placeholder="<?php echo e(trans('admin.height')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['medium_devices']['height']); ?>">
                </div>
            </div><hr>   
            
            <div class="form-group">
              <br><p><b><i><?php echo e(trans('admin.large_devices_dimension')); ?></i></b></p>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="global_canvas_large_devices_width" id="global_canvas_large_devices_width" placeholder="<?php echo e(trans('admin.width')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['large_devices']['width']); ?>">
              </div>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="global_canvas_large_devices_height" id="global_canvas_large_devices_height" placeholder="<?php echo e(trans('admin.height')); ?>" value="<?php echo e($custom_designer_settings_data['general_settings']['canvas_dimension']['large_devices']['height']); ?>">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>