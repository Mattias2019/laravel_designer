<?php if(Request::is('admin/product/categories/list')): ?>
  <?php $__env->startSection('title', trans('admin.product_categories_list') .' < '. get_site_title()); ?>
<?php elseif(Request::is('admin/blog/categories/list')): ?>
  <?php $__env->startSection('title', trans('admin.blog_categories_list') .' < '. get_site_title()); ?>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
<div class="row">
  <div class="col-xs-7 col-sm-7 col-md-7 col-lg-7">
    <h4><?php echo trans('admin.categories_list'); ?></h4>
  </div>
  <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
    <div class="pull-right">
      <button data-toggle="modal" data-target="#addDynamicCategories" class="btn btn-primary custom-event" type="button"><?php echo trans('admin.add_new_category'); ?></button>
    </div>  
  </div>
</div>

<div class="modal fade" id="addDynamicCategories" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog add-cat-dialog">
    <div class="ajax-overlay"></div>
    
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
        <br>
        <i class="icon-credit-card icon-7x"></i>
        <p class="no-margin top-title"><b><?php echo trans('admin.create_new_product_category'); ?></b></p>
      </div>
      <div class="modal-body">
        <div class="custom-model-row">
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatName"><?php echo trans('admin.name'); ?></label></div>
            <div class="custom-input-element"><input type="text" placeholder="<?php echo e(trans('admin.category_name')); ?>" id="inputCatName" name="inputCatName" class="form-control"></div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatSlug"><?php echo trans('admin.slug'); ?></label></div>
            <div class="custom-input-element"><input type="text" placeholder="<?php echo e(trans('admin.enter_unique_slug_name')); ?>" id="inputCatSlug" name="inputCatSlug" class="form-control">
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatParent"><?php echo trans('admin.parent'); ?></label></div>
            <div class="custom-input-element">
              <select name="cat_parent" id="cat_parent" class="form-control select2" style="width: 100%;">
                <option value="0"><?php echo trans('admin.none'); ?></option>
                <?php if(count($only_cat_name)>0): ?>
                  <?php $__currentLoopData = $only_cat_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($row['id']); ?>"> <?php echo $row['name']; ?> </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
              </select>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatDescription"><?php echo trans('admin.description'); ?></label></div>
            <div class="custom-input-element">
              <textarea class="form-control" name="inputCatDescription" id="inputCatDescription" placeholder="<?php echo e(trans('admin.description')); ?>"></textarea>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatStatus"><?php echo trans('admin.status'); ?></label></div>
            <div class="custom-input-element">
              <select name="cat_status" id="cat_status" class="form-control select2" style="width: 100%;">
                <option value="1"><?php echo trans('admin.enable'); ?></option>
                <option value="0"><?php echo trans('admin.disable'); ?></option>
              </select>
            </div>
          </div>
          <div class="custom-input-group">
            <div class="custom-input-label"><label for="inputCatThumbnail"><?php echo trans('admin.thumbnail'); ?></label></div>
            <div class="custom-input-element">
              <div class="uploadform dropzone no-margin dz-clickable upload-cat-img" id="upload_cat_img" name="upload_cat_img">
                <div class="dz-default dz-message">
                  <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                </div>
              </div>
              <br>
              <div class="cat-img-content">
                <div class="cat-sample-img"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt=""></div>
                <div class="cat-img"><img class="img-responsive" src="" alt=""></div>
                <br>
                <div class="cat-img-upload-btn">
                  <button type="button" class="btn btn-default attachtopost remove-cat-img"><?php echo trans('admin.remove_image'); ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default attachtopost create-cat"><?php echo trans('admin.create_category'); ?></button>
        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-body">
        <div id="table_search_option">
          <form action="<?php echo e($action); ?>" method="GET"> 
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="input-group">
                  <input type="text" name="term_cat" class="search-query form-control" placeholder="<?php echo e(trans('admin.cat_search_placeholder')); ?>" value="<?php echo e($search_value); ?>" />
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
        <table class="table table-striped table-bordered dt-responsive nowrap admin-data-table" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th><?php echo trans('admin.image'); ?></th>
              <th><?php echo trans('admin.name'); ?></th>
              <th><?php echo trans('admin.category_type'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </thead>
          <tbody>
            <?php if(count($cat_list_data)>0): ?>
              <?php $__currentLoopData = $cat_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <?php if(!empty($row['category_img_url'])): ?>
                <td><img src="<?php echo e(get_image_url( $row['category_img_url'] )); ?>" alt="<?php echo e(basename ($row['category_img_url'])); ?>"></td>
                <?php else: ?>
                <td><img src="<?php echo e(default_placeholder_img_src()); ?>" alt=""></td>
                <?php endif; ?>

                <td><?php echo $row['name']; ?></td>

                <?php if($row['parent'] == 0): ?>
                <td><?php echo trans('admin.parent_category'); ?></td>
                <?php else: ?>
                <td><?php echo trans('admin.sub_category'); ?></td>
                <?php endif; ?>

                <?php if($row['status'] == 1): ?>
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
                      <li><a href="#" class="edit-data" data-track_name="cat_list" data-id="<?php echo e($row['term_id']); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                      <li><a class="remove-selected-data-from-list" data-track_name="cat_list" data-id="<?php echo e($row['term_id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
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
              <th><?php echo trans('admin.image'); ?></th>
              <th><?php echo trans('admin.name'); ?></th>
              <th><?php echo trans('admin.category_type'); ?></th>
              <th><?php echo trans('admin.status'); ?></th>
              <th><?php echo trans('admin.action'); ?></th>
            </tr>
          </tfoot>
        </table>
        <div class="products-pagination"><?php echo $cat_list_data->appends(Request::capture()->except('page'))->render(); ?></div>
      </div>
    </div>
  </div>
</div>

<div class="eb-overlay"></div>
<div class="eb-overlay-loader"></div>

<input type="hidden" name="hf_from_model" id="hf_from_model" value="">
<input type="hidden" name="hf_update_id" id="hf_update_id" value="">

<?php if(Request::is('admin/product/categories/list')): ?>
<input type="hidden" name="hf_cat_post_for" id="hf_cat_post_for" value="product_cat">
<?php elseif(Request::is('admin/blog/categories/list')): ?>
<input type="hidden" name="hf_cat_post_for" id="hf_cat_post_for" value="blog_cat">
<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>