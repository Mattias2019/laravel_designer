<?php $__env->startSection('title', trans('admin.pages_list_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4><?php echo trans('admin.pages_list'); ?></h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <a href="<?php echo e(route('admin.add_page')); ?>" class="btn btn-primary"><?php echo trans('admin.add_new_page'); ?></a>
    </div>  
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="<?php echo e(route('admin.all_pages')); ?>" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_page" class="search-query form-control" placeholder="<?php echo e(trans('admin.post_title_search_placeholder')); ?>" value="<?php echo e($search_value); ?>" />
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
              <th><?php echo trans('admin.post_title'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($pages_list)>0): ?>
              <?php $__currentLoopData = $pages_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                  <td><?php echo $row['post_title']; ?></td>

                  <?php if($row['post_status'] == 1): ?>
                    <td><?php echo trans('admin.enable'); ?></td>
                  <?php else: ?>
                    <td><?php echo trans('admin.disable'); ?></td>
                  <?php endif; ?>

                  <td>
                    <div class="btn-group">
                      <button class="btn btn-success btn-flat" type="button"><?php echo trans('admin.action'); ?></button>
                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li><a target="_blank" href="<?php echo e(route('custom-page-content', $row['post_slug'])); ?>"><i class="fa fa-eye"></i><?php echo trans('admin.view'); ?></a></li>  
                        
                        <?php if(in_array('add_edit_delete_pages', $user_permission_list)): ?>
                          <li><a href="<?php echo e(route('admin.update_page', $row['post_slug'])); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                        <?php endif; ?>
                        
                        <?php if(in_array('add_edit_delete_pages', $user_permission_list)): ?>
                          <li><a class="remove-selected-data-from-list" data-track_name="pages_list" data-id="<?php echo e($row['id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
                        <?php endif; ?>
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
              <th><?php echo trans('admin.post_title'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $pages_list->appends(Request::capture()->except('page'))->render(); ?></div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>