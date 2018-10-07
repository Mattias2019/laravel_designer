<?php $__env->startSection('title', trans('admin.orders_list') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <table class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th><?php echo e(trans('admin.orders')); ?></th>
              <th><?php echo e(trans('admin.order_totals')); ?></th>
              <th><?php echo e(trans('admin.vendor_name_label')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($orders_list_data)>0): ?>
              <?php $__currentLoopData = $orders_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><a href="<?php echo e(route('admin.view_order_details', $row['_post_id'])); ?>"><?php echo e(trans('admin.order')); ?> #<?php echo $row['_post_id']; ?></a><?php if($row['_order_status'] == 'on-hold'): ?><span class="on-hold-label"><?php echo e(trans('admin.on_hold')); ?></span><?php elseif($row['_order_status'] == 'refunded'): ?> <span class="refunded-label"><?php echo e(trans('admin.refunded')); ?></span><?php elseif($row['_order_status'] == 'cancelled'): ?> <span class="cancelled-label"><?php echo e(trans('admin.cancelled')); ?></span> <?php elseif($row['_order_status'] == 'pending'): ?> <span class="pending-label"><?php echo e(trans('admin.pending')); ?></span> <?php elseif($row['_order_status'] == 'processing'): ?> <span class="processing-label"><?php echo e(trans('admin.processing')); ?></span> <?php elseif($row['_order_status'] == 'completed'): ?> <span class="completed-label"><?php echo e(trans('admin.completed')); ?></span> <?php elseif($row['_order_status'] == 'shipping'): ?> <span class="shipping-label"><?php echo e(trans('admin.shipping')); ?></span> <?php endif; ?> <br><span class="order-date-format"><?php echo $row['_order_date']; ?></span></td>
                <td><?php echo price_html( $row['_final_order_total'], $row['_order_currency'] ); ?></td>
                <td><?php echo get_vendor_name(get_vendor_id_by_order_id( $row['_post_id'] )); ?></td>
                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a href="<?php echo e(route('admin.view_order_details', $row['_post_id'])); ?>"><i class="fa  fa-search"></i><?php echo e(trans('admin.view_order')); ?></a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="order_list" data-id="<?php echo e($row['_post_id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo e(trans('admin.delete')); ?></a></li>
                    </ul>
                  </div>
                </td>
              </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <tr><td colspan="3"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>  
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo e(trans('admin.orders')); ?></th>
              <th><?php echo e(trans('admin.order_totals')); ?></th>
              <th><?php echo e(trans('admin.vendor_name_label')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $orders_list_data->appends(Request::capture()->except('page'))->render(); ?></div>   
      </div>
    </div>
  </div>
</div>
<input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>