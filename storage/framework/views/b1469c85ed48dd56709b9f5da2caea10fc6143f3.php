<?php $__env->startSection('title', trans('admin.manage_languages') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<form class="form-horizontal lang-settings" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_settings_name" value="language_settings">
  
  <?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-flag"></i>
      <?php if(Request::is('admin/settings/languages')): ?>
        <h3 class="box-title"><?php echo e(trans('admin.upload_lang_file')); ?></h3>
      <?php elseif(Request::is('admin/settings/languages/update/*')): ?>
        <h3 class="box-title"><?php echo e(trans('admin.edit_upload_lang_file')); ?></h3>
      <?php endif; ?>
    </div>
    <br>
    <div class="box-body">
      <div class="row">
        
        <?php if(Request::is('admin/settings/languages')): ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputLanguageName"><?php echo e(trans('admin.lang_name')); ?></label></div>
            <div class="col-sm-8">
              <input type="text" placeholder="<?php echo e(trans('admin.lang_name_placeholder')); ?>" id="inputLangName" name="inputLangName" class="form-control" value="">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputUploadLanguageZip"><?php echo e(trans('admin.upload_languages_zip')); ?></label></div>
            <div class="col-sm-8">
              <div><input type="file" name="lang_file_upload" id="lang_file_upload"></div><br>
              <div><span><?php echo e(trans('admin.zip_file_confirmation')); ?></span> &nbsp;&nbsp; <span>[<a href="<?php echo e(url('/resources/lang/en.zip')); ?>" download><?php echo e(trans('admin.download_sample_language_file')); ?></a>]</span></div>
            </div>
          </div>  
          <div class="text-right">
            <input type="submit" name="post_lang_file_upload" class="btn btn-primary" value="<?php echo e(trans('admin.upload_lang_zip_file')); ?>">
          </div>
        </div>
        <?php elseif(Request::is('admin/settings/languages/update/*')): ?>
        <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputLanguageName"><?php echo e(trans('admin.lang_name')); ?></label></div>
            <div class="col-sm-8">
              <input type="text" placeholder="<?php echo e(trans('admin.lang_name_placeholder')); ?>" id="inputLangName" name="inputLangName" class="form-control" value="<?php echo e($lang_data_by_id['lang_name']); ?>">
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-4"><label class="control-label" for="inputUploadLanguageZip"><?php echo e(trans('admin.upload_languages_zip')); ?></label></div>
            <div class="col-sm-8">
              <div><input type="file" name="lang_file_upload" id="lang_file_upload"></div><br>
              <div><span><?php echo e(trans('admin.zip_file_confirmation')); ?></span> &nbsp;&nbsp; <span>[<a href="<?php echo e(url('/resources/lang/en.zip')); ?>" download><?php echo e(trans('admin.download_sample_language_file')); ?></a>]</span></div>
            </div>
          </div>  
          <div class="text-right">
            <input type="submit" name="post_lang_file_edit_option" class="btn btn-primary" value="<?php echo e(trans('admin.update_lang_zip_file')); ?>">
          </div>
        </div>
        <?php endif; ?>
        
      </div>
    </div>
  </div>  
  
  <div class="box box-solid">
    <div class="box-header with-border">
      <i class="fa fa-flag"></i>
      <h3 class="box-title"><?php echo e(trans('admin.lang_manage_option')); ?></h3>
    </div>
    <br>
    <div class="box-body">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <table class="table table-bordered table-striped admin-data-table">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.lang_name')); ?></th>
                <th><?php echo e(trans('admin.lang_status')); ?></th>
                <th><?php echo e(trans('admin.lang_default_status')); ?></th>
                <th><?php echo e(trans('admin.action')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($lang_data)>0): ?>
              <?php $i = 1;?>
               <?php $__currentLoopData = $lang_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <tr>
                 <td>
                   <?php if($row['lang_code'] == 'en'): ?>
                    <img src="<?php echo e(asset('public/images/'. $row['lang_sample_img'])); ?>"> &nbsp;&nbsp;<?php echo e($row['lang_name']); ?>

                   <?php else: ?>
                    <img src="<?php echo e(get_image_url($row['lang_sample_img'])); ?>"> &nbsp;&nbsp;<?php echo e($row['lang_name']); ?>

                   <?php endif; ?>
                 </td>
                 
                 <?php if($row['status'] == 1): ?>
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_frontend[]" id="enable_switching_for_frontend_<?php echo e($i); ?>" checked value="<?php echo e($row['id']); ?>">
                    <span></span>
                  </label>       
                 </td>
                 <?php else: ?>
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_frontend[]" id="disable_switching_for_frontend_<?php echo e($i); ?>" value="<?php echo e($row['id']); ?>">
                    <span></span>
                  </label>   
                 </td>
                 <?php endif; ?>
                 
                 <?php if($row['default_lang'] == 1): ?>
                 <td>   
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_default[]" class="switching-for-default onoffswitch-checkbox" id="enable_switching_for_default_<?php echo e($i); ?>" checked value="<?php echo e($row['id']); ?>">
                    <span></span>
                  </label>     
                 </td>
                 <?php else: ?>
                 <td>
                  <label class="shopist-switch">
                    <input type="checkbox" name="switching_for_default[]" class="switching-for-default onoffswitch-checkbox" id="disable_switching_for_default_<?php echo e($i); ?>" value="<?php echo e($row['id']); ?>">
                    <span></span>
                  </label>    
                 </td>
                 <?php endif; ?>
                 
                 <td>
                    <?php if($row['lang_code'] !== 'en'): ?>
                      <div class="btn-group">
                        <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                        <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                          <span class="caret"></span>
                          <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <ul role="menu" class="dropdown-menu">
                          <li><a href="<?php echo e(route('admin.update_languages_settings_content', $row['id'])); ?>"><i class="fa fa-edit"></i><?php echo e(trans('admin.edit')); ?></a></li>
                          <li><a href="<?php echo e(url('/resources/lang/'.$row['lang_code'].'.zip')); ?>" download><i class="fa fa-download"></i><?php echo e(trans('admin.download_file')); ?></a></li>
                          <li><a class="remove-selected-data-from-list" data-track_name="manage_languages" data-id="<?php echo e($row['id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo e(trans('admin.delete')); ?></a></li>
                        </ul>
                      </div>
                    <?php endif; ?>
                 </td>
               </tr>
               <?php $i ++;?>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.lang_name')); ?></th>
                <th><?php echo e(trans('admin.lang_status')); ?></th>
                <th><?php echo e(trans('admin.lang_default_status')); ?></th>
                <th><?php echo e(trans('admin.action')); ?></th>
              </tr>
            </tfoot>
          </table>
          <br>
          <div class="text-right">
            <input type="submit" name="post_lang_settings" class="btn btn-primary" value="<?php echo e(trans('admin.update_language_settings')); ?>">
          </div>
        </div>
      </div>
    </div>
  </div>
</form>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>