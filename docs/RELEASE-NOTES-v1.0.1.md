# v1.0.1 — Responsive UI & Catalog Hardening

Tanggal: 12 September 2026

## Perubahan

- Memperbaiki header/brand agar tidak membungkus atau bertabrakan di layar HP sempit.
- Hero storefront dibuat lebih compact dan proporsional tanpa heading berukuran berlebihan.
- Mengubah visual ke solid soft-pink surfaces; tidak bergantung pada gradient/glass effect.
- Card produk sekarang memakai harga termurah dari varian yang berstatus `Ready`.
- Card menampilkan indikator `Ready` / `Sold Out` agar status terlihat sebelum detail dibuka.
- Menambah kemampuan hapus gambar produk serta hapus logo toko dari panel admin.
- Quick Edit Harga mendeteksi perubahan dan memberi status unsaved changes.
- Konfirmasi aksi destruktif admin memakai dialog custom.
- Feedback drag & drop memakai toast custom dan tidak lagi memakai `alert()` browser.
- Menaikkan ukuran label admin yang terlalu kecil untuk meningkatkan keterbacaan mobile.
- Asset cache-busting dinaikkan ke `v1.0.1`.
- Login admin diberi rate limit untuk mengurangi brute-force sederhana.

Tidak ada migration baru. Upgrade dari v1.0.0 cukup mengganti file patch dan menjalankan `php artisan optimize:clear`.
