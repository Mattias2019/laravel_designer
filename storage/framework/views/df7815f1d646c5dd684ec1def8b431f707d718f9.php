<?php $__env->startSection('title', trans('admin.update_payment_options') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($payment_method_data)>0): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_payment_method_type" value="save_options">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.payment_options')); ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.update')); ?></button>
      </div>
    </div>
  </div>
  
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.enable_payment_method')); ?>

            </div>
            <div class="col-sm-7">
              <?php if($payment_method_data['payment_option']['enable_payment_method'] == 'yes'): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentMethod" id="inputEnablePaymentMethod">
              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentMethod" id="inputEnablePaymentMethod">
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