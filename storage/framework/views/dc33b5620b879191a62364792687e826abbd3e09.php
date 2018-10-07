<?php if(Session::has('success-message')): ?>
  <div class="alert alert-success">
    <?php echo e(Session::get('success-message')); ?>

  </div>
<?php endif; ?>