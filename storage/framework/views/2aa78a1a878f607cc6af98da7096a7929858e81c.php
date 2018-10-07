<?php $__env->startSection('title', trans('admin.update_product') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php if(Session::has('update-message')): ?>
  <?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php else: ?>
  <?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endif; ?>

<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo trans('admin.update_product'); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.product_list', 'all')); ?>"><?php echo trans('admin.products_list'); ?></a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.add_product')); ?>"><?php echo trans('admin.add_new_product'); ?></a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" target="_blank" href="<?php echo e(route( 'details-page', $product_post_data['post_slug'])); ?>"><?php echo trans('admin.view'); ?></a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary pull-right" type="submit"><?php echo trans('admin.update'); ?></button>
      </div>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.product_name'); ?></h3>
        </div>
        <div class="box-body">
            <input type="text" placeholder="<?php echo e(trans('admin.example_red_t_shirt')); ?>" class="form-control" name="product_name" id="eb_product_name" value="<?php echo e($product_post_data['post_title']); ?>">
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.product_description'); ?></h3>
        </div>
        <div class="box-body">
          <textarea id="eb_description_editor" name="eb_description_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.product_description_placeholder')); ?>">
          <?php echo $product_post_data['post_content']; ?>           
          </textarea>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-upload"></i>
          <h3 class="box-title"><?php echo trans('admin.product_image'); ?></h3>
          <div class="box-tools pull-right">
            <div data-toggle="modal" data-dropzone_id="eb_dropzone_file_upload" data-target="#productUploader" class="icon product-uploader"><?php echo trans('admin.upload_image'); ?></div>
          </div>
        </div>
        <div class="box-body">
          <div class="uploaded-product-image">
            <?php if($product_post_data['_product_related_images_url']->product_image && $product_post_data['_product_related_images_url']->product_image != '/images/upload.png'): ?>
            <div class="product-sample-img" style="display:none;"><img class="upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="product-uploaded-image" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url($product_post_data['_product_related_images_url']->product_image)); ?>"><div class="remove-img-link"><button type="button" data-target="product_image" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
            <?php else: ?>
            <div class="product-sample-img" style="display:block;"><img class="upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="product-uploaded-image" style="display:none;"><img class="img-responsive"><div class="remove-img-link"><button type="button" data-target="product_image" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
            <?php endif; ?>
          </div>
            
          <div class="modal fade" id="productUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                  <br>
                  <i class="icon-credit-card icon-7x"></i>
                  <p class="no-margin"><?php echo trans('admin.you_can_upload_1_image'); ?></p>
                </div>
                <div class="modal-body">             
                  <div class="uploadform dropzone no-margin dz-clickable eb_dropzone_file_upload" id="eb_dropzone_file_upload" name="eb_dropzone_file_upload">
                    <div class="dz-default dz-message">
                      <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-upload"></i>
          <h3 class="box-title"><?php echo trans('admin.gallery_images'); ?></h3>
          <div class="box-tools pull-right">
            <div data-toggle="modal" data-dropzone_id="eb_dropzone_gallery_image_file_upload" data-target="#productGalleryUploader" class="icon product-gallery-uploader"><?php echo trans('admin.upload_image'); ?></div>
          </div>
        </div>
        <div class="box-body">
          <div class="uploaded-product-gallery-image">
            <?php if(count($product_post_data['_product_related_images_url']->product_gallery_images)>0): ?>
            <div class="product-uploaded-gallery-image" style="display:block;">
              <?php $__currentLoopData = $product_post_data['_product_related_images_url']->product_gallery_images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="gallery-image-single-container"><img class="img-responsive" src="<?php echo e(get_image_url($data->url)); ?>"><div data-id="<?php echo e($data->id); ?>" class="remove-gallery-img-link"></div></div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="product-gallery-sample-img" style="display:none;"><img class="gallery-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <?php else: ?>
            <div class="product-gallery-sample-img"><img class="gallery-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="product-uploaded-gallery-image"></div>
            <?php endif; ?>
          </div>  
          <div class="modal fade" id="productGalleryUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                  <br>
                  <i class="icon-credit-card icon-7x"></i>
                  <p class="no-margin"><?php echo trans('admin.you_can_upload_10_image'); ?></p>
                </div>
                <div class="modal-body">             
                  <div class="uploadform dropzone no-margin dz-clickable eb_dropzone_gallery_image_file_upload" id="eb_dropzone_gallery_image_file_upload" name="eb_dropzone_gallery_image_file_upload">
                    <div class="dz-default dz-message">
                      <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-upload"></i>
          <h3 class="box-title"><?php echo trans('admin.shop_banner'); ?></h3>
          <div class="box-tools pull-right">
            <div data-toggle="modal" data-dropzone_id="eb_dropzone_banner_file_upload" data-target="#shopbannerUploader" class="icon shop-banner-uploader"><?php echo trans('admin.upload_image'); ?></div>
          </div>
        </div>
        <div class="box-body">
          <div class="uploaded-banner-image">
            <?php if($product_post_data['_product_related_images_url']->shop_banner_image && $product_post_data['_product_related_images_url']->shop_banner_image != '/images/upload.png'): ?>
            <div class="banner-uploaded-image" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url($product_post_data['_product_related_images_url']->shop_banner_image)); ?>"><div class="remove-img-link banner-img-remove"><button type="button" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
            <div class="banner-sample-img" style="display:none;"><img class="banner-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <?php else: ?>
            <div class="banner-sample-img"><img class="banner-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="banner-uploaded-image"><img class="img-responsive"><div class="remove-img-link banner-img-remove"><button type="button" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
            <?php endif; ?>
          </div>
            
          <div class="modal fade" id="shopbannerUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                  <br>
                  <i class="icon-credit-card icon-7x"></i>
                  <p class="no-margin"><?php echo trans('admin.you_can_upload_1_image'); ?></p>
                </div>
                <div class="modal-body">             
                  <div class="uploadform dropzone no-margin dz-clickable eb_dropzone_banner_file_upload" id="eb_dropzone_banner_file_upload" name="eb_dropzone_banner_file_upload">
                    <div class="dz-default dz-message">
                      <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                    </div>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="box box-solid product-type-details">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.product_type'); ?></h3>
          <div class="box-tools pull-right">
            <select id="change_product_type" name="change_product_type" class="form-control select2" style="width: 100%;">
              <?php if($product_post_data['post_type'] == 'simple_product'): ?>
                <option selected="selected" value="simple_product"><?php echo trans('admin.simple_product'); ?></option>
              <?php else: ?>
                <option value="simple_product"><?php echo trans('admin.simple_product'); ?></option>
              <?php endif; ?>
              
              <?php if($product_post_data['post_type'] == 'configurable_product'): ?>
                <option selected="selected" value="configurable_product"><?php echo trans('admin.configurable_product'); ?></option>
              <?php else: ?>
                <option value="configurable_product"><?php echo trans('admin.configurable_product'); ?></option>
              <?php endif; ?>
              
              <?php if($product_post_data['post_type'] == 'customizable_product'): ?>
                <option selected="selected" value="customizable_product"><?php echo trans('admin.customizable_product'); ?></option>
              <?php else: ?>
                <option value="customizable_product"><?php echo trans('admin.customizable_product'); ?></option>
              <?php endif; ?>
														
							<?php if($product_post_data['post_type'] == 'downloadable_product'): ?>
                <option selected="selected" value="downloadable_product"><?php echo trans('admin.downloadable_product'); ?></option>
              <?php else: ?>
                <option value="downloadable_product"><?php echo trans('admin.downloadable_product'); ?></option>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="box-body product-tab-content">
          <div class="tabbable tabs-left">
