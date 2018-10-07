<header class="main-header">
  <div class="logo">
    <a target="_blank" title="<?php echo e(trans('admin.view_online_store')); ?>" href="<?php echo e(route('home-page')); ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php echo trans('admin.view_online_store'); ?></a>
  </div>
                            
  <nav class="navbar navbar-static-top" role="navigation">
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <?php if(!empty($user_data['user_photo_url'])): ?>
              <img src="<?php echo e(get_image_url($user_data['user_photo_url'])); ?>" class="user-image" alt=""/>
            <?php else: ?>
              <img src="<?php echo e(default_avatar_img_src()); ?>" class="user-image" alt=""/>
            <?php endif; ?>
            <span class="hidden-xs"><?php echo $user_data['user_display_name']; ?></span>
          </a>
          <ul class="dropdown-menu">
            <li class="user-header">
              <?php if(!empty($user_data['user_photo_url'])): ?>
                <img src="<?php echo e(get_image_url($user_data['user_photo_url'])); ?>" class="user-image" alt=""/>
              <?php else: ?>
                <img src="<?php echo e(default_avatar_img_src()); ?>" class="user-image" alt=""/>
              <?php endif; ?>
              <p>
                <?php echo $user_data['user_display_name']; ?>

                <small><?php echo $user_data['user_role']; ?></small>
              </p>
            </li>

            <li class="user-footer">
              <?php if(isset($user_data['user_role_slug']) && $user_data['user_role_slug'] == 'administrator'): ?>  
                <div class="pull-left">
                  <a href="<?php echo e(route('admin.user_profile')); ?>" class="btn btn-default btn-flat"><?php echo e(trans('admin.profile')); ?></a>
                </div>
              <?php endif; ?>
              <form method="post" action="<?php echo e(route('admin.logout')); ?>" enctype="multipart/form-data">
                <input type="hidden" name="_token" id="_token" value="<?php echo e(csrf_token()); ?>">
                <div class="pull-right">
                  <button type="submit" class="btn btn-default btn-flat"><?php echo trans('admin.sign_out'); ?></button>
                </div>
              </form>    
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>