<?php $__env->startSection('title', trans('admin.user_profile') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if($user_profile_data->count() > 0): ?>

<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <div class="box box-solid">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.edit_your_profile')); ?></h3>
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
            <div class="col-sm-4">
              <label class="control-label" for="inputDisplayName"><?php echo e(trans('admin.display_name')); ?></label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="<?php echo e(trans('admin.display_name')); ?>" class="form-control" value="<?php echo e($user_profile_data->display_name); ?>" id="display_name" name="display_name">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputUserName"><?php echo e(trans('admin.user_name')); ?></label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="<?php echo e(trans('admin.user_name')); ?>" class="form-control" value="<?php echo e($user_profile_data->name); ?>" id="user_name" name="user_name">
            </div>
          </div>  
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputEmail"><?php echo e(trans('admin.email')); ?></label>
            </div>
            <div class="col-sm-8">
              <input type="text" placeholder="<?php echo e(strtolower(trans('admin.email'))); ?>" class="form-control" value="<?php echo e($user_profile_data->email); ?>" id="email_id" name="email_id">
            </div>
          </div> 
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputNewPassword"><?php echo e(trans('admin.new_password')); ?></label>
            </div>
            <div class="col-sm-8">
               <input type="password" placeholder="<?php echo e(trans('admin.new_password')); ?>" class="form-control" value="" id="password" name="password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4">
              <label class="control-label" for="inputProfilePicture"><?php echo e(trans('admin.profile_picture')); ?></label>
            </div>
            <div class="col-sm-8 profile-picture-content">
               <?php if($user_profile_data->user_photo_url): ?>
                <div class="profile-picture">
                  <div class="img-div"><img src="<?php echo e(get_image_url($user_profile_data->user_photo_url)); ?>" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-profile-picture"><?php echo e(trans('admin.remove_image')); ?></button></div>
                </div>
                <div class="no-profile-picture" style="display:none;">
                  <div class="img-div"><img src="<?php echo e(default_upload_sample_img_src()); ?>" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button data-toggle="modal" data-target="#uploadprofilepicture" type="button" class="btn btn-default btn-sm profile-picture-uploader"><?php echo e(trans('admin.upload_image')); ?></button></div>
                </div>
               <?php else: ?>
               <div class="profile-picture" style="display:none;">
                  <div class="img-div"><img src="" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-profile-picture"><?php echo e(trans('admin.remove_image')); ?></button></div>
                </div>
               <div class="no-profile-picture">
                  <div class="img-div"><img src="<?php echo e(default_upload_sample_img_src()); ?>" class="user-image" alt=""/></div><br>
                  <div class="btn-div"><button data-toggle="modal" data-target="#uploadprofilepicture" type="button" class="btn btn-default btn-sm profile-picture-uploader"><?php echo e(trans('admin.upload_image')); ?></button></div>
               </div>
               <?php endif; ?>
            </div>
          </div>
        </div>
      </div>  
    </div>
  </div>

  <div class="modal fade" id="uploadprofilepicture" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <br>
          <i class="icon-credit-card icon-7x"></i>
          <p class="no-margin"><?php echo e(trans('admin.you_can_upload_1_image')); ?></p>
        </div>
        <div class="modal-body">             
          <div class="uploadform dropzone no-margin dz-clickable profile-picture-uploader" id="profile-picture-uploader" name="profile-picture-uploader">
            <div class="dz-default dz-message">
              <span><?php echo e(trans('admin.drop_your_cover_picture_here')); ?></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo e(trans('admin.close')); ?></button>
        </div>
      </div>
    </div>
  </div> 
  <input type="hidden" name="hf_profile_picture" id="hf_profile_picture" value="<?php echo e($user_profile_data['user_photo_url']); ?>">
</form>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>