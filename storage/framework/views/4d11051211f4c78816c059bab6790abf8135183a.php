<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', '')); ?> <?php echo $__env->yieldContent('title'); ?> </title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles Tailwind Laravel Breeze -->
        <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
        

        <!-- Scripts Tailwind Laravel Breeze -->
        <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
        
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            <?php echo e($slot); ?>

        </div>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/layouts/guest.blade.php ENDPATH**/ ?>