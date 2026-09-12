# Product Requirements Document (PRD)
## Website Katalog & Pricelist Aplikasi Premium

**Versi Dokumen:** 1.0  
**Status:** Draft Final Requirement  
**Tipe Produk:** Website Pricelist Interaktif + Mobile Admin Panel  
**Target Pengguna:** Customer dan 1 Owner/Admin  
**Platform:** Web responsive, mobile-first  
**Tujuan Utama:** Menampilkan daftar harga aplikasi premium secara menarik, mudah dicari, mudah dipilih, dan mudah diperbarui oleh owner melalui HP.

---

# 1. Ringkasan Produk

Website ini merupakan **website katalog dan pricelist aplikasi premium**, bukan website e-commerce penuh.

Customer dapat:
- melihat daftar aplikasi premium,
- mencari produk dengan search,
- memfilter produk berdasarkan kategori,
- membuka detail produk,
- memilih kombinasi varian seperti tipe akun, durasi, device, atau opsi lainnya,
- menentukan quantity jika produk mengizinkan,
- menambahkan produk ke keranjang,
- membeli satu produk langsung melalui WhatsApp,
- atau mengirim seluruh isi keranjang ke WhatsApp dalam format pesan otomatis.

Seluruh transaksi, pembayaran, konfirmasi, dan proses lanjutan tetap dilakukan melalui WhatsApp.

Owner memiliki **Admin Panel yang mobile-first** agar dapat mengubah harga, varian, status, kategori, gambar, promo, urutan produk, dan pengaturan WhatsApp langsung dari HP tanpa mengubah source code.

---

# 2. Latar Belakang

Owner menjual berbagai aplikasi premium dengan harga dan paket yang dapat berubah cukup sering.

Pricelist yang hanya berupa gambar, spreadsheet, atau chat memiliki beberapa keterbatasan:
- customer sulit mencari produk tertentu,
- daftar harga menjadi panjang dan sulit dibaca,
- perubahan harga harus mengedit ulang media pricelist,
- pilihan produk dapat memiliki banyak kombinasi,
- owner membutuhkan cara yang cepat untuk memperbarui harga melalui HP.

Website ini dibuat sebagai **pusat pricelist digital** yang ringan, mudah digunakan, dan dapat dibagikan melalui link langsung.

Website tidak difokuskan untuk SEO atau pencarian Google. Fungsi utamanya adalah sebagai halaman pricelist yang dibuka melalui link dari WhatsApp, Instagram, TikTok, atau media lainnya.

---

# 3. Tujuan Produk

## 3.1 Tujuan Utama

1. Membuat pricelist aplikasi premium yang lebih modern dan mudah digunakan.
2. Memudahkan customer mencari produk dan melihat seluruh pilihan paket.
3. Menyederhanakan proses pemilihan produk sebelum customer diarahkan ke WhatsApp.
4. Mempermudah owner memperbarui harga setiap hari melalui HP.
5. Mengurangi kebutuhan owner mengedit pricelist secara manual dalam bentuk gambar atau dokumen.
6. Menyediakan struktur produk yang fleksibel untuk berbagai tipe aplikasi premium.

## 3.2 Indikator Keberhasilan

Produk dianggap berhasil apabila:
- owner dapat mengubah harga melalui HP tanpa menyentuh source code,
- customer dapat menemukan produk melalui search,
- customer dapat memilih kombinasi varian yang valid,
- customer dapat menambahkan beberapa produk ke keranjang,
- sistem dapat membuat pesan WhatsApp otomatis berdasarkan produk yang dipilih,
- owner dapat mengatur seluruh produk melalui satu panel admin.

---

# 4. Ruang Lingkup Produk

## 4.1 In Scope

Website mencakup:

### Customer
- Homepage / katalog produk.
- Search produk.
- Filter kategori.
- Detail produk.
- Pemilihan varian produk.
- Harga normal dan harga promo.
- Status Ready / Sold Out.
- Quantity.
- Keranjang.
- Tombol Beli Sekarang.
- Tombol Tambah ke Keranjang.
- Tombol Pesan Semua via WhatsApp.
- Pesan WhatsApp otomatis.
- Penyimpanan keranjang secara lokal di browser.
- Tampilan responsive dan mobile-first.

