<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="theme-color" content="#fff7fa">
    <title><?php echo $__env->yieldContent('title','Admin'); ?> — Pinky Pricelist</title>
    <link rel="stylesheet" href="/assets/css/admin.css?v=1.0.2">
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <a class="admin-brand" href="<?php echo e(route('admin.dashboard')); ?>"><span>🎀</span><div><b>Pinky Admin</b><small>pricelist manager</small></div></a>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('admin.dashboard')?'active':''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">⌂ <span>Dashboard</span></a>
            <a class="<?php echo e(request()->routeIs('admin.products.index','admin.products.create','admin.products.edit')?'active':''); ?>" href="<?php echo e(route('admin.products.index')); ?>">▦ <span>Produk</span></a>
            <a class="<?php echo e(request()->routeIs('admin.products.quick-*')?'active':''); ?>" href="<?php echo e(route('admin.products.quick-edit')); ?>">✎ <span>Quick Edit</span></a>
            <a class="<?php echo e(request()->routeIs('admin.categories.*')?'active':''); ?>" href="<?php echo e(route('admin.categories.index')); ?>"># <span>Kategori</span></a>
            <a class="<?php echo e(request()->routeIs('admin.settings.*')?'active':''); ?>" href="<?php echo e(route('admin.settings.edit')); ?>">⚙ <span>Pengaturan</span></a>
        </nav>
        <div class="sidebar-bottom">
            <a href="<?php echo e(route('storefront')); ?>" target="_blank">↗ <span>Lihat Pricelist</span></a>
            <form method="post" action="<?php echo e(route('admin.logout')); ?>"><?php echo csrf_field(); ?><button type="submit">↪ <span>Logout</span></button></form>
        </div>
    </aside>

    <div class="admin-main">
        <header class="admin-topbar">
            <div><small><?php echo $__env->yieldContent('eyebrow','OWNER PANEL'); ?></small><h1><?php echo $__env->yieldContent('page-title','Dashboard'); ?></h1></div>
            <a class="view-store" href="<?php echo e(route('storefront')); ?>" target="_blank">Lihat toko ↗</a>
        </header>
        <main class="admin-content">
            <?php if(session('success')): ?><div class="flash success"><span>♡</span><?php echo e(session('success')); ?></div><?php endif; ?>
            <?php if(session('error')): ?><div class="flash error"><span>!</span><?php echo e(session('error')); ?></div><?php endif; ?>
            <?php if($errors->any()): ?><div class="flash error"><div><b>Ada yang perlu diperbaiki:</b><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div></div><?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>
<nav class="mobile-nav" aria-label="Navigasi admin">
    <a class="<?php echo e(request()->routeIs('admin.dashboard')?'active':''); ?>" href="<?php echo e(route('admin.dashboard')); ?>"><b>⌂</b><span>Home</span></a>
    <a class="<?php echo e(request()->routeIs('admin.products.index','admin.products.create','admin.products.edit')?'active':''); ?>" href="<?php echo e(route('admin.products.index')); ?>"><b>▦</b><span>Produk</span></a>
    <a class="<?php echo e(request()->routeIs('admin.products.quick-*')?'active':''); ?>" href="<?php echo e(route('admin.products.quick-edit')); ?>"><b>✎</b><span>Harga</span></a>
    <a class="<?php echo e(request()->routeIs('admin.categories.*')?'active':''); ?>" href="<?php echo e(route('admin.categories.index')); ?>"><b>#</b><span>Kategori</span></a>
    <a class="<?php echo e(request()->routeIs('admin.settings.*')?'active':''); ?>" href="<?php echo e(route('admin.settings.edit')); ?>"><b>⚙</b><span>Setting</span></a>
</nav>

<div class="admin-dialog-backdrop" id="adminConfirmDialog" hidden>
    <div class="admin-dialog" role="dialog" aria-modal="true" aria-labelledby="adminConfirmTitle">
        <div class="admin-dialog-mark">♡</div>
        <h2 id="adminConfirmTitle">Konfirmasi dulu</h2>
        <p id="adminConfirmMessage">Lanjutkan aksi ini?</p>
        <div class="admin-dialog-actions"><button class="button ghost" type="button" data-confirm-cancel>Batal</button><button class="button danger" type="button" data-confirm-accept>Ya, lanjutkan</button></div>
    </div>
</div>
<div class="admin-toast" id="adminToast" role="status" aria-live="polite"></div>
<script src="/assets/js/admin.js?v=1.0.2" defer></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\GAWEAN\Pinky-Pricelist\resources\views/layouts/admin.blade.php ENDPATH**/ ?>