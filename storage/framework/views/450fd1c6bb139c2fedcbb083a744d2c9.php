<?php $__env->startSection('title','Quick Edit Harga'); ?> <?php $__env->startSection('page-title','Quick Edit Harga'); ?> <?php $__env->startSection('eyebrow','UPDATE HARIAN'); ?>
<?php $__env->startSection('content'); ?>
<div class="toolbar"><div class="toolbar-copy"><h2>Ubah harga tanpa buka satu-satu</h2><p>Cari produk, edit beberapa harga sekaligus, lalu simpan.</p></div></div>
<div class="quick-filter"><input type="search" placeholder="Cari produk atau kategori..." data-quick-search><select data-quick-category><option value="all">Semua kategori</option><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($category->slug); ?>"><?php echo e($category->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
<form method="post" action="<?php echo e(route('admin.products.quick-update')); ?>" class="quick-edit-form" data-dirty-form><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<div class="quick-product-list">
<?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<section class="quick-product" data-quick-product data-search-text="<?php echo e(mb_strtolower($product->name.' '.$product->categories->pluck('name')->implode(' '))); ?>" data-category-text="<?php echo e($product->categories->pluck('slug')->implode(' ')); ?>">
<button class="quick-product-head" type="button" data-collapse-toggle><div><span class="kicker"><?php echo e($product->categories->first()?->name ?? 'Produk'); ?></span><h3><?php echo e($product->name); ?></h3></div><span><?php echo e($product->variants->count()); ?> varian⌄</span></button>
<div class="quick-variants">
<?php $__empty_2 = true; $__currentLoopData = $product->variants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
<div class="quick-variant-row"><div class="quick-variant-name"><?php $__empty_3 = true; $__currentLoopData = $variant->values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_3 = false; ?><span><small><?php echo e($value->option->name); ?></small><?php echo e($value->value); ?></span><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_3): ?><span><small>PAKET</small>Utama</span><?php endif; ?></div>
<label class="field compact"><span>Normal</span><input type="number" min="0" name="variants[<?php echo e($variant->id); ?>][regular_price]" value="<?php echo e($variant->regular_price); ?>" required inputmode="numeric"></label>
<label class="field compact"><span>Promo</span><input type="number" min="0" name="variants[<?php echo e($variant->id); ?>][promo_price]" value="<?php echo e($variant->promo_price); ?>" inputmode="numeric" placeholder="—"></label>
<label class="field compact status-select"><span>Status</span><select name="variants[<?php echo e($variant->id); ?>][availability_status]"><option value="ready" <?php if($variant->availability_status==='ready'): echo 'selected'; endif; ?>>Ready</option><option value="sold_out" <?php if($variant->availability_status==='sold_out'): echo 'selected'; endif; ?>>Sold Out</option></select></label></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?><div class="admin-empty slim">Belum ada varian.</div><?php endif; ?>
</div></section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="admin-empty">Belum ada produk.</div><?php endif; ?>
</div>
<div class="sticky-save"><span data-dirty-note>Belum ada perubahan.</span><button class="button primary" type="submit" data-dirty-save>Simpan Semua Perubahan</button></div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\GAWEAN\Pinky-Pricelist\resources\views/admin/products/quick-edit.blade.php ENDPATH**/ ?>