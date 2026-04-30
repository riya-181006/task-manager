<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Task Manager | <?php echo $__env->yieldContent('title'); ?></title>

    <?php echo $__env->make('layout.css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('style'); ?>
</head>

<body>

    <?php echo $__env->yieldContent('content'); ?>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <?php echo $__env->make('layout.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php echo $__env->yieldContent('customjs'); ?>

</body>
</html><?php /**PATH C:\Users\KIIT\Desktop\INTERSHIP\WEB DEVELOPEMENT\PROJECTS\PROJECT2\task_manager\resources\views/layout/baseview.blade.php ENDPATH**/ ?>