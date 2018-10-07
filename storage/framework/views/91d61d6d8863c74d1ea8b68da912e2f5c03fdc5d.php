<section class="breadcrumbs">
  <div class="container">
    <ul class="breadcrumb">
      <li><a href="<?php echo e(route('home-page')); ?>"><i class="fa fa-home"></i></a></li>
      <li><?php echo e(trans('frontend.products')); ?></li>
    </ul>
  </div>
</section>

<div class="pageContent">
  <section class="content">
    <div class="container">
      <div class="row">
        <div id="productLeftColumn" class="col-xs-12 col-md-4">
          <div class="left-column-content">
            <div class="product-categories-list">
              <?php echo $__env->make('includes.frontend.categories', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->yieldContent('categories-content'); ?>
            </div>
              
            <?php if(count($popular_tags_list) > 0): ?>
            <div class="tags-product-list">
              <h2><?php echo e(trans('frontend.popular_tags_label')); ?> <span class="responsive-accordian"></span></h2>
              <div class="tag-list">
                <ul>
                  <?php $__currentLoopData = $popular_tags_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('tag-single-page', $tags['slug'])); ?>"><i class="fa fa-angle-right"></i> <?php echo e(ucfirst($tags['name'])); ?></a></li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </div>
            </div>
            <?php endif; ?>
            
            <div class="brands-list">
              <h2><?php echo e(trans('frontend.our_brand_label')); ?> <span class="responsive-accordian"></span></h2>
              <?php if(count($brands_data) > 0): ?>
                <?php $numb = 1; ?>
                <div id="brand-slider-carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <?php $__currentLoopData = $brands_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand_name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($numb == 1): ?>
                        <div class="item active">
                          <div class="col-md-12">
                            <div class="text-center">
                              <?php if(!empty($brand_name['brand_logo_img_url'])): ?>
                              <a href="<?php echo e(route('brands-single-page', $brand_name['slug'])); ?>"><img src="<?php echo e(get_image_url($brand_name['brand_logo_img_url'])); ?>"></a>
                              <?php else: ?>
                              <a href="<?php echo e(route('brands-single-page', $brand_name['slug'])); ?>"><img src="<?php echo e(default_placeholder_img_src()); ?>"></a>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      <?php else: ?>
                        <div class="item">
                          <div class="col-md-12">
                            <div class="text-center">
                              <?php if(!empty($brand_name['brand_logo_img_url'])): ?>
                              <a href="<?php echo e(route('brands-single-page', $brand_name['slug'])); ?>"><img src="<?php echo e(get_image_url($brand_name['brand_logo_img_url'])); ?>"></a>
                              <?php else: ?>
                              <a href="<?php echo e(route('brands-single-page', $brand_name['slug'])); ?>"><img src="<?php echo e(default_placeholder_img_src()); ?>"></a>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>
                      <?php endif; ?>
                      <?php $numb++ ; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                  <div class="slider-control-main text-center">
                    <div class="prev-btn">
                      <a href="#brand-slider-carousel" class="control-carousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                      </a>
                    </div>

                    <div class="next-btn">
                      <a href="#brand-slider-carousel" class="control-carousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                      </a>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
            
            <div class="advertisement">
              <h2><?php echo e(trans('frontend.advertisement_label')); ?> <span class="responsive-accordian"></span></h2>
              <div class="advertisement-content text-center">
                <img class="img-responsive" src="<?php echo e(asset('public/images/add-sample/shipping.jpg')); ?>" alt="">
              </div>
            </div>
            
            <div class="filter-panel">
              <div class="filter-option-title"><?php echo e(trans('frontend.filter_options_label')); ?></div>
              <form action="<?php echo e($all_products_details['action_url']); ?>" method="get">  
                <div class="price-filter">
                  <h2><?php echo e(trans('frontend.price_range_label')); ?> <span class="responsive-accordian"></span></h2>
                  <div class="price-slider-option">
                    <input type="text" class="span2" value="" data-slider-min="<?php echo e(get_appearance_settings()['general']['filter_price_min']); ?>" data-slider-max="<?php echo e(get_appearance_settings()['general']['filter_price_max']); ?>" data-slider-step="5" data-slider-value="[<?php echo e($all_products_details['min_price']); ?>,<?php echo e($all_products_details['max_price']); ?>]" id="price_range" ><br />
                    <b><?php echo price_html(get_appearance_settings()['general']['filter_price_min'], get_frontend_selected_currency()); ?></b> <b class="pull-right"><?php echo price_html(get_appearance_settings()['general']['filter_price_max'], get_frontend_selected_currency()); ?></b>

                    <input name="price_min" id="price_min" value="<?php echo e($all_products_details['min_price']); ?>" type="hidden">
                    <input name="price_max" id="price_max" value="<?php echo e($all_products_details['max_price']); ?>" type="hidden">
                  </div>
                </div>  
                  
                <?php if(count($colors_list_data) > 0): ?>
                <div class="colors-filter">
                  <h2><?php echo e(trans('frontend.choose_color_label')); ?> <span class="responsive-accordian"></span></h2>
                  <div class="colors-filter-option">
                    <?php $__currentLoopData = $colors_list_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $terms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="colors-filter-elements">
                      <div class="chk-filter">
                        <?php if(count($all_products_details['selected_colors']) > 0 && in_array($terms['slug'], $all_products_details['selected_colors'])): ?>  
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
                  <?php if($all_products_details['selected_colors_hf']): ?>
                  <input name="selected_colors" id="selected_colors" value="<?php echo e($all_products_details['selected_colors_hf']); ?>" type="hidden">
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
                        <?php if(count($all_products_details['selected_sizes']) > 0 && in_array($terms['slug'], $all_products_details['selected_sizes'])): ?>  
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
                  <?php if($all_products_details['selected_sizes_hf']): ?>
                  <input name="selected_sizes" id="selected_sizes" value="<?php echo e($all_products_details['selected_sizes_hf']); ?>" type="hidden">
                  <?php endif; ?>
                </div>
                <?php endif; ?>
                
                <div class="btn-filter clearfix">
                  <button class="btn btn-sm" type="submit"><i class="fa fa-filter" aria-hidden="true"></i> <?php echo e(trans('frontend.filter_label')); ?></button>
                  <a class="btn btn-sm" href="<?php echo e(route('shop-page')); ?>"><i class="fa fa-close" aria-hidden="true"></i> <?php echo e(trans('frontend.clear_filter_label')); ?></a>  
                </div>
              </form>
            </div>
          </div>
        </div>
          
        <div id="productCenterColumn" class="col-xs-12 col-md-8">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <div class="advertisement-right">
                <div id="advertisement-right-carousel" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="item active">
                      <div class="text-center">
                        <img src="<?php echo e(asset('public/images/add-sample/girl.jpg')); ?>" alt="" class="img-responsive" />
                      </div>
                    </div>
                    <div class="item">
                      <div class="text-center">
                        <img src="<?php echo e(asset('public/images/add-sample/sunglass.png')); ?>" alt="" class="img-responsive" />
                      </div>
                    </div> 
                    <div class="item">
                      <div class="text-center">
                        <img src="<?php echo e(asset('public/images/add-sample/mobile.png')); ?>" alt="" class="img-responsive" />
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
            <div class="products-list-top clearfix">
              <div class="col-xs-4 col-md-4">
                <div class="product-views pull-left">
                  <?php if($all_products_details['selected_view'] == 'grid'): ?>
                    <a class="active" href="<?php echo e($all_products_details['action_url_grid_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.grid_label')); ?>"><i class="fa fa-th"></i></a> 
                  <?php else: ?>  
                    <a href="<?php echo e($all_products_details['action_url_grid_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.grid_label')); ?>"><i class="fa fa-th"></i></a> 
                  <?php endif; ?>

                  <?php if($all_products_details['selected_view'] == 'list'): ?>
                    <a class="active" href="<?php echo e($all_products_details['action_url_list_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.list_label')); ?>"><i class="fa fa-th-list"></i></a>
                  <?php else: ?>  
                    <a href="<?php echo e($all_products_details['action_url_list_view']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.list_label')); ?>"><i class="fa fa-th-list"></i></a>
                  <?php endif; ?>
                </div>
              </div>
              <div class="col-xs-8 col-md-8">
                <div class="sort-filter-option">
                  <span><?php echo e(trans('frontend.sort_filter_label')); ?> </span>   
                  <select class="form-control select2 sort-by-filter" style="width:50%;">
                    <?php if($all_products_details['sort_by'] == 'all'): ?>  
                    <option selected="selected" value="all"><?php echo e(trans('frontend.sort_filter_all_label')); ?></option>
                    <?php else: ?>
                    <option value="all"><?php echo e(trans('frontend.sort_filter_all_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'alpaz'): ?>  
                    <option selected="selected" value="alpaz"><?php echo e(trans('frontend.sort_filter_alpaz_label')); ?></option>
                    <?php else: ?>
                    <option value="alpaz"><?php echo e(trans('frontend.sort_filter_alpaz_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'alpza'): ?>  
                    <option selected="selected" value="alpza"><?php echo e(trans('frontend.sort_filter_alpza_label')); ?></option>
                    <?php else: ?>
                    <option value="alpza"><?php echo e(trans('frontend.sort_filter_alpza_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'low-high'): ?>  
                    <option selected="selected" value="low-high"><?php echo e(trans('frontend.sort_filter_low_high_label')); ?></option>
                    <?php else: ?>
                    <option value="low-high"><?php echo e(trans('frontend.sort_filter_low_high_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'high-low'): ?>  
                    <option selected="selected" value="high-low"><?php echo e(trans('frontend.sort_filter_high_low_label')); ?></option>
                    <?php else: ?>
                    <option value="high-low"><?php echo e(trans('frontend.sort_filter_high_low_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'old-new'): ?>  
                    <option selected="selected" value="old-new"><?php echo e(trans('frontend.sort_filter_old_new_label')); ?></option>
                    <?php else: ?>
                    <option value="old-new"><?php echo e(trans('frontend.sort_filter_old_new_label')); ?></option>
                    <?php endif; ?>

                    <?php if($all_products_details['sort_by'] == 'new-old'): ?>
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
            <div class="products-list">
              <?php echo $__env->make('includes.frontend.products', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->yieldContent('products-content'); ?>
            </div>
          </div>      
        </div>
      </div>
      <br>
      <div class="row">
        <div class="product-page-bottom">
          <div class="col-xs-12 col-md-6 product-bottom-bg">
            <div class="product-page-best-seller">
              <h2 class="text-center title-under"><?php echo e(trans('frontend.best_seller_label')); ?></h2><br>
              <?php if(count($advancedData['best_sales']) > 0): ?>
              <div id="product-page-best-seller" class="carousel slide" data-ride="carousel">
                <?php $numb =1; $flag =1; $is_last_tag_added_for_best_seller = false;?>
                <div class="carousel-inner">
                  <?php $__currentLoopData = $advancedData['best_sales']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($numb == 1): ?>
                      <?php if($flag == 1): ?>
                        <div class="item active">
                      <?php else: ?>
                        <div class="item">
                      <?php endif; ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row['post_image_url'])): ?>
                          <img src="<?php echo e(get_image_url( $row['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $row['post_image_url'] ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo e($row['post_title']); ?></p>
                          <?php if( $row['post_type'] == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'customizable_product' || $row['post_type'] == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($row['id']))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          <a href="<?php echo e(route('details-page', $row['post_slug'])); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $is_last_tag_added_for_best_seller = false;?>
                    <?php elseif($numb == 2): ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row['post_image_url'])): ?>
                          <img src="<?php echo e(get_image_url( $row['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $row['post_image_url'] ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo e($row['post_title']); ?></p>
                          <?php if( $row['post_type'] == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'customizable_product' || $row['post_type'] == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($row['id']))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          <a href="<?php echo e(route('details-page', $row['post_slug'])); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $numb = 0; $is_last_tag_added_for_best_seller = true;?>
                      </div>
                    <?php else: ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row['post_image_url'])): ?>
                          <img src="<?php echo e(get_image_url( $row['post_image_url'] )); ?>" alt="<?php echo e(basename( get_image_url( $row['post_image_url'] ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo e($row['post_title']); ?></p>
                          <?php if( $row['post_type'] == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                          <?php elseif( $row['post_type'] == 'customizable_product' || $row['post_type'] == 'downloadable_product'): ?>
                            <?php if(count(get_product_variations($row['id']))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row['id']); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row['post_price'], get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          <a href="<?php echo e(route('details-page', $row['post_slug'])); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $is_last_tag_added_for_best_seller = false;?>
                    <?php endif; ?>

                    <?php 
                     $numb++;
                     $flag++;
                    ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  <?php if(!$is_last_tag_added_for_best_seller): ?>
                     </div>
                  <?php endif; ?> 
                </div>
                <div class="slider-control-main text-center">
                  <div class="prev-btn">
                    <a href="#product-page-best-seller" class="control-carousel" data-slide="prev">
                      <i class="fa fa-angle-left"></i>
                    </a>
                  </div>

                  <div class="next-btn">
                    <a href="#product-page-best-seller" class="control-carousel" data-slide="next">
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <?php else: ?>
                <p class="not-available"><?php echo trans('frontend.best_sales_products_empty_label'); ?></p>
              <?php endif; ?>
            </div>
          </div>  
          
          <div class="col-xs-12 col-md-6 product-bottom-bg">
            <div class="product-page-latest">
              <h2 class="text-center title-under"><?php echo e(trans('frontend.new_arrival_label')); ?></h2><br>
              <?php if(count($advancedData['latest_items']) > 0): ?>
              <div id="product-page-new-arrival" class="carousel slide" data-ride="carousel">
                <?php $numb =1; $flag =1; $is_last_tag_added_for_latest = false;?>
                <div class="carousel-inner">
                  <?php $__currentLoopData = $advancedData['latest_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($numb == 1): ?>
                      <?php if($flag == 1): ?>
                        <div class="item active">
                      <?php else: ?>
                        <div class="item">
                      <?php endif; ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row->image_url)): ?>
                          <img src="<?php echo e(get_image_url( $row->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $row->image_url ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo $row->title; ?></p>
                          <?php if( $row->type == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row->type == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                          <?php elseif( $row->type == 'customizable_product' || $row->type == 'downloadable_product' ): ?>
                            <?php if(count(get_product_variations($row->id))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          <a href="<?php echo e(route('details-page', $row->slug)); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $is_last_tag_added_for_latest = false;?>
                    <?php elseif($numb == 2): ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row->image_url)): ?>
                          <img src="<?php echo e(get_image_url( $row->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $row->image_url ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo $row->title; ?></p>
                          <?php if( $row->type == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row->type == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                          <?php elseif( $row->type == 'customizable_product' || $row->type == 'downloadable_product' ): ?>
                            <?php if(count(get_product_variations($row->id))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          
                          <a href="<?php echo e(route('details-page', $row->slug)); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $numb = 0; $is_last_tag_added_for_latest = true;?>
                      </div>
                    <?php else: ?>
                      <div class="product-content">
                        <div class="image-content text-center">
                          <?php if(!empty($row->image_url)): ?>
                          <img src="<?php echo e(get_image_url( $row->image_url )); ?>" alt="<?php echo e(basename( get_image_url( $row->image_url ) )); ?>" />
                          <?php else: ?>
                          <img src="<?php echo e(default_placeholder_img_src()); ?>" alt="" />
                          <?php endif; ?>
                        </div>
                        <div class="product-details">
                          <p><?php echo $row->title; ?></p>
                          <?php if( $row->type == 'simple_product' ): ?>
                            <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                          <?php elseif( $row->type == 'configurable_product' ): ?>
                            <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                          <?php elseif( $row->type == 'customizable_product' || $row->type == 'downloadable_product' ): ?>
                            <?php if(count(get_product_variations($row->id))>0): ?>
                              <p><strong><?php echo get_product_variations_min_to_max_price_html(get_frontend_selected_currency(), $row->id); ?></strong></p>
                            <?php else: ?>
                              <p><strong><?php echo price_html( $row->price, get_frontend_selected_currency() ); ?></strong></p>
                            <?php endif; ?>
                          <?php endif; ?>
                          
                          <a href="<?php echo e(route('details-page', $row->slug)); ?>" class="btn btn-sm btn-style"><?php echo trans('frontend.read_more_label'); ?></a>
                        </div>
                      </div>
                      <?php $is_last_tag_added_for_latest = false;?>
                    <?php endif; ?>

                    <?php 
                     $numb++;
                     $flag++;
                    ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                  <?php if(!$is_last_tag_added_for_latest): ?>
                     </div>
                  <?php endif; ?> 
                </div>
                <div class="slider-control-main text-center">
                  <div class="prev-btn">
                    <a href="#product-page-new-arrival" class="control-carousel" data-slide="prev">
                      <i class="fa fa-angle-left"></i>
                    </a>
                  </div>

                  <div class="next-btn">
                    <a href="#product-page-new-arrival" class="control-carousel" data-slide="next">
                      <i class="fa fa-angle-right"></i>
                    </a>
                  </div>
                </div>
              </div>
              <?php else: ?>
                <p class="not-available"><?php echo trans('frontend.latest_products_empty_label'); ?></p>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>