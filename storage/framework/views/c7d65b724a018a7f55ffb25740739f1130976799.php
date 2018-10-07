<?php $__env->startSection('title', trans('admin.add_manufacturers') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.add_new_manufacturers')); ?> &nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.manufacturers_list_content')); ?>"><?php echo e(trans('admin.manufacturers_list')); ?></a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.save')); ?></button>
      </div>
    </div>
  </div>
  

<div class="box box-solid">
 <div class="row">
    <div class="col-md-12">
      <div class="box-body">
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputManufacturersName"><?php echo e(trans('admin.manufacturers_name')); ?></label>
          <div class="col-sm-9">
            <input type="text" placeholder="<?php echo e(trans('admin.manufacturers_name')); ?>" id="inputManufacturersName" name="inputManufacturersName" class="form-control" value="<?php echo e(old('inputManufacturersName')); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputCountryName"><?php echo e(trans('admin.country_name')); ?></label>
          <div class="col-sm-9">
            <input type="text" placeholder="<?php echo e(trans('admin.country_name')); ?>" id="inputCountryName" name="inputCountryName" class="form-control" value="<?php echo e(old('inputCountryName')); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputShortDescription"><?php echo e(trans('admin.short_description')); ?></label>
          <div class="col-sm-9">
            <textarea id="inputShortDescription" name="inputShortDescription" class="dynamic-editor" placeholder="<?php echo e(trans('admin.short_description')); ?>"></textarea>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputStatus"><?php echo e(trans('admin.status')); ?></label>
          <div class="col-sm-9">
            <select class="form-control select2" name="inputStatus" style="width: 100%;">
              <option selected="selected" value="1"><?php echo e(trans('admin.enable')); ?></option>
              <option value="0"><?php echo e(trans('admin.disable')); ?></option>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="inputUploadLogo"><?php echo e(trans('admin.upload_logo')); ?></label>
          <div class="col-sm-9">
            <div class="uploadform dropzone no-margin dz-clickable upload-manufacturers-logo" id="inputUploadLogo" name="inputUploadLogo">
              <div class="dz-default dz-message">
                <span><?php echo e(trans('admin.drop_your_cover_picture_here')); ?></span>
              </div>
            </div>
            <br>
            <div class="manufacturers-img-content">
              <div class="manufacturers-sample-img"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt=""></div>
              <div class="manufacturers-img"><img class="img-responsive" src="" alt=""></div>
              <br>
              <div class="manufacturers-img-remove-btn">
                <button type="button" class="btn btn-default attachtopost remove-manufacturers-img"><?php echo e(trans('admin.remove_image')); ?></button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="logo_img" id="logo_img" value="">
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>