<?php $__env->startSection('title', trans('admin.update_local_delivery') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if($shipping_method_data): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_shipping_method_name" value="save_local_delivery">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.shipping_method_local_delivery')); ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.save')); ?></button>
      </div>
    </div>
  </div>
  
  <p><?php echo e(trans('admin.local_delivery_title')); ?></p> 
 <div class="box box-solid">
    <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.enable_disable')); ?>

            </div>
            <div class="col-sm-6">
               <?php if($shipping_method_data['local_delivery']['enable_option'] == true): ?>
               <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableLocalDelivery" id="inputEnableLocalDelivery">
               <?php echo e(trans('admin.enable_this_shipping_method')); ?>

              <?php else: ?>
                <input type="checkbox" class="shopist-iCheck" name="inputEnableLocalDelivery" id="inputEnableLocalDelivery">
               <?php echo e(trans('admin.enable_this_shipping_method')); ?>

              <?php endif; ?>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.method_title')); ?>

            </div>
            <div class="col-sm-6">
              <input type="text" placeholder="<?php echo e(trans('admin.title')); ?>" class="form-control" name="inputLocalDeliveryTitle" id="inputLocalDeliveryTitle" value="<?php echo e($shipping_method_data['local_delivery']['method_title']); ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.fee_type')); ?>

            </div>
            <div class="col-sm-6">
              <select name="inputLocalDeliveryFeeType" id="inputLocalDeliveryFeeType" class="form-control select2" style="width: 100%;">
                
                <?php if($shipping_method_data['local_delivery']['fee_type'] == 'fixed_amount'): ?>
                <option selected="selected" value="fixed_amount"><?php echo e(trans('admin.fixed_amount')); ?></option>
                <?php else: ?>
                <option value="fixed_amount"><?php echo e(trans('admin.fixed_amount')); ?></option>
                <?php endif; ?>
                
                <?php if($shipping_method_data['local_delivery']['fee_type'] == 'cart_total'): ?>
                <option selected="selected" value="cart_total"><?php echo e(trans('admin.percentage_of_cart_total')); ?></option>
                <?php else: ?>
                <option value="cart_total"><?php echo e(trans('admin.percentage_of_cart_total')); ?></option>
                <?php endif; ?>
                
                <?php if($shipping_method_data['local_delivery']['fee_type'] == 'per_product'): ?>
                 <option selected="selected" value="per_product"><?php echo e(trans('admin.fixed_amount_per_product')); ?></option>
                <?php else: ?>
                 <option value="per_product"><?php echo e(trans('admin.fixed_amount_per_product')); ?></option>
                <?php endif; ?>
               
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6">
              <?php echo e(trans('admin.delivery_fee')); ?>

            </div>
            <div class="col-sm-6">
              <input type="number" placeholder="<?php echo e(trans('admin.delivery_fee')); ?>" class="form-control" min="0" step="any" name="inputLocalDeliveryDeliveryFee" id="inputLocalDeliveryDeliveryFee" value="<?php echo e($shipping_method_data['local_delivery']['delivery_fee']); ?>">
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