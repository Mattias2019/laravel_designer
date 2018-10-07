<?php $__env->startSection('vendor-admin-withdraw-content'); ?>
<h4 class="box-title"><?php echo trans('admin.withdraw_requests_list_label'); ?></h4><hr class="text-border-bottom">
<div class="row">
  <div class="col-md-12">
    <div class="list-top-label">
      <ul>
        <li><a <?php echo e($is_all); ?> href="<?php echo e(route('admin.withdraws_content')); ?>"><?php echo trans('admin.only_all_label'); ?> (<?php echo $total_row; ?>) </a></li> &nbsp; | &nbsp;  
        <li><a <?php echo e($is_pending); ?> href="<?php echo e(route('admin.withdraws_status_change', 'pending')); ?>"><?php echo trans('admin.pending'); ?> (<?php echo $total_pending; ?>) </a></li> &nbsp; | &nbsp;
        <li><a <?php echo e($is_completed); ?> href="<?php echo e(route('admin.withdraws_status_change', 'completed')); ?>"><?php echo trans('admin.completed'); ?> (<?php echo $total_completed; ?>) </a></li> &nbsp; | &nbsp;
        <li><a <?php echo e($is_cancelled); ?> href="<?php echo e(route('admin.withdraws_status_change', 'cancelled')); ?>"><?php echo trans('admin.cancelled'); ?> (<?php echo $total_cancelled; ?>) </a></li>
      </ul>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box box-solid">
      <div class="box-body">
        <table id="table_for_products_list" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th><?php echo trans('admin.vendor_name_label'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.only_ip_label'); ?></th>
              <th><?php echo trans('admin.requested_date_label'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
          <?php if(count($withdraw_request_data_all) > 0): ?>
            <?php $__currentLoopData = $withdraw_request_data_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><a target="_blank" href="<?php echo e(route('store-details-page-content', get_vendor_name($row['user_id']))); ?>"><?php echo get_vendor_name($row['user_id']); ?></a></td>
              <td>
                <?php if($row['status'] == 'COMPLETED'): ?>  
                <span style="color:#00a65a;"><?php echo trans('admin.completed'); ?></span>
                <?php elseif($row['status'] == 'CANCELLED'): ?>
                <span style="color:#ff0084;"><?php echo trans('admin.cancelled'); ?></span>
                <?php elseif($row['status'] == 'ON_HOLD'): ?>
                <span style="color:#3c8dbc;"><?php echo trans('admin.pending'); ?></span>
                <?php endif; ?>
              </td>
              <td><?php echo $row['ip']; ?></td>
              <td><?php echo Carbon\Carbon::parse(  $row['created_at'] )->format('d, M Y'); ?></td>
              <td>
                <div class="btn-group">
                  <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                  <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul role="menu" class="dropdown-menu">
                    <li><a href="#" data-toggle="modal" data-target="#vendors_withdraw_view" class="withdraw-requests-data-view" data-requested_id="<?php echo e($row['id']); ?>"><i class="fa fa-eye"></i><?php echo e(trans('admin.view')); ?></a></li>
                    <?php if(($row['status'] == 'ON_HOLD')): ?>
                    <li><a href="#" class="requested-withdraw-status-change" data-target="completed" data-requested_id="<?php echo e($row['id']); ?>"><i class="fa fa-check"></i><?php echo e(trans('admin.completed')); ?></a></li>
                    <li><a href="#" class="requested-withdraw-status-change" data-target="cancelled" data-requested_id="<?php echo e($row['id']); ?>"><i class="fa fa-close"></i><?php echo e(trans('admin.cancelled')); ?></a></li>
                    <?php endif; ?>
                  </ul>
                </div>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
          <tr><td colspan="5"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>
          <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo trans('admin.vendor_name_label'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.only_ip_label'); ?></th>
              <th><?php echo trans('admin.requested_date_label'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $withdraw_request_data_all->appends(Request::capture()->except('page'))->render(); ?></div>  
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="vendors_withdraw_view" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
      <div class="modal-body">
        <div class="eb-overlay-loader"></div>
      </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>