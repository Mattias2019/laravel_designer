<?php $__env->startSection('title', trans('admin.update_general_settings') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if($settings_data): ?>
<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
 
<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="_settings_name" value="general">
  
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?php echo e(trans('admin.general_settings')); ?></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.save')); ?></button>
      </div>
    </div>
  </div>
  
<div class="box box-solid">
  <div class="row">
    <div class="col-md-12">
      <div class="box-body">
        <b><i><?php echo e(trans('admin.general_options')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputSiteTitle"><?php echo e(trans('admin.site_title')); ?></label>
          <div class="col-sm-8">
            <input type="text" placeholder="<?php echo e(trans('admin.example_shopist')); ?>" id="inputSiteTitle" name="inputSiteTitle" class="form-control" value="<?php echo e($settings_data['general_settings']['general_options']['site_title']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputEmailAddress"><?php echo e(trans('admin.email_address')); ?></label>
          <div class="col-sm-8">
            <input type="text" placeholder="<?php echo e(trans('admin.email_address')); ?>" id="inputEmailAddress" name="inputEmailAddress" class="form-control" value="<?php echo e($settings_data['general_settings']['general_options']['email_address']); ?>">
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRegistrationAllow"><?php echo e(trans('admin.user_registration_allow_status')); ?></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['general_options']['allow_registration_for_frontend'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableDisableFrontendRegistration" id="inputEnableDisableFrontendRegistration">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableDisableFrontendRegistration" id="inputEnableDisableFrontendRegistration">        
          <?php endif; ?>
          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputDefaultRoleForSite"><?php echo e(trans('admin.default_role_for_site')); ?></label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputDefaultRoleForSite" style="width: 100%;">
              <?php if(count($user_role_list_data)>0): ?>
                <?php $__currentLoopData = $user_role_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($row['slug'] == $settings_data['general_settings']['general_options']['default_role_slug_for_site']): ?>
                    <option selected="selected" value="<?php echo e($row['slug']); ?>"><?php echo e($row['role_name']); ?></option>
                  <?php else: ?>
                    <option value="<?php echo e($row['slug']); ?>"><?php echo e($row['role_name']); ?></option>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>                          
          </div>
        </div>
        
        <div class="form-group site-logo-panel">
          <label class="col-sm-4 control-label" for="inputUploadLogo"><?php echo e(trans('admin.site_logo')); ?></label>
          <div class="col-sm-8">
            <?php if($settings_data['general_settings']['general_options']['site_logo']): ?>
              <div class="site-logo-container">
                <div class="img-div"><img src="<?php echo e(get_image_url($settings_data['general_settings']['general_options']['site_logo'])); ?>" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-logo-image"><?php echo e(trans('admin.remove_image')); ?></button></div>
              </div>
              <div class="no-logo-image" style="display:none;">
                <div class="img-div"><img src="<?php echo e(default_upload_sample_img_src()); ?>" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadSiteLogo" type="button" class="btn btn-default btn-sm site-logo-uploader"><?php echo e(trans('admin.upload_image')); ?></button></div>
              </div>
            <?php else: ?>
              <div class="site-logo-container" style="display:none;">
                <div class="img-div"><img src="" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button type="button" class="btn btn-default btn-sm remove-logo-image"><?php echo e(trans('admin.remove_image')); ?></button></div>
              </div>
              <div class="no-logo-image">
                <div class="img-div"><img src="<?php echo e(default_upload_sample_img_src()); ?>" class="logo-image" alt=""/></div><br>
                <div class="btn-div"><button data-toggle="modal" data-target="#uploadSiteLogo" type="button" class="btn btn-default btn-sm site-logo-uploader"><?php echo e(trans('admin.upload_image')); ?></button></div>
              </div>
            <?php endif; ?>
            
            
            <div class="modal fade" id="uploadSiteLogo" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                    <br>
                    <i class="icon-credit-card icon-7x"></i>
                    <p class="no-margin"><?php echo e(trans('admin.you_can_upload_1_image')); ?></p>
                  </div>
                  <div class="modal-body">             
                    <div class="uploadform dropzone no-margin dz-clickable site-picture-uploader" id="site-picture-uploader" name="site-picture-uploader">
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
            <input type="hidden" name="hf_site_picture" id="hf_site_picture" value="<?php echo e($settings_data['general_settings']['general_options']['site_logo']); ?>">
          </div>
        </div>
       
        <b><i><?php echo e(trans('admin.taxes_options')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputTaxesOptions"><?php echo e(trans('admin.taxes_options')); ?></label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputTaxesOptions" style="width: 100%;">
              <?php if($settings_data['general_settings']['taxes_options']['enable_status'] == 1): ?>
              <option selected="selected" value="1"><?php echo e(trans('admin.enable')); ?></option>
              <?php else: ?>
              <option value="1"><?php echo e(trans('admin.enable')); ?></option>
              <?php endif; ?>
              
              <?php if($settings_data['general_settings']['taxes_options']['enable_status'] == 0): ?>
              <option selected="selected" value="0"><?php echo e(trans('admin.disable')); ?></option>
              <?php else: ?>
              <option value="0"><?php echo e(trans('admin.disable')); ?></option>
              <?php endif; ?>
            </select>                                        
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputApplyTaxes"><?php echo e(trans('admin.apply_tax_on')); ?></label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputApplyTaxes" style="width: 100%;">
              <?php if($settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'per_product'): ?>
                <option selected="selected" value="per_product"><?php echo e(trans('admin.per_product')); ?></option>
              <?php else: ?>
                <option value="per_product"><?php echo e(trans('admin.per_product')); ?></option>
              <?php endif; ?>
              
              <?php if($settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'order_total'): ?>
                <option selected="selected" value="order_total"><?php echo e(trans('admin.order_total')); ?></option>
              <?php else: ?>
                <option value="order_total"><?php echo e(trans('admin.order_total')); ?></option>
              <?php endif; ?>
            </select>
          </div>
        </div>  
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputTaxAmount"><?php echo e(trans('admin.tax_amount')); ?></label>
          <div class="col-sm-8">
            <input type="number" placeholder="<?php echo e(trans('admin.tax_amount')); ?>" min="0" step="any" id="inputTaxAmount" name="inputTaxAmount" class="form-control" value="<?php echo e($settings_data['general_settings']['taxes_options']['tax_amount']); ?>">%
          </div>
        </div>
        
        <b><i><?php echo e(trans('admin.checkout_options')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputGuestUserAllow"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['checkout_options']['enable_guest_user'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableGuestUser" id="inputEnableGuestUser">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableGuestUser" id="inputEnableGuestUser">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.allow_guest_user_at_checkout')); ?>

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputLoginUserAllow"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['checkout_options']['enable_login_user'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableLoginUser" id="inputEnableLoginUser">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableLoginUser" id="inputEnableLoginUser">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.allow_login_user_at_checkout')); ?>

          </div>
        </div>
        <br>
        
        <b><i><?php echo trans('admin.downloadable_products_options'); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputAccessRestriction"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['downloadable_products_options']['login_restriction'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputLoginRestriction" id="inputLoginRestriction">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputLoginRestriction" id="inputLoginRestriction">        
          <?php endif; ?>
          &nbsp; <?php echo trans('admin.downloads_require_login_label'); ?>

          </div>
        </div>
        
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputGrantAccessThankYouPage"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['downloadable_products_options']['grant_access_from_thankyou_page'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputGrantAccessOrderDetails" id="inputGrantAccessOrderDetails">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputGrantAccessOrderDetails" id="inputGrantAccessOrderDetails">        
          <?php endif; ?>
          &nbsp; <?php echo trans('admin.grant_access_from_order_thank_you_label'); ?>

          </div>
        </div>
        
        <div class="form-group" style="display:none;">
          <label class="col-sm-4 control-label" for="inputGrantAccessEmail"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['downloadable_products_options']['grant_access_from_email'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputGrantAccessEmail" id="inputGrantAccessEmail">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputGrantAccessEmail" id="inputGrantAccessEmail">        
          <?php endif; ?>
          &nbsp; <?php echo trans('admin.grant_access_from_email_label'); ?>

          </div>
        </div>
        <br>
        
        <b><i><?php echo e(trans('admin.recaptcha_label')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForAdminLogin"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_admin_login'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForAdmin" id="inputEnableForAdmin">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForAdmin" id="inputEnableForAdmin">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.recaptcha_for_admin_label')); ?>

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForUserLogin"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_user_login'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForUser" id="inputEnableForUser">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForUser" id="inputEnableForUser">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.recaptcha_for_user_label')); ?>

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForUserReg"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_user_registration'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForUserReg" id="inputEnableForUserReg">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForUserReg" id="inputEnableForUserReg">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.recaptcha_for_user_reg_label')); ?>

          </div>
        </div>
<!--        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForVendorLogin"></label>
          <div class="col-sm-8">
          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForVendor" id="inputEnableForVendor">
          </div>
        </div>-->
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaAllowForVendorReg"></label>
          <div class="col-sm-8">
          <?php if(isset($settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_vendor_registration']) && $settings_data['general_settings']['recaptcha_options']['enable_recaptcha_for_vendor_registration'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForVendorReg" id="inputEnableForVendorReg">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableForVendorReg" id="inputEnableForVendorReg">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.recaptcha_for_vendor_reg_label')); ?>

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaSecretKey"><?php echo trans('admin.recaptcha_secret_key_label'); ?></label>
          <div class="col-sm-8">
              <input type="text" name="inputRecaptchaSecretKey" id="inputRecaptchaSecretKey" class="form-control" placeholder="<?php echo e(trans('admin.recaptcha_secret_key_label')); ?>" value="<?php echo e($settings_data['general_settings']['recaptcha_options']['recaptcha_secret_key']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputRecaptchaSiteKey"><?php echo trans('admin.recaptcha_site_key_label'); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputRecaptchaSiteKey" id="inputRecaptchaSiteKey" class="form-control" placeholder="<?php echo e(trans('admin.recaptcha_site_key_label')); ?>" value="<?php echo e($settings_data['general_settings']['recaptcha_options']['recaptcha_site_key']); ?>">
          </div>
        </div>
        <br>
        <b><i><?php echo e(trans('admin.nexmo_config_option_label')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoEnable"></label>
          <div class="col-sm-8">
          <?php if($settings_data['general_settings']['nexmo_config_option']['enable_nexmo_option'] == true): ?>  
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableNexmo" id="inputEnableNexmo">            
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="inputEnableNexmo" id="inputEnableNexmo">        
          <?php endif; ?>
          &nbsp; <?php echo e(trans('admin.nexmo_enable_label')); ?>

          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoKey"><?php echo trans('admin.nexmo_key_label'); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoKey" id="inputNexmoKey" class="form-control" placeholder="<?php echo e(trans('admin.nexmo_key_label')); ?>" value="<?php echo e($settings_data['general_settings']['nexmo_config_option']['nexmo_key']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoSecret"><?php echo trans('admin.nexmo_secret_label'); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoSecret" id="inputNexmoSecret" class="form-control" placeholder="<?php echo e(trans('admin.nexmo_secret_label')); ?>" value="<?php echo e($settings_data['general_settings']['nexmo_config_option']['nexmo_secret']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoNumberTo"><?php echo trans('admin.nexmo_number_to_label'); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoNumberTo" id="inputNexmoNumberTo" class="form-control" placeholder="<?php echo e(trans('admin.nexmo_number_to_label')); ?>" value="<?php echo e($settings_data['general_settings']['nexmo_config_option']['number_to']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoNumberFrom"><?php echo trans('admin.nexmo_number_from_label'); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputNexmoNumberFrom" id="inputNexmoNumberFrom" class="form-control" placeholder="<?php echo e(trans('admin.nexmo_number_from_label')); ?>" value="<?php echo e($settings_data['general_settings']['nexmo_config_option']['number_from']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNexmoSendingMessage"><?php echo trans('admin.nexmo_sending_msg_label'); ?></label>
          <div class="col-sm-8">
            <textarea name="inputNexmoSendingMessage" id="inputNexmoSendingMessage" class="form-control" placeholder="<?php echo e(trans('admin.nexmo_sending_msg_label')); ?>"><?php echo e($settings_data['general_settings']['nexmo_config_option']['message']); ?></textarea>  
          </div>
        </div>
        <br>
        <b><i><?php echo e(trans('admin.currency_converter_option')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrencyConverterAccessKey"><?php echo e(trans('admin.fixer_access_key')); ?></label>
          <div class="col-sm-8">
            <input type="text" name="inputCurrencyConverterAccessKey" id="inputCurrencyConverterAccessKey" class="form-control" placeholder="<?php echo e(trans('admin.fixer_access_key')); ?>" value="<?php echo e($settings_data['general_settings']['fixer_config_option']['fixer_api_access_key']); ?>">
            <span><i>Get API access key from <a href="https://fixer.io/" target="_blank">Fixer</a></i></span>
          </div>
        </div>
        <br>
        <b><i><?php echo e(trans('admin.currency_options')); ?></i></b><hr>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrency"><?php echo e(trans('admin.default_currency')); ?></label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputCurrency" style="width: 100%;"> 
              <?php if(count(get_available_currency_name())>0): ?>
                <?php $__currentLoopData = get_available_currency_name(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency_code => $currency_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($settings_data['general_settings']['currency_options']['currency_name'] == $currency_code): ?>
                    <option selected="selected" value="<?php echo e($currency_code); ?>"><?php echo e($currency_name); ?></option>
                  <?php else: ?>  
                    <option value="<?php echo e($currency_code); ?>"><?php echo e($currency_name); ?></option>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </select>
          </div>
        </div>  
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputCurrencyPosition"><?php echo e(trans('admin.currency_position')); ?></label>
          <div class="col-sm-8">
            <select class="form-control select2" name="inputCurrencyPosition" style="width: 100%;">
              <?php if($settings_data['general_settings']['currency_options']['currency_position'] == 'left'): ?>
              
                <option selected="selected" value="left"><?php echo e(trans('admin.left')); ?>(<?php echo get_current_currency_symbol().'99.99'; ?>)</option>
              
              <?php else: ?>
              
                <option value="left"><?php echo e(trans('admin.left')); ?>(<?php echo get_current_currency_symbol().'99.99'; ?>)</option>
              
              <?php endif; ?>
              
              <?php if($settings_data['general_settings']['currency_options']['currency_position'] == 'right'): ?>
              
                <option selected="selected" value="right"><?php echo e(trans('admin.right')); ?>(<?php echo '99.99'.get_current_currency_symbol(); ?>)</option>
              
              <?php else: ?>
              
                <option value="right"><?php echo e(trans('admin.right')); ?>(<?php echo '99.99'.get_current_currency_symbol(); ?>)</option>
              
              <?php endif; ?>
              
              <?php if($settings_data['general_settings']['currency_options']['currency_position'] == 'left_with_space'): ?>
              
                <option selected="selected" value="left_with_space"><?php echo e(trans('admin.left_with_space')); ?>(<?php echo get_current_currency_symbol().' 99.99'; ?>)</option>
              
              <?php else: ?>
              
                <option value="left_with_space"><?php echo e(trans('admin.left_with_space')); ?>(<?php echo get_current_currency_symbol().' 99.99'; ?>)</option>
              
              <?php endif; ?>
              
              <?php if($settings_data['general_settings']['currency_options']['currency_position'] == 'right_with_space'): ?>
              
                <option selected="selected" value="right_with_space"><?php echo e(trans('admin.right_with_space')); ?>(<?php echo '99.99 '.get_current_currency_symbol(); ?>)</option>
              
              <?php else: ?>
              
                <option value="right_with_space"><?php echo e(trans('admin.right_with_space')); ?>(<?php echo '99.99 '.get_current_currency_symbol(); ?>) </option>
              
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputThousandSeparator"><?php echo e(trans('admin.thousand_separator')); ?></label>
          <div class="col-sm-8">
            <input type="text" placeholder="<?php echo e(trans('admin.thousand_separator_example')); ?>" id="inputThousandSeparator" name="inputThousandSeparator" class="form-control" value="<?php echo e($settings_data['general_settings']['currency_options']['thousand_separator']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputDecimalSeparator"><?php echo e(trans('admin.decimal_separator')); ?></label>
          <div class="col-sm-8">
            <input type="text" placeholder="<?php echo e(trans('admin.decimal_separator_example')); ?>" id="inputDecimalSeparator" name="inputDecimalSeparator" class="form-control" value="<?php echo e($settings_data['general_settings']['currency_options']['decimal_separator']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputNumberofDecimals"><?php echo e(trans('admin.number_of_decimals')); ?></label>
          <div class="col-sm-8">
            <input type="number" placeholder="<?php echo e(trans('admin.number_of_decimals_example')); ?>" id="inputNumberofDecimals" name="inputNumberofDecimals" class="form-control" value="<?php echo e($settings_data['general_settings']['currency_options']['number_of_decimals']); ?>">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-4 control-label" for="inputFrontendCurrency"><?php echo e(trans('admin.frontend_currency')); ?></label>
          <div class="col-sm-8">
            <div class="row">
              <?php $count = 1;?>  
              <?php if(count(get_available_currency_name())>0): ?>
                <?php $__currentLoopData = get_available_currency_name(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency_code => $currency_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                
                <?php if($count == 1){?>
                <div class="col-sm-12 margin-bottom-extra">
                <?php }?>  
                    
                  <?php if($settings_data['general_settings']['currency_options']['frontend_currency'] && in_array($currency_code, $settings_data['general_settings']['currency_options']['frontend_currency'])): ?>
                  <div class="col-sm-6"><input type="checkbox" class="shopist-iCheck" checked="checked" name="selected_currency_for_frontend[]" id="selected_currency_for_frontend" value="<?php echo e($currency_code); ?>">&nbsp;<?php echo e($currency_name); ?></div>
                  <?php else: ?>
                    <div class="col-sm-6"><input type="checkbox" class="shopist-iCheck" name="selected_currency_for_frontend[]" id="selected_currency_for_frontend" value="<?php echo e($currency_code); ?>">&nbsp;<?php echo e($currency_name); ?></div>
                  <?php endif; ?>
                  
                <?php if($count == 2){?>
                </div>
                <?php } $count ++ ; if($count == 3){$count = 1;}?>   
                
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
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