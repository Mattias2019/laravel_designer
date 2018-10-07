<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu"> 
      <?php if(Request::is('admin/dashboard')): ?>
        <li class="active">
          <a href="<?php echo e(route('admin.dashboard')); ?>" class="active">
            <i class="fa fa-dashboard"></i> <span><?php echo trans('admin.dashboard'); ?></span>
          </a>
        </li>
      <?php else: ?>
        <li>
          <a href="<?php echo e(route('admin.dashboard')); ?>">
            <i class="fa fa-dashboard"></i> <span><?php echo trans('admin.dashboard'); ?></span>
          </a>
        </li>
      <?php endif; ?>
      
      <?php if(check_permission_menu_heading('cms')): ?>
      <li class="sidebar-cms-title"><?php echo trans('admin.sidebar_cms_title'); ?></li>
      <?php endif; ?>
      
      <?php if(Request::is('admin/pages/list') || Request::is('admin/page/add') || Request::is('admin/page/update/*')): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-file"></i> <span><?php echo trans('admin.page_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('pages_list_access', $user_permission_list)): ?>   
              <?php if(Request::is('admin/pages/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.all_pages')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_pages_list'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.all_pages')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_pages_list'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('add_edit_delete_pages', $user_permission_list)): ?>
              <?php if(Request::is('admin/page/add') || Request::is('admin/page/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_page')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_page'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.add_page')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_page'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </li>
      <?php else: ?>
        <?php if((in_array('pages_list_access', $user_permission_list)) || (in_array('add_edit_delete_pages', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file"></i> <span><?php echo trans('admin.page_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('pages_list_access', $user_permission_list)): ?>  
              <li><a href="<?php echo e(route('admin.all_pages')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_pages_list'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('add_edit_delete_pages', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.add_page')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_page'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      <?php if(Request::is('admin/blog/list') || Request::is('admin/blog/add') || Request::is('admin/blog/comments-list') || Request::is('admin/blog/update/*') || Request::is('admin/blog/categories/list')): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-commenting"></i> <span><?php echo trans('admin.blog_manager'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <?php if(in_array('list_blogs_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/blog/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.all_blogs')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.all_blogs')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('add_edit_delete_blog', $user_permission_list)): ?>
              <?php if(Request::is('admin/blog/add') || Request::is('admin/blog/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_blog')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.add_blog')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('blog_categories_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/blog/categories/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.blog_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.blog_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('blog_comments_list', $user_permission_list)): ?>
              <?php if(Request::is('admin/blog/comments-list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.all_blog_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.all_blog_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </li>
      <?php else: ?>
        <?php if((in_array('list_blogs_access', $user_permission_list)) || (in_array('add_edit_delete_blog', $user_permission_list)) || (in_array('blog_categories_access', $user_permission_list)) || (in_array('blog_comments_list', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa fa-commenting"></i> <span><?php echo trans('admin.blog_manager'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('list_blogs_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.all_blogs')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('add_edit_delete_blog', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.add_blog')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('blog_categories_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.blog_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('blog_comments_list', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.all_blog_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      <?php if(Request::is('admin/testimonial/add') || Request::is('admin/testimonial/list') || Request::is('admin/testimonial/update/*') ): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-thumbs-o-up"></i> <span><?php echo trans('admin.testimonial_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('testimonial_list_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/testimonial/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.testimonial_post_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.testimonial_post_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('add_edit_delete_testimonial', $user_permission_list)): ?>
              <?php if(Request::is('admin/testimonial/add') || Request::is('admin/testimonial/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.testimonial_post_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.testimonial_post_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </li>
      <?php else: ?>
        <?php if((in_array('testimonial_list_access', $user_permission_list)) || (in_array('add_edit_delete_testimonial', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-thumbs-o-up"></i> <span><?php echo trans('admin.testimonial_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('testimonial_list_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.testimonial_post_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.posts_list'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('add_edit_delete_testimonial', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.testimonial_post_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_new_post'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      <?php if(Request::is('admin/manufacturers/list') || Request::is('admin/manufacturers/add') || Request::is('admin/manufacturers/update/*')): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-apple"></i> <span><?php echo trans('admin.manufacturers'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('brands_list_access', $user_permission_list)): ?>  
              <?php if(Request::is('admin/manufacturers/list')): ?>  
                <li class="active"><a href="<?php echo e(route('admin.manufacturers_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_manufacturers'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.manufacturers_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_manufacturers'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('add_edit_delete_brands', $user_permission_list)): ?>  
              <?php if(Request::is('admin/manufacturers/add') || Request::is('admin/manufacturers/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_manufacturers_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_manufacturer'); ?></a></li>
              <?php else: ?>
                 <li><a href="<?php echo e(route('admin.add_manufacturers_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_manufacturer'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </li>
      <?php else: ?>
        <?php if((in_array('brands_list_access', $user_permission_list)) || (in_array('add_edit_delete_brands', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-apple"></i> <span><?php echo trans('admin.manufacturers'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('brands_list_access', $user_permission_list)): ?>  
                <li><a href="<?php echo e(route('admin.manufacturers_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_manufacturers'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('add_edit_delete_brands', $user_permission_list)): ?> 
                <li><a href="<?php echo e(route('admin.add_manufacturers_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_manufacturer'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      <?php if(in_array('manage_seo_full', $user_permission_list)): ?>
        <?php if(Request::is('admin/manage/seo')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.manage_seo_content')); ?>" class="active">
              <i class="fa fa-search-plus"></i> <span><?php echo trans('admin.seo_label'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.manage_seo_content')); ?>">
              <i class="fa fa-search-plus"></i> <span><?php echo trans('admin.seo_label'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(check_permission_menu_heading('sales')): ?>
      <li class="sidebar-cms-title"><?php echo trans('admin.sidebar_sales_channel_title'); ?></li>
      <?php endif; ?>
        
      <?php if(Request::is('admin/product/list/*') || Request::is('admin/product/add') || Request::is('admin/product/update/*') || Request::is('admin/product/categories/list') || Request::is('admin/product/tags/list') || Request::is('admin/product/attributes/list') || Request::is('admin/product/colors/list') || Request::is('admin/product/sizes/list') || Request::is('admin/product/comments-list')): ?>
       <li class="active treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i> <span><?php echo trans('admin.products'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">

            <?php if(in_array('products_list_access', $user_permission_list)): ?>  
              <?php if(Request::is('admin/product/list/*')): ?>  
                <li class="active"><a href="<?php echo e(route('admin.product_list', $product_parm)); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_products'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_list', $product_parm)); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_products'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('add_edit_delete_product', $user_permission_list)): ?> 
              <?php if(Request::is('admin/product/add') || Request::is('admin/product/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_product')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_product'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.add_product')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_product'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('product_categories_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/categories/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.product_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('product_tags_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/tags/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.product_tags_list')); ?>"><i class="fa fa-tags"></i> <?php echo trans('admin.tags'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_tags_list')); ?>"><i class="fa fa-tags"></i> <?php echo trans('admin.tags'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('product_attributes_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/attributes/list') || Request::is('admin/product/attribute/add') || Request::is('admin/product/attribute/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.product_attributes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.attributes'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_attributes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.attributes'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('product_colors_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/colors/list') || Request::is('admin/product/colors/add') || Request::is('admin/product/colors/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.product_colors_list')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.colors_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_colors_list')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.colors_label'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('product_sizes_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/sizes/list') || Request::is('admin/product/sizes/add') || Request::is('admin/product/sizes/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.product_sizes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.sizes_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.product_sizes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.sizes_label'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('products_comments_list_access', $user_permission_list)): ?>
              <?php if(Request::is('admin/product/comments-list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.all_products_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>  
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.all_products_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>  
              <?php endif; ?>
            <?php endif; ?>
          </ul>
      </li>
      <?php else: ?>
        <?php if((in_array('products_list_access', $user_permission_list)) || (in_array('add_edit_delete_product', $user_permission_list)) || (in_array('product_categories_access', $user_permission_list)) || (in_array('product_tags_access', $user_permission_list)) || (in_array('product_attributes_access', $user_permission_list)) || (in_array('product_colors_access', $user_permission_list)) || (in_array('product_sizes_access', $user_permission_list)) || (in_array('products_comments_list_access', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-shopping-cart"></i> <span><?php echo trans('admin.products'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('products_list_access', $user_permission_list)): ?>  
                <li><a href="<?php echo e(route('admin.product_list', $product_parm)); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.all_products'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('add_edit_delete_product', $user_permission_list)): ?> 
                <li><a href="<?php echo e(route('admin.add_product')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.add_product'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('product_categories_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.product_categories_list')); ?>"><i class="fa fa-camera"></i> <?php echo trans('admin.categories'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('product_tags_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.product_tags_list')); ?>"><i class="fa fa-tags"></i> <?php echo trans('admin.tags'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('product_attributes_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.product_attributes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.attributes'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('product_colors_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.product_colors_list')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.colors_label'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('product_sizes_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.product_sizes_list')); ?>"><i class="fa fa-th-large"></i> <?php echo trans('admin.sizes_label'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('products_comments_list_access', $user_permission_list)): ?>
                <li><a href="<?php echo e(route('admin.all_products_comments')); ?>"><i class="fa fa-comment"></i> <?php echo trans('admin.blog_comments_list'); ?></a></li>  
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      
      <?php if(in_array('manage_orders_list', $user_permission_list)): ?>
        <?php if(Request::is('admin/orders') || Request::is('admin/orders/details/*') || Request::is('admin/orders/current-date')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.shop_orders_list')); ?>">
              <i class="fa fa-file-text-o"></i> <span><?php echo trans('admin.orders'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.shop_orders_list')); ?>">
              <i class="fa fa-file-text-o"></i> <span><?php echo trans('admin.orders'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(in_array('manage_reports_list', $user_permission_list)): ?>
        <?php if(Request::is('admin/reports') || Request::is('admin/reports/sales-by-product-title') || Request::is('admin/reports/sales-by-month') || Request::is('admin/reports/sales-by-last-7-days') || Request::is('admin/reports/sales-by-custom-days') || Request::is('admin/reports/sales-by-payment-method')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.reports_list')); ?>">
              <i class="fa fa-bar-chart"></i> <span><?php echo trans('admin.reports'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.reports_list')); ?>">
              <i class="fa fa-bar-chart"></i> <span><?php echo trans('admin.reports'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>  
      
      <?php if(check_permission_menu_heading('vendors') && !is_vendor_login()): ?>
      <li class="sidebar-vendor-title"><?php echo trans('admin.sidebar_vendor_title'); ?></li>
      <?php endif; ?>
      
      <?php if(!is_vendor_login()): ?>
        <?php if(Request::is('admin/vendors/list') || Request::is('admin/vendors/list/active') || Request::is('admin/vendors/list/pending') || Request::is('admin/vendors/comments-list') || Request::is('admin/vendors/withdraw') || Request::is('admin/vendors/refund') || Request::is('admin/vendors/earning-reports') || Request::is('admin/vendors/earning-reports/*') || Request::is('admin/vendors/announcement') || Request::is('admin/vendors/announcement/*') || Request::is('admin/vendors/announcement/list') || Request::is('admin/status/vendors/withdraw/*') || Request::is('admin/vendors/settings')): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-handshake-o"></i> <span><?php echo trans('admin.admin_menu_vendors_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(in_array('vendors_list_access', $user_permission_list)): ?>  
              <?php if(Request::is('admin/vendors/list') || Request::is('admin/vendors/list/active') || Request::is('admin/vendors/list/pending')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.vendors_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_vendors_list_label'); ?></a></li>
              <?php else: ?>
              <li><a href="<?php echo e(route('admin.vendors_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_vendors_list_label'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('vendors_withdraw_access', $user_permission_list)): ?>  
              <?php if(Request::is('admin/vendors/withdraw') || Request::is('admin/status/vendors/withdraw/*')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.withdraws_content')); ?>"><i class="fa fa-money"></i> <?php echo trans('admin.sidebar_withdraw_title'); ?></a></li>
              <?php else: ?>
              <li><a href="<?php echo e(route('admin.withdraws_content')); ?>"><i class="fa fa-money"></i> <?php echo trans('admin.sidebar_withdraw_title'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('vendors_earning_reports_access', $user_permission_list)): ?>   
              <?php if(Request::is('admin/vendors/earning-reports') || Request::is('admin/vendors/earning-reports/*')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.earning_reports_content')); ?>"><i class="fa fa-line-chart"></i> <?php echo trans('admin.sidebar_earning_title'); ?></a></li>
              <?php else: ?>
              <li><a href="<?php echo e(route('admin.earning_reports_content')); ?>"><i class="fa fa-line-chart"></i> <?php echo trans('admin.sidebar_earning_title'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('vendors_announcement_access', $user_permission_list)): ?> 
              <?php if(Request::is('admin/vendors/announcement') || Request::is('admin/vendors/announcement/*') || Request::is('admin/vendors/announcement/list')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.announcement_list_content')); ?>"><i class="fa fa-bullhorn"></i> <?php echo trans('admin.sidebar_announcement_title'); ?></a></li>
              <?php else: ?>
              <li><a href="<?php echo e(route('admin.announcement_list_content')); ?>"><i class="fa fa-bullhorn"></i> <?php echo trans('admin.sidebar_announcement_title'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>

            <?php if(in_array('vendor_settings', $user_permission_list)): ?> 
              <?php if(Request::is('admin/vendors/settings')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.vendor_settings_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.settings'); ?></a></li>
              <?php else: ?>
              <li><a href="<?php echo e(route('admin.vendor_settings_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.settings'); ?></a></li>
              <?php endif; ?>
            <?php endif; ?>
          </ul>
        </li>
        <?php else: ?>
          <?php if((in_array('vendors_list_access', $user_permission_list)) || (in_array('vendors_withdraw_access', $user_permission_list)) || (in_array('vendors_earning_reports_access', $user_permission_list)) || (in_array('vendors_announcement_access', $user_permission_list)) || (in_array('vendor_settings', $user_permission_list))): ?>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-handshake-o"></i> <span><?php echo trans('admin.admin_menu_vendors_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <?php if(in_array('vendors_list_access', $user_permission_list)): ?>  
                <li><a href="<?php echo e(route('admin.vendors_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_vendors_list_label'); ?></a></li>
                <?php endif; ?>

                <?php if(in_array('vendors_withdraw_access', $user_permission_list)): ?>  
                <li><a href="<?php echo e(route('admin.withdraws_content')); ?>"><i class="fa fa-money"></i> <?php echo trans('admin.sidebar_withdraw_title'); ?></a></li>
                <?php endif; ?>

                <?php if(in_array('vendors_earning_reports_access', $user_permission_list)): ?>   
                <li><a href="<?php echo e(route('admin.earning_reports_content')); ?>"><i class="fa fa-line-chart"></i> <?php echo trans('admin.sidebar_earning_title'); ?></a></li>  
                <?php endif; ?>

                <?php if(in_array('vendors_announcement_access', $user_permission_list)): ?> 
                <li><a href="<?php echo e(route('admin.announcement_list_content')); ?>"><i class="fa fa-bullhorn"></i> <?php echo trans('admin.sidebar_announcement_title'); ?></a></li>  
                <?php endif; ?>

                <?php if(in_array('vendor_settings', $user_permission_list)): ?> 
                <li><a href="<?php echo e(route('admin.vendor_settings_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.settings'); ?></a></li>  
                <?php endif; ?>
              </ul>
            </li>
          <?php endif; ?>  
        <?php endif; ?>
      <?php endif; ?>  
      
      <?php if(Request::is('admin/vendors/package/create') || Request::is('admin/vendors/package/list') || Request::is('admin/vendors/package/update/*')): ?>
      <li class="active treeview">
        <a href="#">
          <i class="fa fa-gift"></i> <span><?php echo trans('admin.vendors_package_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <?php if(in_array('vendors_packages_list_access', $user_permission_list)): ?>   
            <?php if(Request::is('admin/vendors/package/list')): ?>  
            <li class="active"><a href="<?php echo e(route('admin.vendors_packages_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.vendors_package_list_label'); ?></a></li>
            <?php else: ?>
            <li><a href="<?php echo e(route('admin.vendors_packages_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.vendors_package_list_label'); ?></a></li>
            <?php endif; ?>
          <?php endif; ?>

          <?php if(in_array('vendors_packages_create_access', $user_permission_list)): ?>   
            <?php if(Request::is('admin/vendors/package/create') || Request::is('admin/vendors/package/update/*')): ?>  
            <li class="active"><a href="<?php echo e(route('admin.vendors_packages_create_content')); ?>"><i class="fa fa-plus"></i> <?php echo trans('admin.create_vendors_package_label'); ?></a></li>
            <?php else: ?>
            <li><a href="<?php echo e(route('admin.vendors_packages_create_content')); ?>"><i class="fa fa-plus"></i> <?php echo trans('admin.create_vendors_package_label'); ?></a></li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
      </li>
      <?php else: ?>
        <?php if((in_array('vendors_packages_list_access', $user_permission_list)) || (in_array('vendors_packages_create_access', $user_permission_list))): ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-gift"></i> <span><?php echo trans('admin.vendors_package_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(in_array('vendors_packages_list_access', $user_permission_list)): ?>  
                <li><a href="<?php echo e(route('admin.vendors_packages_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.vendors_package_list_label'); ?></a></li>
              <?php endif; ?>

              <?php if(in_array('vendors_packages_create_access', $user_permission_list)): ?>   
                <li><a href="<?php echo e(route('admin.vendors_packages_create_content')); ?>"><i class="fa fa-plus"></i> <?php echo trans('admin.create_vendors_package_label'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php endif; ?>  
      <?php endif; ?>
      
      <?php if(isset($user_data['user_role_slug']) && $user_data['user_role_slug'] == 'administrator'): ?>
      <li class="sidebar-manage-user-title"><?php echo trans('admin.sidebar_manage_users_title'); ?></li>
      <?php endif; ?>
      
       <?php if(isset($user_data['user_role_slug']) && $user_data['user_role_slug'] == 'administrator'): ?>
        <?php if(Request::is('admin/users/roles/list') || Request::is('admin/users/roles/add') || Request::is('admin/users/roles/update/*') || Request::is('admin/users/list') || Request::is('admin/user/add') || Request::is('admin/user/update/*') || Request::is('admin/user/profile')): ?>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-user"></i> <span><?php echo trans('admin.admin_menu_users_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/users/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.users_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_1'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.users_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_1'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/users/roles/list')): ?>
                <li class="active"><a href="<?php echo e(route('admin.users_roles_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_4'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.users_roles_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_4'); ?></a></li>
              <?php endif; ?>

              <?php if( Request::is('admin/users/roles/add') || Request::is('admin/users/roles/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_roles')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_2'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.add_roles')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_2'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/user/add') || Request::is('admin/user/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.add_new_user')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_3'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.add_new_user')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_3'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/user/profile')): ?>
                <li class="active"><a href="<?php echo e(route('admin.user_profile')); ?>"><i class="fa fa-user"></i> <?php echo trans('admin.your_profile'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.user_profile')); ?>"><i class="fa fa-user"></i> <?php echo trans('admin.your_profile'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-user"></i> <span><?php echo trans('admin.admin_menu_users_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.users_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_1'); ?></a></li>
              <li><a href="<?php echo e(route('admin.users_roles_list')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.admin_menu_users_sub_label_4'); ?></a></li>
              <li><a href="<?php echo e(route('admin.add_roles')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_2'); ?></a></li>
              <li><a href="<?php echo e(route('admin.add_new_user')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.admin_menu_users_sub_label_3'); ?></a></li>
              <li><a href="<?php echo e(route('admin.user_profile')); ?>"><i class="fa fa-user"></i> <?php echo trans('admin.your_profile'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(check_permission_menu_heading('config')): ?>
      <li class="sidebar-config-title"><?php echo trans('admin.sidebar_config_title'); ?></li>
      <?php endif; ?>
      
      <?php if(in_array('manage_shipping_method_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/shipping-method/options') || Request::is('admin/shipping-method/flat-rate') || Request::is('admin/shipping-method/free-shipping') || Request::is('admin/shipping-method/local-delivery')): ?>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-car"></i> <span><?php echo trans('admin.shipping_method'); ?></span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <?php if(Request::is('admin/shipping-method/options')): ?>  
              <li class="active"><a href="<?php echo e(route('admin.shipping_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.shipping_options'); ?></a></li>
            <?php else: ?>
              <li><a href="<?php echo e(route('admin.shipping_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.shipping_options'); ?></a></li>
            <?php endif; ?>

            <?php if(Request::is('admin/shipping-method/flat-rate')): ?>
              <li class="active"><a href="<?php echo e(route('admin.shipping_method_flat_rate_content')); ?>"><i class="fa fa-calculator"></i> <?php echo trans('admin.flat_rate'); ?></a></li>
            <?php else: ?>
              <li><a href="<?php echo e(route('admin.shipping_method_flat_rate_content')); ?>"><i class="fa fa-calculator"></i> <?php echo trans('admin.flat_rate'); ?></a></li>
            <?php endif; ?>

            <?php if(Request::is('admin/shipping-method/free-shipping')): ?>
              <li class="active"><a href="<?php echo e(route('admin.shipping_method_free_shipping_content')); ?>"><i class="fa fa-close"></i> <?php echo trans('admin.free_shipping'); ?></a></li>
            <?php else: ?>
               <li><a href="<?php echo e(route('admin.shipping_method_free_shipping_content')); ?>"><i class="fa fa-close"></i> <?php echo trans('admin.free_shipping'); ?></a></li>
            <?php endif; ?>

            <?php if(Request::is('admin/shipping-method/local-delivery')): ?>
              <li class="active"><a href="<?php echo e(route('admin.shipping_method_local_delivery_content')); ?>"><i class="fa fa-bus"></i> <?php echo trans('admin.local_delivery'); ?></a></li>
            <?php else: ?>
              <li><a href="<?php echo e(route('admin.shipping_method_local_delivery_content')); ?>"><i class="fa fa-bus"></i> <?php echo trans('admin.local_delivery'); ?></a></li>
            <?php endif; ?>
          </ul>
        </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-car"></i> <span><?php echo trans('admin.shipping_method'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.shipping_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.shipping_options'); ?></a></li>
              <li><a href="<?php echo e(route('admin.shipping_method_flat_rate_content')); ?>"><i class="fa fa-calculator"></i> <?php echo trans('admin.flat_rate'); ?></a></li>
              <li><a href="<?php echo e(route('admin.shipping_method_free_shipping_content')); ?>"><i class="fa fa-close"></i> <?php echo trans('admin.free_shipping'); ?></a></li>
              <li><a href="<?php echo e(route('admin.shipping_method_local_delivery_content')); ?>"><i class="fa fa-bus"></i> <?php echo trans('admin.local_delivery'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(in_array('manage_payment_method_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/payment-method/options') || Request::is('admin/payment-method/direct-bank') || Request::is('admin/payment-method/cash-on-delivery') || Request::is('admin/payment-method/paypal') || Request::is('admin/payment-method/stripe') || Request::is('admin/payment-method/two-checkout')): ?>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-money"></i> <span><?php echo trans('admin.payment_method'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/payment-method/options')): ?>  
                <li class="active"><a href="<?php echo e(route('admin.payment_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.payment_options'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.payment_options'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/payment-method/direct-bank')): ?>
                <li class="active"><a href="<?php echo e(route('admin.payment_method_direct_bank_content')); ?>"><i class="fa fa-bank"></i> <?php echo trans('admin.direct_bank_transfer'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_direct_bank_content')); ?>"><i class="fa fa-bank"></i> <?php echo trans('admin.direct_bank_transfer'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/payment-method/cash-on-delivery')): ?>
                <li class="active"><a href="<?php echo e(route('admin.payment_method_cash_on_delivery_content')); ?>"><i class="fa fa-home"></i> <?php echo trans('admin.cash_on_delivery'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_cash_on_delivery_content')); ?>"><i class="fa fa-home"></i> <?php echo trans('admin.cash_on_delivery'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/payment-method/paypal')): ?>
                <li class="active"><a href="<?php echo e(route('admin.payment_method_paypal_content')); ?>"><i class="fa fa-paypal"></i> <?php echo trans('admin.paypal'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_paypal_content')); ?>"><i class="fa fa-paypal"></i> <?php echo trans('admin.paypal'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/payment-method/stripe')): ?>
                <li class="active"><a href="<?php echo e(route('admin.payment_method_stripe_content')); ?>"><i class="fa fa-cc-stripe"></i> <?php echo trans('admin.stripe'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_stripe_content')); ?>"><i class="fa fa-cc-stripe"></i> <?php echo trans('admin.stripe'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/payment-method/two-checkout')): ?>
                <li class="active"><a href="<?php echo e(route('admin.payment_method_two_checkout_content')); ?>"><i class="fa fa-cc-visa"></i> <?php echo trans('admin.two_checkout'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.payment_method_two_checkout_content')); ?>"><i class="fa fa-cc-visa"></i> <?php echo trans('admin.two_checkout'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-money"></i> <span><?php echo trans('admin.payment_method'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.payment_method_options_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.payment_options'); ?></a></li>
              <li><a href="<?php echo e(route('admin.payment_method_direct_bank_content')); ?>"><i class="fa fa-bank"></i> <?php echo trans('admin.direct_bank_transfer'); ?></a></li>
              <li><a href="<?php echo e(route('admin.payment_method_cash_on_delivery_content')); ?>"><i class="fa fa-home"></i> <?php echo trans('admin.cash_on_delivery'); ?></a></li>
              <li><a href="<?php echo e(route('admin.payment_method_paypal_content')); ?>"><i class="fa fa-paypal"></i> <?php echo trans('admin.paypal'); ?></a></li>
              <li><a href="<?php echo e(route('admin.payment_method_stripe_content')); ?>"><i class="fa fa-cc-stripe"></i> <?php echo trans('admin.stripe'); ?></a></li>
              <li><a href="<?php echo e(route('admin.payment_method_two_checkout_content')); ?>"><i class="fa fa-cc-visa"></i> <?php echo trans('admin.two_checkout'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(in_array('manage_designer_elements_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/designer/clipart/categories/list') || Request::is('admin/designer/clipart/category/add') || Request::is('admin/designer/clipart/category/update/*') || Request::is('admin/designer/clipart/list') || Request::is('admin/designer/clipart/add') || Request::is('admin/designer/clipart/update/*') || Request::is('admin/designer/settings') || Request::is('admin/designer/shape/list') || Request::is('admin/designer/shape/add') || Request::is('admin/designer/shape/update/*') || Request::is('admin/designer/fonts/list') || Request::is('admin/designer/font/add') || Request::is('admin/designer/font/update/*')): ?>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-paint-brush"></i> <span><?php echo trans('admin.custom_designer_elements'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/designer/clipart/categories/list') || Request::is('admin/designer/clipart/category/add') || Request::is('admin/designer/clipart/category/update/*')): ?>  
                <li class="active"><a href="<?php echo e(route('admin.art_categories_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.art_categories_lists'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.art_categories_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.art_categories_lists'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/designer/clipart/list') || Request::is('admin/designer/clipart/add') || Request::is('admin/designer/clipart/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.clipart_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.clipart_lists'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.clipart_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.clipart_lists'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/designer/shape/list') || Request::is('admin/designer/shape/add') || Request::is('admin/designer/shape/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.shape_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.shape_lists'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.shape_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.shape_lists'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/designer/fonts/list') || Request::is('admin/designer/font/add') || Request::is('admin/designer/font/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.fonts_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.fonts_lists'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.fonts_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.fonts_lists'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/designer/settings')): ?>
                <li class="active"><a href="<?php echo e(route('admin.designer_settings_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.settings'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.designer_settings_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.settings'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-paint-brush"></i> <span><?php echo trans('admin.custom_designer_elements'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.art_categories_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.art_categories_lists'); ?></a></li>
              <li><a href="<?php echo e(route('admin.clipart_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.clipart_lists'); ?></a></li>
              <li><a href="<?php echo e(route('admin.shape_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.shape_lists'); ?></a></li>
              <li><a href="<?php echo e(route('admin.fonts_list_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.fonts_lists'); ?></a></li>
              <li><a href="<?php echo e(route('admin.designer_settings_content')); ?>"><i class="fa fa-wrench"></i> <?php echo trans('admin.settings'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?> 
       
      <?php if(in_array('manage_coupon_menu_access', $user_permission_list)): ?>
        <?php if( Request::is('admin/coupon-manager/coupon/add') || Request::is('admin/coupon-manager/coupon/update/*') || Request::is('admin/coupon-manager/coupon/list') ): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.coupon_manager_list')); ?>" class="active">
              <i class="fa fa-percent"></i> <span><?php echo trans('admin.coupon_manager_label'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.coupon_manager_list')); ?>">
              <i class="fa fa-percent"></i> <span><?php echo trans('admin.coupon_manager_label'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(in_array('manage_settings_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/settings/general') || Request::is('admin/settings/languages') || Request::is('admin/settings/languages/update/*') || Request::is('admin/settings/appearance') || Request::is('admin/settings/emails') || Request::is('admin/settings/emails/details/*')): ?>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-cog"></i> <span><?php echo trans('admin.settings'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/settings/general')): ?>  
                <li class="active"><a href="<?php echo e(route('admin.general_settings_content')); ?>"><i class="fa fa-circle-o"></i> <?php echo trans('admin.general'); ?></a></li>
              <?php else: ?>
                 <li><a href="<?php echo e(route('admin.general_settings_content')); ?>"><i class="fa fa-circle-o"></i> <?php echo trans('admin.general'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/settings/languages') || Request::is('admin/settings/languages/update/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.languages_settings_content')); ?>"><i class="fa fa-flag"></i> <?php echo trans('admin.languages'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.languages_settings_content')); ?>"><i class="fa fa-flag"></i> <?php echo trans('admin.languages'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/settings/appearance')): ?>
                <li class="active"><a href="<?php echo e(route('admin.frontend_layout_settings_content')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.frontend_layout'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.frontend_layout_settings_content')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.frontend_layout'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/settings/emails') || Request::is('admin/settings/emails/details/*')): ?>
                <li class="active"><a href="<?php echo e(route('admin.emails_settings_content')); ?>"><i class="fa fa-envelope"></i> <?php echo trans('admin.emails_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.emails_settings_content')); ?>"><i class="fa fa-envelope"></i> <?php echo trans('admin.emails_label'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-cog"></i> <span><?php echo trans('admin.settings'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.general_settings_content')); ?>"><i class="fa fa-circle-o"></i> <?php echo trans('admin.general'); ?></a></li>
              <li><a href="<?php echo e(route('admin.languages_settings_content')); ?>"><i class="fa fa-flag-o"></i> <?php echo trans('admin.languages'); ?></a></li>
              <li><a href="<?php echo e(route('admin.frontend_layout_settings_content')); ?>"><i class="fa fa-paint-brush"></i> <?php echo trans('admin.frontend_layout'); ?></a></li>
              <li><a href="<?php echo e(route('admin.emails_settings_content')); ?>"><i class="fa fa-envelope"></i> <?php echo trans('admin.emails_label'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(is_vendor_login()): ?>
        <?php if(Request::is('admin/vendor/settings')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.vendors_settings_content')); ?>" class="active">
              <i class="fa fa-cog"></i> <span><?php echo trans('admin.settings'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.vendors_settings_content')); ?>">
              <i class="fa fa-cog"></i> <span><?php echo trans('admin.settings'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(is_vendor_login()): ?>
        <?php if(Request::is('admin/vendors/manage/packages')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.manage_packages_content')); ?>">
              <i class="fa fa-gift"></i> <span><?php echo trans('admin.manage_packages_title'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.manage_packages_content')); ?>">
              <i class="fa fa-gift"></i> <span><?php echo trans('admin.manage_packages_title'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(check_permission_menu_heading('features')): ?>
      <li class="sidebar-extra-features-title"><?php echo trans('admin.sidebar_extra_features_title'); ?></li>
      <?php endif; ?>
      
			<?php if(is_vendor_login()): ?>
        <?php if(Request::is('admin/vendors/withdraw') || Request::is('admin/vendors/withdraw/*')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.withdraws_content')); ?>">
              <i class="fa fa-money"></i> <span><?php echo trans('admin.sidebar_withdraw_title'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.withdraws_content')); ?>">
              <i class="fa fa-money"></i> <span><?php echo trans('admin.sidebar_withdraw_title'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
						
			<?php if(is_vendor_login()): ?>
        <?php if(Request::is('admin/vendors/reviews')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.reviews_content')); ?>">
              <i class="fa fa-star"></i> <span><?php echo trans('admin.reviews_title'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.reviews_content')); ?>">
              <i class="fa fa-star"></i> <span><?php echo trans('admin.reviews_title'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(in_array('manage_requested_product_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/customer/request-product')): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.request_product_content')); ?>" class="active">
              <i class="fa fa-question-circle-o"></i> <span><?php echo trans('admin.request_product_label'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.request_product_content')); ?>">
              <i class="fa fa-question-circle-o"></i> <span><?php echo trans('admin.request_product_label'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>  
       
      <?php if(in_array('manage_subscription_menu_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/subscription/custom') || Request::is('admin/subscription/mailchimp') || Request::is('admin/subscription/settings') ): ?>
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span><?php echo trans('admin.subscriptions_manager_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/subscription/custom')): ?>
                <li class="active"><a href="<?php echo e(route('admin.custom_subscription_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.custom_subscriptions_menu_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.custom_subscription_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.custom_subscriptions_menu_label'); ?></a></li>
              <?php endif; ?>

              <?php if(Request::is('admin/subscription/mailchimp')): ?>
                <li class="active"><a href="<?php echo e(route('admin.mailchimp_subscription_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.mailchimp_subscriptions_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.mailchimp_subscription_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.mailchimp_subscriptions_label'); ?></a></li>
              <?php endif; ?>
              
              <?php if(Request::is('admin/subscription/settings')): ?>
                <li class="active"><a href="<?php echo e(route('admin.settings_subscription_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.subscription_settings_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.settings_subscription_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.subscription_settings_label'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-file-text"></i> <span><?php echo trans('admin.subscriptions_manager_menu_title'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.custom_subscription_content')); ?>"><i class="fa fa-table"></i> <?php echo trans('admin.custom_subscriptions_menu_label'); ?></a></li>
              <li><a href="<?php echo e(route('admin.mailchimp_subscription_content')); ?>"><i class="fa fa-plus-square-o"></i> <?php echo trans('admin.mailchimp_subscriptions_label'); ?></a></li>
              <li><a href="<?php echo e(route('admin.settings_subscription_content')); ?>"><i class="fa fa-cog"></i> <?php echo trans('admin.subscription_settings_label'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>  
						
      <?php if(in_array('manage_extra_features_access', $user_permission_list)): ?>
        <?php if(Request::is('admin/extra-features/product-compare-fields') || Request::is('admin/extra-features/color-filter')): ?>			
          <li class="active treeview">
            <a href="#">
              <i class="fa fa-plus"></i> <span><?php echo trans('admin.more_features_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <?php if(Request::is('admin/extra-features/product-compare-fields')): ?>
                <li class="active"><a href="<?php echo e(route('admin.extra_features_compare_products_content')); ?>"><i class="fa fa-exchange"></i> <?php echo trans('admin.more_features_compare_products_label'); ?></a></li>
              <?php else: ?>
                <li><a href="<?php echo e(route('admin.extra_features_compare_products_content')); ?>"><i class="fa fa-exchange"></i> <?php echo trans('admin.more_features_compare_products_label'); ?></a></li>
              <?php endif; ?>
            </ul>
          </li>
        <?php else: ?>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-plus"></i> <span><?php echo trans('admin.more_features_label'); ?></span> <i class="fa fa-angle-left pull-right"></i>
            </a>
            <ul class="treeview-menu">
              <li><a href="<?php echo e(route('admin.extra_features_compare_products_content')); ?>"><i class="fa fa-exchange"></i> <?php echo trans('admin.more_features_compare_products_label'); ?></a></li>
            </ul>
          </li>
        <?php endif; ?>
      <?php endif; ?>
      
      <?php if(is_vendor_login()): ?>
        <?php if((Request::is('admin/vendor/notice-board')) || (Request::is('admin/vendor/notice-board/single/details/*'))): ?>
          <li class="active">
            <a href="<?php echo e(route('admin.vendor_notice_board_content')); ?>">
              <i class="fa fa-bullhorn"></i> <span><?php echo trans('admin.notice_board_label'); ?></span>
            </a>
          </li>
        <?php else: ?>
          <li>
            <a href="<?php echo e(route('admin.vendor_notice_board_content')); ?>">
              <i class="fa fa-bullhorn"></i> <span><?php echo trans('admin.notice_board_label'); ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </section>
</aside>