### Admin
- Login admin.
- Dashboard sederhana.
- Kelola produk.
- Kelola kategori.
- Kelola opsi produk.
- Kelola varian produk.
- Kelola harga.
- Kelola harga promo.
- Kelola status Ready / Sold Out.
- Kelola status Aktif / Nonaktif.
- Kelola gambar produk.
- Kelola badge produk.
- Kelola keyword pencarian.
- Kelola quantity rule.
- Drag & drop urutan produk.
- Drag & drop urutan kategori.
- Quick Edit harga.
- Kelola nomor WhatsApp.
- Kelola template pesan WhatsApp.
- Kelola informasi dasar toko.

## 4.2 Out of Scope

Versi awal tidak mencakup:
- login customer,
- registrasi customer,
- akun customer,
- payment gateway,
- pembayaran online,
- invoice,
- receipt,
- order management,
- tracking order,
- histori transaksi customer,
- dashboard customer,
- stok berbasis angka,
- pengiriman,
- integrasi kurir,
- sistem reseller,
- multi-owner,
- multi-store,
- marketplace,
- Google Search Console sebagai kebutuhan utama,
- SEO kompleks,
- checkout transaksi di dalam website.

---

# 5. Target Pengguna

## 5.1 Customer

Customer merupakan pengguna umum yang mengakses website melalui link.

Customer tidak perlu login.

Tujuan customer:
- mencari aplikasi,
- melihat harga,
- membandingkan pilihan,
- memilih varian,
- menentukan jumlah,
- mengirim pesanan ke WhatsApp.

## 5.2 Admin / Owner

Jumlah admin: **1 orang**.

Admin menggunakan website terutama melalui smartphone.

Tujuan admin:
- memperbarui harga dengan cepat,
- menambah produk,
- menambah paket,
- mengubah varian,
- menandai produk Ready / Sold Out,
- mengatur promo,
- mengubah kategori,
- mengubah gambar,
- mengatur urutan tampilan,
- mengubah template WhatsApp.

---

# 6. Konsep Desain

## 6.1 Arah Visual

Tema utama:
- pink,
- cute,
- feminine,
- soft,
- bersih,
- modern,
- ringan.

Desain tidak boleh terlalu ramai atau terlihat seperti website anak-anak.

Rekomendasi arah visual:
- soft pink,
- blush pink,
- cream,
- putih,
- dusty rose,
- elemen dekoratif kecil seperti ribbon, heart, star, flower, atau sparkle.

## 6.2 Prinsip UX

- Mobile-first.
- Navigasi sederhana.
- Search mudah ditemukan.
- Produk mudah dibaca.
- Harga menjadi informasi utama.
- Tombol WhatsApp jelas.
- Tidak ada proses checkout kompleks.
- Tidak ada form customer yang tidak diperlukan.
- Semua aksi admin harus nyaman dari HP.

---

# 7. Struktur Halaman Customer

## 7.1 Homepage / Pricelist

Isi utama:

### Header
- Logo / nama toko.
- Tombol/menu kategori jika diperlukan.
- Tombol keranjang.
- Opsional: tombol WhatsApp.

### Hero
Contoh:
> Premium Apps, Harga Ramah Kantong 🎀

Dapat berisi:
- nama toko,
- tagline,
- info singkat,
- banner promo.

### Search
Search tersedia di area yang mudah terlihat.

Placeholder contoh:
> Cari Canva, Netflix, Spotify, 1 bulan...

### Filter Kategori
Contoh:
- Semua
- Streaming
- Design
- Music
- Productivity
- AI
- Lainnya

Kategori dibuat dan diatur oleh admin.

### Daftar Produk
Card produk minimal menampilkan:
- gambar/icon,
- nama produk,
- kategori,
- harga mulai dari,
- badge,
- status,
- tombol Lihat Pilihan.

Contoh:

**Canva Premium**  
Design & Productivity  
Mulai dari **Rp5.000**  
`Best Seller`

[Lihat Pilihan]

---

# 8. Search dan Filter

