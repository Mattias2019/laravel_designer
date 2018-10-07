<?php if(count($data['children'])>0): ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a data-toggle="collapse" data-parent="#accordian" href="#<?php echo e(str_replace(' ', '-', $data['slug'])); ?>">
        <span class="pull-right">
          <?php if( (in_array($data['id'], $product_by_cat_id['selected_cat'])) || ($data['id'] == $product_by_cat_id['parent_id'])){?>
          <i class="fa fa-minus"></i>
          <?php } else {?>
          <i class="fa fa-plus"></i>
          <?php }?>
        </span>
        <i class="fa fa-angle-double-right"></i> &nbsp; 
        <?php if(in_array($data['id'], $product_by_cat_id['selected_cat'])){?>
        <span class="active"><?php echo $data['name']; ?></span>
         <?php } else {?>
        <span><?php echo $data['name']; ?></span>
         <?php }?>
      </a>
    </h4>
  </div>
  
 <?php if( (in_array($data['id'], $product_by_cat_id['selected_cat'])) || ($data['id'] == $product_by_cat_id['parent_id'])){?>
  <div id="<?php echo e(str_replace(' ', '-', $data['slug'])); ?>" class="panel-collapse in">
  <?php } else {?>
  <div id="<?php echo e(str_replace(' ', '-', $data['slug'])); ?>" class="panel-collapse collapse">
  <?php }?>
    <div class="panel-body">
        <?php if(count($data['children'])>0): ?>
        <ul>
          <?php $__currentLoopData = $data['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('pages.common.category-frontend-loop-extra', $data, array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>  
        <?php endif; ?>
    </div>
  </div>
</div>  
<?php else: ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h4 class="panel-title">
      <a href="<?php echo e(route('categories-page', $data['slug'])); ?>">
        <i class="fa fa-angle-double-right"></i> &nbsp; 
        <?php if(in_array($data['id'], $product_by_cat_id['selected_cat'])){?>
        <span class="active"><?php echo $data['name']; ?></span>
        <?php } else {?>
        <span><?php echo $data['name']; ?></span>
        <?php }?>
      </a>
    </h4>
  </div>
</div>
<?php endif; ?>
