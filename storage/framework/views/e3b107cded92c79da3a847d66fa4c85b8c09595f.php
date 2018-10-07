<h3><?php echo trans('admin.emails_notifications_new_order_label'); ?></h3><hr>
<p><?php echo trans('admin.email_new_order_received_label'); ?></p>
<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="email_type" value="new_order">
  
  <div class="box box-solid">
    <div class="box-body">
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputEnableDisable"><?php echo e(trans('admin.email_enable_disable_label')); ?></label>
        <div class="col-sm-8">
          <?php if($emails_notification_data['new_order']['enable_disable'] == true): ?>
            <input type="checkbox" checked="checked" name="new_order_enable_disable" class="shopist-iCheck"> &nbsp;<?php echo trans('admin.enable_notify_msg_label'); ?>

          <?php else: ?>
            <input type="checkbox" name="new_order_enable_disable" class="shopist-iCheck"> &nbsp;<?php echo trans('admin.enable_notify_msg_label'); ?>

          <?php endif; ?>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputSubject"><?php echo e(trans('admin.subject')); ?></label>
        <div class="col-sm-8">
          <input type="text" name="new_order_subject" class="form-control" value="<?php echo e($emails_notification_data['new_order']['subject']); ?>">
          <span style="font-style: italic;">[date will replace with "#date_place#" string]</span>
        </div>
      </div> 
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputEmailHeading"><?php echo e(trans('admin.email_heading_label')); ?></label>
        <div class="col-sm-8">
          <input type="text" name="new_order_email_heading" class="form-control" value="<?php echo e($emails_notification_data['new_order']['email_heading']); ?>">
        </div>
      </div> 
      <div class="form-group">
        <label class="col-sm-4 control-label" for="inputBodyBGColor"><?php echo e(trans('admin.body_bg_color_label')); ?></label>
        <div class="col-sm-8">
          <input type="text" name="new_order_body_bg_color" class="form-control color" value="<?php echo e($emails_notification_data['new_order']['body_bg_color']); ?>">
        </div>
      </div>   
      <br>
      <h4><strong><?php echo trans('admin.select_template_label'); ?></strong></h4><hr>
      <div class="order-confirmation-templates-list">
        <?php if(count($email_templates) > 0): ?>
          <div class="row">
            <?php $__currentLoopData = $email_templates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-xs-12 col-md-4 sample-img-content">
                <div class="sample-img-content">
                  <img src="<?php echo e(url('resources/views/emails/order-confirmation/' . $val. '/screenshot-temp-1.jpg')); ?>" class="img-responsive" alt="sample_img">
                  <div class="manage-template clearfix">
                    <span><?php echo ucwords(str_replace('-', ' ', $val)); ?></span>
                    <span class="pull-right">
                      <?php if($emails_notification_data['new_order']['selected_template'] == $val): ?>
                        <input type="radio" checked="checked" name="templates_name" class="shopist-iCheck" value="<?php echo e($val); ?>">
                      <?php else: ?>
                        <input type="radio" name="templates_name" class="shopist-iCheck" value="<?php echo e($val); ?>">
                      <?php endif; ?>
                    </span>
                  </div>
                </div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endif; ?>
      </div>  
    </div>
    <div class="clearfix">
      <div class="pull-right">
        <button style="margin:0px 15px 15px 0px;" class="btn btn-primary pull-right" type="submit"><?php echo e(trans('admin.save')); ?></button>
      </div>
    </div>
  </div>		
</form>    