## 8.1 Search

Search harus dapat menemukan produk berdasarkan beberapa sumber data.

Minimal searchable:
- nama produk,
- kategori,
- nama opsi,
- value opsi,
- keyword tambahan,
- nama varian,
- deskripsi singkat.

Contoh pencarian:
- Canva
- 1 bulan
- Designer
- Streaming
- Android
- Private

Search harus nyaman digunakan dari mobile.

## 8.2 Filter Kategori

Customer dapat memfilter produk berdasarkan kategori.

Satu produk minimal memiliki satu kategori utama.

Jika implementasi mendukung multi-category, satu produk dapat dimasukkan ke lebih dari satu kategori.

Kategori dapat:
- dibuat,
- diedit,
- dihapus,
- diaktifkan/nonaktifkan,
- diurutkan melalui drag & drop.

---

# 9. Sistem Produk

## 9.1 Data Dasar Produk

Setiap produk minimal memiliki:

- Nama produk.
- Slug/internal identifier otomatis.
- Gambar/icon produk.
- Kategori.
- Deskripsi singkat.
- Deskripsi lengkap opsional.
- Keyword pencarian.
- Badge opsional.
- Status Aktif / Nonaktif.
- Aturan quantity.
- Posisi urutan.
- Tanggal dibuat.
- Tanggal diperbarui.

## 9.2 Status Aktif / Nonaktif

### Aktif
Produk tampil pada website customer.

### Nonaktif
Produk disembunyikan dari website customer tanpa harus dihapus.

Fitur ini digunakan jika:
- produk dihentikan sementara,
- supplier sedang tidak tersedia,
- owner ingin menyimpan data produk untuk dipakai lagi.

---

# 10. Kategori Produk

Admin dapat:
- tambah kategori,
- edit nama kategori,
- ubah icon jika digunakan,
- aktif/nonaktifkan kategori,
- hapus kategori jika tidak digunakan,
- mengurutkan kategori melalui drag & drop.

Contoh:
- Streaming
- Music
- Design
- AI
- Productivity
- Education
- Entertainment

---

# 11. Sistem Opsi dan Varian Produk

## 11.1 Konsep

Produk tidak menggunakan struktur harga tunggal.

Satu produk dapat memiliki beberapa jenis pilihan.

Contoh Canva:

**Tipe**
- Member
- Designer

**Durasi**
- 1 Hari
- 1 Minggu
- 1 Bulan

Namun tidak semua kombinasi harus tersedia.

Contoh kombinasi valid:

| Tipe | Durasi | Harga |
|---|---|---:|
| Member | 1 Hari | Rp5.000 |
| Member | 1 Minggu | Rp10.000 |
| Member | 1 Bulan | Rp20.000 |
| Designer | 1 Minggu | Rp15.000 |
| Designer | 1 Bulan | Rp25.000 |

Designer 1 Hari tidak tersedia dan tidak boleh dianggap sebagai produk valid.

## 11.2 Opsi Harus Fleksibel

Field tidak boleh dibuat hardcoded hanya sebagai:
- Durasi,
- Account Type.

Admin harus dapat membuat nama opsi sendiri.

Contoh produk lain:

**Netflix**
- Jenis: Sharing / Private
- Durasi: 1 Bulan / 3 Bulan

**Aplikasi X**
- Device: Android / iOS
- Paket: Basic / Premium

**Aplikasi Y**
- User: 1 User / 2 User
- Durasi: 1 Bulan / 1 Tahun

## 11.3 Variant Combination

Setelah membuat opsi dan value, admin menentukan kombinasi yang benar-benar dijual.

Setiap kombinasi memiliki:
- harga normal,
- harga promo opsional,
- status Ready / Sold Out,
- SKU/internal identifier opsional,
- posisi urutan opsional.

---

# 12. Harga

## 12.1 Harga Normal

Setiap kombinasi varian wajib memiliki harga normal.

## 12.2 Harga Promo

Harga promo bersifat opsional.

Jika harga promo diisi:
- website menampilkan harga normal dicoret,
- website menampilkan harga promo sebagai harga utama.

Contoh:

