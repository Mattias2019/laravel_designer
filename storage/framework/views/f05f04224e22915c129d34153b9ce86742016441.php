<?php $__env->startSection('title', trans('admin.vendors_package_label') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div id="vendors_package_create">
  <?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  
  <form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">

    <div class="box box-info">
      <div class="box-header">
        <h3 class="box-title"><?php echo trans('admin.create_vendors_package_label'); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.vendors_packages_list_content')); ?>"><?php echo trans('admin.vendors_package_list_label'); ?></a></h3>
        <div class="box-tools pull-right">
          <button class="btn btn-block btn-primary" type="submit"><?php echo trans('admin.save'); ?></button>
        </div>
      </div>
    </div>  

    <div class="box box-solid">
      <div class="row">
        <div class="col-md-12">
          <div class="box-body">
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputPackages"><?php echo e(trans('admin.vendors_package_type_label')); ?></label>
              <div class="col-sm-8">
                <input type="text" id="inputPackageType" name="inputPackageType" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputAllowMaxProducts"><?php echo e(trans('admin.allow_max_products_label')); ?></label>
              <div class="col-sm-8">
                <input type="number" id="inputMaxNumberProducts" name="inputMaxNumberProducts" class="form-control">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowMap"><?php echo e(trans('admin.map_show_label')); ?> <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo e(trans('popover.show_map_extra_label')); ?>"></i></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowMap" name="inputShowMap" class="shopist-iCheck">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowFollowBtn"><?php echo e(trans('admin.show_social_media_follow_label')); ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowSocialMediaFollow" name="inputShowSocialMediaFollow" class="shopist-iCheck">
              </div>
            </div>  
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowShareBtn"><?php echo e(trans('admin.show_social_media_share_label')); ?></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowSocialMediaShareBtn" name="inputShowSocialMediaShareBtn" class="shopist-iCheck">
              </div>
            </div>    
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputShowContactForm"><?php echo e(trans('admin.show_contact_form_label')); ?> <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo e(trans('popover.show_contact_form_extra_label')); ?>"></i></label>
              <div class="col-sm-8">
                <input type="checkbox" id="inputShowContactForm" name="inputShowContactForm" class="shopist-iCheck">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputExpiredType"><?php echo e(trans('admin.vendor_expired_date_label')); ?></label>
              <div class="col-sm-8">
                <ul class="vendor-expired-option">
                  <li>
                    <input type="radio" id="inputCustomDateVendor" name="inputExpiredType" value="custom_date" class="shopist-iCheck">&nbsp; <?php echo trans('admin.vendor_custom_expired_date_label'); ?> &nbsp; 
                  </li>  
                  <li style="display:none;" class="allow-expired-date-picker"><input type="text" id="inputExpiredDate" name="inputExpiredDate" class="form-control"></li>
                  <li><input type="radio" id="inputLifeTimeVendor" name="inputExpiredType" value="lifetime" class="shopist-iCheck">&nbsp; <?php echo trans('admin.vendor_lifetime_expired_date_label'); ?></li>
                </ul>  
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputCommission"><?php echo e(trans('admin.vendor_commission_label')); ?> <i class="fa fa-question-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="<?php echo e(trans('popover.vendor_commission_msg')); ?>"></i></label>
              <div class="col-sm-8">
                <input type="number" id="inputCommissionPercentage" name="inputCommissionPercentage" class="form-control">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label" for="inputMinWithdrawAmount"><?php echo e(trans('admin.vendor_min_withdraw_amount')); ?></label>
              <div class="col-sm-8">
                <input type="number" id="inputMinWithdrawAmount" name="inputMinWithdrawAmount" class="form-control">
              </div>
            </div>  
          </div>  
        </div>
      </div>
    </div>
  </form>        
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>