# Pinky Pricelist v1.0.2

Website katalog/pricelist aplikasi premium dengan desain pink-cute, mobile-first, flexible variants, cart-to-WhatsApp, dan panel admin yang nyaman dipakai dari HP.

## Fitur v1.0.2

### Customer
- Katalog responsive, mobile-first.
- Search nama produk, kategori, keyword, nama opsi, dan pilihan opsi.
- Filter kategori.
- Flexible/dependent variants (contoh: Tipe + Durasi, hanya kombinasi valid yang aktif).
- Harga normal + harga promo.
- Ready / Sold Out per varian.
- Quantity per produk: `multiple` (default) atau `single`.
- Beli langsung ke WhatsApp dengan pesan otomatis.
- Keranjang multi-produk, subtotal/total, quantity, dan pesan list ke WhatsApp.
- Cart disimpan di Local Storage, tanpa login customer.
- Card katalog memakai harga termurah dari varian **Ready**, bukan varian Sold Out.
- Status Ready/Sold Out terlihat langsung pada card produk.
- Item keranjang dapat dipilih/dibatalkan satu per satu sebelum dikirim ke WhatsApp.
- Semua item Ready terpilih secara default; item Sold Out tidak dapat dipilih.
- Total checkout mengikuti item yang dipilih saja.
- Setelah checkout WhatsApp ditekan, item yang dipilih otomatis dikeluarkan dari keranjang; item lain tetap tersimpan.
- Asset root-relative + trusted proxy agar CSS/JS/storage aman saat dibuka melalui ngrok HTTPS.

### Admin
- Login 1 owner/admin.
- Dashboard ringkas.
- CRUD produk + upload gambar.
- Produk Aktif/Nonaktif.
- Multi-kategori per produk.
- Opsi custom dan value custom.
- Kombinasi varian fleksibel.
- Quick Edit Harga + Promo + Ready/Sold Out.
- Kategori editable.
- Drag & drop produk dan kategori, termasuk touchscreen.
- Pengaturan nama toko, tagline, hero, nomor WhatsApp.
- Template pesan WhatsApp editable dengan placeholder.
- Bottom navigation khusus mobile.
- Quick Edit mendeteksi perubahan dan baru mengaktifkan tombol Simpan saat ada edit.
- Gambar produk dan logo toko dapat diganti atau dihapus langsung dari form.
- Konfirmasi hapus memakai dialog custom yang konsisten dengan UI, bukan dialog browser native.

## Stack

- PHP 8.3+
- Laravel 13.x
- Blade
- Vanilla JavaScript
- Custom responsive CSS (tanpa dependency frontend runtime)
- MySQL / MariaDB

Tidak ada proses `npm run build` untuk baseline ini karena asset CSS/JS sudah berupa file production-ready di `public/assets`.

## Instalasi

```bash
composer update
cp .env.example .env
php artisan key:generate
```

Buat database MySQL lalu edit `.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainkamu.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database

ADMIN_NAME="Owner"
ADMIN_EMAIL=owner@email.com
ADMIN_PASSWORD="password-awal-yang-kuat"
```

Lalu jalankan:

```bash
php artisan migrate --seed
php artisan storage:link
php artisan optimize
```

> Seeder membuat sample produk agar UI langsung dapat diuji. Sample tersebut bebas diedit/hapus dari admin.

## Login Awal Admin

Akun admin dibuat dari `.env` saat `php artisan migrate --seed` dijalankan:

- Email: `ADMIN_EMAIL`
- Password: `ADMIN_PASSWORD`

Default `.env.example` hanya untuk development. **Ubah credential sebelum deployment production.**

## Pengaturan WhatsApp

Default storefront v1.0.2 memakai nama `@anyptime list` dan nomor `+62 813-2628-586`. Keduanya tetap dapat diubah dari admin.


Setelah login buka:

`Admin > Pengaturan`

Ubah:
- nomor WhatsApp (format `62...`, tanpa `+`),
- teks pembuka,
- teks penutup,
- template Beli Sekarang,
- template Keranjang.

Placeholder yang tersedia:

### Beli Sekarang
- `{opening}`
- `{product}`
- `{variant_lines}`
- `{quantity}`
- `{price_line}`
- `{subtotal}`
- `{closing}`

### Keranjang
- `{opening}`
- `{items}`
- `{total}`
- `{closing}`

## Hosting / Document Root

Untuk keamanan, document root domain harus diarahkan ke folder:

```text
/project/public
```

Jangan membuka root project Laravel langsung ke publik.

Pastikan folder berikut writable:

```bash
chmod -R 775 storage bootstrap/cache
```

Jika `storage:link` belum ada:

```bash
php artisan storage:link
```

## Production Refresh

Setelah perubahan source:

```bash
php artisan optimize:clear
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize
```

## Struktur Data Utama

- `categories`
- `products`
- `category_product`
- `product_options`
- `product_option_values`
- `product_variants`
- `product_variant_values`
- `store_settings`

Cart customer tidak disimpan ke database; cart berada di browser customer menggunakan Local Storage.

## Catatan SEO

Pricelist default memakai:

```html
<meta name="robots" content="noindex,nofollow">
```

karena requirement saat ini hanya sebagai link pricelist, bukan website yang ditargetkan masuk Google Search. Hapus/ubah meta tersebut jika nantinya ingin diindeks.

## Dokumen

PRD lengkap tersedia di `docs/PRD.md`.
