<?php $__env->startSection('title', trans('admin.update_2checkout_payment') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if(count($payment_method_data) > 0): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_payment_method_type" value="2checkout">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.two_checkout')); ?></h3>
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
              <?php if($payment_method_data['2checkout']['enable_option'] == 'yes'): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnablePayment2CheckoutMethod" id="inputEnablePayment2CheckoutMethod">  <?php echo e(trans('admin.enable_2checkout')); ?>

              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="inputEnablePayment2CheckoutMethod" id="inputEnablePayment2CheckoutMethod"> <?php echo e(trans('admin.enable_2checkout')); ?>

              <?php endif; ?>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.method_title')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.title')); ?>" class="form-control" name="input2CheckoutTitle" id="input2CheckoutTitle" value="<?php echo e($payment_method_data['2checkout']['method_title']); ?>">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.2checkout_sellerId_label')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.2checkout_sellerId_label')); ?>" class="form-control" name="input2CheckoutSellerId" id="input2CheckoutSellerId" value="<?php echo e($payment_method_data['2checkout']['sellerId']); ?>">
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.2checkout_publishableKey_label')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.2checkout_publishableKey_label')); ?>" class="form-control" name="input2CheckoutPublishableKey" id="input2CheckoutPublishableKey" value="<?php echo e($payment_method_data['2checkout']['publishableKey']); ?>">
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.2checkout_privateKey_label')); ?>

            </div>
            <div class="col-sm-7">
              <input type="text" placeholder="<?php echo e(trans('admin.2checkout_privateKey_label')); ?>" class="form-control" name="input2CheckoutPrivateKey" id="input2CheckoutPrivateKey" value="<?php echo e($payment_method_data['2checkout']['privateKey']); ?>">
            </div>
          </div>  
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.2checkout_sandbox_status_label')); ?>

            </div>
            <div class="col-sm-7">
              <?php if($payment_method_data['2checkout']['sandbox_enable_option'] == 'yes'): ?>
              <input type="checkbox" checked="checked" class="shopist-iCheck" name="input2CheckoutSandboxStatus" id="input2CheckoutSandboxStatus">
              <?php else: ?>
              <input type="checkbox" class="shopist-iCheck" name="input2CheckoutSandboxStatus" id="input2CheckoutSandboxStatus">
              <?php endif; ?>
            </div>
          </div>
            
          <div class="form-group">
            <div class="col-sm-5">
              <?php echo e(trans('admin.method_description')); ?>

            </div>
            <div class="col-sm-7">
                <textarea id="input2CheckoutDescription" name="input2CheckoutDescription" placeholder="<?php echo e(trans('admin.method_description')); ?>" class="form-control"><?php echo e($payment_method_data['2checkout']['method_description']); ?></textarea>
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