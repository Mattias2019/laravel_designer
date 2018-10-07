<?php $__env->startSection('title', trans('admin.update_paypal_payment') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($payment_method_data) > 0): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_payment_method_type" value="paypal">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.paypal')); ?></h3>
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
              <?php echo e(trans('admin.enable_disable')); ?>

            </div>
            <div class="col-sm-7">
              <?php if($payment_method_data['paypal']['enable_option'] == 'yes'): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaymentPaypalMethod" id="inputEnablePaymentPaypalMethod">  <?php echo trans('admin.enable_payPal'); ?>

              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaymentPaypalMethod" id="inputEnablePaymentPaypalMethod"> <?php echo trans('admin.enable_payPal'); ?>

              <?php endif; ?>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.method_title')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.title')); ?>" class="form-control" name="inputPaypalTitle" id="inputPaypalTitle" value="<?php echo e($payment_method_data['paypal']['method_title']); ?>">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.paypal_app_client_id')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.paypal_app_client_id')); ?>" class="form-control" name="inputPaypalClientId" id="inputPaypalClientId" value="<?php echo e($payment_method_data['paypal']['paypal_client_id']); ?>">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.paypal_app_secret')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.paypal_app_secret')); ?>" class="form-control" name="inputPaypalSecret" id="inputPaypalSecret" value="<?php echo e($payment_method_data['paypal']['paypal_secret']); ?>">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.enable_disable_paypal_sandbox')); ?>

            </div>
            <div class="col-sm-7">
              <?php if($payment_method_data['paypal']['paypal_sandbox_enable_option'] == 'yes'): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePaypalSandboxOption" id="inputEnablePaypalSandboxOption">  <?php echo e(trans('admin.enable_payPal_sandbox')); ?>

              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePaypalSandboxOption" id="inputEnablePaypalSandboxOption">  <?php echo e(trans('admin.enable_payPal_sandbox')); ?>

              <?php endif; ?>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.method_description')); ?>

            </div>
            <div class="col-sm-7">
                <textarea id="inputPaypalDescription" name="inputPaypalDescription" placeholder="<?php echo e(trans('admin.method_description')); ?>" class="form-control"><?php echo e($payment_method_data['paypal']['method_description']); ?></textarea>
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