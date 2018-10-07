<?php $__env->startSection('title', trans('frontend.vendor_list_title_label') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <div id="vendors_list">
    <div class="row">
      <?php if(count($vendors_list) > 0): ?>
        <?php $__currentLoopData = $vendors_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($vendor->user_status == 1 && !is_vendor_expired($vendor->id)): ?>
            <?php $details = json_decode($vendor->details);?>
            <div class="col-xs-12 col-sm-6 col-md-4">
              <div class="vendors-list-content">
                <div class="vendors-list-header"></div>
                <div class="vendors-list-profile-image">
                  <?php if(!empty($vendor->user_photo_url)): ?>
                    <img src="<?php echo e(get_image_url($vendor->user_photo_url)); ?>">
                  <?php else: ?>
                    <img src="<?php echo e(default_placeholder_img_src()); ?>">
                  <?php endif; ?>
                </div>
                <div class="vendors-list-profile-details">
                  <div class="vendor-name"><h3><a href="<?php echo e(route('store-details-page-content', $vendor->name)); ?>"><?php echo $details->profile_details->store_name; ?></a></h3></div>
                  <div class="vendor-address"><?php echo $details->profile_details->address_line_1; ?></div>
                  <div class="vendor-email"><strong><?php echo trans('frontend.email_label'); ?>:</strong> <?php echo $vendor->email; ?></div>
                  <div class="vendor-phone"><strong><?php echo trans('frontend.phone'); ?>:</strong> <?php echo $details->profile_details->phone; ?></div>
                  <div class="vendor-created"><strong><?php echo trans('frontend.member_since_label'); ?>:</strong> <?php echo Carbon\Carbon::parse(  $vendor->created_at )->format('F d, Y'); ?></div>
                </div>
                <div class="vendors-list-footer"><a href="<?php echo e(route('store-details-page-content', $vendor->name)); ?>"><?php echo trans('frontend.view_details'); ?></a></div>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
      <br>
      <p><?php echo trans('admin.no_store_label'); ?></p>
      <?php endif; ?>
    </div>
  </div>    
</div>    
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>