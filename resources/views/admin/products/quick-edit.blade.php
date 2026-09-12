@extends('layouts.admin')
@section('title','Quick Edit Harga') @section('page-title','Quick Edit Harga') @section('eyebrow','UPDATE HARIAN')
@section('content')
<div class="toolbar"><div class="toolbar-copy"><h2>Ubah harga tanpa buka satu-satu</h2><p>Cari produk, edit beberapa harga sekaligus, lalu simpan.</p></div></div>
<div class="quick-filter"><input type="search" placeholder="Cari produk atau kategori..." data-quick-search><select data-quick-category><option value="all">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->slug }}">{{ $category->name }}</option>@endforeach</select></div>
<form method="post" action="{{ route('admin.products.quick-update') }}" class="quick-edit-form" data-dirty-form>@csrf @method('PUT')
<div class="quick-product-list">
@forelse($products as $product)
<section class="quick-product" data-quick-product data-search-text="{{ mb_strtolower($product->name.' '.$product->categories->pluck('name')->implode(' ')) }}" data-category-text="{{ $product->categories->pluck('slug')->implode(' ') }}">
<button class="quick-product-head" type="button" data-collapse-toggle><div><span class="kicker">{{ $product->categories->first()?->name ?? 'Produk' }}</span><h3>{{ $product->name }}</h3></div><span>{{ $product->variants->count() }} varian⌄</span></button>
<div class="quick-variants">
@forelse($product->variants as $variant)
<div class="quick-variant-row"><div class="quick-variant-name">@forelse($variant->values as $value)<span><small>{{ $value->option->name }}</small>{{ $value->value }}</span>@empty<span><small>PAKET</small>Utama</span>@endforelse</div>
<label class="field compact"><span>Normal</span><input type="number" min="0" name="variants[{{ $variant->id }}][regular_price]" value="{{ $variant->regular_price }}" required inputmode="numeric"></label>
<label class="field compact"><span>Promo</span><input type="number" min="0" name="variants[{{ $variant->id }}][promo_price]" value="{{ $variant->promo_price }}" inputmode="numeric" placeholder="—"></label>
<label class="field compact status-select"><span>Status</span><select name="variants[{{ $variant->id }}][availability_status]"><option value="ready" @selected($variant->availability_status==='ready')>Ready</option><option value="sold_out" @selected($variant->availability_status==='sold_out')>Sold Out</option></select></label></div>
@empty<div class="admin-empty slim">Belum ada varian.</div>@endforelse
</div></section>
@empty<div class="admin-empty">Belum ada produk.</div>@endforelse
</div>
<div class="sticky-save"><span data-dirty-note>Belum ada perubahan.</span><button class="button primary" type="submit" data-dirty-save>Simpan Semua Perubahan</button></div>
</form>
@endsection
