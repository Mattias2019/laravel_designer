<?php $__env->startSection('title', trans('admin.add_product') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  
  <div class="box box-info">
    <div class="box-header">
      <h3 class="box-title"><?php echo trans('admin.add_new_product'); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.product_list', 'all')); ?>"><?php echo trans('admin.products_list'); ?></a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-block btn-primary" type="submit"><?php echo trans('admin.save'); ?></button>
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
          <input type="text" placeholder="<?php echo e(trans('admin.example_red_t_shirt')); ?>" class="form-control" name="product_name" id="eb_product_name" value="<?php echo e(old('product_name')); ?>">
        </div>
      </div>
      <!-- 900 -->
      <input type="hidden" name="product_Pfb" value="0" id="eb_product_Pfb">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.product_description'); ?></h3>
        </div>
        <div class="box-body">
          <textarea id="eb_description_editor" name="eb_description_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.product_description_placeholder')); ?>"></textarea>
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
            <div class="product-sample-img"><img class="upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="product-uploaded-image"><img class="img-responsive"><div class="remove-img-link"><button type="button" data-target="product_image" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
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
            <div class="product-gallery-sample-img"><img class="gallery-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="product-uploaded-gallery-image"></div>
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
            <div class="banner-sample-img"><img class="banner-upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="banner-uploaded-image"><img class="img-responsive"><div class="remove-img-link banner-img-remove"><button type="button" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
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

            <!-- 800 -->
            <select id="change_product_type" name="change_product_type" class="form-control select2" style="width: 100%;">
              <option selected="selected" value="simple_product"><?php echo trans('admin.simple_product'); ?></option>
              <option value="configurable_product"><?php echo trans('admin.configurable_product'); ?></option>
              <option value="customizable_product" class="cct"><?php echo trans('admin.customizable_product'); ?></option>
							<option value="downloadable_product"><?php echo trans('admin.downloadable_product'); ?></option>
            </select>
          </div>
        </div>
        <div class="box-body product-tab-content">
          <div class="tabbable tabs-left">
            <ul class="nav nav-tabs">
              <li class="active general"><a href="#tab_general" data-toggle="tab"><?php echo trans('admin.general'); ?></a></li>
              <li class="inventory"><a href="#tab_stock" data-toggle="tab"><?php echo trans('admin.inventory'); ?></a></li>
              <li class="features"><a href="#tab_features" data-toggle="tab"><?php echo trans('admin.features'); ?></a></li>
              <li class="advanced"><a href="#tab_advanced" data-toggle="tab"><?php echo trans('admin.advanced'); ?></a></li>
              <li class="attribute" style="display:none;"><a href="#tab_attribute" data-toggle="tab"><?php echo trans('admin.attributes'); ?></a></li>
              <li class="variations" style="display:none;"><a href="#tab_variations" data-toggle="tab"><?php echo trans('admin.variations'); ?></a></li>
              <li class="custom-design" style="display:none;"><a href="#tab_custom_design" data-toggle="tab"><?php echo trans('admin.add_design_elements'); ?></a></li>
              <li class="manage-download-files" style="display:none;"><a href="#tab_manage_download_files" data-toggle="tab"><?php echo trans('admin.manage_download_files'); ?></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-general tab-pane active" id="tab_general">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputSKU"><?php echo trans('admin.sku'); ?></label>
                      <div class="col-sm-6">
                        <input type="text" placeholder="<?php echo e(trans('admin.sku')); ?>" id="inputForProductSKU" name="ProductSKU" class="form-control" value="<?php echo e(old('ProductSKU')); ?>">
                        <span><?php echo trans('admin.unique_field'); ?></span>
                      </div>
                    </div>
                    <br>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputRegularPrice"><?php echo trans('admin.regular_price'); ?> (<?php echo $currency_symbol; ?>)</label>
                      <div class="col-sm-6">
                        <input type="number" placeholder="<?php echo e(trans('admin.regular_price')); ?>" id="inputRegularPrice" name="inputRegularPrice" class="form-control" min="0" step="any" value="<?php echo e(old('inputRegularPrice')); ?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputSalePrice"><?php echo trans('admin.sale_price'); ?> (<?php echo $currency_symbol; ?>)</label>
                      <div class="col-sm-6">
                        <input type="number" placeholder="<?php echo e(trans('admin.sale_price')); ?>" id="inputSalePrice" name="inputSalePrice" class="form-control" min="0" step="any" value="<?php echo e(old('inputSalePrice')); ?>"> 
                        <a href="#" class="create_sale_schedule"><?php echo trans('admin.create_schedule'); ?></a>
                      </div>
                    </div>
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
                    
                    <?php if(count($available_user_roles) > 0): ?>
                    <p style="font-size: 17px;font-weight:bold;color:#3c8dbc;"><i><?php echo trans('admin.role_based_pricing_label'); ?></i></p><hr>
                    
                    <div class="role-based-pricing-content">
                      <div class="form-group">
                        <label class="col-sm-6 control-label" for="inputEnableRoleBasedPricing"><?php echo trans('admin.enable_role_based_pricing_label'); ?></label>
                        <div class="col-sm-6">
                          <input type="checkbox" name="inputEnableDisableRoleBasedPricing" class="shopist-iCheck" id="inputEnableDisableRoleBasedPricing">
                        </div>
                      </div>

                        <?php $__currentLoopData = $available_user_roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $roles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-group">
                            <label class="col-sm-12 control-label" for="inputRoleBasedPricingText<?php echo e($roles['role_name']); ?>"><?php echo trans('admin.user_pricing_top_label', ['user_role' => $roles['role_name']]); ?></label>
                        </div>
                        <div class="form-group">
                          <div class="col-sm-6">
                            <input type="number" class="form-control" name="RoleRegularPricing[<?php echo e($roles['slug']); ?>]" placeholder="<?php echo e(trans('admin.regular_price')); ?>" min="0">
                          </div>
                          <div class="col-sm-6">
                            <input type="number" class="form-control" name="RoleSalePricing[<?php echo e($roles['slug']); ?>]" placeholder="<?php echo e(trans('admin.sale_price')); ?>" min="0">
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
                          <input type="checkbox" name="manage_stock" id="manage_stock" class="shopist-iCheck">
                          &nbsp;<?php echo trans('admin.enable_stock_management_product'); ?>

                        </label>                                             
                      </div>
                    </div>
                    <div class="form-group stock-qty" style="display:none;">
                      <label class="col-sm-6 control-label" for="inputStockQty"><?php echo trans('admin.stock_qty'); ?></label>
                      <div class="col-sm-6">
                        <input type="number" min="0" placeholder="<?php echo e(trans('admin.stock_qty')); ?>" id="inputStockQty" name="inputStockQty" class="form-control" value="0">
                      </div>
                    </div>
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
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputStockAvailability"><?php echo trans('admin.stock_availability'); ?></label>
                      <div class="col-sm-6">
                        <select id="stock_availability_status" name="stock_availability_status" class="form-control select2" style="width: 100%;">
                          <option selected="selected" value="in_stock"><?php echo trans('admin.in_stock'); ?></option>
                          <option value="out_of_stock"><?php echo trans('admin.out_of_stock'); ?></option>                  
                        </select>
                      </div>
                    </div>
                  </div>
                </div>    
              </div>
														
              <div class="tab-features tab-pane" id="tab_features">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <textarea id="eb_features_editor" name="eb_features_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.write_some_extra_features')); ?>"></textarea>
                    </div> 
                  </div>
                </div>  
              </div>
														
              <div class="tab-advanced tab-pane" id="tab_advanced">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableRecommendedProduct"><?php echo trans('admin.recommended_product'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" class="shopist-iCheck" name="enable_recommended_product" id="enable_recommended_product">
                        &nbsp;<?php echo trans('admin.enable_recommended_product'); ?>                                 
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableFeaturesProduct"><?php echo trans('admin.features_product'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" class="shopist-iCheck" name="enable_features_product" id="enable_features_product">
                        &nbsp;<?php echo trans('admin.enable_features_product'); ?>                                         
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableLatestProduct"><?php echo trans('admin.latest_product'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" class="shopist-iCheck" name="enable_latest_product" id="enable_latest_product">
                        &nbsp;<?php echo trans('admin.enable_latest_product'); ?>                                         
                      </div>
                    </div>
                    <div class="form-group cca">
                      <label class="col-sm-6 control-label" for="inputEnableForRelatedProduct"><?php echo trans('admin.related_product'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox"  class="shopist-iCheck" name="inputEnableForRelatedProduct" id="inputEnableForRelatedProduct">
                        &nbsp;<?php echo trans('admin.enable_related_product'); ?>                                         
                      </div>
                    </div>
                    <div class="form-group enable-custom-design" <?php echo $tabSettings['btnCustomize']; ?>>
                      <label class="col-sm-6 control-label" for="inputEnableForCustomDesignProduct"><?php echo trans('admin.custom_design'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableForCustomDesignProduct" id="inputEnableForCustomDesignProduct">
                        &nbsp;<?php echo trans('admin.enable_custom_design_product'); ?>                                        
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-6 control-label" for="inputEnableForHomePage"><?php echo trans('admin.home_page_product_label_1'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" class="shopist-iCheck" name="inputEnableForHomePage" id="inputEnableForHomePage">
                        &nbsp;<?php echo trans('admin.home_page_product_label_2'); ?>                                         
                      </div>
                    </div>  
                    <?php if( $settings_data['general_settings']['taxes_options']['enable_status'] == 1 && $settings_data['general_settings']['taxes_options']['apply_tax_for'] == 'per_product' ): ?>
                    <div class="form-group taxes-option">
                      <label class="col-sm-6 control-label" for="inputEnableTaxesForProduct"><?php echo trans('admin.taxes'); ?></label>
                      <div class="col-sm-6">
                        <input type="checkbox" class="shopist-iCheck" name="inputEnableTaxesForProduct" id="inputEnableTaxesForProduct">
                        &nbsp;<?php echo trans('admin.enable_taxes_this_product'); ?>                                         
                      </div>
                    </div>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
														
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
                                <div class="variation-sample-img"><img class="img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>" alt=""></div>
                                <div class="variation-img"><img class="img-responsive" src="" alt=""></div>
                                <br>
                                <div class="variation-img-upload-btn">
                                  <button type="button" class="btn btn-default attachtopost remove-variation-img"><?php echo trans('admin.remove_image'); ?></button>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="custom-input-group">
                            <div class="custom-input-label"><input type="checkbox" class="minimal-red" name="inputVariationEnable" id="inputVariationEnable">&nbsp;&nbsp;<label for="inputVariationEnable"><?php echo trans('admin.enable_this_variation'); ?></label></div>
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
                            <div class="custom-input-label"><input type="checkbox" class="minimal-red" name="inputManageVariationStock" id="inputManageVariationStock">&nbsp;&nbsp;<label for="inputManageVariationStock"><?php echo trans('admin.enable_stock_management_variation_product'); ?></label></div>
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
                            <div class="custom-input-label"><input type="checkbox" class="minimal-red" name="inputEnableTaxesForVariation" id="inputEnableTaxesForVariation">&nbsp;&nbsp;<label for="inputEnableTaxesForVariation"><?php echo trans('admin.enable_taxes_this_variation'); ?></label></div>  
                          </div>
                          <?php endif; ?>
                          <div class="custom-input-group">
                            <label class="custom-input-label" for="inputVariationDescription"><?php echo trans('admin.variation_description'); ?></label>
                            <div class="custom-input-element">
                              <textarea name="variation_description" id="variation_description" class="form-control"></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="custom-model-row content-for-variation-view">
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default attachtopost create-new-variations"><?php echo trans('admin.add_variation'); ?></button>
                        <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
                <?php if(count($attrs_list_data)>0): ?>
                <div class="clearfix">
                    <button data-toggle="modal" type="button" class="btn btn-default btn-xs create-variations pull-right"><?php echo trans('admin.create_variation'); ?></button>
                </div>    
                
                <div class="attributes-lists">
                  <?php $__currentLoopData = $attrs_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="attribute-name">
                    <select class="form-control select2 variation-attr-list" style="width: 100%;" data-attr_name="<?php echo e($rows['name']); ?>">
                      <option selected="selected" value="all"><?php echo trans('admin.any_label'); ?> <?php echo $rows['name']; ?></option>
                      <?php $__currentLoopData = explode(',', $rows['product_attr_values']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($val); ?>"><?php echo $val; ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>            
                    </select>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <?php else: ?>
                  <?php if(!is_vendor_login()): ?>
                  <a class="btn btn-default" href="<?php echo e(route('admin.product_attributes_list')); ?>"><?php echo trans('admin.create_attributes'); ?></a>
                  <?php endif; ?>
                <?php endif; ?>
              </div>
              
              <div class="tab-custom-design tab-pane" id="tab_custom_design">
                <div class="row">
                  <div class="col-md-12">                                        
                    <div class="form-group">
                      <div class="clearfix design-element-btn">
                         <button data-toggle="modal" data-target="#element_title_name" type="button" class="btn btn-default pull-right create-design-element"><?php echo trans('admin.create_design_element'); ?></button>
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
                              <input type="text" class="form-control" name="design_title_name" id="design_title_name" placeholder="<?php echo e(trans('admin.your_design_title_name')); ?>">
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
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo trans('admin.close'); ?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="design-element-main-container"></div>                      
                    </div>
                  </div>
                </div>                
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
                          <input type="number" class="form-control" name="download_limit" placeholder="<?php echo e(trans('admin.unlimited_placeholder_label')); ?>" id="download_limit"> <?php echo trans('admin.blank_for_unlimited_label'); ?>

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
            </div>
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
            <h3><?php echo trans('admin.product_title_label'); ?></h3>
            <p class="link"><?php echo url('/'); ?>/product/details/<span><?php echo string_slug_format( trans('admin.product_title_label') ); ?></span></p>
            <p class="description"><?php echo trans('admin.product_seo_desc_example'); ?></p>
          </div><hr>
          <div class="seo-content">
            <div class="row">  
              <div class="col-md-12">
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="<?php echo e(trans('admin.seo_title_label')); ?>" value="">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_url_format" id="seo_url_format" placeholder="<?php echo e(trans('admin.seo_url_label')); ?>" value="">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">  
                    <textarea id="seo_description" class="form-control" name="seo_description" placeholder="<?php echo e(trans('admin.seo_description_label')); ?>"></textarea>
                  </div>
                </div>  
                <div class="form-group">   
                  <div class="col-md-12">  
                    <textarea id="seo_keywords" class="form-control" name="seo_keywords" placeholder="<?php echo e(trans('admin.seo_keywords_label')); ?>"></textarea>
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
                        <input type="text" class="form-control" name="inputCompareData[<?php echo $key;?>]" placeholder="<?php echo e($compare_field); ?>">                                            
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
                    <input type="checkbox" checked="checked" class="shopist-iCheck" name="inputEnableReviews" id="inputEnableReviews">
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableAddReviewLinkToProductPage"><?php echo trans('admin.enable_add_review_link_to_product_page'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <input type="checkbox" class="shopist-iCheck" checked="checked" name="inputEnableAddReviewLinkToProductPage" id="inputEnableAddReviewLinkToProductPage">
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputEnableAddReviewLinkToDetailsPage"><?php echo trans('admin.enable_add_review_link_to_details_page'); ?></label>
                <div class="col-sm-6">
                  <label>
                    <input type="checkbox" class="shopist-iCheck" checked="checked" name="inputEnableAddReviewLinkToDetailsPage" id="inputEnableAddReviewLinkToDetailsPage">
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
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableProductVideo" id="inputEnableProductVideo">
                  </label>                                             
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputDisplayProductVideo"><?php echo trans('admin.product_video_display_mode_at_frontend'); ?></label>
                <div class="col-sm-6">
                  <span><input type="radio" class="shopist-iCheck" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPopup" value="popup">&nbsp; <?php echo trans('admin.display_at_popup'); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><input type="radio" checked="checked" class="shopist-iCheck" name="inputVideoDisplayMode" id="inputVideoDisplayModeAtPageContent" value="content">&nbsp; <?php echo trans('admin.page_content'); ?></span>
                </div>
              </div><hr><br>
              
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputTitleForVideo"><?php echo trans('admin.video_title'); ?></label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="inputTitleForVideo" id="inputTitleForVideo" placeholder="<?php echo e(trans('admin.video_title')); ?>" value="<?php echo e(old('inputTitleForVideo')); ?>">          
                </div>
              </div>
              <div class="form-group" style="display:none;">
                <label class="col-sm-6 control-label" for="inputVideoPanelWidth"><?php echo trans('admin.video_panel_width'); ?></label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="inputVideoPanelWidth" id="inputVideoPanelWidth" placeholder="<?php echo e(trans('admin.video_panel_width')); ?>" value="<?php echo e(old('inputVideoPanelWidth')); ?>"><i><?php echo trans('admin.pixels'); ?></i>          
                </div>
              </div>
              <div class="form-group" style="display:none;">
                <label class="col-sm-6 control-label" for="inputVideoPanelHeight"><?php echo trans('admin.video_panel_height'); ?></label>
                <div class="col-sm-6">
                    <input type="number" class="form-control" name="inputVideoPanelHeight" id="inputVideoPanelHeight" placeholder="<?php echo e(trans('admin.video_panel_height')); ?>" value="<?php echo e(old('inputVideoPanelHeight')); ?>"><i><?php echo trans('admin.pixels'); ?></i>
                </div>
              </div>
              <hr><br>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputLabelVideoSource"><?php echo trans('admin.select_video_source'); ?></label>
                <div class="col-sm-6">
                  <div class="source-embedded-code">
                    <div class="source-embedded-code-label"><input type="radio" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceEmbed" value="embedded_code"> <?php echo trans('admin.embedded_code'); ?></div>
                    <div class="source-embedded-code-textarea"><input type="text" class="form-control" name="inputEmbedCode" id="inputEmbedCode" placeholder="<?php echo e(trans('admin.enter_your_embedded_code_here')); ?>">
                    </div>
                    <?php echo trans('admin.youtube_embedded_msg'); ?>

                  </div><hr><br>
                  
                  <div class="source-custom-video-url">
                    <div class="source-custom-video-url-label"><input type="radio" class="shopist-iCheck" name="inputVideoSourceName" id="inputVideoSourceCustomVideoUrl" value="online_url"> <?php echo trans('admin.add_online_video_url'); ?></div>
                    <div class="source-custom-video-url-textbox"><input type="text" class="form-control" name="inputAddOnlineVideoUrl" id="inputAddOnlineVideoUrl" placeholder="<?php echo e(trans('admin.add_online_video_url')); ?>"></div>
                    <?php echo trans('admin.online_video_file_extensions'); ?>

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
                    <input type="checkbox" class="shopist-iCheck" name="inputEnableProductManufacturer" id="inputEnableProductManufacturer">
                  </label>                                             
                </div>
              </div>
              <?php if(count($manufacturer_lists)>0): ?>
              <div class="form-group">
                <label class="col-sm-6 control-label" for="inputSelectManufacturerName"><?php echo trans('admin.select_manufacturer'); ?></label>
                <div class="col-sm-6">
                 <?php $__currentLoopData = $manufacturer_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <div class="manufacturer-name"><div><input type="checkbox" class="shopist-iCheck" name="inputManufacturerName[]" id="inputManufacturerName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>"></div><?php if($row['brand_logo_img_url']): ?><div><img src="<?php echo e(get_image_url($row['brand_logo_img_url'])); ?>" class="img-responsive"></div><?php else: ?> <div><img src="<?php echo e(default_upload_sample_img_src()); ?>" class="img-responsive"></div> <?php endif; ?><div><?php echo $row['name']; ?></div><div>(<?php echo $row['brand_country_name']; ?>)</div></div>
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
                    <option selected="selected" value="1"><?php echo trans('admin.enable'); ?></option>
                    <option value="0"><?php echo trans('admin.disable'); ?></option>                  
                  </select>                                         
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
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
                          <?php echo $__env->make('pages.common.category-list', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
                <label class="col-sm-1 control-label" for="inputSelectColors"></label>
                <div class="col-sm-11">
                  <?php if(count($colors_lists)>0): ?>
                    <?php $__currentLoopData = $colors_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="colors-name"><div><input type="checkbox" class="shopist-iCheck" name="inputColorsName[]" id="inputColorsName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>"></div> &nbsp;&nbsp;<div style="width:22px;height:22px;border:1px solid #EEEEEE; background-color:#<?php echo e($row['color_code']); ?>"></div> <div><?php echo $row['name']; ?></div></div>
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
                <label class="col-sm-1 control-label" for="inputSelectSizes"></label>
                <div class="col-sm-11">
                  <?php if(count($sizes_lists)>0): ?>
                    <?php $__currentLoopData = $sizes_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="sizes-name"><div><input type="checkbox" class="shopist-iCheck" name="inputSizesName[]" id="inputSizesName-<?php echo e($row['name']); ?>" value="<?php echo e($row['term_id']); ?>"></div> &nbsp;&nbsp;<div><?php echo $row['name']; ?></div></div>
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
       <div class="box box-solid product-categories ccc" style="display: none">
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
                          <?php echo $__env->make('pages.common.category-list', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
      <div class="box box-solid product-tags ccc" style="display: none">
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
      $("#eb_product_Pfb").val("1");

    } else {
     $(".ccc").css("display", "none");
     $(".cca").css("display", "block");
       $("#eb_product_Pfb").val("0");

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
                    <option value="<?php echo e($vendor->id); ?>"> <?php echo $vendor->display_name; ?> </option>
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

 
  <input type="hidden" name="hf_uploaded_all_images" id="hf_uploaded_all_images" value="<?php echo e($product_all_images_json); ?>">
  <input type="hidden" name="hf_selected_variation_attr" id="hf_selected_variation_attr" value="">
  <input type="hidden" name="hf_variation_data" id="hf_variation_data" value="">
  <input type="hidden" name="hf_custom_designer_data" id="hf_custom_designer_data" value="">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="add_post">
  <input type="hidden" name="product_id" id="product_id" value="">
	<input type="hidden" name="selected_upsell_products" id="selected_upsell_products" value="">
  <input type="hidden" name="selected_crosssell_products" id="selected_crosssell_products" value="">
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
<input type="hidden" name="hf_downloadable_product_file_url_track" id="hf_downloadable_product_file_url_track">
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>