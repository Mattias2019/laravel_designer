<?php $__env->startSection('title', trans('admin.coupon_manager_list_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title"><?php echo trans('admin.coupon_list_label'); ?></h3>
    <div class="box-tools pull-right">
      <a href="<?php echo e(route('admin.coupon_manager_content')); ?>" class="btn btn-primary"><?php echo trans('admin.create_new_coupon_label'); ?></a>
    </div>
  </div>
</div>

<div class="row"> 
  <div class="col-xs-12">
    <h3></h3>  
    <div class="box">
      <div class="box-body">
				<div id="table_search_option">
          <form action="<?php echo e(route('admin.coupon_manager_list')); ?>" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_coupon" class="search-query form-control" placeholder="Enter your title to search" value="<?php echo e($search_value); ?>" />
                  <div class="input-group-btn">
                    <button class="btn btn-primary" type="submit">
                      <span class="glyphicon glyphicon-search"></span>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </form>  
        </div>    
        <table class="table table-striped table-bordered dt-responsive nowrap data-table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo trans('admin.coupon_code_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_type_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_amount_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_description_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_usage_limit_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_usage_selected_role_tbl_title'); ?></th>
              <th><?php echo trans('admin.coupon_expiry_date_tbl_title'); ?></th>
              <th><?php echo trans('admin.vendor_name_label'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($coupon_all_data) > 0): ?>  
              <?php $__currentLoopData = $coupon_all_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo $row['post_title']; ?></td>
                  
                  <?php if($row['coupon_condition_type'] == 'discount_from_product'): ?>
                    <td><?php echo trans('admin.discount_from_product_label'); ?></td>
                  <?php elseif($row['coupon_condition_type'] == 'percentage_discount_from_product'): ?> 
                    <td><?php echo trans('admin.percentage_discount_from_product_label'); ?></td>
                  <?php elseif($row['coupon_condition_type'] == 'discount_from_total_cart'): ?> 
                    <td><?php echo trans('admin.discount_from_total_cart_label'); ?></td>
                  <?php elseif($row['coupon_condition_type'] == 'percentage_discount_from_total_cart'): ?> 
                    <td><?php echo trans('admin.percentage_discount_from_total_cart_label'); ?></td>  
                  <?php endif; ?>
                  
                  <td><?php echo $row['coupon_amount']; ?></td>
                  <td><?php echo string_decode($row['post_content']); ?></td>
                  <td><?php echo $row['usage_limit_per_coupon']; ?></td>
                  <td><?php echo $row['coupon_allow_role_name']; ?></td>
                  <td><?php echo e(Carbon\Carbon::parse(  $row['usage_range_end_date'] )->format('F d, Y')); ?></td>
                  <td><?php echo get_vendor_name( $row['post_author_id'] ); ?></td>
                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a href="<?php echo e(route('admin.update_coupon_manager_content', $row['post_slug'])); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                        <li><a class="remove-selected-data-from-list" data-track_name="coupon_list" data-id="<?php echo e($row['id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo e(trans('admin.delete')); ?></a></li>
                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <tr><td colspan="9"><i class="fa fa-exclamation-triangle"></i> <?php echo trans('admin.no_data_found_label'); ?></td></tr>  
            <?php endif; ?>
          </tbody>
          <tfoot>
            <tr>
              <th><?php echo e(trans('admin.coupon_code_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_type_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_amount_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_description_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_usage_limit_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_usage_selected_role_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.coupon_expiry_date_tbl_title')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </tfoot>
        </table>
				<div class="products-pagination"><?php echo $coupon_all_data->appends(Request::capture()->except('page'))->render(); ?></div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>