~~Rp25.000~~  
**Rp18.000**

Jika harga promo kosong:
- hanya harga normal yang tampil.

## 12.3 Harga Mulai Dari

Card produk dapat menampilkan harga termurah dari seluruh varian yang sedang aktif.

Contoh:
> Mulai dari Rp5.000

Harga promo dapat dijadikan acuan harga termurah jika sedang aktif.

---

# 13. Status Ready / Sold Out

Status diterapkan pada setiap kombinasi varian.

Contoh:

Canva:
- Member + 1 Hari → Ready
- Member + 1 Bulan → Ready
- Designer + 1 Bulan → Sold Out

Jika varian Sold Out:
- tetap boleh ditampilkan,
- tidak dapat dibeli,
- tidak dapat ditambahkan ke keranjang,
- diberi penanda Sold Out.

---

# 14. Quantity

## 14.1 Aturan Quantity Per Produk

Saat admin membuat atau mengedit produk, admin wajib memilih aturan pembelian:

### Opsi 1 — Bisa membeli beberapa
Default.

Customer dapat menentukan quantity:
- 1
- 2
- 3
- dan seterusnya.

### Opsi 2 — Hanya 1 per pesanan
Quantity dikunci pada 1.

## 14.2 Default

Default produk baru:
> **Bisa membeli beberapa**

## 14.3 UI Admin

Gunakan bahasa natural.

Contoh:

**Pembelian Produk**

- Bisa membeli beberapa
- Hanya 1 per pesanan

Hindari istilah teknis seperti `allow_quantity`.

## 14.4 UI Customer

Jika produk mendukung quantity:
> `−   2   +`

Jika produk hanya boleh 1:
- quantity tidak perlu ditampilkan sebagai input,
- otomatis bernilai 1.

---

# 15. Detail Produk

Halaman/modal detail produk menampilkan:

- gambar produk,
- nama,
- kategori,
- badge,
- deskripsi,
- pilihan opsi,
- harga,
- harga promo jika ada,
- status Ready / Sold Out,
- quantity jika diperbolehkan,
- tombol Beli Sekarang,
- tombol Tambah ke Keranjang.

Contoh:

## Canva Premium

**Tipe**  
[Member] [Designer]

**Durasi**  
[1 Hari] [1 Minggu] [1 Bulan]

**Harga**  
Rp25.000

**Status**  
Ready

Quantity:  
`− 1 +`

[Beli Sekarang]  
[+ Keranjang]

---

# 16. Dependent Variant Selection

Pilihan varian harus mengikuti kombinasi yang tersedia.

Contoh:

Jika:
- Member tersedia untuk 1 Hari, 1 Minggu, 1 Bulan.
- Designer hanya tersedia untuk 1 Minggu dan 1 Bulan.

Ketika customer memilih Designer:
- 1 Hari harus otomatis disabled / tidak dapat dipilih,
- hanya 1 Minggu dan 1 Bulan yang tersedia.

Website tidak boleh membentuk kombinasi yang tidak dibuat oleh admin.

---

# 17. Keranjang

## 17.1 Fungsi

Customer dapat memasukkan beberapa produk ke keranjang.

Contoh:
- Canva,
- VIU,
- Zoom.

Keranjang bukan checkout transaksi.

Keranjang hanya digunakan untuk:
- mengumpulkan pilihan,
- menghitung subtotal,
- membuat pesan WhatsApp.

## 17.2 Data Item Keranjang

Setiap item menyimpan:
- produk,
- pilihan varian,
- harga satuan,
- quantity,
- subtotal.

## 17.3 Quantity di Keranjang

Jika produk memperbolehkan quantity:
- customer dapat menambah/mengurangi quantity.

Jika produk dibatasi satu:
- quantity tetap 1.

## 17.4 Total

Sistem menampilkan:
- subtotal per item,
- total seluruh item.

## 17.5 Persistence

Keranjang disimpan pada browser menggunakan local storage atau teknologi setara.

Tujuan:
- keranjang tidak hilang saat refresh,
- customer dapat keluar sebentar lalu kembali.

Tidak diperlukan akun customer.

---

# 18. Beli Sekarang

