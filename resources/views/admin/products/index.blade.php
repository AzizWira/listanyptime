@extends('layouts.admin')
@section('title','Produk') @section('page-title','Produk') @section('eyebrow','KELOLA KATALOG')
@section('content')
<div class="toolbar"><div class="toolbar-copy"><h2>Semua Produk</h2><p>Tekan dan geser handle untuk mengubah urutan tampil.</p></div><a class="button primary" href="{{ route('admin.products.create') }}">+ Tambah Produk</a></div>
<div class="mini-search"><input type="search" placeholder="Cari produk..." data-admin-search data-target="[data-product-row]"></div>
<div class="sortable-list product-admin-list" data-sortable data-reorder-url="{{ route('admin.products.reorder') }}">
@forelse($products as $product)
<article class="admin-product-row" data-sort-id="{{ $product->id }}" data-product-row data-search-text="{{ mb_strtolower($product->name.' '.$product->categories->pluck('name')->implode(' ')) }}">
    <button class="drag-handle" type="button" aria-label="Geser {{ $product->name }}">⋮⋮</button>
    <div class="admin-product-thumb">@if($product->image_path)<img src="/storage/{{ $product->image_path }}" alt="">@else<span>{{ mb_strtoupper(mb_substr($product->name,0,1)) }}</span>@endif</div>
    <div class="admin-product-copy"><div class="row-title"><b>{{ $product->name }}</b>@if(!$product->is_active)<span class="status neutral">Nonaktif</span>@endif</div><small>{{ $product->categories->pluck('name')->implode(', ') }} · {{ $product->variants_count }} varian · {{ $product->quantity_mode==='multiple'?'Qty bebas':'Max 1' }}</small></div>
    <div class="row-actions"><a class="button ghost small" href="{{ route('admin.products.edit',$product) }}">Edit</a></div>
</article>
@empty<div class="admin-empty">Belum ada produk. Tambahkan produk pertama kamu.</div>@endforelse
</div>
@endsection
