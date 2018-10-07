<div class="footer-top full-width">
  <div class="footer-top-background">
    <div class="container">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title"><?php echo trans('frontend.footer_about_us'); ?></h3>
          <div class="is-divider small"></div>
          <p><?php echo $appearance_all_data['footer_details']['footer_about_us_description']; ?></p>
         
          <h3 class="widget-title"><?php echo trans('frontend.footer_follow_us'); ?></h3>
          <div class="is-divider small"></div>
          <ul class="social-media">
            <li><a class="facebook" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['fb']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.fb_tooltip_msg')); ?>"><i class="fa fa-facebook"></i></a></li>
            <li><a class="twitter" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['twitter']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.twitter_tooltip_msg')); ?>"><i class="fa fa-twitter"></i></a></li>
            <li><a class="linkedin" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['linkedin']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.linkedin_tooltip_msg')); ?>"><i class="fa fa-linkedin"></i></a></li>
            <li><a class="dribbble" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['dribbble']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.dribbble_tooltip_msg')); ?>"><i class="fa fa-dribbble"></i></a></li>
            <li><a class="google-plus" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['google_plus']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.google_plus_tooltip_msg')); ?>"><i class="fa fa-google-plus"></i></a></li>
            <li><a class="instagram" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['instagram']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.instagram_tooltip_msg')); ?>"><i class="fa fa-instagram"></i></a></li>
            <li><a class="youtube-play" href="//<?php echo e($appearance_all_data['footer_details']['follow_us_url']['youtube']); ?>" data-toggle="tooltip" data-placement="top" title="<?php echo e(trans('frontend.youtube_play_tooltip_msg')); ?>"><i class="fa fa-youtube-play"></i></a></li>
          </ul>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title"><?php echo trans('frontend.latest_news_label'); ?></h3>
          <div class="is-divider small"></div>
          <div class="latest-footer-blogs">
            <?php if(count($blogs_data) > 0): ?>
            <ul>
              <?php $__currentLoopData = $blogs_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li>
                <div class="footer-latest-blog-row">
                  <div class="footer-blogs-widget-title footer-blogs-left-boxs"><span><?php echo e(Carbon\Carbon::parse($rows['created_at'])->format('d')); ?></span><br><span><?php echo e(Carbon\Carbon::parse($rows['created_at'])->format('M')); ?></span></div>
                  <div class="footer-blogs-widget-title footer-blogs-right-text"><a href="<?php echo e(route('blog-single-page', $rows['post_slug'])); ?>"><?php echo e($rows['post_title']); ?></a> <br><span><a href="<?php echo e(route('blog-single-page', $rows['post_slug'])); ?>"><strong><?php echo $rows['comments_details']['total']; ?></strong>&nbsp;<?php echo trans('frontend.comments_label'); ?></a></span></div>
                </div>
              </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php else: ?>
            <p class="not-available"><?php echo trans('frontend.no_latest_news_label'); ?></p>
            <?php endif; ?>
          </div>
        </div>
        
        <div class="col-xs-12 col-sm-12 col-md-4">
          <h3 class="widget-title"><?php echo trans('frontend.footer_tags_label'); ?></h3>
          <div class="is-divider small"></div>
          <div class="footer-tags-list">
            <?php if(count($popular_tags_list) > 0): ?>
              <?php $__currentLoopData = $popular_tags_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tags): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('tag-single-page', $tags['slug'])); ?>"><?php echo $tags['name']; ?></a>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <p class="not-available"><?php echo trans('frontend.footer_no_tags_label'); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="footer-copyright full-width">
  <div class="footer-copyright-background">
    <div class="container">
      <div class="row">
        <div class="col-md-12 footer-text">
          <div class="text-center"><?php echo trans('frontend.footer_msg', ['title' => get_site_title()]); ?></div>
          <div class="text-center"><?php echo trans('frontend.footer_powered_by'); ?> <strong><?php echo get_site_title(); ?></strong></div>
        </div>
      </div>
    </div>
  </div>  
</div>