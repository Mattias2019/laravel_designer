<li>
  <input type="checkbox" class="shopist-iCheck" name="inputCategoriesName[]" id="inputCategoriesName-<?php echo e($data['name']); ?>" value="<?php echo e($data['id']); ?>">
  &nbsp;&nbsp;<?php echo e($data['name']); ?>

</li>
<?php if(count($data['children']) > 0): ?>
  <ul>
  <?php $__currentLoopData = $data['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php echo $__env->make('pages.common.category-list', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </ul>
<?php endif; ?>