Tombol **Beli Sekarang** digunakan untuk satu produk/varian.

Alur:

1. Customer memilih produk.
2. Customer memilih kombinasi varian.
3. Customer memilih quantity jika tersedia.
4. Customer klik Beli Sekarang.
5. Sistem generate pesan WhatsApp.
6. Customer diarahkan ke WhatsApp.

Contoh pesan:

Halo kak, saya mau order:

Canva Premium  
Tipe: Designer  
Durasi: 1 Bulan  
Qty: 2  
Harga: Rp25.000 x 2  
Subtotal: Rp50.000

Terima kasih.

---

# 19. Checkout Keranjang ke WhatsApp

Keranjang memiliki tombol:

> **Pesan Semua via WhatsApp**

Sistem membuat pesan otomatis.

Contoh:

Halo kak, saya mau order:

1. Canva Premium
- Designer
- 1 Bulan
- Qty: 3
- Rp25.000 x 3 = Rp75.000

2. VIU Premium
- Private
- 1 Bulan
- Qty: 1
- Rp15.000

3. Zoom Pro
- 1 Bulan
- Qty: 1
- Rp30.000

Total: Rp120.000

Terima kasih.

Setelah itu customer diarahkan ke nomor WhatsApp owner.

---

# 20. WhatsApp Configuration

Admin dapat mengubah:

- nomor WhatsApp,
- teks pembuka,
- teks penutup,
- template pesan beli langsung,
- template pesan keranjang.

Contoh setting:

**Teks Pembuka**
> Halo kak, saya mau order:

**Teks Penutup**
> Mohon dibantu proses ya kak, terima kasih 🎀

Template harus memiliki placeholder yang dapat diisi otomatis oleh sistem.

Contoh placeholder potensial:
- `{product_name}`
- `{variant}`
- `{quantity}`
- `{price}`
- `{subtotal}`
- `{cart_items}`
- `{total}`

Admin tidak perlu memahami syntax teknis yang kompleks.

Jika menggunakan placeholder, UI admin harus menyediakan bantuan/daftar placeholder yang tersedia.

---

# 21. Badge Produk

Admin dapat memberikan badge.

Contoh:
- Best Seller
- Promo
- New
- Recommended
- Hot
- Limited

Badge bersifat opsional.

Versi awal dapat menggunakan:
- predefined badge,
atau
- custom text badge.

---

# 22. Gambar Produk

Admin dapat:
- upload gambar dari HP,
- mengganti gambar,
- menghapus gambar,
- preview gambar sebelum simpan.

Gambar dapat berupa:
- icon aplikasi,
- logo,
- artwork custom.

Upload harus nyaman melalui mobile browser.

---

# 23. Urutan Produk Drag & Drop

Admin dapat mengatur urutan produk tanpa memasukkan angka posisi secara manual.

UI contoh:

☰ Canva  
☰ Netflix  
☰ VIU  
☰ Spotify  
☰ Zoom

Admin dapat:
- tekan,
- tahan,
- geser,
- lepas.

Urutan tersimpan otomatis atau melalui tombol Simpan.

Drag & drop harus mendukung:
- desktop mouse,
- mobile touchscreen.

---

# 24. Urutan Kategori Drag & Drop

Kategori juga dapat diurutkan menggunakan metode serupa.

Contoh:

☰ Streaming  
☰ Design  
☰ Music  
☰ AI  
☰ Productivity

---

# 25. Admin Panel

## 25.1 Prinsip

Admin Panel harus:
- mobile-first,
- ringan,
- tidak terlihat seperti dashboard enterprise,
- mudah digunakan oleh owner non-teknis.

Menu utama yang direkomendasikan:

- Dashboard
- Produk
- Quick Edit Harga
- Kategori
- Urutan Produk
- Pengaturan WhatsApp
- Pengaturan Toko
- Logout

---

# 26. Dashboard Admin

Dashboard cukup sederhana.

Informasi opsional:
- jumlah produk aktif,
- jumlah produk Sold Out,
- jumlah kategori,
- produk terakhir diperbarui,
- shortcut Tambah Produk,
- shortcut Edit Harga.

