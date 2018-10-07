<?php $__env->startSection('title', trans('frontend.retrieve_password') .' < '. get_site_title() ); ?>
<?php $__env->startSection('content'); ?>

<br><br>
<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="text-center">
          <img src="<?php echo e(URL::asset('public/images/forgot-password.png')); ?>">
          
          <h3 class="text-center"><?php echo e(trans('frontend.forgot_password')); ?></h3>
          
          <p><?php echo e(trans('frontend.reset_password_msg')); ?></p>
            <div class="panel-body">

              <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

              <form method="post" action="" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
                <fieldset>                 
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                      <input id="forgotEmailInput" placeholder="<?php echo e(trans('frontend.email_address')); ?>" class="form-control" type="email" name="forgotEmailInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                      <input id="resetPasswordInput" placeholder="<?php echo e(trans('frontend.new_password')); ?>" class="form-control" type="password" name="resetPasswordInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
                      <input id="secretKeyInput" placeholder="<?php echo e(trans('frontend.secret_key')); ?>" class="form-control" type="text" name="secretKeyInput">
                    </div>
                  </div>

                  <div class="form-group">
                    <input class="btn btn-lg btn-primary btn-block" value="<?php echo e(trans('frontend.reset_my_password')); ?>" type="submit">
                  </div>
                </fieldset>
              </form>

            </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin.install', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>