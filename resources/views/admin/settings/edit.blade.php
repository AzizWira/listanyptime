@extends('layouts.admin')
@php
$singleDefault = "{opening}\n\n{product}\n{variant_lines}\nQty: {quantity}\nHarga: {price_line}\nSubtotal: {subtotal}\n\n{closing}";
$cartDefault = "{opening}\n\n{items}\n\nTotal: {total}\n\n{closing}";
@endphp
@section('title','Pengaturan') @section('page-title','Pengaturan Toko') @section('eyebrow','TOKO & WHATSAPP')
@section('content')
<form method="post" action="{{ route('admin.settings.update') }}" class="settings-stack" enctype="multipart/form-data">@csrf @method('PUT')
<section class="section-card"><div class="section-head compact"><div><span class="kicker">IDENTITAS TOKO</span><h2>Tampilan pricelist</h2></div></div><div class="form-grid two">
<label class="field"><span>Nama toko *</span><input name="store_name" value="{{ old('store_name',$settings['store_name']??'@anyptime list') }}" required></label>
<label class="field"><span>Tagline *</span><input name="tagline" value="{{ old('tagline',$settings['tagline']??'Premium apps, harga manis 🎀') }}" required></label>
<label class="field span-2"><span>Teks hero</span><textarea name="hero_text" rows="3">{{ old('hero_text',$settings['hero_text']??'Cari paket premium favoritmu, pilih variannya, lalu lanjut order lewat WhatsApp.') }}</textarea></label>
<label class="field span-2"><span>Logo toko <small>(opsional)</small></span><input type="file" name="logo" accept="image/png,image/jpeg,image/webp" data-image-input data-preview-target="#storeLogoPreview"><small>JPG/PNG/WebP, maks. 2 MB.</small></label>
<div class="image-tools"><div class="image-preview" id="storeLogoPreview" data-image-preview>@if(!empty($settings['logo_path']))<img src="/storage/{{ $settings['logo_path'] }}" alt="Logo toko">@else<span>Preview logo</span>@endif</div>@if(!empty($settings['logo_path']))<label class="remove-media"><input type="checkbox" name="remove_logo" value="1"><span>Hapus logo saat disimpan</span></label>@endif</div>
</div></section>
<section class="section-card"><div class="section-head compact"><div><span class="kicker">WHATSAPP</span><h2>Nomor & kalimat default</h2><p>Gunakan format 62 tanpa tanda +, contoh 628132628586.</p></div></div><div class="form-grid two">
<label class="field"><span>Nomor WhatsApp *</span><input name="whatsapp_number" value="{{ old('whatsapp_number',$settings['whatsapp_number']??'628132628586') }}" required inputmode="numeric"></label><span></span>
<label class="field"><span>Teks pembuka *</span><textarea name="whatsapp_opening" rows="3" required>{{ old('whatsapp_opening',$settings['whatsapp_opening']??'Halo kak, saya mau order:') }}</textarea></label>
<label class="field"><span>Teks penutup *</span><textarea name="whatsapp_closing" rows="3" required>{{ old('whatsapp_closing',$settings['whatsapp_closing']??'Mohon dibantu proses ya kak, terima kasih.') }}</textarea></label>
</div></section>
<section class="section-card"><div class="section-head compact"><div><span class="kicker">FORMAT PESAN</span><h2>Template yang dikirim customer</h2><p>Kamu boleh mengubah kalimat, tapi pertahankan placeholder yang diperlukan.</p></div></div>
<div class="template-help"><b>Placeholder beli langsung:</b> {opening}, {product}, {variant_lines}, {quantity}, {price_line}, {subtotal}, {closing}<br><b>Placeholder keranjang:</b> {opening}, {items}, {total}, {closing}</div>
<div class="form-grid two"><label class="field"><span>Template Beli Sekarang</span><textarea name="whatsapp_single_template" rows="10" required>{{ old('whatsapp_single_template',$settings['whatsapp_single_template']??$singleDefault) }}</textarea></label><label class="field"><span>Template Keranjang</span><textarea name="whatsapp_cart_template" rows="10" required>{{ old('whatsapp_cart_template',$settings['whatsapp_cart_template']??$cartDefault) }}</textarea></label></div></section>
<div class="sticky-save"><span>Perubahan langsung dipakai pricelist.</span><button class="button primary" type="submit">Simpan Pengaturan</button></div></form>
@endsection