Tidak perlu analytics kompleks pada versi awal.

---

# 27. Kelola Produk

Admin dapat:
- tambah,
- edit,
- duplikat jika diperlukan,
- aktif/nonaktifkan,
- hapus.

Form produk:

## Informasi Dasar
- Nama.
- Gambar.
- Kategori.
- Deskripsi.
- Keyword.
- Badge.

## Aturan Pembelian
- Bisa membeli beberapa.
- Hanya 1 per pesanan.

Default:
> Bisa membeli beberapa.

## Status
- Aktif.
- Nonaktif.

## Opsi dan Varian
- Tambah opsi.
- Tambah value.
- Bentuk kombinasi varian.
- Isi harga.
- Isi promo.
- Set Ready / Sold Out.

---

# 28. Quick Edit Harga

Fitur ini menjadi salah satu fitur utama admin karena harga dapat berubah setiap hari.

Admin tidak perlu membuka edit produk satu per satu.

Contoh halaman:

## Canva

Member · 1 Hari  
Harga: [Rp5.000]  
Promo: [Kosong]  
Status: [Ready]

Member · 1 Bulan  
Harga: [Rp15.000]  
Promo: [Rp12.000]  
Status: [Ready]

Designer · 1 Bulan  
Harga: [Rp25.000]  
Promo: [Kosong]  
Status: [Sold Out]

[Simpan Perubahan]

Quick Edit harus nyaman melalui HP.

Fitur pendukung:
- search produk,
- filter kategori,
- collapse/expand produk,
- tombol simpan yang jelas.

---

# 29. Kelola Kategori

Admin dapat:
- tambah,
- edit,
- hapus,
- aktif/nonaktif,
- drag & drop urutan.

Kategori yang memiliki produk harus diproteksi saat dihapus.

Sistem dapat:
- meminta admin memindahkan produk,
atau
- menolak penghapusan hingga kategori kosong.

---

# 30. Pengaturan Toko

Admin dapat mengatur informasi dasar seperti:

- nama toko,
- logo,
- tagline,
- deskripsi singkat,
- nomor WhatsApp,
- teks header,
- teks footer,
- link sosial media opsional.

---

# 31. Responsive Design

Website harus optimal untuk:

- smartphone,
- tablet,
- laptop,
- desktop.

Prioritas:
> smartphone.

## Customer
Search, filter, card produk, pilihan varian, quantity, dan keranjang harus nyaman digunakan satu tangan.

## Admin
Semua form harus nyaman di layar kecil.

Tidak boleh bergantung pada tabel desktop lebar untuk operasi utama.

---

# 32. Empty State dan Error State

Sistem harus memiliki tampilan yang jelas ketika:

### Search tidak ditemukan
> Produk yang kamu cari belum tersedia 🎀

### Kategori kosong
> Belum ada produk di kategori ini.

### Keranjang kosong
> Keranjang kamu masih kosong.

### Produk Sold Out
> Paket ini sedang Sold Out.

### Produk tidak aktif
Tidak ditampilkan ke customer.

---

# 33. Validasi

Contoh validasi:

## Produk
- nama wajib,
- kategori wajib,
- aturan quantity wajib.

## Variant
- kombinasi tidak boleh duplikat,
- harga wajib,
- harga tidak boleh negatif,
- harga promo tidak boleh negatif.

## WhatsApp
- nomor WhatsApp wajib valid.

## Image
- hanya format gambar yang diizinkan,
- ukuran file dibatasi.

---

# 34. Keamanan

Minimal:
- halaman admin wajib login,
- password disimpan secara aman,
- CSRF protection,
- validasi input server-side,
- upload file divalidasi,
- akses admin diproteksi middleware/auth,
- session admin aman,
- rate limiting login direkomendasikan.

Karena hanya terdapat satu admin, sistem role/permission kompleks tidak diperlukan.

---

# 35. Performance

Website customer harus ringan.

Rekomendasi:
- optimasi gambar,
- lazy loading gambar,
- asset minification,
- caching yang sesuai,
- query database efisien.

