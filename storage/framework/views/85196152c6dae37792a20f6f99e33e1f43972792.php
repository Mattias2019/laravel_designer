<?php $__env->startSection('title', trans('admin.update_post_page_title') .' < '. get_site_title()); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('pages-message.form-submit', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.notify-msg-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('pages-message.notify-msg-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<form class="form-horizontal" method="post" action="" enctype="multipart/form-data">
  <div class="box">
    <div class="box-header">
      <h3 class="box-title"><?php echo trans('admin.update_post_page_title'); ?> &nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.all_blogs')); ?>"><?php echo trans('admin.posts_list'); ?></a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" href="<?php echo e(route('admin.add_blog')); ?>"><?php echo trans('admin.add_new_post_top_title'); ?></a>&nbsp;&nbsp;<a class="btn btn-default btn-xs" target="_blank" href="<?php echo e(route('blog-single-page', $blog_details_by_slug['post_slug'])); ?>"><?php echo trans('admin.view'); ?></a></h3>
      <div class="box-tools pull-right">
        <button class="btn btn-primary" type="submit"><?php echo trans('admin.update'); ?></button>
      </div>
    </div>
  </div>
  
  <div class="row">
    <div class="col-md-8">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.post_title'); ?></h3>
        </div>
        <div class="box-body">
          <input type="text" placeholder="<?php echo e(trans('admin.example_blog_post')); ?>" class="form-control" name="blog_post_title" id="blog_post_title" value="<?php echo e($blog_details_by_slug['post_title']); ?>">
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.description'); ?></h3>
        </div>
        <div class="box-body">
          <textarea id="blog_description_editor" name="blog_description_editor" class="dynamic-editor" placeholder="<?php echo e(trans('admin.post_description_placeholder')); ?>"><?php echo $blog_details_by_slug['post_content']; ?></textarea>
        </div>
      </div>
      
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-upload"></i>
          <h3 class="box-title"><?php echo trans('admin.featured_image'); ?></h3>
          <div class="box-tools pull-right">
            <div data-toggle="modal" data-dropzone_id="blog_featured_dropzone_file_uploader" data-target="#featuredUploader" class="icon product-uploader"><?php echo trans('admin.upload_image'); ?></div>
          </div>
        </div>
        <div class="box-body featured-img-content">
          
          <?php if($blog_details_by_slug['featured_image']): ?>
          <div class="uploaded-featured-image">
            <div class="featured-sample-img" style="display:none;"><img class="upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="featured-uploaded-image" style="display:block;"><img class="img-responsive" src="<?php echo e(get_image_url( $blog_details_by_slug['featured_image'] )); ?>"><div class="remove-img-link"><button type="button" data-target="featured_image" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
          </div>
          <?php else: ?>
          <div class="uploaded-featured-image">
            <div class="featured-sample-img" style="display:block;"><img class="upload-icon img-responsive" src="<?php echo e(default_upload_sample_img_src()); ?>"></div>
            <div class="featured-uploaded-image" style="display:none;"><img class="img-responsive"><div class="remove-img-link"><button type="button" data-target="featured_image" class="btn btn-default attachtopost"><?php echo trans('admin.remove_image'); ?></button></div></div>
          </div>
          <?php endif; ?>  
          <div class="modal fade" id="featuredUploader" tabindex="-1" role="dialog" aria-labelledby="updater" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">✕</button>
                  <br>
                  <i class="icon-credit-card icon-7x"></i>
                  <p class="no-margin"><?php echo trans('admin.you_can_upload_1_image'); ?></p>
                </div>
                <div class="modal-body">             
                  <div class="uploadform dropzone no-margin dz-clickable featured_dropzone_file_upload" id="featured_dropzone_file_upload" name="featured_dropzone_file_upload">
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
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.post_seo_label'); ?></h3>
        </div>
        <div class="box-body">
          <div class="seo-preview-content">
            <p><i class="fa fa-eye"></i> <?php echo trans('admin.google_search_preview_label'); ?></p><hr>
            
            <?php if(!empty($blog_details_by_slug['blog_seo_title'])): ?>
            <h3><?php echo $blog_details_by_slug['blog_seo_title']; ?></h3>
            <?php else: ?>
            <h3><?php echo trans('admin.product_title_label'); ?></h3>
            <?php endif; ?>
            
            <?php if(!empty($blog_details_by_slug['blog_seo_url'])): ?>
            <p class="link"><?php echo url('/'); ?>/blog/<span><?php echo $blog_details_by_slug['blog_seo_url']; ?></span></p>
            <?php else: ?>
            <p class="link"><?php echo url('/'); ?>/blog/<span><?php echo string_slug_format( trans('admin.product_title_label') ); ?></span></p>
            <?php endif; ?>
            
            <?php if(!empty($blog_details_by_slug['blog_seo_description'])): ?>
            <p class="description"><?php echo $blog_details_by_slug['blog_seo_description']; ?></p>
            <?php else: ?>
            <p class="description"><?php echo trans('admin.product_seo_desc_example'); ?></p>
            <?php endif; ?>
            
          </div><hr>
          <div class="seo-content">
            <div class="row">  
              <div class="col-md-12">
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_title" id="seo_title" placeholder="<?php echo e(trans('admin.seo_title_label')); ?>" value="<?php echo e($blog_details_by_slug['blog_seo_title']); ?>">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">
                  <input type="text" class="form-control" name="seo_url_format" id="seo_url_format" placeholder="<?php echo e(trans('admin.seo_url_label')); ?>" value="<?php echo e($blog_details_by_slug['blog_seo_url']); ?>">
                  </div>  
                </div>
                <div class="form-group">  
                  <div class="col-md-12">  
                    <textarea id="seo_description" class="form-control" name="seo_description" placeholder="<?php echo e(trans('admin.seo_description_label')); ?>"><?php echo $blog_details_by_slug['blog_seo_description']; ?></textarea>
                  </div>
                </div>  
                <div class="form-group">   
                  <div class="col-md-12">  
                    <textarea id="seo_keywords" class="form-control" name="seo_keywords" placeholder="<?php echo e(trans('admin.seo_keywords_label')); ?>"><?php echo $blog_details_by_slug['blog_seo_keywords']; ?></textarea>
                  </div>
                </div>
              </div>
            </div>
          </div>  
        </div>  
      </div>   
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.blog_post_allow_characters'); ?></h3>
        </div>
        <div class="box-body">
          <input type="number" class="form-control"  name="allow_max_number_characters_at_frontend" id="allow_max_number_characters_at_frontend" value="<?php echo e($blog_details_by_slug['allow_max_number_characters_at_frontend']); ?>" style="width:100px;"><span><?php echo trans('admin.max_characters_msg'); ?></span>
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-text-width"></i>
          <h3 class="box-title"><?php echo trans('admin.blog_post_allow_comments'); ?></h3>
        </div>
        <div class="box-body">
          <?php if($blog_details_by_slug['allow_comments_at_frontend'] == 'yes'): ?>
            <input type="checkbox" checked="checked" class="shopist-iCheck" name="allow_comments_at_frontend" id="allow_comments_at_frontend"> &nbsp;<span><?php echo trans('admin.blog_post_allow_comments_msg'); ?></span>
          <?php else: ?>
            <input type="checkbox" class="shopist-iCheck" name="allow_comments_at_frontend" id="allow_comments_at_frontend"> &nbsp;<span><?php echo trans('admin.blog_post_allow_comments_msg'); ?></span>
          <?php endif; ?>
        </div>
      </div>  
    </div>
    <div class="col-md-4">
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-eye"></i>
          <h3 class="box-title"><?php echo trans('admin.visibility'); ?></h3>
        </div>
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="col-sm-4 control-label" for="inputVisibility"><?php echo trans('admin.blog_post_status'); ?></label>
                <div class="col-sm-8">
                  <select class="form-control select2" name="blog_post_visibility" style="width: 100%;">
                    <?php if($blog_details_by_slug['post_status'] == 1): ?>
                      <option selected="selected" value="1"><?php echo trans('admin.enable'); ?></option>
                    <?php else: ?>
                      <option value="1"><?php echo trans('admin.enable'); ?></option>
                    <?php endif; ?>
                    
                    <?php if($blog_details_by_slug['post_status'] == 0): ?>
                      <option selected="selected" value="0"><?php echo trans('admin.disable'); ?></option>          
                    <?php else: ?>
                      <option value="0"><?php echo trans('admin.disable'); ?></option>
                    <?php endif; ?>      
                  </select>                                         
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        
      <div class="box box-solid">
        <div class="box-header with-border">
          <i class="fa fa-camera"></i>
          <h3 class="box-title"><?php echo trans('admin.categories'); ?></h3>
        </div>
        <div class="box-body blog-categories">
          <div class="row">
            <div class="col-md-12">
              <div class="clearfix">
                <a class="btn btn-default pull-right" href="<?php echo e(route('admin.blog_categories_list')); ?>"><?php echo trans('admin.create_categories'); ?></a>
                  <div class="form-group">
                    <label class="col-sm-1 control-label" for="inputSelectCategories"></label>
                    <div class="col-sm-11">
                      <?php if(count($blog_categories_lists) > 0): ?>
                        <ul>
                        <?php $__currentLoopData = $blog_categories_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
    </div>  
  </div>
  <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
  <input type="hidden" name="hf_post_type" id="hf_post_type" value="update">
  <input type="hidden" name="image_url" id="image_url" value="<?php echo e($blog_details_by_slug['featured_image']); ?>">
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>