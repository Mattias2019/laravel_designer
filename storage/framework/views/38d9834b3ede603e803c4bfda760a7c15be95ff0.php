<?php $__env->startSection('title', trans('frontend.frontend_user_login_title') .' - '. get_site_title()); ?>
<?php $__env->startSection('content'); ?>

<div class="container custom-extra-top-style">  
  <div class="row">
    <div class="col-md-6 col-md-offset-3">
      <div class="panel panel-login">
        <div class="panel-heading">
          <div class="row">
            <div class="col-xs-12">
              <h3><?php echo e(trans('frontend.frontend_user_login')); ?></h3>
            </div>
          </div>
          <hr>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-lg-12">
                
              <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              
              <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
                
                <div class="form-group has-feedback">
                  <input name="login_username" id="login_username" tabindex="1" class="form-control" placeholder="<?php echo e(trans('frontend.frontend_username_placeholder')); ?>" value="<?php echo e($frontend_login_data['user']); ?>" type="text">
                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>
                
                <div class="form-group has-feedback">
                    <input name="login_password" id="login_password" tabindex="2" class="form-control" placeholder="<?php echo e(trans('frontend.password')); ?>" type="password" value="<?php echo e($frontend_login_data['pass']); ?>">
                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
         
                <?php if($frontend_login_data['is_enable_recaptcha'] == true): ?>
                <div class="form-group">
                  <div class="captcha-style"><?php echo app('captcha')->display();; ?></div>
                </div>
                <?php endif; ?>
                
                <div class="form-group text-center">
                  <?php if(Cookie::has('frontend_remember_me_data')): ?>
                  <input tabindex="3" class="shopist-iCheck" name="login_remember_me" id="login_remember_me" type="checkbox" checked>
                  <label for="remember"> <?php echo e(trans('frontend.remember_me')); ?></label>
                  <?php else: ?>
                  <input tabindex="3" class="shopist-iCheck" name="login_remember_me" id="login_remember_me" type="checkbox">
                  <label for="remember"> <?php echo e(trans('frontend.remember_me')); ?></label>
                  <?php endif; ?>  
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                      <input name="login_submit" id="login_submit" tabindex="4" class="form-control btn btn-primary" value="<?php echo e(trans('frontend.frontend_log_in')); ?>" type="submit">
                    </div>
                  </div>
                </div>
                
                <div class="form-group">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="text-center">
                        <a href="<?php echo e(route('user-forgot-password-page')); ?>" tabindex="5" class="forgot-password"><?php echo e(trans('frontend.forgot_password')); ?></a>&nbsp;&nbsp;&nbsp;&nbsp;
                        <?php if($settings_data['general_options']['allow_registration_for_frontend']): ?>
                        <a href="<?php echo e(route('user-registration-page')); ?>" tabindex="5" class="register-new-user"><?php echo e(trans('frontend.register_as_a_new_user')); ?></a>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>  
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>