Target utama:
- homepage cepat dibuka dari mobile network,
- search terasa responsif,
- perubahan varian tidak memerlukan reload halaman penuh.

---

# 36. SEO

SEO bukan fokus utama.

Website tidak dirancang sebagai portal yang bergantung pada Google Search.

Minimal:
- title halaman,
- meta description dasar,
- favicon,
- Open Graph agar link terlihat rapi saat dibagikan.

Google Search Console tidak menjadi requirement wajib.

Jika owner ingin website tidak terindeks, dapat dipertimbangkan:
- meta robots noindex,
- robots configuration.

Keputusan final dapat dibuat saat deployment.

---

# 37. Struktur Data Konseptual

## 37.1 Admin
- id
- name
- email/username
- password

## 37.2 Categories
- id
- name
- slug
- image/icon optional
- is_active
- sort_order

## 37.3 Products
- id
- category_id / relation
- name
- slug
- description
- image
- keywords
- badge
- quantity_mode
- is_active
- sort_order
- timestamps

`quantity_mode`:
- multiple
- single

Default:
- multiple

## 37.4 Product Options
Contoh:
- Tipe
- Durasi
- Device

Field:
- id
- product_id
- name
- sort_order

## 37.5 Option Values
Contoh:
- Member
- Designer
- 1 Hari
- 1 Bulan

Field:
- id
- product_option_id
- value
- sort_order

## 37.6 Product Variants
Mewakili kombinasi yang benar-benar dijual.

Field:
- id
- product_id
- regular_price
- promo_price nullable
- availability_status
- sku optional
- sort_order

## 37.7 Variant Option Values
Pivot relasi:
- variant_id
- option_value_id

## 37.8 Store Settings
- store_name
- logo
- tagline
- whatsapp_number
- whatsapp_single_template
- whatsapp_cart_template
- whatsapp_opening
- whatsapp_closing
- social_links
- additional settings

Keranjang customer tidak wajib disimpan ke database karena dapat menggunakan local storage.

---

# 38. User Flow Customer

## 38.1 Beli Satu Produk

Homepage  
→ Search / pilih kategori  
→ Pilih produk  
→ Buka detail  
→ Pilih opsi  
→ Pilih varian  
→ Pilih quantity  
→ Beli Sekarang  
→ Generate WhatsApp  
→ Buka WhatsApp.

## 38.2 Menggunakan Keranjang

Homepage  
→ Pilih produk  
→ Pilih varian  
→ Pilih quantity  
→ Tambah ke Keranjang  
→ Cari produk lain  
→ Tambah lagi  
→ Buka Keranjang  
→ Review item  
→ Ubah quantity jika diperbolehkan  
→ Pesan Semua via WhatsApp  
→ Generate list  
→ Buka WhatsApp.

---

# 39. User Flow Admin

## 39.1 Ubah Harga Cepat

Login  
→ Quick Edit Harga  
→ Cari produk  
→ Ubah harga  
→ Ubah promo/status jika perlu  
→ Simpan.

## 39.2 Tambah Produk

Login  
→ Produk  
→ Tambah Produk  
→ Isi informasi  
→ Pilih kategori  
→ Upload gambar  
→ Tentukan quantity mode  
→ Tambah opsi  
→ Tambah value  
→ Buat kombinasi varian  
→ Isi harga  
→ Set Ready/Sold Out  
→ Simpan.

## 39.3 Ubah Urutan

Login  
→ Urutan Produk  
→ Drag & drop  
→ Simpan.

---

# 40. Acceptance Criteria Utama

## Customer

### Search
- Customer dapat mencari produk berdasarkan nama.
- Customer dapat mencari berdasarkan keyword paket.
- Hasil berubah sesuai pencarian.

### Kategori
- Customer dapat memilih kategori.
- Hanya produk sesuai kategori yang tampil.

### Varian
- Hanya kombinasi valid yang dapat dipilih.
- Kombinasi tidak valid disabled/tidak ditampilkan.
- Harga berubah sesuai varian.

### Quantity
- Produk multiple dapat qty > 1.
- Produk single selalu qty 1.

