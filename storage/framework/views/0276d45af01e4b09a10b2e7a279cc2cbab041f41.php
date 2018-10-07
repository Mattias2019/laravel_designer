<?php if(Session::has('error-message')): ?>
  <div class="alert alert-danger">
    <?php echo e(Session::get('error-message')); ?>

  </div>
<?php endif; ?>