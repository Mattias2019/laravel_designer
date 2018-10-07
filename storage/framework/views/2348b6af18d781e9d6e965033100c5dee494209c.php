<?php $__env->startSection('title', trans('admin.login') .' < '. get_site_title()); ?>
<?php $__env->startSection('content'); ?>

<div class="login-box">
  <div class="login-logo">
    <?php echo e(trans('admin.shopist')); ?> <b><?php echo e(trans('admin.login')); ?></b>
  </div>
  
  <div class="login-box-body">
    <p class="login-box-msg"><?php echo e(trans('admin.sign_in_as_a_user')); ?></p>
    
    <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <form method="post" action="" enctype="multipart/form-data">
      <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
      
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="<?php echo e(strtolower(trans('admin.email'))); ?>" name="admin_login_email" value="<?php echo e($data['user']); ?>">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="<?php echo e(strtolower(trans('admin.password'))); ?>" name="admin_login_password" value="<?php echo e($data['pass']); ?>">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <?php if($data['is_enable_recaptcha'] == true): ?>
      <div class="form-group">
        <div class="captcha-style"><?php echo app('captcha')->display();; ?></div>
      </div>
      <?php endif; ?>
      
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <?php if(Cookie::has('remember_me_data')): ?>
              <input type="checkbox" name="remember_me" checked="checked"> <?php echo e(trans('admin.remember_me')); ?>

              <?php else: ?>
              <input type="checkbox" name="remember_me" > <?php echo e(trans('admin.remember_me')); ?>

              <?php endif; ?>
            </label>
          </div>
        </div>
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" name="admin_login_submit"><?php echo e(trans('admin.sign_in')); ?></button>
        </div>
      </div>
      
    </form>
    
    <a href="<?php echo e(route('forgotPassword')); ?>"><?php echo e(trans('admin.i_forgot_my_password')); ?></a><br>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.install', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>