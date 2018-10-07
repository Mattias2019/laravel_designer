<?php $__env->startSection('title', trans('admin.request_product_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xs-12">
    <h3></h3>  
    <div class="box">
      <div class="box-body">
        <table class="table table-striped table-bordered dt-responsive nowrap data-table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo e(trans('admin.request_product_table_header_name_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_email_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_tele_number_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_source_name_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_desc_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_date_title')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($request_product_data) > 0): ?>  
              <?php $__currentLoopData = $request_product_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo e($row->name); ?></td>  
                  <td><?php echo e($row->email); ?></td>
                  <td><?php echo e($row->phone_number); ?></td>
                  <td><a target="_blank" href="<?php echo e(route('details-page', $row->slug)); ?>"> <?php echo e($row->title); ?> </a></td>
                  <td><?php echo e($row->description); ?></td>
                  <td><?php echo e(Carbon\Carbon::parse(  $row->created_at )->format('F d, Y')); ?></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a class="remove-selected-data-from-list" data-track_name="request_product_list" data-id="<?php echo e($row->id); ?>" href="#"><i class="fa fa-remove"></i><?php echo e(trans('admin.delete')); ?></a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <tr><td colspan="7"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>  
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo e(trans('admin.request_product_table_header_name_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_email_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_tele_number_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_source_name_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_desc_title')); ?></th>
              <th><?php echo e(trans('admin.request_product_table_header_date_title')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>