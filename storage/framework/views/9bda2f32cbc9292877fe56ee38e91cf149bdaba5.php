<li>
  <a href="<?php echo e(route('categories-page', $data['slug'])); ?>">
    <i class="fa fa-angle-right"></i> &nbsp; 
    <?php if(in_array($data['id'], $product_by_cat_id['selected_cat'])){?>
    <span class="active"><?php echo $data['name']; ?></span>
    <?php } else {?>
    <span><?php echo $data['name']; ?></span>
    <?php }?>
  </a>
</li>
<?php $__currentLoopData = $data['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('pages.common.category-frontend-loop-extra', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>