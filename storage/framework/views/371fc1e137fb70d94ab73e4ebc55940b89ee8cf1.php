<?php if(!empty($designer_img_elments) && !empty($designer_hf_data) && count($designer_img_elments) > 0 && count($designer_hf_data) >0): ?>
<style type="text/css">
   <?php if(count($fonts_list) > 0): ?>
    <?php $__currentLoopData = $fonts_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $parse_ext = explode('.', $row['url']);?>
      @font-face {
        font-family: <?php echo $row['post_slug']; ?>;
        src: url("<?php echo e(url('public').'/'. $row['url']); ?>") format("<?php echo e($parse_ext[1]); ?>");
        font-weight: normal;
        font-style: normal;
      }
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   <?php endif; ?>
</style>

<div class="custom-designer-panel">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="overflow:auto;">
      <div class="canvas-container-main">
        <ul class="nav-design-element">
          <?php if(Request::is('admin/product/update/*')): ?>
            <li data-tab_name="text" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.add_text')); ?>"><span class="icon-img-text"></span></li>
            <li data-tab_name="clipart" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.image_gallery')); ?>"><span class="icon-img-gallery"></span></li>
            <li data-tab_name="image_upload" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.upload_image')); ?>"><span class="icon-img-upload"></span></li>
            <li data-tab_name="shape_add" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.add_shape')); ?>"><span class="icon-img-shape"></span></li>
            <li data-tab_name="swap" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.swap')); ?>"><span class="icon-img-swap"></span></li>
            <li class="preview" data-tab_name="preview" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.preview')); ?>"><span class="icon-img-preview"></span></li>
          <?php else: ?>
            <li data-tab_name="text" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.add_text')); ?>"><span class="icon-img-text"></span></li>
            <li data-tab_name="clipart" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.image_gallery')); ?>"><span class="icon-img-gallery"></span></li>
            <li data-tab_name="image_upload" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.upload_image')); ?>"><span class="icon-img-upload"></span></li>
            <li data-tab_name="shape_add" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.add_shape')); ?>"><span class="icon-img-shape"></span></li>
            <li data-tab_name="swap" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.swap')); ?>"><span class="icon-img-swap"></span></li>
            <li class="preview" data-tab_name="preview" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.preview')); ?>"><span class="icon-img-preview"></span></li>
          <?php endif; ?>
          
          <?php if(Request::is('product/customize/*')): ?>
          <li data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.download')); ?>">
            <a id="downloadImgLink" href="#" download="product.png">
              <span class="icon-img-download"></span>
            </a>
          </li>
          <li data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.pdf')); ?>"><span class="icon-img-pdf"></span></li>
          <li data-toggle="tooltip" data-placement="bottom" title="<?php echo e(trans('frontend.print')); ?>"><span class="icon-img-print"></span></li>
          <?php endif; ?>
        </ul>
        
        <div id="swap-popover-content" class="hide">
          <?php $__currentLoopData = $designer_img_elments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div data-id="<?php echo e($row->id); ?>" data-design_img_url="<?php echo e(get_image_url($row->design_img_url)); ?>" data-design_trans_img_url="<?php echo e(get_image_url($row->design_trans_img_url)); ?>" class="design-title-items">
            <div><img src="<?php echo e(get_image_url($row->design_title_icon)); ?>"></div>
            <div class="design-title-label"><?php echo $row->title_label; ?></div>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <div class="canvas-design-panel">
          <canvas id="designer_canvas"></canvas>

          <div class="designer-text-control panel panel-default">
            <div class="panel-heading" id="draggable-handle">
              <?php echo e(trans('frontend.rearrange_your_text')); ?>

              <i class="fa fa-close pull-right close-design-control-modal" data-name="text"></i>
            </div>

            <div class="panel-body">
              <p><i><?php echo e(trans('frontend.edit_your_text')); ?></i></p>
              <div class="dynamic-change-text"><textarea name="change_dynamic_text" id="change_dynamic_text"></textarea></div>
              <div class="remove-selected-object" data-toggle="tooltip" data-placement="left" title="<?php echo e(trans('frontend.text_remove')); ?>"></div>
              <hr>
              <p><i><?php echo e(trans('frontend.enable_curved_text')); ?></i></p>
              <div class="enable-curve-text">
                <input type="checkbox" value="None" id="enableCurvedText" name="enableCurvedText" />
                <label for="enableCurvedText"></label>
              </div>
              <div class="curved-text-elements">
                <p><i><?php echo e(trans('frontend.change_radius')); ?></i></p>
                <div class="change-radius"><input id="change_radius" type="text" name="change_radius" data-name="radius" value=""></div>
                <p><i><?php echo e(trans('frontend.change_spacing')); ?></i></p>
                <div class="change-spacing"><input id="change_spacing" type="text" name="change_spacing" data-name="spacing" value=""></div>
                <p><i><?php echo e(trans('frontend.reverse')); ?></i></p>
                <div class="enable-reverse">
                  <input type="checkbox" value="None" data-name="reverse" id="enableCurvedTextReverse" name="enableCurvedTextReverse" />
                  <label for="enableCurvedTextReverse"></label>
                </div>
              </div>
              <p><i><?php echo e(trans('frontend.change_font_family')); ?></i></p>
              <div class="dynamic-fonts-change">
                <select id="change_fonts" name="change_fonts" class="change-text-attribute" data-name="fontFamily">
                    <option value="-1"><?php echo e(trans('frontend.select_font')); ?></option>
                    <option value="arial">arial</option>

                    <?php if(count($fonts_list) > 0): ?>
                      <?php $__currentLoopData = $fonts_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $font): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($font['post_slug']); ?>" style="font-family:<?php echo e($font['post_slug']); ?>"><?php echo $font['post_title']; ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </select>
              </div>
              <p><i><?php echo e(trans('frontend.change_line_height')); ?></i></p>
              <div class="dynamic-line-height">
                  <input id="text_line_height" type="text" name="text_line_height" data-name="lineHeight" value="">
              </div>
              <p><i><?php echo e(trans('frontend.change_text_color')); ?></i></p>
              <div class="dynamic-color-change">
                  <input class="color change-text-attribute" data-name="fill" type="text" id="change_text_color" name="change_text_color">
              </div>
              <p><i><?php echo e(trans('frontend.change_text_alignment')); ?></i></p>
              <div class="dynamic-text-alignment">
                  <ul class="text-align">
                    <li class="align-left" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.align_left')); ?>"><span class="icon-img-left-alignment"></span></li>
                    <li class="align-center" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.align_center')); ?>"><span class="icon-img-center-alignment"></span></li>
                    <li class="align-right" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.align_right')); ?>"><span class="icon-img-right-alignment"></span></li>
                  </ul>
              </div>
              <p><i><?php echo e(trans('frontend.change_text_style')); ?></i></p>
              <div class="dynamic-text-font-weight">
                  <ul class="text-font-weight">
                    <li class="normal" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.normal_style')); ?>"><span class="icon-img-font-weight-normal"></span></li>
                    <li class="bold" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.text_bold')); ?>"><span class="icon-img-font-weight-bold"></span></li>
                    <li class="italic" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.text_italic')); ?>"><span class="icon-img-font-weight-italic"></span></li>
                  </ul>
              </div>
              <p><i><?php echo e(trans('frontend.change_text_decoration')); ?></i></p>
              <div class="dynamic-text-decoration">
                  <ul class="textDecoration">
                    <li class="none" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.normal_decoration')); ?>"><span class="icon-img-decoration-normal"></span></li>
                    <li class="underline" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.text_underline')); ?>"><span class="icon-img-decoration-underline"></span></li>
                    <li class="line-through" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.text_line_through')); ?>"><span class="icon-img-decoration-line-through"></span></li>
                    <li class="overline" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.text_overline')); ?>"><span class="icon-img-decoration-overline"></span></li>
                  </ul>
              </div>
              <p><i><?php echo e(trans('frontend.change_text_opacity')); ?></i></p>
              <div class="dynamic-text-opacity">
                <input type="text" id="change_text_opacity" name="change_text_opacity">
              </div>
              <p><i><?php echo e(trans('frontend.change_text_shadow_color')); ?></i></p>
              <div class="dynamic-text-shadow-color"> 
                <div class="shadow-color"><input class="color change-text-shadow" data-name="color" type="text" id="change_text_shadow_color" name="change_text_shadow_color"></div>
              </div>
              <p><i><?php echo e(trans('frontend.change_text_shadow_offset_x')); ?></i></p>
              <div class="shadow-offset-x"><input type="text" id="change_text_x_shadow" data-name="offset_x" name="change_text_x_shadow"></div>
              <p><i><?php echo e(trans('frontend.change_text_shadow_offset_y')); ?></i></p>
              <div class="shadow-offset-y"><input type="text" id="change_text_y_shadow" data-name="offset_y" name="change_text_y_shadow"></div>
              <p><i><?php echo e(trans('frontend.change_text_shadow_blur')); ?></i></p>
              <div class="shadow-blur"><input type="text" id="change_text_blur_shadow" data-name="blur" name="change_text_blur_shadow"></div>
              <p><i><?php echo e(trans('frontend.change_more_option')); ?></i></p>
              <div class="dynamic-text-more-option">
                  <ul>
                    <li class="object-flip-x" data-name="flip-x" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.flip_x')); ?>"><span class="icon-object-flip-x"></span></li>
                    <li class="object-flip-y" data-name="flip-y" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.flip_y')); ?>"><span class="icon-object-flip-y"></span></li>
                    <li class="object-move-front" data-name="move-front" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.move_to_front')); ?>"><span class="icon-object-move-front"></span></li>
                    <li class="object-move-back" data-name="move-back" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.send_to_back')); ?>"><span class="icon-object-move-back"></span></li>
                    <?php if(!Request::is('product/customize/*')): ?>
                    <li class="object-lock" data-name="lock" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.lock_unlock')); ?>"><span class="icon-object-lock"></span></li>
                    <?php endif; ?>
                  </ul>
              </div>
            </div>
          </div>
          <div class="designer-image-gallery panel panel-default">
            <div class="panel-heading" id="draggable-handle">
                <?php echo e(trans('frontend.image_gallery')); ?>

                <i class="fa fa-close pull-right close-design-control-modal" data-name="gallery"></i>
            </div>
            <div class="panel-body">
              <?php if(count($art_cat_lists_data) >0): ?>
                <div class="gallery-image-categories-list">
                  <?php $__currentLoopData = $art_cat_lists_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $atr_cat_row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($atr_cat_row['status'] == 1): ?>
                    <div data-cat_id="<?php echo e($atr_cat_row['term_id']); ?>" class="gallery-items"><span><?php echo $atr_cat_row['name']; ?></span></div>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <div class="clear_both"></div>
                </div>
              <?php else: ?> 
                <div class="no-available-msg"><?php echo e(trans('frontend.no_clipart_categories_yet')); ?></div>
              <?php endif; ?>
            </div>
          </div>
          <div class="designer-image-edit-panel panel panel-default">
            <div class="panel-heading" id="draggable-handle">
                <?php echo e(trans('frontend.rearrange_your_added_images')); ?>

                <i class="fa fa-close pull-right close-design-control-modal" data-name="image"></i>
            </div>
            <div class="panel-body">
              <p><i><?php echo e(trans('frontend.change_image_color')); ?></i></p>
              <div class="dynamic-color-change">
                  <input class="color" data-name="fill" data-type="image" type="text" id="change_img_color" name="change_img_color">
              </div>
              <div class="image-opacity-option">
                <p><i><?php echo e(trans('frontend.change_image_opacity')); ?></i></p>
                <div class="dynamic-img-opacity">
                  <input type="text" id="change_img_opacity" name="change_img_opacity">
                </div>
              </div>
              <p><i><?php echo e(trans('frontend.change_more_option')); ?></i></p>
              <div class="dynamic-img-more-option">
                  <ul>
                    <li class="object-flip-x" data-name="flip-x" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.flip_x')); ?>"><span class="icon-object-flip-x"></span></li>
                    <li class="object-flip-y" data-name="flip-y" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.flip_y')); ?>"><span class="icon-object-flip-y"></span></li>
                    <li class="object-move-front" data-name="move-front" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.move_to_front')); ?>"><span class="icon-object-move-front"></span></li>
                    <li class="object-move-back" data-name="move-back" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.send_to_back')); ?>"><span class="icon-object-move-back"></span></li>
                    <?php if(!Request::is('product/customize/*')): ?>
                    <li class="object-lock" data-name="lock" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.lock_unlock')); ?>"><span class="icon-object-lock"></span></li>
                    <?php endif; ?>
                    <li class="object-remove" data-name="remove" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.remove')); ?>"><span class="remove-selected-object"></span></li>
                  </ul>
              </div>
            </div>
          </div>
          
          <div class="designer-upload-image panel panel-default">
            <div class="panel-heading" id="draggable-handle">
              <?php echo e(trans('frontend.upload_your_images')); ?>

              <i class="fa fa-close pull-right close-design-control-modal" data-name="upload"></i>
            </div>
            <div class="panel-body">
              <p class="no-margin"><?php echo e(trans('frontend.you_can_upload_1_image')); ?></p>
              <div class="dropzone dz-clickable" id="file_upload_for_designer" name="file_upload_for_designer">
                <div class="dz-default dz-message">
                  <span><?php echo e(trans('frontend.drop_your_cover_picture_here')); ?></span>
                </div>
              </div>
              <div class="recently-uploaded-images">
                <br>
                <?php if( count(get_recent_uploaded_images_for_designer())>0 ): ?>
                  <?php $__currentLoopData = get_recent_uploaded_images_for_designer(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="recent-images-items"><img src="<?php echo e(url('/')); ?>/public/uploads/<?php echo e($data); ?>"></div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <div class="clear_both"></div>
                <?php else: ?>
                  <div class="no-available-msg"><?php echo e(trans('frontend.no_recently_uploaded_images_yet')); ?></div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="modal fade" id="designPreview" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                  <br>
                  <i class="icon-credit-card icon-7x"></i>
                  <p class="no-margin"><?php echo e(trans('frontend.design_preview')); ?></p>
                </div>
                <div class="modal-body" style="text-align:center;overflow:auto;"><img src=""></div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default attachtopost" data-dismiss="modal"><?php echo e(trans('frontend.close')); ?></button>
                </div>
              </div>
            </div>
          </div>
          
          <div class="designer-shape-gallery panel panel-default">
            <div class="panel-heading" id="draggable-handle">
              <?php echo e(trans('frontend.shape_label')); ?>

              <i class="fa fa-close pull-right close-design-control-modal" data-name="gallery"></i>
            </div>
            <div class="panel-body">
              <?php if(count($shape_list) >0): ?>
                <div class="shape-list">
                  <ul>
                    <?php $__currentLoopData = $shape_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shape): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li data-shape="<?php echo e($shape['post_content']); ?>"><?php echo base64_decode($shape['post_content']); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
              <?php else: ?> 
                <div class="no-available-msg"><?php echo e(trans('frontend.no_shape_yet')); ?></div>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
