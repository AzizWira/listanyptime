<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="theme-color" content="#fff6f9">
    <meta name="robots" content="noindex,nofollow">
    <title><?php echo e($settings['storeName']); ?> — Pricelist</title>
    <meta name="description" content="<?php echo e($settings['tagline']); ?>">
    <meta property="og:title" content="<?php echo e($settings['storeName']); ?> — Pricelist">
    <meta property="og:description" content="<?php echo e($settings['tagline']); ?>">
    <meta property="og:type" content="website">
    <?php if($settings['logo']): ?><meta property="og:image" content="<?php echo e($settings['logo']); ?>"><?php endif; ?>
    <link rel="stylesheet" href="/assets/css/storefront.css?v=1.0.2">
</head>
<body>
<div class="page-shell">
    <header class="topbar">
        <a class="brand" href="<?php echo e(route('storefront')); ?>" aria-label="Beranda <?php echo e($settings['storeName']); ?>">
            <span class="brand-mark"><?php if($settings['logo']): ?><img src="<?php echo e($settings['logo']); ?>" alt="Logo <?php echo e($settings['storeName']); ?>"><?php else: ?> 🎀 <?php endif; ?></span>
            <span><strong><?php echo e($settings['storeName']); ?></strong><small>pricelist</small></span>
        </a>
        <button class="cart-button" type="button" data-open-cart aria-label="Buka keranjang">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h7.9a2 2 0 0 0 1.9-1.4L21 8H7.2M10 20h.01M17 20h.01"/></svg>
            <span>Keranjang</span><b data-cart-count>0</b>
        </button>
    </header>

    <main>
        <section class="hero-card">
            <div class="hero-copy">
                <span class="eyebrow">PRICE LIST • PREMIUM APPS</span>
                <h1><?php echo e($settings['tagline']); ?></h1>
                <p><?php echo e($settings['heroText']); ?></p>
                <div class="hero-notes"><span>✦ Pilih paket dengan mudah</span><span>WA Order via WhatsApp</span></div>
            </div>
            <div class="hero-deco" aria-hidden="true"><span>♡</span><span>✦</span><span>୨୧</span></div>
        </section>

        <section class="finder" aria-label="Cari produk">
            <label class="search-box">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.2-3.2"/></svg>
                <input id="productSearch" type="search" placeholder="Cari Canva, 1 bulan, designer..." autocomplete="off">
                <button id="clearSearch" type="button" aria-label="Hapus pencarian" hidden>×</button>
            </label>
            <div class="category-scroll" id="categoryFilters">
                <button class="category-chip is-active" type="button" data-category="all">Semua</button>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button class="category-chip" type="button" data-category="<?php echo e($category->slug); ?>"><?php echo e($category->name); ?></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </section>

        <section class="catalog-head">
            <div><span class="section-kicker">Katalog</span><h2>Pilih yang kamu butuhkan</h2></div>
            <span class="result-count"><b id="resultCount"><?php echo e($products->count()); ?></b> produk</span>
        </section>

        <section class="product-grid" id="productGrid">
            <?php $__empty_1 = true; $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $readyVariants=$product->variants->where('availability_status','ready');
                    $minPrice=$readyVariants->map(fn($v)=>$v->promo_price ?: $v->regular_price)->filter(fn($price)=>$price !== null)->min();
                    $allSoldOut=$product->variants->isNotEmpty() && $readyVariants->isEmpty();
                    $catSlugs=$product->categories->pluck('slug')->implode(' ');
                    $searchText=collect([$product->name,$product->description,$product->keywords,$product->categories->pluck('name')->implode(' '),$product->options->pluck('name')->implode(' '),$product->options->flatMap(fn($o)=>$o->values->pluck('value'))->implode(' ')])->filter()->implode(' ');
                ?>
                <article class="product-card" data-product-id="<?php echo e($product->id); ?>" data-categories="<?php echo e($catSlugs); ?>" data-search="<?php echo e(mb_strtolower($searchText)); ?>">
                    <button type="button" class="product-open" data-open-product="<?php echo e($product->id); ?>" aria-label="Lihat <?php echo e($product->name); ?>">
                        <div class="product-image-wrap">
                            <?php if($product->image_path): ?>
                                <img src="/storage/<?php echo e($product->image_path); ?>" alt="<?php echo e($product->name); ?>" loading="lazy">
                            <?php else: ?>
                                <div class="product-placeholder"><?php echo e(mb_strtoupper(mb_substr($product->name,0,1))); ?></div>
                            <?php endif; ?>
                            <?php if($product->badge): ?><span class="badge"><?php echo e($product->badge); ?></span><?php endif; ?>
                            <?php if($allSoldOut): ?><span class="availability-badge sold">Sold Out</span><?php elseif($readyVariants->isNotEmpty()): ?><span class="availability-badge ready">Ready</span><?php endif; ?>
                        </div>
                        <div class="product-body">
                            <div class="product-category"><?php echo e($product->categories->first()?->name ?? 'Premium App'); ?></div>
                            <h3><?php echo e($product->name); ?></h3>
                            <?php if($minPrice !== null): ?>
                                <div class="price-label"><small>Mulai dari</small><strong>Rp<?php echo e(number_format($minPrice,0,',','.')); ?></strong></div>
                            <?php elseif($allSoldOut): ?>
                                <div class="price-label muted sold-price"><small>Status</small><strong>Semua paket Sold Out</strong></div>
                            <?php else: ?>
                                <div class="price-label muted"><small>Harga</small><strong>Belum tersedia</strong></div>
                            <?php endif; ?>
                            <span class="see-detail">Lihat pilihan <b>›</b></span>
                        </div>
                    </button>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state"><span>🎀</span><h3>Belum ada produk</h3><p>Pricelist akan muncul di sini.</p></div>
            <?php endif; ?>
        </section>
        <div class="empty-state" id="searchEmpty" hidden><span>♡</span><h3>Belum ketemu</h3><p>Coba kata kunci atau kategori lain ya.</p></div>
    </main>

    <footer class="site-footer"><span>Made with ♡ for easy ordering</span><span>Transaksi dilanjutkan melalui WhatsApp</span></footer>
</div>

<div class="overlay" id="productOverlay" hidden>
    <div class="sheet product-sheet" role="dialog" aria-modal="true" aria-labelledby="detailTitle">
        <div class="sheet-handle" aria-hidden="true"></div>
        <button class="sheet-close" type="button" data-close-product aria-label="Tutup">×</button>
        <div id="productDetail"></div>
    </div>
</div>

<div class="overlay" id="cartOverlay" hidden>
    <div class="sheet cart-sheet" role="dialog" aria-modal="true" aria-labelledby="cartTitle">
        <div class="sheet-handle" aria-hidden="true"></div>
        <div class="sheet-title-row"><div><span class="section-kicker">Pilihanmu</span><h2 id="cartTitle">Keranjang</h2></div><button class="sheet-close static" type="button" data-close-cart aria-label="Tutup">×</button></div>
        <div id="cartContent"></div>
    </div>
</div>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script>
window.PINKY_DATA = <?php echo json_encode($payload, 15, 512) ?>;
window.PINKY_SETTINGS = <?php echo json_encode($settings, 15, 512) ?>;
</script>
<script src="/assets/js/storefront.js?v=1.0.2" defer></script>
</body>
</html>
<?php /**PATH D:\GAWEAN\Pinky-Pricelist\resources\views/storefront.blade.php ENDPATH**/ ?>