<!--          <div class="nav-tabs-custom">-->
            <ul class="nav nav-tabs">
              <?php if($product_post_data['post_type'] == 'simple_product'): ?>
              <li class="active general"><a href="#tab_general" data-toggle="tab"><?php echo trans('admin.general'); ?></a></li>
              <li class="inventory"><a href="#tab_stock" data-toggle="tab"><?php echo trans('admin.inventory'); ?></a></li>
              <li class="features"><a href="#tab_features" data-toggle="tab"><?php echo trans('admin.features'); ?></a></li>
              <li class="advanced"><a href="#tab_advanced" data-toggle="tab"><?php echo trans('admin.advanced'); ?></a></li>
              <li class="attribute" style="display:none;"><a href="#tab_attribute" data-toggle="tab"><?php echo trans('admin.attributes'); ?></a></li>
              <li class="variations" style="display:none;"><a href="#tab_variations" data-toggle="tab"><?php echo trans('admin.variations'); ?></a></li>
              <li class="custom-design" style="display:none;"><a href="#tab_custom_design" data-toggle="tab"><?php echo trans('admin.edit_design_elements'); ?></a></li>
              <li class="custom-design-layout" style="display:none;"><a href="#tab_custom_design_layout" data-toggle="tab"><?php echo trans('admin.create_layout'); ?></a></li>
														<li class="manage-download-files" style="display:none;"><a href="#tab_manage_download_files" data-toggle="tab"><?php echo trans('admin.manage_download_files'); ?></a></li>
              <?php endif; ?>
              
              <?php if($product_post_data['post_type'] == 'configurable_product'): ?>
              <li class="general" style="display:none;"><a href="#tab_general" data-toggle="tab"><?php echo trans('admin.general'); ?></a></li>
              <li class="inventory" style="display:none;"><a href="#tab_stock" data-toggle="tab"><?php echo trans('admin.inventory'); ?></a></li>
              <li class="active features"><a href="#tab_features" data-toggle="tab"><?php echo trans('admin.features'); ?></a></li>
              <li class="advanced"><a href="#tab_advanced" data-toggle="tab"><?php echo trans('admin.advanced'); ?></a></li>
              <li class="attribute"><a href="#tab_attribute" data-toggle="tab"><?php echo trans('admin.attributes'); ?></a></li>
              <li class="variations"><a href="#tab_variations" data-toggle="tab"><?php echo trans('admin.variations'); ?></a></li>
              <li class="custom-design" style="display:none;"><a href="#tab_custom_design" data-toggle="tab"><?php echo trans('admin.edit_design_elements'); ?></a></li>
              <li class="custom-design-layout" style="display:none;"><a href="#tab_custom_design_layout" data-toggle="tab"><?php echo trans('admin.create_layout'); ?></a></li>
							<li class="manage-download-files" style="display:none;"><a href="#tab_manage_download_files" data-toggle="tab"><?php echo trans('admin.manage_download_files'); ?></a></li>
              <?php endif; ?>
              
              <?php if($product_post_data['post_type'] == 'customizable_product'): ?>
              <li class="active general"><a href="#tab_general" data-toggle="tab"><?php echo trans('admin.general'); ?></a></li>
              <li class="inventory"><a href="#tab_stock" data-toggle="tab"><?php echo trans('admin.inventory'); ?></a></li>
              <li class="features"><a href="#tab_features" data-toggle="tab"><?php echo trans('admin.features'); ?></a></li>
              <li class="advanced"><a href="#tab_advanced" data-toggle="tab"><?php echo trans('admin.advanced'); ?></a></li>
              <li class="attribute"><a href="#tab_attribute" data-toggle="tab"><?php echo trans('admin.attributes'); ?></a></li>
              <li class="variations"><a href="#tab_variations" data-toggle="tab"><?php echo trans('admin.variations'); ?></a></li>
              <li class="custom-design"><a href="#tab_custom_design" data-toggle="tab"><?php echo trans('admin.edit_design_elements'); ?></a></li>
              <li class="custom-design-layout"><a href="#tab_custom_design_layout" data-toggle="tab"><?php echo trans('admin.create_layout'); ?></a></li>
							<li class="manage-download-files" style="display:none;"><a href="#tab_manage_download_files" data-toggle="tab"><?php echo trans('admin.manage_download_files'); ?></a></li>
              <?php endif; ?>
														
							<?php if($product_post_data['post_type'] == 'downloadable_product'): ?>
              <li class="active general"><a href="#tab_general" data-toggle="tab"><?php echo trans('admin.general'); ?></a></li>
              <li class="inventory"><a href="#tab_stock" data-toggle="tab"><?php echo trans('admin.inventory'); ?></a></li>
              <li class="features"><a href="#tab_features" data-toggle="tab"><?php echo trans('admin.features'); ?></a></li>
              <li class="advanced"><a href="#tab_advanced" data-toggle="tab"><?php echo trans('admin.advanced'); ?></a></li>
              <li class="attribute"><a href="#tab_attribute" data-toggle="tab"><?php echo trans('admin.attributes'); ?></a></li>
              <li class="variations"><a href="#tab_variations" data-toggle="tab"><?php echo trans('admin.variations'); ?></a></li>
              <li class="custom-design" style="display:none;"><a href="#tab_custom_design" data-toggle="tab"><?php echo trans('admin.edit_design_elements'); ?></a></li>
              <li class="custom-design-layout" style="display:none;"><a href="#tab_custom_design_layout" data-toggle="tab"><?php echo trans('admin.create_layout'); ?></a></li>
							<li class="manage-download-files"><a href="#tab_manage_download_files" data-toggle="tab"><?php echo trans('admin.manage_download_files'); ?></a></li>
              <?php endif; ?>
            </ul>
            <div class="tab-content">
              <div class="tab-general tab-pane <?php echo e($tabSettings['generalTab']); ?>" id="tab_general">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputSKU"><?php echo trans('admin.sku'); ?></label>
                      <div class="col-sm-6">
                        <input type="text" placeholder="<?php echo e(trans('admin.sku')); ?>" id="inputForProductSKU" name="ProductSKU" class="form-control" value="<?php echo e($product_post_data['post_sku']); ?>">
                        <span><?php echo trans('admin.unique_field'); ?></span>
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputRegularPrice"><?php echo trans('admin.regular_price'); ?> (<?php echo $currency_symbol; ?>)</label>
                      <div class="col-sm-6">
                        <input type="number" placeholder="<?php echo e(trans('admin.regular_price')); ?>" id="inputRegularPrice" name="inputRegularPrice" class="form-control" min="0" step="any" value="<?php echo e($product_post_data['post_regular_price']); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputSalePrice"><?php echo trans('admin.sale_price'); ?> (<?php echo $currency_symbol; ?>)</label>
                      <div class="col-sm-6">
                        <input type="number" placeholder="<?php echo e(trans('admin.sale_price')); ?>" id="inputSalePrice" name="inputSalePrice" class="form-control" min="0" step="any" value="<?php echo e($product_post_data['post_sale_price']); ?>">
                        <?php if($product_post_data['_product_sale_price_start_date'] && $product_post_data['_product_sale_price_end_date']): ?>
                          <a href="#" class="create_sale_schedule" style="display:none;"><?php echo trans('admin.create_schedule'); ?></a>
                        <?php else: ?>
                          <a href="#" class="create_sale_schedule" style="display:block;"><?php echo trans('admin.create_schedule'); ?></a>
                        <?php endif; ?>
                      </div>
                    </div>
                    
                    <?php if($product_post_data['_product_sale_price_start_date'] && $product_post_data['_product_sale_price_end_date']): ?>
                    <div class="form-group sale_start_date" style="display: block;">
                      <label class="col-sm-6 control-label" for="inputSalePriceStartDate"><?php echo trans('admin.sale_price_start_date'); ?></label>
                      <div class="col-sm-6">                  
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" placeholder="<?php echo e(trans('admin.start_date_format')); ?>" id="inputSalePriceStartDate" name="inputSalePriceStartDate" class="form-control pull-right" value="<?php echo e(date("Y-m-d", strtotime($product_post_data['_product_sale_price_start_date']))); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group sale_end_date" style="display: block;">
                      <label class="col-sm-6 control-label" for="inputSalePriceEndDate"><?php echo trans('admin.sale_price_end_date'); ?></label>
                      <div class="col-sm-6">                  
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" placeholder="<?php echo e(trans('admin.end_date_format')); ?>" id="inputSalePriceEndDate" name="inputSalePriceEndDate" class="form-control pull-right" value="<?php echo e(date("Y-m-d", strtotime($product_post_data['_product_sale_price_end_date']))); ?>">
                        </div>
                        <a href="#" class="cancel_schedule"><?php echo trans('admin.cancel_schedule'); ?></a>
                      </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group sale_start_date" style="display: none;">
                      <label class="col-sm-6 control-label" for="inputSalePriceStartDate"><?php echo trans('admin.sale_price_start_date'); ?></label>
                      <div class="col-sm-6">                  
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" placeholder="<?php echo e(trans('admin.start_date_format')); ?>" id="inputSalePriceStartDate" name="inputSalePriceStartDate" class="form-control pull-right">
                        </div>
                      </div>
                    </div>
                    <div class="form-group sale_end_date" style="display: none;">
                      <label class="col-sm-6 control-label" for="inputSalePriceEndDate"><?php echo trans('admin.sale_price_end_date'); ?></label>
                      <div class="col-sm-6">                  
                        <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                          </div>
                          <input type="text" placeholder="<?php echo e(trans('admin.end_date_format')); ?>" id="inputSalePriceEndDate" name="inputSalePriceEndDate" class="form-control pull-right">
                        </div>
                        <a href="#" class="cancel_schedule"><?php echo trans('admin.cancel_schedule'); ?></a>
                      </div>
                    </div>
                    <?php endif; ?>
                    
																				
                    <?php if(count($available_user_roles) > 0 && isset($role_based_pricing_data['is_enable']) && isset($role_based_pricing_data['pricing'])): ?>
                    <p style="font-size: 17px;font-weight:bold;color:#3c8dbc;"><i><?php echo trans('admin.role_based_pricing_label'); ?></i></p><hr>
                    
                    <div class="role-based-pricing-content">
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputEnableRoleBasedPricing"><?php echo trans('admin.enable_role_based_pricing_label'); ?></label>
                        <div class="col-sm-6">
                          <?php if(isset($role_based_pricing_data['is_enable']) && $role_based_pricing_data['is_enable'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" name="inputEnableDisableRoleBasedPricing" class="shopist-iCheck" id="inputEnableDisableRoleBasedPricing">
                          <?php else: ?>
                          <input type="checkbox" name="inputEnableDisableRoleBasedPricing" class="shopist-iCheck" id="inputEnableDisableRoleBasedPricing">
                          <?php endif; ?>
                        </div>
                      </div>
                        
                      <?php $__currentLoopData = $available_user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php 
                      $regular_price = '';
                      $sale_price    = '';
                      
                      if(isset($role_based_pricing_data['pricing'][$roles['slug']]['regular_price'])){
                        $regular_price = $role_based_pricing_data['pricing'][$roles['slug']]['regular_price'];
                      }
                      
                      if(isset($role_based_pricing_data['pricing'][$roles['slug']]['sale_price'])){
                        $sale_price    = $role_based_pricing_data['pricing'][$roles['slug']]['sale_price'];
                      }
                      ?>
                      <div class="form-group">
                        <label class="col-sm-12 control-label" for="inputRoleBasedPricingText<?php echo e($roles['role_name']); ?>"><?php echo trans('admin.user_pricing_top_label', ['user_role' => $roles['role_name']]); ?></label>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-6">
                          <input type="number" class="form-control" name="RoleRegularPricing[<?php echo e($roles['slug']); ?>]" placeholder="<?php echo e(trans('admin.regular_price')); ?>" min="0" value="<?php echo e($regular_price); ?>">
                        </div>
                        <div class="col-sm-6">
                          <input type="number" class="form-control" name="RoleSalePricing[<?php echo e($roles['slug']); ?>]" placeholder="<?php echo e(trans('admin.sale_price')); ?>" min="0" value="<?php echo e($sale_price); ?>">
                        </div>
                      </div>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>                
              </div>
              
              <div class="tab-stock tab-pane" id="tab_stock">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputManageStock"><?php echo trans('admin.manage_stock'); ?></label>
                      <div class="col-sm-6">
                        <label>
                          <?php if($product_post_data['_product_manage_stock'] == 'yes'): ?>
                            <input type="checkbox" checked="checked" class="shopist-iCheck" name="manage_stock" id="manage_stock">
                          <?php else: ?>
                            <input type="checkbox" class="shopist-iCheck" name="manage_stock" id="manage_stock">
                          <?php endif; ?>
                          &nbsp;<?php echo trans('admin.enable_stock_management_product'); ?>

                        </label>                                             
                      </div>
                    </div>
                    <?php if($product_post_data['_product_manage_stock'] == 'yes'): ?>
                    <div class="form-group stock-qty" style="display:block;">
                      <label class="col-sm-6 control-label" for="inputStockQty"><?php echo trans('admin.stock_qty'); ?></label>
                      <div class="col-sm-6">
                        <input type="number" min="0" placeholder="<?php echo e(trans('admin.stock_qty')); ?>" id="inputStockQty" name="inputStockQty" class="form-control" value="<?php echo e($product_post_data['post_stock_qty']); ?>">
                      </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group stock-qty" style="display:none;">
                      <label class="col-sm-6 control-label" for="inputStockQty"><?php echo trans('admin.stock_qty'); ?></label>
                      <div class="col-sm-6">
                        <input type="number" min="0" placeholder="<?php echo e(trans('admin.stock_qty')); ?>" id="inputStockQty" name="inputStockQty" class="form-control" value="0">
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if($product_post_data['_product_manage_stock'] == 'yes'): ?>
                    <div class="form-group back-to-order-page" style="display:block;">
                      <label class="col-sm-6 control-label" for="inputBackToOrder"><?php echo trans('admin.backorders'); ?></label>
                      <div class="col-sm-6">
                        <select id="back_to_order_status" name="back_to_order_status" class="form-control select2" style="width: 100%;">
                          <?php if($product_post_data['_product_manage_stock_back_to_order'] == 'not_allow'): ?>
                            <option selected="selected" value="not_allow"><?php echo trans('admin.not_allow'); ?></option>
                          <?php else: ?>
                            <option value="not_allow"><?php echo trans('admin.not_allow'); ?></option>
                          <?php endif; ?>
                          
                          <?php if($product_post_data['_product_manage_stock_back_to_order'] == 'allow_notify_customer'): ?>
                            <option selected="selected" value="allow_notify_customer"><?php echo trans('admin.allow_and_notify_customer'); ?></option>
                          <?php else: ?>
                            <option value="allow_notify_customer"><?php echo trans('admin.allow_and_notify_customer'); ?></option>
                          <?php endif; ?>
                          
                          <?php if($product_post_data['_product_manage_stock_back_to_order'] == 'only_allow'): ?>
                            <option selected="selected" value="only_allow"><?php echo trans('admin.only_allow'); ?></option>
                          <?php else: ?>
                            <option value="only_allow"><?php echo trans('admin.only_allow'); ?></option>
                          <?php endif; ?>   
                        </select>
                      </div>
                    </div>
                    <?php else: ?>
                    <div class="form-group back-to-order-page" style="display: none;">
                      <label class="col-sm-6 control-label" for="inputBackToOrder"><?php echo trans('admin.backorders'); ?></label>
                      <div class="col-sm-6">
                        <select id="back_to_order_status" name="back_to_order_status" class="form-control select2" style="width: 100%;">
                          <option selected="selected" value="not_allow"><?php echo trans('admin.not_allow'); ?></option>
                          <option value="allow_notify_customer"><?php echo trans('admin.allow_and_notify_customer'); ?></option>
                          <option value="only_allow"><?php echo trans('admin.only_allow'); ?></option>
                        </select>
                      </div>
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputStockAvailability"><?php echo trans('admin.stock_availability'); ?></label>
                      <div class="col-sm-6">
                        <select id="stock_availability_status" name="stock_availability_status" class="form-control select2" style="width: 100%;">
                          <?php if($product_post_data['post_stock_availability'] == 'in_stock'): ?>
                            <option selected="selected" value="in_stock"><?php echo trans('admin.in_stock'); ?></option>
                          <?php else: ?>
                            <option value="in_stock"><?php echo trans('admin.in_stock'); ?></option>
                          <?php endif; ?>
                          
                          <?php if($product_post_data['post_stock_availability'] == 'out_of_stock'): ?>
                            <option selected="selected" value="out_of_stock"><?php echo trans('admin.out_of_stock'); ?></option>
                          <?php else: ?>
                            <option value="out_of_stock"><?php echo trans('admin.out_of_stock'); ?></option>
                          <?php endif; ?>
                                 
                        </select>
                      </div>
                    </div>
                  </div>
                </div>    
              </div><!-- /.tab-pane -->
              <div class="tab-features tab-pane <?php echo e($tabSettings['featureTab']); ?>" id="tab_features">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea id="eb_features_editor" name="eb_features_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.write_some_extra_features')); ?>">
                       <?php echo $product_post_data['_product_extra_features']; ?>                 
                      </textarea>
                    </div> 
                  </div>
                </div>  
              </div><!-- /.tab-pane -->
              <div class="tab-advanced tab-pane" id="tab_advanced">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableRecommendedProduct"><?php echo trans('admin.recommended_product'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_as_recommended'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="enable_recommended_product" id="enable_recommended_product">
                        <?php else: ?>
                          <input type="checkbox" class="shopist-iCheck" name="enable_recommended_product" id="enable_recommended_product">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_recommended_product'); ?>                                    
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableFeaturesProduct"><?php echo trans('admin.features_product'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_as_features'] == 'yes'): ?>
                        <input type="checkbox" checked="checked" class="shopist-iCheck" name="enable_features_product" id="enable_features_product">
                        <?php else: ?>
                        <input type="checkbox" class="shopist-iCheck" name="enable_features_product" id="enable_features_product">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_features_product'); ?>                                     
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableLatestProduct"><?php echo trans('admin.latest_product'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_as_latest'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="enable_latest_product" id="enable_latest_product">
                        <?php else: ?>
                          <input type="checkbox" class="shopist-iCheck" name="enable_latest_product" id="enable_latest_product">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_latest_product'); ?>                                        
                      </div>
                    </div>
                    <div class="form-group cca" style="display: none;">
                      <label class="col-sm-6 control-label" for="inputEnableForRelatedProduct"><?php echo trans('admin.related_product'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_as_related'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForRelatedProduct" id="inputEnableForRelatedProduct">
                        <?php else: ?>
                          <input type="checkbox" class="shopist-iCheck" name="inputEnableForRelatedProduct" id="inputEnableForRelatedProduct">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_related_product'); ?>                                        
                      </div>
                    </div>
                    <div class="form-group enable-custom-design" <?php echo $tabSettings['btnCustomize']; ?>>
                      <label class="col-sm-6 control-label" for="inputEnableForCustomDesignProduct"><?php echo trans('admin.custom_design'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_as_custom_design'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForCustomDesignProduct" id="inputEnableForCustomDesignProduct">
                        <?php else: ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForCustomDesignProduct" id="inputEnableForCustomDesignProduct">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_custom_design_product'); ?>                                      
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableForHomePage"><?php echo trans('admin.home_page_product_label_1'); ?></label>
                      <div class="col-sm-6">
                        <?php if( !empty($product_post_data['_product_enable_as_selected_cat']) && $product_post_data['_product_enable_as_selected_cat'] == 'yes'): ?>  
                        <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForHomePage" id="inputEnableForHomePage">
                        <?php else: ?>
                        <input type="checkbox" class="shopist-iCheck" name="inputEnableForHomePage" id="inputEnableForHomePage">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.home_page_product_label_2'); ?>                              
                      </div>
                    </div>    
                    <?php if( $settings_data['general_settings']['taxes_options']['enable_status'] == 1 && $settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'per_product' ): ?>
                    <div class="form-group taxes-option">
                      <label class="col-sm-6 control-label" for="inputEnableTaxesForProduct"><?php echo trans('admin.taxes'); ?></label>
                      <div class="col-sm-6">
                        <?php if($product_post_data['_product_enable_taxes'] == 'yes'): ?>
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableTaxesForProduct" id="inputEnableTaxesForProduct">
                        <?php else: ?>
                          <input type="checkbox" class="shopist-iCheck" name="inputEnableTaxesForProduct" id="inputEnableTaxesForProduct">
                        <?php endif; ?>
                        &nbsp;<?php echo trans('admin.enable_taxes_this_product'); ?>                                      
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div><!-- /.tab-pane -->
              
              <div class="tab-advanced tab-pane" id="tab_attribute">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="col-sm-4">
                        <input type="text" class="form-control" name="attrNameByProduct" id="attrNameByProduct" placeholder="<?php echo e(trans('admin.attribute_name_example_size')); ?>">
                      </div>
                      <div class="col-sm-6">
                        <input type="text" class="form-control" name="attrValuesByProduct" id="attrValuesByProduct" placeholder="<?php echo e(trans('admin.attribute_values_example')); ?>">
                        <span><?php echo trans('admin.enter_attribute_values_by_comma_separator'); ?></span>
                      </div>
                      <div class="col-sm-2">
                        <a class="btn btn-default btn-xs add-new-attribute" href=""><?php echo trans('admin.add_attribute'); ?></a>
                      </div>
                    </div>
                    <hr><br>
                    <div class="attr-lists-content">
                      <div class="attr-list">
                        <?php if(!empty($attribute_post_meta_by_id)): ?>
                          <table class="table table-bordered table-striped admin-data-table">
                            <thead><tr><th><?php echo trans('admin.attribute_name'); ?></th><th><?php echo trans('admin.attribute_value'); ?></th><th><?php echo trans('admin.action'); ?></th></tr></thead>
                            <tbody>
                              <?php $__currentLoopData = $attribute_post_meta_by_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr>
                                  <td> <?php echo $row->attr_name; ?></td>
                                  <td> <?php echo $row->attr_val; ?></td>
                                  <td>
                                    <div class="btn-group">
                                      <button class="btn btn-success btn-flat" type="button"><?php echo trans('admin.action'); ?></button>
                                      <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                                      <span class="caret"></span>
                                      <span class="sr-only">Toggle Dropdown</span>
                                      </button>
                                      <ul role="menu" class="dropdown-menu">
                                        <li><a href="#" data-toggle="modal" data-target="#edit_attributes" class="edit-attribute-data" data-track_name="attr_data_list" data-id="<?php echo e($product_post_data['id']); ?>" data-line_variation_json="<?php echo e(htmlspecialchars( json_encode( array('id' =>$row->id, 'attr_name' =>$row->attr_name, 'attr_val' =>$row->attr_val )) )); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                                        <li><a class="remove-selected-data-from-list" data-track_name="attr_data_list" data-id="<?php echo e($product_post_data['id']); ?>" data-item_id="<?php echo e($row->id); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
                                      </ul>
                                    </div>
                                  </td>
                                </tr>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot><tr><th><?php echo trans('admin.attribute_name'); ?></th><th><?php echo trans('admin.attribute_value'); ?></th><th><?php echo trans('admin.action'); ?></th></tr></tfoot>
                          </table>
                        <?php endif; ?>
                      </div>
                      <div class="modal fade" id="edit_attributes" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                              <br>
                              <i class="icon-credit-card icon-7x"></i>
                              <p class="no-margin"><?php echo trans('admin.update_your_attribute'); ?></p>
                            </div>
                            <div class="modal-body">             
                              <div class="form-group">
                                <div class="col-sm-4">
                                  <input type="text" class="form-control" name="editAttrNameByProduct" id="editAttrNameByProduct" placeholder="<?php echo e(trans('admin.attribute_name_example_size')); ?>">
                                </div>
                                <div class="col-sm-5">
                                  <input type="text" class="form-control" name="editAttrValuesByProduct" id="editAttrValuesByProduct" placeholder="<?php echo e(trans('admin.attribute_values_example')); ?>">
                                  <span><?php echo trans('admin.enter_attribute_values_by_comma_separator'); ?></span>
                                </div>
                                <div class="col-sm-3">
                                  <a class="btn btn-default update-attribute" href=""><?php echo e(trans('admin.update_attribute')); ?></a>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>   
              
              <div class="tab-variations tab-pane" id="tab_variations">
                <div class="modal fade" id="addDynamicVariations" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="ajax-overlay"></div>
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                        <br>
                        <i class="icon-credit-card icon-7x"></i>
                        <p class="no-margin top-title"><b><?php echo trans('admin.create_new_product_variation'); ?></b></p>
                      </div>
                      <div class="modal-body">
                        <div class="custom-model-row content-for-variation-add">
                          <div class="attributes-lists" style="display:none;">
                            <?php if(count($attrs_list_data_by_product)>0): ?>
                              <?php $__currentLoopData = $attrs_list_data_by_product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="attribute-name">
                                <select class="form-control select2 variation-attr-list" style="width: 100%;" data-attr_name="<?php echo e($rows['attr_name']); ?>">
                                  <option selected="selected" value="all"><?php echo trans('admin.any_label'); ?> <?php echo $rows['attr_name']; ?></option>
                                  <?php $__currentLoopData = explode(',', $rows['attr_values']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e(htmlspecialchars($val)); ?>"><?php echo $val; ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
                                </select>
                              </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                          </div>
                          <br>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><label for="inputVariationImage"><?php echo trans('admin.variation_image'); ?></label></div>
                            <div class="custom-input-element">
                              <div class="uploadform dropzone no-margin dz-clickable upload-variation-img" id="upload_variation_img" name="upload_variation_img">
                                <div class="dz-default dz-message">
                                  <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                                </div>
                              </div>
                              <br>
                              <div class="variation-img-content">
                                <div class="variation-sample-img"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="variation-sample"></div>
                                <div class="variation-img"><img class="img-responsive" src="" alt="variation-img"></div>
                                <br>
                                <div class="variation-img-upload-btn">
                                  <button type="button" class="btn btn-default attachtopost remove-variation-img"><?php echo trans('admin.remove_image'); ?></button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><input type="checkbox" class="shopist-iCheck" name="inputVariationEnable" id="inputVariationEnable">&nbsp;&nbsp;<label for="inputVariationEnable"><?php echo trans('admin.enable_this_variation'); ?></label></div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><label for="inputVariationSKU"><?php echo trans('admin.sku'); ?></label></div>
                            <div class="custom-input-element"><input type="text" placeholder="<?php echo e(trans('admin.sku')); ?>" id="inputVariationSKU" name="inputVariationSKU" class="form-control"></div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><label for="inputVariationRegularPrice"><?php echo trans('admin.regular_price'); ?> (<?php echo $currency_symbol; ?>)</label></div>
                            <div class="custom-input-element"> <input type="text" placeholder="<?php echo e(trans('admin.regular_price')); ?>" id="inputVariationRegularPrice" name="inputVariationRegularPrice" class="form-control" min="0"></div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><label for="inputVariationSalePrice"><?php echo trans('admin.sale_price'); ?> (<?php echo $currency_symbol; ?>)</label></div>
                            <div class="custom-input-element"> <input type="text" placeholder="<?php echo e(trans('admin.sale_price')); ?>" id="inputVariationSalePrice" name="inputVariationSalePrice" class="form-control" min="0">
                              <a href="#" class="create_variation_sale_schedule"><?php echo trans('admin.create_schedule'); ?></a></div>
                          </div>
                          <div class="custom-input-group variation_sale_start_date" style="display: none;">
                            <div class="custom-input-label"><label for="inputVariationSalePriceStartDate"><?php echo trans('admin.sale_price_start_date'); ?></label></div>
                            <div class="custom-input-element">
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" placeholder="<?php echo e(trans('admin.start_date_format')); ?>" id="inputVariationSalePriceStartDate" name="inputVariationSalePriceStartDate" class="form-control pull-right">
                              </div>
                            </div>
                          </div>
                          <div class="custom-input-group variation_sale_end_date" style="display: none;">
                            <div class="custom-input-label"><label for="inputVariationSalePriceEndDate"><?php echo trans('admin.sale_price_end_date'); ?></label></div>
                            <div class="custom-input-element">
                              <div class="input-group">
                                <div class="input-group-addon">
                                  <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" placeholder="<?php echo e(trans('admin.end_date_format')); ?>" id="inputVariationSalePriceEndDate" name="inputVariationSalePriceEndDate" class="form-control pull-right">
                              </div>
                              <a href="#" class="cancel_variation_schedule"><?php echo trans('admin.cancel_schedule'); ?></a>
                            </div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><input type="checkbox" class="shopist-iCheck" name="inputManageVariationStock" id="inputManageVariationStock">&nbsp;&nbsp;<label for="inputManageVariationStock"><?php echo trans('admin.enable_stock_management_variation_product'); ?></label></div>
                          </div>
                          <div class="custom-input-group variation-stock-qty" style="display:none;">
                            <div class="custom-input-label"><label for="inputVariationStockQty"><?php echo trans('admin.stock_qty'); ?></label></div>
                            <div class="custom-input-element"> <input type="text" min="0" placeholder="<?php echo e(trans('admin.stock_qty')); ?>" id="inputVariationStockQty" name="inputVariationStockQty" class="form-control" value="0"></div>
                          </div>
                          <div class="custom-input-group variation-back-to-order-page" style="display: none;">
                            <div class="custom-input-label"><label for="inputVariationBackToOrder"><?php echo trans('admin.backorders'); ?></label></div>
                            <div class="custom-input-element">
                              <select id="variation_backorders_status" name="variation_backorders_status" class="form-control select2" style="width: 100%;">
                                <option selected="selected" value="variation_not_allow"><?php echo trans('admin.not_allow'); ?></option>
                                <option value="variation_allow_notify_customer"><?php echo trans('admin.allow_and_notify_customer'); ?></option>
                                <option value="variation_only_allow"><?php echo trans('admin.only_allow'); ?></option>
                              </select>
                            </div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><label for="inputVariationStockAvailability"><?php echo trans('admin.stock_availability'); ?></label></div>
                            <div class="custom-input-element">
                              <select id="variation_stock_status" name="variation_stock_status" class="form-control select2" style="width: 100%;">
                                <option selected="selected" value="variation_in_stock"><?php echo trans('admin.in_stock'); ?></option>
                                <option value="variation_out_of_stock"><?php echo trans('admin.out_of_stock'); ?></option>                  
                              </select>
                            </div>
                          </div>
                          <?php if( $settings_data['general_settings']['taxes_options']['enable_status'] == 1 && $settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'per_product' ): ?>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><input type="checkbox" class="shopist-iCheck" name="inputEnableTaxesForVariation" id="inputEnableTaxesForVariation">&nbsp;&nbsp;<label for="inputEnableTaxesForVariation"><?php echo trans('admin.enable_taxes_this_variation'); ?></label></div>  
                          </div>
                          <?php endif; ?>
                          <div class="custom-input-group">
                            <label class="custom-input-label" for="inputVariationDescription"><?php echo trans('admin.variation_description'); ?></label>
                            <div class="custom-input-element">
                              <textarea name="variation_description" id="variation_description" class="form-control"></textarea>
                            </div>
                          </div>
                          
                          <div class="manage-download-files">
                          <br>
                          <p style="font-size: 17px;font-weight:bold;color:#3c8dbc;"><i><?php echo trans('admin.manage_download_files_label'); ?></i></p><hr>  
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label class="col-sm-3 control-label" for="inputDownloadableFiles"><?php echo trans('admin.downloadable_files_label'); ?></label>
                                  <div class="col-sm-9">
                                    <div class="files-manage-option">
                                      <table>
                                        <thead>
                                          <tr>
                                            <th><?php echo trans('admin.downloadable_name_label'); ?></th>
                                            <th><?php echo trans('admin.downloadable_file_url_label'); ?></th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <th colspan="2">
                                              <button type="button" class="btn btn-default add_variable_products_more_downloadable_file" data-target="variable"> <?php echo trans('admin.downloadable_add_more_file_label'); ?> </button>
                                            </th>
                                          </tr>
                                        </tfoot>
                                      </table>
                                    </div>		
                                  </div>
                                </div>
                                <br>  
                                <div class="form-group">
                                  <label class="col-sm-3 control-label" for="inputDownloadlimit"><?php echo trans('admin.download_limit_label'); ?></label>
                                  <div class="col-sm-9">
                                      <input type="text" class="form-control variation-download-limit" name="download_limit" placeholder="<?php echo e(trans('admin.unlimited_placeholder_label')); ?>" id="download_limit"> <?php echo trans('admin.blank_for_unlimited_label'); ?>

                                  </div>  
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-3 control-label" for="inputDownloadexpiry"><?php echo trans('admin.download_expiry_label'); ?></label>
                                  <div class="col-sm-9">
                                      <input type="text" class="form-control" name="download_expiry" placeholder="<?php echo e(trans('admin.expiry_data_label')); ?>" id="download_expiry">
                                  </div>  
                                </div>    
                              </div>    
                            </div>
                          </div>
                          
																					
                          <?php if(count($available_user_roles) > 0): ?>
                          <br>
                          <p style="font-size: 17px;font-weight:bold;color:#3c8dbc;"><i><?php echo trans('admin.role_based_pricing_label'); ?></i></p><hr>
                          <div class="role-based-pricing-content">
                              <div class="form-group">
                                  <label class="col-sm-6 control-label" for="inputEnableRoleBasedPricing"><?php echo trans('admin.enable_role_based_pricing_label'); ?></label>
                                  <div class="col-sm-6">
                                    <input type="checkbox" name="enable_disable_role_based_pricing" class="shopist-iCheck" id="enable_disable_role_based_pricing">
                                  </div>
                              </div>

                              <?php $__currentLoopData = $available_user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <div class="form-group">
                                  <label class="col-sm-12 control-label" for="inputRoleBasedPricingText<?php echo e($roles['role_name']); ?>"><?php echo trans('admin.user_pricing_top_label', ['user_role' => $roles['role_name']]); ?></label>
                              </div>
                              <div class="form-group">
                                  <div class="col-sm-6">
                                      <input type="text" class="form-control pricing-textbox" name="<?php echo e($roles['slug']); ?>_role_regular_pricing" id="<?php echo e($roles['slug']); ?>_role_regular_pricing" placeholder="<?php echo e(trans('admin.regular_price')); ?>" min="0">
                                  </div>
                                  <div class="col-sm-6">
                                      <input type="text" class="form-control pricing-textbox" name="<?php echo e($roles['slug']); ?>_role_sale_pricing" id="<?php echo e($roles['slug']); ?>_role_sale_pricing" placeholder="<?php echo e(trans('admin.sale_price')); ?>" min="0">
                                  </div>
                              </div>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                          <?php endif; ?>
                        </div>
                          
                        <div class="custom-model-row content-for-variation-view"></div>  
                        <input type="hidden" name="hf_available_user_roles" id="hf_available_user_roles" value="<?php echo e(json_encode($available_user_roles)); ?>">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default attachtopost create-new-variations"><?php echo trans('admin.add_variation'); ?></button>
                        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="variations-panel">
                  <div class="clearfix btn-check-available-attribute">
                    <button type="button" class="btn btn-default check-available-attributes pull-right"><?php echo trans('admin.check_available_attributes'); ?></button>
                  </div>
                  <div class="clearfix btn-create-variation">
                    <button type="button" class="btn btn-default create-variations pull-right"><?php echo trans('admin.create_variation'); ?></button>
                  </div>  
                
                  <div class="attributes-lists"></div><hr>
                  <br>
                  <div class="variation-list">  
                  <?php if(count($variation_data)>0): ?>
                    <table class="table table-bordered table-striped admin-data-table">
                      <thead><tr><th><?php echo trans('admin.image'); ?></th><th><?php echo trans('admin.variation_combination'); ?></th><th><?php echo trans('admin.price'); ?></th><th><?php echo trans('admin.action'); ?></th></tr></thead>
                      <tbody>
                      <?php $__currentLoopData = $variation_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <tr>
                        <?php if($row['_variation_post_img_url']): ?>
                        <td><img src="<?php echo e(get_image_url($row['_variation_post_img_url'])); ?>" alt="<?php echo e(basename ($row['_variation_post_img_url'])); ?>"></td>
                        <?php else: ?> 
                        <td><img src="<?php echo e(default_placeholder_img_src()); ?>" alt="no_img"></td>
                        <?php endif; ?>

                        <td>
                          <?php $__currentLoopData = json_decode($row['_variation_post_data']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count(json_decode($row['_variation_post_data']))-1 == $key): ?>
                              <?php echo $val->attr_name .' &#8658; '. $val->attr_val; ?>

                            <?php else: ?>
                              <?php echo $val->attr_name .' &#8658; '. $val->attr_val . ', '; ?>

                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </td>

                        <td><?php echo $currency_symbol.$row['_variation_post_price']; ?></td>

                        <td>
                          <div class="btn-group">
                            <button class="btn btn-success btn-flat" type="button"><?php echo trans('admin.action'); ?></button>    
                            <button data-toggle="dropdown" class="btn btn-success btn-flat dropdown-toggle" type="button">
                            <span class="caret"></span>
                            <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul role="menu" class="dropdown-menu">
                              <li><a href="#" class="view-data" data-track_name="variation_data_list" data-id="<?php echo e($row['id']); ?>"><i class="fa fa-eye"></i><?php echo trans('admin.view'); ?></a></li>
                              <li><a href="#" class="edit-data" data-track_name="variation_data_list" data-id="<?php echo e($row['id']); ?>"><i class="fa fa-edit"></i><?php echo trans('admin.edit'); ?></a></li>
                              <li><a class="remove-selected-data-from-list" data-track_name="variation_data_list" data-id="<?php echo e($row['id']); ?>" href="#"><i class="fa fa-remove"></i><?php echo trans('admin.delete'); ?></a></li>
                            </ul>
                          </div>
                        </td> 

                      </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </tbody>
                      <tfoot><tr><th><?php echo trans('admin.image'); ?></th><th><?php echo trans('admin.variation_combination'); ?></th><th><?php echo trans('admin.price'); ?></th><th><?php echo trans('admin.action'); ?></th></tr></tfoot>
                    </table>
                  <?php endif; ?>
                  </div>
                </div>
              </div><!-- /.tab-pane -->
              
              <div class="tab-custom-design tab-pane" id="tab_custom_design">
                <div class="row">
                  <div class="col-md-12">                    
                    <div class="form-group">
                      <div class="clearfix design-element-btn">
                         <button data-toggle="modal" data-target="#element_title_name" type="button" class="btn btn-default pull-right create-design-element"><?php echo trans('admin.create_more_design_element'); ?></button>
                      </div>
                     
                      <div class="modal fade" id="element_title_name" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                              <br>
                              <i class="icon-credit-card icon-7x"></i>
                              <p class="no-margin"><?php echo trans('admin.your_design_title_name'); ?></p>
                            </div>
                            <div class="modal-body">             
                              <input type="Text" class="form-control" name="design_title_name" id="design_title_name" placeholder="<?php echo e(trans('admin.your_design_title_name')); ?>">
                            </div>
                            <div class="modal-footer">
                               <button class="btn btn-default pull-left" data-dismiss="modal" type="button"><?php echo trans('admin.close'); ?></button>
                               <button class="btn btn-default add-design-element-panel" type="button"><?php echo trans('admin.add'); ?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="modal fade" id="designerImageUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                              <br>
                              <i class="icon-credit-card icon-7x"></i>
                              <p class="no-margin"><?php echo trans('admin.you_can_upload_1_image'); ?></p>
                            </div>
                            <div class="modal-body">             
                              <div class="uploadform dropzone no-margin dz-clickable designer-dropzone-file-upload" id="designer_dropzone_file_upload" name="designer_dropzone_file_upload">
                                <div class="dz-default dz-message">
                                  <span><?php echo trans('admin.drop_your_cover_picture_here'); ?></span>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="design-element-main-container">
                        <?php if( !empty($product_post_data['_product_custom_designer_data']) && count($product_post_data['_product_custom_designer_data'])>0): ?>  
                        <?php $__currentLoopData = $product_post_data['_product_custom_designer_data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="panel-group element-accordion" id="accordion">
                          <div class="panel panel-default">
                            <div class="panel-heading">
                              <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_<?php echo e($row->id); ?>">
                                  <span class="glyphicon glyphicon-plus"></span>&nbsp;&nbsp;
                                  <span><?php echo $row->title_label; ?></span>
                                </a>
                                <a data-id="<?php echo e($row->id); ?>" class="pull-right" href=""><span class="glyphicon glyphicon-remove remove-panel"></span></a>
                              </h4>
                            </div>
                            <div id="collapse_<?php echo e($row->id); ?>" data-id="<?php echo e($row->id); ?>" class="panel-collapse collapse collapse-<?php echo e($row->id); ?>">
                              <div class="panel-body">
                                <div class="form-group">
                                  <div class="col-sm-6">
                                    <div class="design-img-content">
                                      <?php if($row->design_img_url): ?>
                                      <div class="design-img" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url($row->design_img_url)); ?>" alt=""></div>
                                      <div class="design-sample-img" style="display:none;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>  
                                      <?php else: ?>
                                      <div class="design-img" style="display:none;"><img class="img-responsive" alt=""></div>
                                      <div class="design-sample-img" style="display:block;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>  
                                      <?php endif; ?>
                                      <br>
                                      <div class="design-img-upload-btn">
                                        <div><button type="button" data-name="only_design_img" class="btn btn-default attachtopost upload-design-img"><?php echo trans('admin.upload_design_image'); ?></button></div>
                                        <div>
                                          <?php if($row->design_img_url): ?>
                                            <button type="button" data-name="design_img" data-id="solid-<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-img" style="display:block;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php else: ?>
                                            <button type="button" data-name="design_img" data-id="solid-<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-img" style="display:none;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php endif; ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="col-sm-6">
                                    <div class="design-img-content">
                                      <?php if($row->design_trans_img_url): ?>
                                      <div class="trans-design-img" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url($row->design_trans_img_url)); ?>" alt=""></div>
                                      <div class="trans-design-sample-img" style="display:none;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>  
                                      <?php else: ?>
                                      <div class="trans-design-img" style="display:none;"><img class="img-responsive" alt=""></div>
                                      <div class="trans-design-sample-img" style="display:block;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>  
                                      <?php endif; ?>
                                      <br>
                                      <div class="trans-design-img-upload-btn">
                                        <div><button type="button" data-name="only_trans_design_img" class="btn btn-default attachtopost upload-design-img"><?php echo trans('admin.upload_design_transparent_image'); ?></button></div>
                                        <div>
                                          <?php if($row->design_trans_img_url): ?>
                                          <button type="button" data-name="trans_design_img" data-id="trans-<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-img" style="display:block;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php else: ?>
                                          <button type="button" data-name="trans_design_img" data-id="trans-<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-img" style="display:none;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php endif; ?>
                                        </div>
                                      </div>
                                    </div>
                                  </div>  
                                </div><hr>

                                <div class="form-group">
                                  <div class="col-sm-12">
                                    <div class="design-title-img-content">
                                      <?php if($row->design_title_icon): ?>
                                      <div class="design-title-img" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url($row->design_title_icon)); ?>" alt=""></div>
                                      <div class="design-title-sample-img" style="display:none;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>
                                      <?php else: ?>
                                      <div class="design-title-img" style="display:none;"><img class="img-responsive" alt=""></div>
                                      <div class="design-title-sample-img" style="display:block;"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt="no_img"></div>
                                      <?php endif; ?>
                                      <br>
                                      <div class="design-title-img-upload-btn">
                                        <div>
                                          <button type="button" data-name="only_design_title_img" class="btn btn-default attachtopost upload-design-title-img"><?php echo trans('admin.upload_design_title_icon'); ?></button>
                                        </div>
                                        <div>
                                          <?php if(!empty($row->design_title_icon) && $row->design_title_icon != '/public/images/upload.png'): ?>
                                          <button type="button" data-name="design_title_img" data-id="<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-title-img" style="display:block;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php else: ?>
                                          <button type="button" data-name="design_title_img" data-id="<?php echo e($row->id); ?>" class="btn btn-default attachtopost remove-design-title-img" style="display:none;"><?php echo trans('admin.remove_image'); ?></button>
                                          <?php endif; ?>
                                        </div>
                                      </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                          </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                </div>                
              </div>
              
              <div class="tab-custom-design tab-pane" id="tab_custom_design_layout">
                <?php echo $__env->make('pages.common.designer-html', array('designer_hf_data' => $designer_hf_data, 'designer_img_elments' => $product_post_data['_product_custom_designer_data'], 'design_save_data' => $design_json_data), array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              </div>
              
              <div class="tab-manage-download-files tab-pane" id="tab_manage_download_files">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputDownloadableFiles"><?php echo trans('admin.downloadable_files_label'); ?></label>
                      <div class="col-sm-9">
                        <div class="files-manage-option">
                          <table>
                            <thead>
                              <tr>
                                <th><?php echo trans('admin.downloadable_name_label'); ?></th>
                                <th><?php echo trans('admin.downloadable_file_url_label'); ?></th>
                              </tr>
                            </thead>
                            <tbody>
                            <?php if(count($product_post_data['_downloadable_product_files']) > 0): ?>
                            <?php $count = 1;?>
                              <?php $__currentLoopData = $product_post_data['_downloadable_product_files']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($count == 1): ?>
                                <tr class="file-inline"><td><input type="text" class="form-control" id="downloadable_file_name_<?php echo e($key); ?>" placeholder="<?php echo e(trans('admin.downloadable_placeholder_file_name')); ?>" name="downloadable_file_name[<?php echo e($key); ?>]" value="<?php echo e($data['file_name']); ?>"></td><td><div class="upload-downloadable-file"><div class="file-label"><?php echo trans('admin.downloadable_file_label'); ?></div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_uploaded_url_<?php echo e($key); ?>" name="downloadable_uploaded_file_url[<?php echo e($key); ?>]"  readonly="true" placeholder="<?php echo e(trans('admin.downloadable_uploaded_file_url_placeholder')); ?>" value="<?php echo e(get_image_url($data['uploaded_file_url'])); ?>"></div><div class="file-upload-btn"> &nbsp;&nbsp;<button data-id="<?php echo e($key); ?>" data-toggle="modal" data-target="#downloadable_file_upload" type="button" class="btn btn-default upload-for-downloadable-product"><?php echo trans('admin.downloadable_choose_file_label'); ?></button></div></div><div class="url-downloadable-file" style="display:none;"><div class="file-label"><?php echo trans('admin.downloadable_url_label'); ?></div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_url_<?php echo e($key); ?>" placeholder="<?php echo e(trans('admin.downloadable_online_file_url_placeholder')); ?>" name="downloadable_online_file_url[<?php echo e($key); ?>]" value="<?php echo e($data['online_file_url']); ?>"></div></div><a href="" class="btn btn-sm btn-default remove-downloadable-file"><?php echo trans('admin.remove_label'); ?></a></td></tr>
                                <?php else: ?>
                                  <tr class="file-inline"><td><input type="text" class="form-control" id="downloadable_file_name_<?php echo e($key); ?>" placeholder="<?php echo e(trans('admin.downloadable_placeholder_file_name')); ?>" name="downloadable_file_name[<?php echo e($key); ?>]" value="<?php echo e($data['file_name']); ?>"></td><td><hr><div class="upload-downloadable-file"><div class="file-label"><?php echo trans('admin.downloadable_file_label'); ?></div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_uploaded_url_<?php echo e($key); ?>" name="downloadable_uploaded_file_url[<?php echo e($key); ?>]"  readonly="true" placeholder="<?php echo e(trans('admin.downloadable_uploaded_file_url_placeholder')); ?>" value="<?php echo e(get_image_url($data['uploaded_file_url'])); ?>"></div><div class="file-upload-btn"> &nbsp;&nbsp;<button data-id="<?php echo e($key); ?>" data-toggle="modal" data-target="#downloadable_file_upload" type="button" class="btn btn-default upload-for-downloadable-product"><?php echo trans('admin.downloadable_choose_file_label'); ?></button></div></div><div class="url-downloadable-file" style="display:none;"><div class="file-label"><?php echo trans('admin.downloadable_url_label'); ?></div><div class="file-url-textbox"><input type="text" class="form-control" id="downloadable_file_url_<?php echo e($key); ?>" placeholder="<?php echo e(trans('admin.downloadable_online_file_url_placeholder')); ?>" name="downloadable_online_file_url[<?php echo e($key); ?>]" value="<?php echo e($data['online_file_url']); ?>"></div></div><a href="" class="btn btn-sm btn-default remove-downloadable-file"><?php echo trans('admin.remove_label'); ?></a></td></tr>
                                <?php endif; ?>
                                 <?php $count ++;?>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="2">
                                  <button type="button" class="btn btn-default add_more_downloadable_file" data-target="simple"> <?php echo trans('admin.downloadable_add_more_file_label'); ?> </button>
                                </th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>		
                      </div>
                    </div>
                    <br>  
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputDownloadlimit"><?php echo trans('admin.download_limit_label'); ?></label>
                      <div class="col-sm-9">
                          <input type="number" class="form-control" name="download_limit" placeholder="<?php echo e(trans('admin.unlimited_placeholder_label')); ?>" id="download_limit" value="<?php echo e($product_post_data['_downloadable_product_download_limit']); ?>"> <?php echo trans('admin.blank_for_unlimited_label'); ?>

                      </div>  
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label" for="inputDownloadexpiry"><?php echo trans('admin.download_expiry_label'); ?></label>
                      <div class="col-sm-9">
                          <input type="text" class="form-control" name="download_expiry" placeholder="<?php echo e(trans('admin.expiry_data_label')); ?>" id="download_expiry" value="<?php echo e($product_post_data['_downloadable_product_download_expiry']); ?>">
                      </div>  
                    </div>  
                  </div>    
                </div>
              </div>
            </div><!-- /.tab-content -->
<!--          </div> nav-tabs-custom -->
          </div>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.add_upsells_cross_sells_label'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">  
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="inputUpsells"><?php echo trans('admin.upsells_label'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="upsells_product" data-target="upsell" placeholder="<?php echo e(trans('admin.upsells_cross_sells_placeholder_label')); ?>" class="typeahead products-typeahead tm-input upsells-input form-control tm-input-info"/>
                </div>  
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="inputCrossSells"><?php echo trans('admin.cross_sells_label'); ?></label>
                <div class="col-sm-9">
                  <input type="text" name="cross_sells_product" data-target="crosssell" placeholder="<?php echo e(trans('admin.upsells_cross_sells_placeholder_label')); ?>" class="typeahead products-typeahead tm-input crosssells-input form-control tm-input-info"/>
                </div>  
              </div>
            </div>
          </div>
        </div>  
      </div>   
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.product_seo_label'); ?></h3>
        </div>
        <div class="box-body">
          <div class="seo-preview-content">
            <p><i class="fa fa-eye"></i> <?php echo trans('admin.google_search_preview_label'); ?></p><hr>
            <h3><?php echo $product_post_data['_product_seo_title']; ?></h3>
            <p class="link"><?php echo url('/'); ?>/product/details/<span><?php echo $product_post_data['post_slug']; ?></span></p>
            <?php if(!empty($product_post_data['_product_seo_description'])): ?>
            <p class="description"><?php echo $product_post_data['_product_seo_description']; ?></p>
            <?php else: ?>
            <p class="description"><?php echo trans('admin.product_seo_desc_example'); ?></p>
            <?php endif; ?>
          </div><hr>
          <div class="seo-content">
            <div class="row">  
              <div class="col-md-12">
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="<?php echo e(trans('admin.seo_title_label')); ?>" value="<?php echo e($product_post_data['_product_seo_title']); ?>">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_url_format" id="seo_url_format" placeholder="<?php echo e(trans('admin.seo_url_label')); ?>" value="<?php echo e($product_post_data['post_slug']); ?>">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">  
                    <textarea id="seo_description" class="form-control" name="seo_description" placeholder="<?php echo e(trans('admin.seo_description_label')); ?>"><?php echo $product_post_data['_product_seo_description']; ?></textarea>
                  </div>
                </div>  
                <div class="form-group">   
                  <div class="col-md-12">  
                    <textarea id="seo_keywords" class="form-control" name="seo_keywords" placeholder="<?php echo e(trans('admin.seo_keywords_label')); ?>"><?php echo $product_post_data['_product_seo_keywords']; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>  
      </div>
        
      <div class="box box-solid compare-data">
        <div class="box-header with-border">
          <i class="fa  fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.add_compare_data_title'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                  <a class="btn btn-default pull-right" href="<?php echo e(route('admin.extra_features_compare_products_content')); ?>"><?php echo trans('admin.add_compare_data_title'); ?></a>
              </div>  
              <br>  
              <?php if(!empty($fields_name)): ?>
                <?php $__currentLoopData = $fields_name; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $compare_field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="form-group">
                    <label class="col-sm-6 control-label"><?php echo $compare_field; ?></label>
                    <div class="col-sm-6">
                      <?php if(!empty($product_post_data['_product_compare_data'])): ?>  
                        <input type="text" class="form-control" name="inputCompareData[<?php echo $key;?>]" placeholder="<?php echo e($compare_field); ?>" value="<?php echo e($product_post_data['_product_compare_data'][$key]); ?>">
                      <?php else: ?>
                        <input type="text" class="form-control" name="inputCompareData[<?php echo $key;?>]" placeholder="<?php echo e($compare_field); ?>">
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>  
      
      <div class="box box-solid review-settings">
        <div class="box-header with-border">
          <i class="fa  fa-star-half-full"></i>
          <h3 class="box-title"><?php echo trans('admin.product_reviews_settings'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableReviews"><?php echo trans('admin.enable_reviews'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <?php if($product_post_data['_product_enable_reviews'] == 'yes'): ?>
                    <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableReviews" id="inputEnableReviews">
                    <?php else: ?>
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableReviews" id="inputEnableReviews">
                    <?php endif; ?>
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableAddReviewLinkToProductPage"><?php echo trans('admin.enable_add_review_link_to_product_page'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <?php if($product_post_data['_product_enable_reviews_add_link_to_product_page'] == 'yes'): ?>
                    <input type="checkbox" class="shopist-iCheck" checked="checked" name="inputEnableAddReviewLinkToProductPage" id="inputEnableAddReviewLinkToProductPage">
                    <?php else: ?>
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableAddReviewLinkToProductPage" id="inputEnableAddReviewLinkToProductPage">
                    <?php endif; ?>
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableAddReviewLinkToDetailsPage"><?php echo trans('admin.enable_add_review_link_to_details_page'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <?php if($product_post_data['_product_enable_reviews_add_link_to_details_page'] == 'yes'): ?>
                    <input type="checkbox" class="shopist-iCheck" checked="checked" name="inputEnableAddReviewLinkToDetailsPage" id="inputEnableAddReviewLinkToDetailsPage">
                    <?php else: ?>
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableAddReviewLinkToDetailsPage" id="inputEnableAddReviewLinkToDetailsPage">
                    <?php endif; ?>
                  </label>                                             
                </div>
              </div> 
            </div>
          </div>
        </div>
      </div>
      
      <div class="box box-solid product-videos-settings">
        <div class="box-header with-border">
          <i class="fa fa-video-camera"></i>
          <h3 class="box-title"><?php echo trans('admin.product_video_settings'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableProductVideo"><?php echo trans('admin.enable_product_video'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <?php if($product_post_data['_product_enable_video_feature'] == 'yes'): ?>
                    <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableProductVideo" id="inputEnableProductVideo">
                    <?php else: ?>
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableProductVideo" id="inputEnableProductVideo">
                    <?php endif; ?>
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputDisplayProductVideo"><?php echo trans('admin.product_video_display_mode_at_frontend'); ?></label>
                <div class="col-sm-6">
                  <span>
                    <?php if($product_post_data['_product_video_feature_display_mode'] == 'popup'): ?>
                    <input type="radio" class="shopist-iCheck" checked="checked" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPopup" value="popup">&nbsp; <?php echo trans('admin.display_at_popup'); ?>

                    <?php else: ?>
                    <input type="radio" class="shopist-iCheck" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPopup" value="popup">&nbsp; <?php echo trans('admin.display_at_popup'); ?>

                    <?php endif; ?>
                  </span>
                  
                  
                  &nbsp;&nbsp;&nbsp;&nbsp;<span>
                    <?php if($product_post_data['_product_video_feature_display_mode'] == 'content'): ?>
                    <input type="radio" checked="checked" class="shopist-iCheck" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPageContent" value="content">&nbsp; <?php echo trans('admin.page_content'); ?>

                    <?php else: ?>
                    <input type="radio" class="shopist-iCheck" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPageContent" value="content">&nbsp; <?php echo trans('admin.page_content'); ?>

                    <?php endif; ?>
                  </span>
                </div>
              </div><hr><br>
              
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputTitleForVideo"><?php echo trans('admin.video_title'); ?></label>
                <div class="col-sm-6">
                  <input type="Text" class="form-control" name="inputTitleForVideo" id="inputTitleForVideo" placeholder="<?php echo e(trans('admin.video_title')); ?>" value="<?php echo e($product_post_data['_product_video_feature_title']); ?>">          
                </div>
              </div>
              <div class="form-group" style="display:none;">
                <label class="col-sm-6 control-label" for="inputVideoPanelWidth"><?php echo trans('admin.video_panel_width'); ?></label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="inputVideoPanelWidth" id="inputVideoPanelWidth" placeholder="<?php echo e(trans('admin.video_panel_width')); ?>" value="<?php echo e($product_post_data['_product_video_feature_panel_size']['width']); ?>"><i><?php echo trans('admin.pixels'); ?></i>           
                </div>
              </div>
              <div class="form-group" style="display:none;">
                <label class="col-sm-6 control-label" for="inputVideoPanelHeight"><?php echo trans('admin.video_panel_height'); ?></label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="inputVideoPanelHeight" id="inputVideoPanelHeight" placeholder="<?php echo e(trans('admin.video_panel_height')); ?>" value="<?php echo e($product_post_data['_product_video_feature_panel_size']['height']); ?>"><i><?php echo trans('admin.pixels'); ?></i>
                </div>
              </div>
              <hr><br>
              
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputLabelVideoSource"><?php echo trans('admin.select_video_source'); ?></label>
                <div class="col-sm-6">
                  <div class="source-embedded-code">
                    <div class="source-embedded-code-label">
                      <?php if($product_post_data['_product_video_feature_source'] == 'embedded_code'): ?>
                      <input type="radio" checked="checked" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceEmbed" value="embedded_code"> <?php echo trans('admin.embedded_code'); ?>

                      <?php else: ?>
                      <input type="radio" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceEmbed" value="embedded_code"> <?php echo trans('admin.embedded_code'); ?>

                      <?php endif; ?>
                    </div>
                    <div class="source-embedded-code-textarea">
                        <input type="text" class="form-control" name="inputEmbedCode" id="inputEmbedCode" placeholder="<?php echo e(trans('admin.enter_your_embedded_code_here')); ?>" value="<?php echo e(string_decode($product_post_data['_product_video_feature_source_embedded_code'])); ?>">
                    </div>
                    <?php echo trans('admin.youtube_embedded_msg'); ?>

                  </div><hr><br>
                  
                  <div class="source-custom-video-url">
                    <div class="source-custom-video-url-label">
                      <?php if($product_post_data['_product_video_feature_source'] == 'online_url'): ?>
                      <input type="radio" checked="checked" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceCustomVideoUrl" value="online_url"> <?php echo trans('admin.add_online_video_url'); ?>

                      <?php else: ?>
                      <input type="radio" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceCustomVideoUrl" value="online_url"> <?php echo trans('admin.add_online_video_url'); ?>

                      <?php endif; ?>
                    </div>
                    <div class="source-custom-video-url-textbox"><input type="text" class="form-control" name="inputAddOnlineVideoUrl" id="inputAddOnlineVideoUrl" placeholder="<?php echo e(trans('admin.add_online_video_url')); ?>" value="<?php echo e($product_post_data['_product_video_feature_source_online_url']); ?>"></div>
                    <?php echo trans('admin.online_video_file_extensions'); ?>

                  </div>
                  
                  <div class="source-custom-video">                    
                    <div class="modal fade" id="productVideoUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                              <br>
                              <i class="icon-credit-card icon-7x"></i>
                              <p class="no-margin">You can upload only 1 video file at a time, The supported file extensions are: mp4 and ogg</p>
                            </div>
                            <div class="modal-body">             
                              <div class="uploadform dropzone no-margin dz-clickable dropzone-product-video-uploader" id="dropzone_video_file_uploader" name="dropzone_video_file_uploader">
                                <div class="dz-default dz-message">
                                  <span>Drop your Cover Picture here</span>
                                </div>
                              </div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default attachtopost" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
              </div> 
              
            </div>
          </div>
        </div>
      </div>
      
      <?php if(!is_vendor_login()): ?>    
      <div class="box box-solid product-manufacturer-settings">
        <div class="box-header with-border">
          <i class="fa fa-html5"></i>
          <h3 class="box-title"><?php echo trans('admin.product_manufacturer_settings'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group" style="display:none;">
                <label class="col-sm-6 control-label" for="inputEnableProductManufacturer"><?php echo trans('admin.enable_product_manufacturer'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <?php if($product_post_data['_product_enable_manufacturer'] == 'yes'): ?>
                      <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableProductManufacturer" id="inputEnableProductManufacturer">
                    <?php else: ?>
                      <input type="checkbox" class="shopist-iCheck" name="inputEnableProductManufacturer" id="inputEnableProductManufacturer">
                    <?php endif; ?>
                  </label>                                             
                </div>
              </div>
              <?php if(count($manufacturer_lists)>0): ?>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputSelectManufacturerName"><?php echo trans('admin.select_manufacturer'); ?></label>
                <div class="col-sm-6">
                 <?php $__currentLoopData = $manufacturer_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div class="manufacturer-name">
                   <div>
                     <?php if(in_array($row['term_id'], $selected_brands['term_id'])): ?>
                     <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputManufacturerName[]" id="inputManufacturerName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                     <?php else: ?>
                     <input type="checkbox" class="shopist-iCheck" name="inputManufacturerName[]" id="inputManufacturerName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                     <?php endif; ?>
                   </div>
                   <?php if($row['brand_logo_img_url']): ?><div><img src="<?php echo e(get_image_url($row['brand_logo_img_url'])); ?>" class="img-responsive"></div><?php else: ?> <div><img src="<?php echo e(default_placeholder_img_src()); ?>" class="img-responsive"></div> <?php endif; ?><div><?php echo $row['name']; ?></div><div>(<?php echo $row['brand_country_name']; ?>)</div>
                 </div>
                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
              </div>
              <?php else: ?>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="manufacturer-empty"><?php echo trans('admin.no_manufacturer_yet'); ?></label>
              </div>
              <?php endif; ?> 
            </div>
          </div>
        </div>
      </div>
      <?php endif; ?>
      
    </div>
    
    <div class="col-md-4">
      <div class="box box-solid visibility-product">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title"><?php echo trans('admin.visibility'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-7 control-label" for="inputVisibility"><?php echo trans('admin.enable_product'); ?></label>
                <div class="col-sm-5">
                  <select class="form-control select2" name="product_visibility" style="width: 100%;">
                    <?php if($product_post_data['post_status'] == 1): ?>
                      <option selected="selected" value="1"><?php echo trans('admin.enable'); ?></option>
                    <?php else: ?>
                      <option value="1"><?php echo trans('admin.enable'); ?></option>
                    <?php endif; ?>
                    
                    <?php if($product_post_data['post_status'] == 0): ?>
                      <option selected="selected" value="0"><?php echo trans('admin.disable'); ?></option>          
                    <?php else: ?>
                      <option value="0"><?php echo trans('admin.disable'); ?></option>
                    <?php endif; ?>      
                  </select>                                         
                </div>
              </div> 

              <?php if($product_post_data['_product_enable_visibility_schedule'] == 'yes'): ?>
              <div class="form-group enable-product-range" style="display:block;">
                <div class="col-sm-12">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="enableProductRange" name="enableProductRange" value="<?php echo e($product_post_data['_product_visibility_range']); ?>">
                  </div>
                </div>  
              </div>
              <?php else: ?> 
              <div class="form-group enable-product-range">
                <div class="col-sm-12">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="enableProductRange" name="enableProductRange">
                  </div>
                </div>  
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
      <!-- 900 -->
      <div class="box box-solid product-categories">
        <div class="box-header with-border">
          <i class="fa fa-camera"></i>
          <h3 class="box-title"><?php echo trans('admin.product_categories'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                <?php if(!is_vendor_login()): ?>    
                <a class="btn btn-default pull-right" href="<?php echo e(route('admin.product_categories_list')); ?>"><?php echo trans('admin.create_categories'); ?></a>
                <?php endif; ?>
                <div class="form-group">
                  <label class="col-sm-1 control-label" for="inputSelectCategories"></label>
                  <div class="col-sm-11">
                    <?php if(count($categories_lists) > 0): ?>
                      <ul>
                      <?php $__currentLoopData = $categories_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php echo $__env->make('pages.common.update-category-list', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    <?php else: ?>
                      <span><?php echo trans('admin.no_categories_yet'); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>




      <div class="box box-solid product-tags">
        <div class="box-header with-border">
          <i class="fa fa-tags"></i>
          <h3 class="box-title"><?php echo trans('admin.product_tags'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(!is_vendor_login()): ?>  
              <div class="clearfix">
                <a class="btn btn-default pull-right" href="<?php echo e(route('admin.product_tags_list')); ?>"><?php echo trans('admin.create_tags'); ?></a>
              </div>
              <?php endif; ?>

              <div class="form-group">
                <div class="col-sm-12">
                  <?php if(count($tags_lists)>0): ?>
                    <?php $__currentLoopData = $tags_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="tags-name">
                        <div>
                         <?php if(in_array($row['term_id'], $selected_tag['term_id'])): ?>
                         <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputTagsName[]" id="inputTagsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                         <?php else: ?>
                         <input type="checkbox" class="shopist-iCheck" name="inputTagsName[]" id="inputTagsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                         <?php endif; ?>
                        </div>
                         <div><?php echo $row['name']; ?></div>
                      </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <span><?php echo trans('admin.no_tags_yet'); ?></span>
                  <?php endif; ?> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="box box-solid product-colors">
        <div class="box-header with-border">
          <i class="fa fa-paint-brush"></i>
          <h3 class="box-title"><?php echo trans('admin.product_colors'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(!is_vendor_login()): ?>  
              <div class="clearfix">
                <a class="btn btn-default pull-right" href="<?php echo e(route('admin.product_colors_list')); ?>"><?php echo trans('admin.create_colors'); ?></a>
              </div>
              <?php endif; ?>

              <div class="form-group">
                <div class="col-sm-12">
                  <?php if(count($colors_lists)>0): ?>
                    <?php $__currentLoopData = $colors_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="colors-name">
                      <div>
                      <?php if(in_array($row['term_id'], $selected_colors['term_id'])): ?>      
                        <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputColorsName[]" id="inputColorsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                      <?php else: ?>
                        <input type="checkbox" class="shopist-iCheck" name="inputColorsName[]" id="inputColorsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                      <?php endif; ?>
                      </div> &nbsp;&nbsp;
                      <div style="width:22px;height:22px;border:1px solid #EEEEEE; background-color:#<?php echo e($row['color_code']); ?>"></div>
                      <div><?php echo $row['name']; ?></div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <span><?php echo trans('admin.no_colors_yet'); ?></span>
                  <?php endif; ?> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>  
      
      <div class="box box-solid product-sizes">
        <div class="box-header with-border">
          <i class="fa fa-th-large"></i>
          <h3 class="box-title"><?php echo trans('admin.product_sizes'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(!is_vendor_login()): ?>    
              <div class="clearfix">
                <a class="btn btn-default pull-right" href="<?php echo e(route('admin.product_sizes_list')); ?>"><?php echo trans('admin.create_sizes'); ?></a>
              </div>
              <?php endif; ?>

              <div class="form-group">
                <div class="col-sm-12">
                  <?php if(count($sizes_lists)>0): ?>
                    <?php $__currentLoopData = $sizes_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <div class="sizes-name">
                          <div>
                          <?php if(in_array($row['term_id'], $selected_sizes['term_id'])): ?>    
                          <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputSizesName[]" id="inputSizesName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                          <?php else: ?>
                          <input type="checkbox" class="shopist-iCheck" name="inputSizesName[]" id="inputSizesName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>">
                          <?php endif; ?>
                          </div> &nbsp;&nbsp;
                          <div><?php echo $row['name']; ?></div>
                      </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <span><?php echo trans('admin.no_sizes_yet'); ?></span>
                  <?php endif; ?> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 

     <!-- custom categories -->  
       <div class="box box-solid product-categories ccc" style="display: block">
        <div class="box-header with-border">
          <i class="fa fa-cogs"></i>
          <h3 class="box-title"><?php echo trans('Customizable Product Category'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                <?php if(!is_vendor_login()): ?>  
                <a class="btn btn-danger pull-right" href="<?php echo e(route('admin.product_categories_customlist')); ?>"><?php echo trans('admin.create_categories'); ?></a>
                <?php endif; ?>
                <div class="form-group">
                  <label class="col-sm-1 control-label" for="inputSelectCategories"></label>
                  <div class="col-sm-11">
                    <?php if(count($categories_customlists) > 0): ?>
                    <ul>
                      <?php $__currentLoopData = $categories_customlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php echo $__env->make('pages.common.update-customcategory-list', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </ul>
                    <?php else: ?>
                      <span><?php echo trans('admin.no_categories_yet'); ?></span>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

 

      <!-- custom tags -->
      <div class="box box-solid product-tags ccc" style="display: block">
        <div class="box-header with-border">
          <i class="fa fa-cog"></i>
          <h3 class="box-title"><?php echo trans('Customizable Product Category'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <?php if(!is_vendor_login()): ?>    
              <div class="clearfix">
                <a class="btn btn-danger pull-right" href="<?php echo e(route('admin.product_tags_customlist')); ?>"><?php echo trans('admin.create_tags'); ?></a>
              </div>
              <?php endif; ?>

              <div class="form-group">
                <label class="col-sm-1 control-label" for="inputSelectTgs"></label>
                <div class="col-sm-11">
                  <?php if(count($tags_lists)>0): ?>
                    <?php $__currentLoopData = $tags_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     <div class="tags-name"><div><input type="checkbox" class="shopist-iCheck" name="inputTagsName[]" id="inputTagsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>"></div><div><?php echo $row['name']; ?></div></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php else: ?>
                  <span><?php echo trans('admin.no_tags_yet'); ?></span>
                  <?php endif; ?> 
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
<!-- 9000 -->

             

      
         

<script type="text/javascript">
 $(document).ready(function() {  
   
   $("#change_product_type").change(function () {
     if($("#change_product_type").val()=='customizable_product'){
      $(".ccc").css("display", "block");
      $(".cca").css("display", "none");
      // $("#eb_product_Pfb").val("0");

    } else {
     $(".ccc").css("display", "none");
     $(".cca").css("display", "block");
      //  $("#eb_product_Pfb").val("1");

   }
   });
   
    
   });

</script>
        
      <?php if(!is_vendor_login() && count($vendors_list) > 0): ?>  
      <div class="box box-solid product-sizes">
        <div class="box-header with-border">
          <i class="fa fa-handshake-o"></i>
          <h3 class="box-title"><?php echo trans('admin.select_vendor_title'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <div class="col-sm-12">
                  <select name="vendor_list" id="vendor_list" class="vendors-list" style="width:100%;">
                    <option value=""> <?php echo trans('admin.choose_vendor_title'); ?> </option>  
                    <?php $__currentLoopData = $vendors_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(!empty($product_post_data['_selected_vendor'])): ?>
                        <?php if($vendor->id == $product_post_data['_selected_vendor']): ?>
                          <option selected="selected" value="<?php echo e($vendor->id); ?>"> <?php echo $vendor->display_name; ?> </option>
                        <?php else: ?>
                          <option value="<?php echo e($vendor->id); ?>"> <?php echo $vendor->display_name; ?> </option>
                        <?php endif; ?>
                      <?php endif; ?>  
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </select>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
      <?php endif; ?>  
    </div>
  </div>
  
  
  <input type="hidden" name="hf_uploaded_all_images" id="hf_uploaded_all_images" value="<?php echo e($product_post_data['product_related_img_json']); ?>">
  <input type="hidden" name="hf_selected_variation_attr" id="hf_selected_variation_attr" value="">
  <input type="hidden" name="hf_variation_data" id="hf_variation_data" value="<?php echo e($variation_json); ?>">
  <input type="hidden" name="hf_custom_designer_data" id="hf_custom_designer_data" value="<?php echo e($product_post_data['product_custom_designer_json']); ?>">
  <input type="hidden" name="is_product_save" id="is_product_save" value="yes">
  <input type="hidden" name="product_id" id="product_id" value="<?php echo e($product_post_data['id']); ?>">
  <input type="hidden" name="selected_variation_id" id="selected_variation_id">
  <input type="hidden" name="variation_json_before_edit" id="variation_json_before_edit">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="update_post">
  <input type="hidden" name="selected_upsell_products" id="selected_upsell_products" value="<?php echo e($upsell_products); ?>">
  <input type="hidden" name="selected_crosssell_products" id="selected_crosssell_products" value="<?php echo e($crosssell_products); ?>">
</form>

<div class="modal fade" id="downloadable_file_upload" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
  <div class="modal-dialog">
    <form enctype="multipart/form-data" id="downloadableproduct_file_submit" method="POST">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
          <br>
          <i class="icon-credit-card icon-7x"></i>
          <p class="no-margin"><?php echo trans('admin.you_can_upload_1_file_image'); ?></p>
        </div>
        <div class="modal-body">             
          <input type="file" name="uploadDownloadableProductFile" id="uploadDownloadableProductFile" />
        </div>
        <div class="modal-footer">
          <input type="submit" name="upload_downloadable_product_file" id="upload_downloadable_product_file" value="<?php echo e(trans('admin.upload_lang_zip_file')); ?>" class="btn btn-default attachtopost" />   
          <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
        </div>
      </div>
      <input type="hidden" name="simple_product" id="simple_product" value="simple_product">
    </form>      
  </div>
</div>

<div class="sp-popup" data-popup="variableProductDownloadableFileUpload">
  <div class="sp-popup-inner">
    <form enctype="multipart/form-data" id="variableDownloadableproduct_file_submit" method="POST">
      <p class="no-margin"><?php echo trans('admin.you_can_upload_1_file_image'); ?></p><hr>  
      <input type="file" name="uploadDownloadableVariableProductFile" id="uploadDownloadableVariableProductFile" />  
      <br>
      <div class="pull-right"><input type="submit" name="upload_downloadable_product_file" id="upload_downloadable_product_file" value="<?php echo e(trans('admin.upload_lang_zip_file')); ?>" class="btn btn-default attachtopost" />   
      </div>    
      <a class="sp-popup-close" data-popup-close="variableProductDownloadableFileUpload" href="#">x</a>
      
      <input type="hidden" name="variable_product" id="variable_product" value="variable_product">
    </form>  
  </div>
</div>

<input type="hidden" name="hf_downloadable_product_file_url_track" id="hf_downloadable_product_file_url_track">
<input type="hidden" name="hf_variable_product_downloadable_file_url_track" id="hf_variable_product_downloadable_file_url_track">

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>