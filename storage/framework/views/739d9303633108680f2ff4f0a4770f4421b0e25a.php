<?php $__env->startSection('title', trans('admin.custom_subscriptions_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title"><?php echo e(trans('admin.custom_subscriptions_info_top_title')); ?></h3>
        </div> 
        <div class="box-body">
          <table class="table table-bordered table-striped admin-data-table">
            <thead>
              <tr>
                <th><?php echo e(trans('admin.custom_subscriptions_info_email_id_title')); ?></th>
                <th><?php echo e(trans('admin.custom_subscriptions_info_name_title')); ?></th>
                <th><?php echo e(trans('admin.custom_subscriptions_info_date_title')); ?></th>
              </tr>
            </thead>
            <tbody>
              <?php if(count($custom_subscriber_data) > 0): ?>
                <?php $__currentLoopData = $custom_subscriber_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo e(Carbon\Carbon::parse( $row['created_at'] )->format('F d, Y')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php else: ?>
              <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>  
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr>
                <th><?php echo e(trans('admin.custom_subscriptions_info_email_id_title')); ?></th>
                <th><?php echo e(trans('admin.custom_subscriptions_info_name_title')); ?></th>
                <th><?php echo e(trans('admin.custom_subscriptions_info_date_title')); ?></th>
              </tr>
          </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>