<br>
<?php if(Request::is('admin/product/update/*')): ?>
<div class="clearfix">
<!--  <div class="pull-left">
    <a id="add_restricted_area" href="#" class="btn btn-default"><?php echo e(trans('frontend.restricted_label')); ?></a>
    <a id="lock_restricted_area" href="#" class="btn btn-default"><?php echo e(trans('frontend.restricted_lock_label')); ?></a>
    <a id="unlock_restricted_area" href="#" class="btn btn-default"><?php echo e(trans('frontend.restricted_unlock_label')); ?></a>
  </div>  -->
  <div class="pull-right">
    <a id="save_custom_design" data-source_name="admin" href="#" class="btn btn-default"><?php echo e(trans('frontend.save_design')); ?></a>&nbsp;
    <a id="remove_custom_design" data-source_name="admin" href="#" class="btn btn-default"><?php echo e(trans('frontend.remove_design')); ?></a>
  </div>
</div>
<?php endif; ?>
<div class="ajax-overlay"></div>
<div class="_loader"></div>
<input type="hidden" name="hf_designer_settings_json" id="hf_designer_settings_json" value="<?php echo e(json_encode($designer_hf_data)); ?>">
<input type="hidden" name="track_is_loaded_first" id="track_is_loaded_first" value="<?php echo e(get_image_url($designer_img_elments[0]->design_img_url)); ?>">
<input type="hidden" name="track_is_trans_loaded_first" id="track_is_trans_loaded_first" value="<?php echo e(get_image_url($designer_img_elments[0]->design_trans_img_url)); ?>">
<input type="hidden" name="hf_design_save_json_data" id="hf_design_save_json_data" value="<?php echo e($design_save_data); ?>">

<style type="text/css">
  .select2-drop {
    z-index: 99999;
}

.select2-results {
    z-index: 99999;
}

.select2-result {
    z-index: 99999;
}

<?php if(count($designer_img_elments)>1): ?>
  .design-title-items
  {
    width: calc(50% - 5px) !important;
  }
<?php else: ?>
  width: calc(100% - 5px) !important;
<?php endif; ?>
</style>
<?php endif; ?>