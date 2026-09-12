# v1.0.2 — Cart Selection, WhatsApp & Ngrok Hardening

- Nama default storefront menjadi `@anyptime list`.
- Nomor WhatsApp default menjadi `628132628586` (+62 813-2628-586).
- Badge hero `Tanpa login` dihapus.
- Default penutup WhatsApp dibuat plain-text tanpa emoji untuk menghindari karakter pengganti pada perangkat/encoding tertentu.
- Pesan WhatsApp dinormalisasi Unicode sebelum URL dibentuk.
- Keranjang sekarang punya pemilih item berbentuk kontrol bulat; semua item Ready terpilih secara default.
- Total keranjang dihitung hanya dari item yang dipilih.
- Checkout hanya mengirim item yang dipilih, lalu item tersebut otomatis dikeluarkan dari keranjang.
- Item yang tidak dipilih tetap tersimpan.
- Item Sold Out otomatis tidak dapat dipilih.
- Asset CSS/JS dan storage URL dibuat root-relative agar aman pada localhost, ngrok HTTPS, dan hosting.
- Laravel trusted proxies diaktifkan untuk reverse proxy/ngrok.
- `laravel/tinker` diperbarui dari `^2.10.1` menjadi `^3.0` agar kompatibel dengan Laravel 13.
- Migration baru memperbarui hanya nilai default lama pada database existing tanpa menimpa pengaturan custom admin.
