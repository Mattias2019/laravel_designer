<?php echo $__env->make('includes.frontend.header-content-custom-css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<div id="header_content" class="header-before-slider header-background">
  <div class="top-header">
    <div class="container">
      <div class="row">
        <div class="col-xs-5 col-sm-6 col-md-6 col-lg-6">
          <div class="dropdown change-multi-currency">
            <?php if(get_frontend_selected_currency()): ?>
            <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
              <span class="hidden-xs"><?php echo get_currency_name_by_code( get_frontend_selected_currency() ); ?></span>
              <span class="hidden-sm hidden-md hidden-lg fa fa-money fa-lg"></span> 
              <?php if(count(get_frontend_selected_currency_data()) >0): ?>
              <span class="caret"></span>
              <?php endif; ?>
            </a>
            <?php endif; ?>
            <div class="dropdown-content">
              <?php if(count(get_frontend_selected_currency_data()) >0): ?>
                <?php $__currentLoopData = get_frontend_selected_currency_data(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="#" data-currency_name="<?php echo e($val); ?>"><?php echo get_currency_name_by_code( $val ); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </div>
          </div>
          <div class="dropdown language-list">
            <?php if(count(get_frontend_selected_languages_data()) > 0): ?>
              <?php if(get_frontend_selected_languages_data()['lang_code'] == 'en'): ?>
                <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
                  <img src="<?php echo e(asset('public/images/'. get_frontend_selected_languages_data()['lang_sample_img'])); ?>" alt="lang"> <span class="hidden-xs"> &nbsp; <?php echo get_frontend_selected_languages_data()['lang_name']; ?></span> <span class="caret"></span></a>
              <?php else: ?>
                <a class="dropdown-toggle" href="#" data-hover="dropdown" data-toggle="dropdown">
                  <img src="<?php echo e(get_image_url(get_frontend_selected_languages_data()['lang_sample_img'])); ?>" alt="lang"> <span class="hidden-xs"> &nbsp; <?php echo get_frontend_selected_languages_data()['lang_name']; ?></span> <span class="caret"></span></a>
              <?php endif; ?>
            <?php endif; ?>
            
            <?php if(count(get_available_languages_data_frontend()) > 0): ?>
              <div class="dropdown-content">
                <?php $__currentLoopData = get_available_languages_data_frontend(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($val['lang_code'] == 'en'): ?>
                    <a href="#" data-lang_name="<?php echo e($val['lang_code']); ?>"><img src="<?php echo e(asset('public/images/'. $val['lang_sample_img'])); ?>" alt="lang"> &nbsp;<?php echo ucwords($val['lang_name']); ?></a>
                  <?php else: ?>
                    <a href="#" data-lang_name="<?php echo e($val['lang_code']); ?>"><img src="<?php echo e(get_image_url($val['lang_sample_img'])); ?>" alt="lang"> &nbsp;<?php echo ucwords($val['lang_name']); ?></a>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            <?php endif; ?>
          </div>     
        </div>
      
        <div class="col-xs-7 col-sm-6 col-md-6 col-lg-6">
          <div class="clearfix">
            <div class="pull-right">
              <ul class="right-menu top-right-menu">
                <li class="wishlist-content">
                  <a class="main" href="<?php echo e(route('my-saved-items-page')); ?>">
                    <i class="fa fa-heart"></i> 
                    <span class="hidden-xs"><?php echo trans('frontend.frontend_wishlist'); ?></span> 
                  </a>    
                </li> 
                
                <li class="users-vendors-login"><a href="#" class="main selected dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"><i class="fa fa-user" aria-hidden="true"></i> <span class="hidden-xs"><?php echo trans('frontend.menu_my_account'); ?></span><span class="caret"></span></a>
                  <ul class="dropdown-menu">
                    <?php if(Session::has('shopist_frontend_user_id')): ?>
                    <li><a href="<?php echo e(route('user-account-page')); ?>"><?php echo trans('frontend.user_account_label'); ?></a></li>
                    <?php else: ?>
                    <li><a href="<?php echo e(route('user-login-page')); ?>"><?php echo trans('frontend.frontend_user_login'); ?></a></li>
                    <?php endif; ?>
                    
                    <?php if(Session::has('shopist_admin_user_id') && !empty(get_current_vendor_user_info()['user_role_slug']) && get_current_vendor_user_info()['user_role_slug'] == 'vendor'): ?>
                     <li><a target="_blank" href="<?php echo e(route('admin.dashboard')); ?>"><?php echo trans('frontend.vendor_account_label'); ?></a></li>
                    <?php else: ?>
                     <li><a target="_blank" href="<?php echo e(route('admin.login')); ?>"><?php echo trans('frontend.frontend_vendor_login'); ?></a></li>
                    <?php endif; ?>
                    
                    <li><a href="<?php echo e(route('vendor-registration-page')); ?>"><?php echo trans('frontend.vendor_registration'); ?></a></li>
                  </ul>
                </li>
                
                <li class="mini-cart-content">
                    <?php echo $__env->make('pages.ajax-pages.mini-cart-html', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </li>
              </ul>
            </div>  
          </div>
        </div> 
      </div>         
    </div>      
  </div>  
   
  <div class="container">  
    <div class="row">
      <div class="search-content">
        <div class="col-xs-12 col-sm-0 col-md-3 col-lg-3">
          <?php if(get_site_logo_image()): ?>
            <div class="logo hidden-xs hidden-sm"><img src="<?php echo e(get_site_logo_image()); ?>" title="<?php echo e(trans('frontend.your_store_label')); ?>" alt="<?php echo e(trans('frontend.your_store_label')); ?>"></div>
          <?php endif; ?>
        </div> 

        <div class="col-xs-8 col-sm-10 col-md-6 col-lg-6">
          <form id="search_option" action="<?php echo e(route('shop-page')); ?>" method="get">
            <div class="input-group">
              <input type="text" id="srch_term" name="srch_term" class="form-control" placeholder="<?php echo e(trans('frontend.search_for_label')); ?>">
              <span class="input-group-btn">
                <button id="btn-search" type="submit" class="btn btn-default">
                  <span class="glyphicon glyphicon-search"></span>
                </button>
              </span>
            </div>
          </form>
        </div> 

        <div class="col-xs-4 col-sm-2 col-md-3 col-lg-3 text-right"> 
          <a href="<?php echo e(route('product-comparison-page')); ?>" class="btn btn-default btn-compare"><i class="fa fa-exchange"></i> <span class="hidden-xs hidden-sm"> &nbsp; <?php echo trans('frontend.compare_label'); ?></span> <span class="compare-value"> (<?php echo $total_compare_item;?>)</span></a>
        </div>  
      </div>
    </div>    
  </div>    
   
  <div class="container"> 
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <nav class="navbar navbar-default" role="navigation">
          <div class="navbar-header">
            <button type="button" class="btn navbar-toggle collapsed" 
               data-toggle="collapse" data-target="#header-navbar-collapse">
               <span class="sr-only">Toggle navigation</span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <img class="navbar-brand visible-xs visible-sm" src="<?php echo e(get_site_logo_image()); ?>" alt="<?php echo e(trans('frontend.your_store_label')); ?>">  
          </div>
          <div class="collapse navbar-collapse" id="header-navbar-collapse">
            <ul class="all-menu nav navbar-nav">
              <?php if(Request::is('/')): ?>
                <li class="first"><a href="<?php echo e(route('home-page')); ?>" class="main selected menu-name"><?php echo trans('frontend.home'); ?></a></li>
              <?php else: ?>
                <li class="first"><a href="<?php echo e(route('home-page')); ?>" class="main menu-name"><?php echo trans('frontend.home'); ?></a></li>
              <?php endif; ?>

              <li class="dropdown mega-dropdown">
                <a href="#" class="dropdown-toggle menu-name" data-toggle="dropdown"><?php echo trans('frontend.shop_by_cat_label'); ?>  <span class="caret"></span></a>
                <ul class="dropdown-menu mega-dropdown-menu mega-menu-cat row clearfix">
                  <?php if(count($productCategoriesTree) > 0): ?>
                    <?php $i = 1; $j = 0;?>
                    <?php $__currentLoopData = $productCategoriesTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if($i == 1): ?>
                      <?php $j++; ?>
                      <li class="col-xs-12 col-sm-4">  
                      <?php endif; ?>

                      <ul>
                        <?php if(isset($cat['parent']) && $cat['parent'] == 'Parent Category'): ?>  
                        <li class="dropdown-header">
                            <?php if( !empty($cat['img_url']) ): ?>
                            <img src="<?php echo e(get_image_url($cat['img_url'])); ?>"> 
                            <?php else: ?>
                            <img src="<?php echo e(default_placeholder_img_src()); ?>"> 
                            <?php endif; ?>
                            
                            <?php echo $cat['name']; ?>

                        </li>
                        <?php endif; ?>
                        <?php if(isset($cat['children']) && count($cat['children']) > 0): ?>
                          <?php $__currentLoopData = $cat['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat_sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="product-sub-cat"><a href="<?php echo e(route('categories-page', $cat_sub['slug'])); ?>"><?php echo $cat_sub['name']; ?></a></li>
                            <?php if(isset($cat_sub['children']) && count($cat_sub['children']) > 0): ?>
                              <?php echo $__env->make('pages.common.category-frontend-loop-home', $cat_sub, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      </ul>

                      <?php if($i == 1): ?>
                      </li>
                      <?php $i = 0;?>
                      <?php endif; ?>

                      <?php if($j == 3 || $j == 4): ?>
                      <div class="clear-both"></div>
                      <?php $j = 0; ?>
                      <?php endif; ?>

                      <?php $i ++;?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?>
                </ul>
              </li>

              <?php if(Request::is('shop')): ?>
                <li><a href="<?php echo e(route('shop-page')); ?>" class="main selected menu-name"><?php echo trans('frontend.all_products_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('shop-page')); ?>" class="main menu-name"><?php echo trans('frontend.all_products_label'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('checkout')): ?>
                <li><a href="<?php echo e(route('checkout-page')); ?>" class="main selected menu-name"><?php echo trans('frontend.checkout'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('checkout-page')); ?>" class="main menu-name"><?php echo trans('frontend.checkout'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('cart')): ?>
                <li><a href="<?php echo e(route('cart-page')); ?>" class="main selected menu-name"><?php echo trans('frontend.cart'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('cart-page')); ?>" class="main menu-name"><?php echo trans('frontend.cart'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('blogs')): ?>
                <li><a href="<?php echo e(route('blogs-page-content')); ?>" class="main selected menu-name"><?php echo trans('frontend.blog'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('blogs-page-content')); ?>" class="main menu-name"><?php echo trans('frontend.blog'); ?></a></li>
              <?php endif; ?>

              <?php if(count($pages_list) > 0): ?>
              <li>
                <div class="dropdown custom-page">
                  <a class="dropdown-toggle menu-name" href="#" data-hover="dropdown" data-toggle="dropdown"> <?php echo trans('frontend.pages_label'); ?> 
                    <span class="caret"></span>
                  </a>
                  <ul class="dropdown-menu">
                    <?php $__currentLoopData = $pages_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li> <a href="<?php echo e(route('custom-page-content', $pages['post_slug'])); ?>"><?php echo $pages['post_title']; ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                </div>
              </li>
              <?php endif; ?>
              
              <?php if(Request::is('stores')): ?>
                <li><a href="<?php echo e(route('store-list-page-content')); ?>" class="main selected menu-name"><?php echo trans('frontend.vendor_account_store_list_title_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('store-list-page-content')); ?>" class="main menu-name"><?php echo trans('frontend.vendor_account_store_list_title_label'); ?></a></li>
              <?php endif; ?>
              
            </ul>
          </div>
        </nav>
      </div>
    </div> 
  </div>    
</div>

<?php if($appearance_all_data['header_details']['slider_visibility'] == true && Request::is('/')): ?>
  <?php $count = count(get_appearance_header_settings_data());?>
  <?php if($count > 0): ?>
  <div class="header-with-slider">
    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <?php for($i = 0; $i < $count; $i++): ?>
          <?php if($i== 0): ?>
            <li data-target="#slider-carousel" data-slide-to="<?php echo e($i); ?>" class="active"></li>
          <?php else: ?>
            <li data-target="#slider-carousel" data-slide-to="<?php echo e($i); ?>"></li>
          <?php endif; ?>
        <?php endfor; ?>                           
      </ol>

      <?php $numb = 1; ?>
      <div class="carousel-inner">
        <?php $__currentLoopData = get_appearance_header_settings_data(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php if($numb == 1): ?>
            <div class="item active">
              <?php if($img->img_url): ?>
                <img src="<?php echo e(get_image_url($img->img_url)); ?>" class="girl img-responsive" alt="" />
              <?php endif; ?>

              <?php if(isset($img->text)){?>
                <div class="dynamic-text-on-image-container"><?php echo $img->text; ?></div>
              <?php }?>
            </div>
          <?php else: ?>
            <div class="item">
              <?php if($img->img_url): ?>
                <img src="<?php echo e(get_image_url($img->img_url)); ?>" class="girl img-responsive" alt="" />
              <?php endif; ?>

              <?php if(isset($img->text)){?>
                <div class="dynamic-text-on-image-container"><?php echo $img->text; ?></div>
              <?php }?>
            </div>
          <?php endif; ?>
          <?php $numb++ ; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  </div>
  <?php else: ?>
  <div class="header-with-slider">
    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="<?php echo e(asset('public/images/sunglass.jpg')); ?>" class="girl img-responsive" alt="" />
        </div>
      </div>
    </div>
  </div>
  <?php endif; ?>
<?php endif; ?>