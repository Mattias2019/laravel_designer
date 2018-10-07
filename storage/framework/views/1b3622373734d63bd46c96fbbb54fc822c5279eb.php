<?php $__env->startSection('title', trans('admin.manufacturers_list') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if($manufacturerslist): ?>

<div class="box box-info">
  <div class="box-header">
    <h3 class="box-title"><?php echo e(trans('admin.manufacturers_list')); ?></h3>
    <div class="box-tools pull-right">
      <a href="<?php echo e(route('admin.add_manufacturers_content')); ?>" class="btn btn-primary pull-right"><?php echo e(trans('admin.add_new_manufacturers')); ?></a>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="<?php echo e(route('admin.manufacturers_list_content')); ?>" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_brand" class="search-query form-control" placeholder="Enter your brand name to search" value="<?php echo e($search_value); ?>" />
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
        <table class="table table-bordered table-striped admin-data-table">
          <thead>
            <tr>
              <th><?php echo e(trans('admin.image')); ?></th>
              <th><?php echo e(trans('admin.name')); ?></th>
              <th><?php echo e(trans('admin.country_name')); ?></th>
              <th><?php echo e(trans('admin.status')); ?></th>
              <th><?php echo e(trans('admin.action')); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($manufacturerslist)>0): ?>
              <?php $__currentLoopData = $manufacturerslist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <?php if($row['brand_logo_img_url']): ?>
                <td><img src="<?php echo e(get_image_url($row['brand_logo_img_url'])); ?>" alt="<?php echo e(basename ($row['brand_logo_img_url'])); ?>"></td>
                <?php else: ?>
                <td><img src="<?php echo e(default_placeholder_img_src()); ?>" alt=""></td>
                <?php endif; ?>

                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['brand_country_name']; ?></td>

                <?php if($row['status'] == 1): ?>
                <td><?php echo e(trans('admin.enable')); ?></td>
                <?php else: ?>
                <td><?php echo e(trans('admin.disable')); ?></td>
                <?php endif; ?>

                <td>
                  <div class="btn-group">
                    <button class="btn btn-success btn-flat" type="button"><?php echo e(trans('admin.action')); ?></button>
                    <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                      <span class="caret"></span>
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                      <li><a target="_blank" href="<?php echo e(route('brands-single-page', $row['slug'])); ?>"><i class="fa fa-eye"></i><?php echo trans('admin.view'); ?></a></li>  
                      <?php if(in_array('add_edit_delete_brands', $user_permission_list)): ?>
                      <li><a href="<?php echo e(route('admin.update_manufacturers_content', $row['slug'])); ?>"><i class="fa fa-edit"></i><?php echo e(trans('admin.edit')); ?></a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="manufacturers_list" data-id="<?php echo e($row['term_id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo e(trans('admin.delete')); ?></a></li>
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
            <th><?php echo e(trans('admin.image')); ?></th>
            <th><?php echo e(trans('admin.name')); ?></th>
            <th><?php echo e(trans('admin.country_name')); ?></th>
            <th><?php echo e(trans('admin.status')); ?></th>
            <th><?php echo e(trans('admin.action')); ?></th>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $manufacturerslist->appends(Request::capture()->except('page'))->render(); ?></div>
      </div>
    </div>
  </div>
</div>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>