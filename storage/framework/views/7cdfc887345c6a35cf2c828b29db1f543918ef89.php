<?php $__env->startSection('title', trans('admin.comments_list') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('admin.comments_list'); ?></h3>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php echo trans('admin.user_image'); ?></th>
              <th><?php echo trans('admin.user_display_name'); ?></th>
              <th><?php echo trans('admin.product_name'); ?></th>
              <th><?php echo trans('admin.user_contents'); ?></th>
              <th><?php echo trans('admin.user_rating_val'); ?></th>
              <th><?php echo trans('admin.comment_status'); ?></th>
              <th><?php echo trans('admin.comment_added'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($product_comments) > 0): ?>  
              <?php $__currentLoopData = $product_comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <?php if($row->user_photo_url): ?>
                  <td><img src="<?php echo e(get_image_url($row->user_photo_url)); ?>" alt="<?php echo e($row->user_photo_url); ?>"></td>
                <?php else: ?>
                  <td><img src="<?php echo e(default_placeholder_img_src()); ?>" alt=""></td>
                <?php endif; ?>

                <td><?php echo $row->display_name; ?></td>
                <td><?php echo $row->title; ?></td>
                <td><?php echo $row->content; ?></td>
                <td><?php echo $row->rating; ?></td>

                <?php if($row->status == 1): ?>
                  <td><?php echo trans('admin.enable'); ?></td>
                <?php else: ?>
                  <td><?php echo trans('admin.disable'); ?></td>
                <?php endif; ?>

                <td><?php echo e(Carbon\Carbon::parse(  $row->created_at )->format('d, M Y')); ?></td>

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button"><?php echo trans('admin.action'); ?></button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <?php if($row->status == 1): ?>
                        <li><a href="" class="comments-status-change" data-target="product" data-id="<?php echo e($row->id); ?>" data-status="disable"><i class="fa fa-close"></i><?php echo trans('admin.disable'); ?></a></li>
                      <?php else: ?>
                        <li><a href="" class="comments-status-change" data-target="product" data-id="<?php echo e($row->id); ?>" data-status="enable"><i class="fa fa-check-circle"></i><?php echo trans('admin.enable'); ?></a></li>
                      <?php endif; ?>
                      <li><a target="_blank" href="<?php echo e(route('details-page', $row->slug)); ?>"><i class="fa fa-eye"></i><?php echo trans('admin.view'); ?></a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="product_comments_list" data-id="<?php echo e($row->id); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <tr><td colspan="8"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>  
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo trans('admin.user_image'); ?></th>
              <th><?php echo trans('admin.user_display_name'); ?></th>
              <th><?php echo trans('admin.product_name'); ?></th>
              <th><?php echo trans('admin.user_contents'); ?></th>
              <th><?php echo trans('admin.user_rating_val'); ?></th>
              <th><?php echo trans('admin.comment_status'); ?></th>
              <th><?php echo trans('admin.comment_added'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>