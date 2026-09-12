<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
    <meta name="theme-color" content="#fff6f9">
    <meta name="robots" content="noindex,nofollow">
    <title>{{ $settings['storeName'] }} — Pricelist</title>
    <meta name="description" content="{{ $settings['tagline'] }}">
    <meta property="og:title" content="{{ $settings['storeName'] }} — Pricelist">
    <meta property="og:description" content="{{ $settings['tagline'] }}">
    <meta property="og:type" content="website">
    @if($settings['logo'])<meta property="og:image" content="{{ $settings['logo'] }}">@endif
    <link rel="stylesheet" href="/assets/css/storefront.css?v=1.0.2">
</head>
<body>
<div class="page-shell">
    <header class="topbar">
        <a class="brand" href="{{ route('storefront') }}" aria-label="Beranda {{ $settings['storeName'] }}">
            <span class="brand-mark">@if($settings['logo'])<img src="{{ $settings['logo'] }}" alt="Logo {{ $settings['storeName'] }}">@else 🎀 @endif</span>
            <span><strong>{{ $settings['storeName'] }}</strong><small>pricelist</small></span>
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
                <h1>{{ $settings['tagline'] }}</h1>
                <p>{{ $settings['heroText'] }}</p>
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
                @foreach($categories as $category)
                    <button class="category-chip" type="button" data-category="{{ $category->slug }}">{{ $category->name }}</button>
                @endforeach
            </div>
        </section>

        <section class="catalog-head">
            <div><span class="section-kicker">Katalog</span><h2>Pilih yang kamu butuhkan</h2></div>
            <span class="result-count"><b id="resultCount">{{ $products->count() }}</b> produk</span>
        </section>

        <section class="product-grid" id="productGrid">
            @forelse($products as $product)
                @php
                    $readyVariants=$product->variants->where('availability_status','ready');
                    $minPrice=$readyVariants->map(fn($v)=>$v->promo_price ?: $v->regular_price)->filter(fn($price)=>$price !== null)->min();
                    $allSoldOut=$product->variants->isNotEmpty() && $readyVariants->isEmpty();
                    $catSlugs=$product->categories->pluck('slug')->implode(' ');
                    $searchText=collect([$product->name,$product->description,$product->keywords,$product->categories->pluck('name')->implode(' '),$product->options->pluck('name')->implode(' '),$product->options->flatMap(fn($o)=>$o->values->pluck('value'))->implode(' ')])->filter()->implode(' ');
                @endphp
                <article class="product-card" data-product-id="{{ $product->id }}" data-categories="{{ $catSlugs }}" data-search="{{ mb_strtolower($searchText) }}">
                    <button type="button" class="product-open" data-open-product="{{ $product->id }}" aria-label="Lihat {{ $product->name }}">
                        <div class="product-image-wrap">
                            @if($product->image_path)
                                <img src="/storage/{{ $product->image_path }}" alt="{{ $product->name }}" loading="lazy">
                            @else
                                <div class="product-placeholder">{{ mb_strtoupper(mb_substr($product->name,0,1)) }}</div>
                            @endif
                            @if($product->badge)<span class="badge">{{ $product->badge }}</span>@endif
                            @if($allSoldOut)<span class="availability-badge sold">Sold Out</span>@elseif($readyVariants->isNotEmpty())<span class="availability-badge ready">Ready</span>@endif
                        </div>
                        <div class="product-body">
                            <div class="product-category">{{ $product->categories->first()?->name ?? 'Premium App' }}</div>
                            <h3>{{ $product->name }}</h3>
                            @if($minPrice !== null)
                                <div class="price-label"><small>Mulai dari</small><strong>Rp{{ number_format($minPrice,0,',','.') }}</strong></div>
                            @elseif($allSoldOut)
                                <div class="price-label muted sold-price"><small>Status</small><strong>Semua paket Sold Out</strong></div>
                            @else
                                <div class="price-label muted"><small>Harga</small><strong>Belum tersedia</strong></div>
                            @endif
                            <span class="see-detail">Lihat pilihan <b>›</b></span>
                        </div>
                    </button>
                </article>
            @empty
                <div class="empty-state"><span>🎀</span><h3>Belum ada produk</h3><p>Pricelist akan muncul di sini.</p></div>
            @endforelse
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
window.PINKY_DATA = @json($payload);
window.PINKY_SETTINGS = @json($settings);
</script>
<script src="/assets/js/storefront.js?v=1.0.2" defer></script>
</body>
</html>
