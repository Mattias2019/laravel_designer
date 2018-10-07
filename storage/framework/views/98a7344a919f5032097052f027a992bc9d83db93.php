<?php if(count($blogs_all_data) > 0): ?>
<div class="blog-content-main">
  <div class="row">
    <div class="col-md-9">
      <?php $__currentLoopData = $blogs_all_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="blog-content-elements-main">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="blog-media">
              <?php if(!empty($row['featured_image'])): ?>
                <img class="img-responsive" src="<?php echo e(get_image_url($row['featured_image'])); ?>" alt="<?php echo e(basename($row['featured_image'])); ?>">
              <?php else: ?>
                <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="media">
              <?php endif; ?>
            </div>
          </div>
          
          <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
            <div class="blog-text">
              <p>
                <span class="blog-date"><i class="fa fa-calendar"></i>&nbsp;<?php echo e(Carbon\Carbon::parse($row['created_at'])->format('d F, Y')); ?></span> &nbsp;&nbsp;
                <span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; <?php echo $row['comments_details']['total']; ?> <?php echo trans('frontend.comments_label'); ?></span>
              </p>
              <p class="blog-title"><?php echo $row['post_title']; ?></p>
              <p class="blog-description">
                <?php echo get_limit_string(string_decode($row['post_content']), $row['allow_max_number_characters_at_frontend']); ?>

              </p>
              <br>
              <div class="btn-read-more"><a class="btn btn-block btn-default" href="<?php echo e(route('blog-single-page', $row['post_slug'])); ?>"><?php echo trans('frontend.read_more_label'); ?></a></div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="col-md-3">
      <?php echo $__env->make('includes.frontend.blog-categories', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php echo $__env->yieldContent('blog-categories-content'); ?>
      
      <?php if(count($advanced_data['best_items']) > 0): ?>  
      <div class="best-blog">
        <div class="content-title">
          <h2 class="text-center title-under"><?php echo trans('frontend.best_from_the_blog_title'); ?></h2>
        </div>
        <div class="best-blog-content">
          <div class="row">
            <?php $__currentLoopData = $advanced_data['best_items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-md-12 blog-box extra-padding">
                <a href="<?php echo e(route('blog-single-page', $items['post_slug'])); ?>">
                  <?php if(!empty($items['blog_image'])): ?>  
                    <img class="img-responsive" src="<?php echo e(get_image_url($items['blog_image'])); ?>"  alt="<?php echo e(basename($items['blog_image'])); ?>">          
                  <?php else: ?>
                    <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>"  alt="">          
                  <?php endif; ?>
                  <div class="blog-bottom-text">
                    <p class="blog-title"><?php echo $items['post_title']; ?></p>
                    <p><span class="blog-date"><i class="fa fa-calendar"></i>&nbsp; <?php echo e(Carbon\Carbon::parse($items['created_at'])->format('d F, Y')); ?></span>&nbsp;&nbsp;<span class="blog-comments"> <i class="fa fa-comment"></i>&nbsp; <?php echo $items['comments_details']['total']; ?> <?php echo trans('frontend.comments_label'); ?></span></p>
                  </div>
                </a>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>  
<?php else: ?>
<p><?php echo trans('frontend.no_blogs_data_label'); ?></p>
<?php endif; ?>