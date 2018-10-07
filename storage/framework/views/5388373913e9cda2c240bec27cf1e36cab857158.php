<?php $__env->startSection('blog-categories-content'); ?>
<div class="blog-categories-accordian">
  <h2><?php echo e(trans('frontend.category_label')); ?> <span class="responsive-accordian"></span></h2>
  
  <?php if(count($categoriesTree) > 0): ?>
  <div class="category">
    <ul class="blog-categories list-unstyled">
      <?php $__currentLoopData = $categoriesTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="blog-parent-categories">
          <?php if(count($data['children'])>0): ?>
          <?php $img = $data['img_url'];?>
          <div class="dropdown">
            <a class="btn btn-default dropdown-toggle hidden-xs" id="dropdownMenu2" href="<?php echo e(route('blog-cat-page', $data['slug'])); ?>"> <?php echo $data['name']; ?> <span class="caret pull-right"></span></a>
            <button class="btn btn-default dropdown-toggle hidden-sm hidden-md hidden-lg" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $data['name']; ?><span class="caret pull-right"></span></button>
            
            <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
              <div class="cat-list-area col-sm-9">
                <?php $__currentLoopData = $data['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo $__env->make('pages.common.blog-children-category', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div> 
              <div class="blog-cat-img-area col-sm-3">
                <?php if(!empty($img)): ?>
                <img class="img-responsive" src="<?php echo e(get_image_url($img)); ?>" alt="cat-img">
                <?php else: ?>
                <img class="img-responsive" src="<?php echo e(default_placeholder_img_src()); ?>" alt="cat-img">
                <?php endif; ?>
              </div>
              <div class="clearfix"></div>  
            </div>
          </div>
          <?php else: ?>
          <a href="<?php echo e(route('blog-cat-page', $data['slug'])); ?>"> <?php echo $data['name']; ?> </a>
          <?php endif; ?>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>  
  </div>    
  <?php else: ?>
  <h5><?php echo e(trans('frontend.no_categories_yet')); ?></h5>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?> 