<?php $__env->startSection('content'); ?>
    <br><br>
    <div class="row">
        <?php echo $html; ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('main', \Illuminate\Support\Arr::except(get_defined_vars(), array('__data', '__path')))->render(); ?>