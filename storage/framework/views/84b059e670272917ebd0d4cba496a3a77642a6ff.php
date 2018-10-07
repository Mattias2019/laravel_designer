<?php $__env->startSection('title', trans('frontend.shopist_category_products') .' < '. get_site_title() ); ?>

<?php $__env->startSection('content'); ?>
<?php if(isset($product_by_cat_id['breadcrumb_html'])){?>
<div class="container">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div id="product-category-breadcrumb">
        <?php echo $product_by_cat_id['breadcrumb_html']; ?>

      </div>
    </div>    
  </div>    
</div>    
<?php }?>

<div id="product-category" class="container new-container">
  <div class="row">
    <div class="col-xs-12 col-md-4">
      <div class="left-sidebar">
      <?php echo $__env->make('includes.frontend.categories-page', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->yieldContent('categories-page-content'); ?>
      </div>
			
      <div class="filter-panel">
        <form action="<?php echo e($product_by_cat_id['action_url']); ?>" method="get">      
          <div class="price-filter">
            <h2><?php echo e(trans('frontend.price_range_label')); ?> <span class="responsive-accordian"></span></h2>
            <div class="price-slider-option">
              <input type="text" class="span2" value="" data-slider-min="<?php echo e(get_appearance_settings()['general']['filter_price_min']); ?>" data-slider-max="<?php echo e(get_appearance_settings()['general']['filter_price_max']); ?>" data-slider-step="5" data-slider-value="[<?php echo e($product_by_cat_id['min_price']); ?>,<?php echo e($product_by_cat_id['max_price']); ?>]" id="price_range" ><br />
              <b><?php echo price_html(get_appearance_settings()['general']['filter_price_min'], get_frontend_selected_currency()); ?></b> <b class="pull-right"><?php echo price_html(get_appearance_settings()['general']['filter_price_max'], get_frontend_selected_currency()); ?></b>
            </div>
            
            <input name="price_min" id="price_min" value="<?php echo e($product_by_cat_id['min_price']); ?>" type="hidden">
            <input name="price_max" id="price_max" value="<?php echo e($product_by_cat_id['max_price']); ?>" type="hidden">
          </div>
						
          <?php if(count($colors_list_data) > 0): ?>
          <div class="colors-filter">
            <h2><?php echo e(trans('frontend.choose_color_label')); ?> <span class="responsive-accordian"></span></h2>
            <div class="colors-filter-option">
              <?php $__currentLoopData = $colors_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="colors-filter-elements">
                <div class="chk-filter">
                  <?php if(count($product_by_cat_id['selected_colors']) > 0 && in_array($terms['slug'], $product_by_cat_id['selected_colors'])): ?>  
                  <input type="checkbox" checked class="shopist-iCheck chk-colors-filter" value="<?php echo e($terms['slug']); ?>">
                  <?php else: ?>
                  <input type="checkbox" class="shopist-iCheck chk-colors-filter" value="<?php echo e($terms['slug']); ?>">
                  <?php endif; ?>
                </div>
                <div class="filter-terms">
                  <div class="filter-terms-appearance"><span style="background-color:#<?php echo e($terms['color_code']); ?>;width:21px;height:20px;display:block;"></span></div>
                  <div class="filter-terms-name">&nbsp; <?php echo $terms['name']; ?></div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php if($product_by_cat_id['selected_colors_hf']): ?>
            <input name="selected_colors" id="selected_colors" value="<?php echo e($product_by_cat_id['selected_colors_hf']); ?>" type="hidden">
            <?php endif; ?>
          </div>
          <?php endif; ?>
      
          <?php if(count($sizes_list_data) > 0): ?>
          <div class="size-filter">
            <h2><?php echo e(trans('frontend.choose_size_label')); ?> <span class="responsive-accordian"></span></h2>
            <div class="size-filter-option">
              <?php $__currentLoopData = $sizes_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="size-filter-elements">
                <div class="chk-filter">
                  <?php if(count($product_by_cat_id['selected_sizes']) > 0 && in_array($terms['slug'], $product_by_cat_id['selected_sizes'])): ?>  
                  <input type="checkbox" checked class="shopist-iCheck chk-size-filter" value="<?php echo e($terms['slug']); ?>">
                  <?php else: ?>
                  <input type="checkbox" class="shopist-iCheck chk-size-filter" value="<?php echo e($terms['slug']); ?>">
                  <?php endif; ?>
                </div>
                <div class="filter-terms">
                  <div class="filter-terms-name"><?php echo $terms['name']; ?></div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div> 
            <?php if($product_by_cat_id['selected_sizes_hf']): ?>
            <input name="selected_sizes" id="selected_sizes" value="<?php echo e($product_by_cat_id['selected_sizes_hf']); ?>" type="hidden">
            <?php endif; ?>
          </div>
          <?php endif; ?>
          
          <div class="btn-filter clearfix">
            <a class="btn btn-sm" href="<?php echo e(route('categories-page', $product_by_cat_id['parent_slug'])); ?>"><i class="fa fa-close" aria-hidden="true"></i>
 <?php echo e(trans('frontend.clear_filter_label')); ?></a>  
            <button class="btn btn-sm" type="submit"><i class="fa fa-filter" aria-hidden="true"></i> <?php echo e(trans('frontend.filter_label')); ?></button>
          </div>
        </form>
      </div>
    </div>

    <div class="col-xs-12 col-md-8">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <div class="advertisement-right">
            <div id="advertisement-right-carousel" class="carousel slide" data-ride="carousel">
              <div class="carousel-inner">
                <div class="item active">
                  <div class="text-center">
                    <a href=""><img src="<?php echo e(asset('public/images/add-sample/girl.jpg')); ?>" alt="" class="img-responsive" /></a>
                  </div>
                </div>
                <div class="item">
                  <div class="text-center">
                    <a href=""><img src="<?php echo e(asset('public/images/add-sample/girl-in-sunglass.jpg')); ?>" alt="" class="img-responsive" /></a>
                  </div>
                </div> 
                <div class="item">
                  <div class="text-center">
                    <a href=""><img src="<?php echo e(asset('public/images/add-sample/T-shirt.jpg')); ?>" alt="" class="img-responsive" /></a>
                  </div>
                </div>
              </div>
              <div class="slider-control-main text-center">
                <div class="prev-btn">
                  <a href="#advertisement-right-carousel" class="control-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                  </a>
                </div>

                <div class="next-btn">
                  <a href="#advertisement-right-carousel" class="control-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> 
        
      <div class="row">
        <div class=" products-list-top">  
          <div class="col-xs-4 col-md-4">
            <div class="product-views pull-left">
              <?php if($product_by_cat_id['selected_view'] == 'grid'): ?>
                <a class="active" href="<?php echo e($product_by_cat_id['action_url_grid_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.grid_label')); ?>"><i class="fa fa-th"></i></a> 
              <?php else: ?>  
                <a href="<?php echo e($product_by_cat_id['action_url_grid_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.grid_label')); ?>"><i class="fa fa-th"></i></a> 
              <?php endif; ?>

              <?php if($product_by_cat_id['selected_view'] == 'list'): ?>
                <a class="active" href="<?php echo e($product_by_cat_id['action_url_list_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.list_label')); ?>"><i class="fa fa-th-list"></i></a>
              <?php else: ?>  
                <a href="<?php echo e($product_by_cat_id['action_url_list_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.list_label')); ?>"><i class="fa fa-th-list"></i></a>
              <?php endif; ?>
            </div>
          </div>
          <div class="col-xs-8 col-md-8">
            <div class="sort-filter-options">
              <span><?php echo e(trans('frontend.sort_filter_label')); ?> </span>  
              <select class="form-control select2 sort-by-filter" style="width: 50%;">
                <?php if($product_by_cat_id['sort_by'] == 'all'): ?>  
                <option selected="selected" value="all"><?php echo e(trans('frontend.sort_filter_all_label')); ?></option>
                <?php else: ?>
                <option value="all"><?php echo e(trans('frontend.sort_filter_all_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'alpaz'): ?>  
                <option selected="selected" value="alpaz"><?php echo e(trans('frontend.sort_filter_alpaz_label')); ?></option>
                <?php else: ?>
                <option value="alpaz"><?php echo e(trans('frontend.sort_filter_alpaz_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'alpza'): ?>  
                <option selected="selected" value="alpza"><?php echo e(trans('frontend.sort_filter_alpza_label')); ?></option>
                <?php else: ?>
                <option value="alpza"><?php echo e(trans('frontend.sort_filter_alpza_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'low-high'): ?>  
                <option selected="selected" value="low-high"><?php echo e(trans('frontend.sort_filter_low_high_label')); ?></option>
                <?php else: ?>
                <option value="low-high"><?php echo e(trans('frontend.sort_filter_low_high_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'high-low'): ?>  
                <option selected="selected" value="high-low"><?php echo e(trans('frontend.sort_filter_high_low_label')); ?></option>
                <?php else: ?>
                <option value="high-low"><?php echo e(trans('frontend.sort_filter_high_low_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'old-new'): ?>  
                <option selected="selected" value="old-new"><?php echo e(trans('frontend.sort_filter_old_new_label')); ?></option>
                <?php else: ?>
                <option value="old-new"><?php echo e(trans('frontend.sort_filter_old_new_label')); ?></option>
                <?php endif; ?>

                <?php if($product_by_cat_id['sort_by'] == 'new-old'): ?>
                <option selected="selected" value="new-old"><?php echo e(trans('frontend.sort_filter_new_old_label')); ?></option>
                <?php else: ?>
                <option value="new-old"><?php echo e(trans('frontend.sort_filter_new_old_label')); ?></option>
                <?php endif; ?>
              </select>
            </div>
          </div>  
        </div>        
      </div>
        
      <div class="row">
        <div class="categories-products-list">
          <?php echo $__env->make('pages.frontend.frontend-pages.categories-products', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php echo $__env->yieldContent('categories-products-content'); ?>
        </div>
      </div>  
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.frontend.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>