### Cart
- Customer dapat menambah beberapa produk.
- Quantity dapat diubah sesuai aturan.
- Total dihitung otomatis.
- Cart tetap ada setelah refresh.

### WhatsApp
- Beli langsung menghasilkan format pesan produk.
- Keranjang menghasilkan list item.
- Total sesuai dengan isi keranjang.
- Nomor WA menggunakan setting admin.

## Admin

### Produk
- Admin dapat tambah/edit/nonaktif/hapus produk.
- Admin dapat upload gambar.

### Variant
- Admin dapat membuat opsi custom.
- Admin dapat membuat value custom.
- Admin dapat menentukan kombinasi valid.

### Harga
- Admin dapat mengubah harga.
- Admin dapat mengubah promo.
- Quick Edit berfungsi dari mobile.

### Status
- Admin dapat mengatur Ready/Sold Out.
- Sold Out tidak dapat dibeli customer.

### Quantity
- Default produk adalah multiple.
- Admin dapat mengubah menjadi single.

### Sorting
- Admin dapat drag & drop produk.
- Urutan customer mengikuti urutan admin.

### WhatsApp
- Admin dapat mengubah nomor WhatsApp.
- Admin dapat mengubah template default.

---

# 41. Rekomendasi Teknologi

Rekomendasi stack:

## Backend
- Laravel

## Frontend
- Blade
- Tailwind CSS atau CSS framework ringan
- Alpine.js / JavaScript ringan untuk interaksi

## Database
- MySQL / MariaDB

## Storage
- Local/server storage untuk gambar
- Local Storage browser untuk cart

## Hosting
Shared hosting yang mendukung:
- PHP,
- Laravel,
- MySQL,
- SSL.

Stack ini dipilih karena:
- website relatif sederhana,
- tidak membutuhkan SPA kompleks,
- mudah dimaintain,
- cocok untuk shared hosting,
- admin panel dapat dibuat ringan.

---

# 42. Future Enhancement

Fitur berikut tidak termasuk scope awal tetapi dapat dipertimbangkan:

- histori perubahan harga,
- import/export produk Excel,
- generate pricelist image,
- generate pricelist PDF,
- statistik klik produk,
- statistik klik WhatsApp,
- produk favorit,
- banner promo terjadwal,
- promo dengan tanggal mulai/akhir,
- fitur copy rekening,
- QRIS display,
- dark mode,
- theme customization,
- multi-admin,
- reseller mode,
- inventory stock angka,
- order management,
- payment gateway.

---

# 43. Prioritas Implementasi

## P0 — Wajib
- Pricelist customer.
- Search.
- Kategori.
- Detail produk.
- Flexible variants.
- Harga.
- Ready/Sold Out.
- Quantity.
- Keranjang.
- WhatsApp generator.
- Admin login.
- CRUD produk.
- CRUD kategori.
- CRUD opsi/varian.
- Quick Edit harga.
- Upload gambar.
- Aktif/Nonaktif.
- Drag & drop produk.
- Pengaturan WhatsApp.
- Responsive mobile.

## P1 — Penting
- Harga promo.
- Badge.
- Drag & drop kategori.
- Keyword pencarian.
- Store settings.
- Open Graph metadata.
- Empty state yang rapi.

## P2 — Opsional
- Duplikat produk.
- Statistik sederhana.
- Social links.
- Advanced template configuration.

---

# 44. Kesimpulan

Produk yang akan dibangun adalah **Website Katalog & Pricelist Aplikasi Premium dengan Flexible Product Variants, Cart-to-WhatsApp, Quantity Rules, dan Mobile Admin Panel**.

Website mengambil pengalaman pemilihan produk seperti marketplace, tetapi tidak menjalankan transaksi di dalam sistem.

Alur customer dibuat sederhana:

> Cari → Pilih Produk → Pilih Varian → Tentukan Quantity → Beli / Keranjang → WhatsApp.

Alur owner juga dibuat sederhana:

> Login → Cari Produk → Ubah Harga / Status / Varian → Simpan.

Fokus utama produk adalah:
- mudah dibuka,
- mudah dicari,
- mudah dipahami,
- mudah diubah setiap hari,
- dan nyaman digunakan dari smartphone.
