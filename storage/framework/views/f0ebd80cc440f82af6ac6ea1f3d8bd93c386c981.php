<?php $__env->startSection('title', trans('admin.shipping_options') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if($shipping_method_data): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_shipping_method_name" value="save_options">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.shipping_options')); ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.save')); ?></button>
      </div>
    </div>
  </div>
  
  <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.enable_shipping')); ?>

            </div>
            <div class="col-sm-6">
              <?php if($shipping_method_data['shipping_option']['enable_shipping'] == true): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableShipping" id="inputEnableShipping">
              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="inputEnableShipping" id="inputEnableShipping">
              <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.shipping_display_mode')); ?>

            </div>
            <div class="col-sm-6">
              <?php if($shipping_method_data['shipping_option']['display_mode'] == 'radio_buttons'): ?>
              <div><input type="radio" checked="checked" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayRadioBtn" value="radio_buttons">&nbsp; <?php echo e(trans('admin.display_shipping_methods_with_radio_buttons')); ?></div>
              <?php else: ?>
              <div><input type="radio" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayRadioBtn" value="radio_buttons">&nbsp; <?php echo e(trans('admin.display_shipping_methods_with_radio_buttons')); ?></div>
              <?php endif; ?>

              <?php if($shipping_method_data['shipping_option']['display_mode'] == 'dropdown'): ?>
              <div><input type="radio" checked="checked" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayDropDown" value="dropdown">&nbsp; <?php echo e(trans('admin.display_shipping_methods_in_a_dropdown')); ?></div>
              <?php else: ?>
              <div><input type="radio" class="shopist-iCheck" name="inputDisplayMode" id="inputDisplayDropDown" value="dropdown">&nbsp; <?php echo e(trans('admin.display_shipping_methods_in_a_dropdown')); ?></div>
              <?php endif; ?>
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