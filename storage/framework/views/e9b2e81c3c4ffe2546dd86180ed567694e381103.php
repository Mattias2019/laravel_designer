<div class="col-sm-4">
  <div class="sub-cat">
    <?php if(count($data['children'])>0): ?>
    <h3><a href="<?php echo e(route('categories-page', $data['slug'])); ?>"> <?php echo $data['name']; ?> <span class="pull-right"><i class="fa fa-chevron-right"></i></span></a></h3>
    <ul class="list-unstyled child-cat-list">
      <?php $__currentLoopData = $data['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
        <?php echo $__env->make('pages.common.product-children-category-extra', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <?php else: ?>
    <h3><a href="<?php echo e(route('categories-page', $data['slug'])); ?>"> <?php echo $data['name']; ?> </a></h3>
    <?php endif; ?>
  </div>
</div>