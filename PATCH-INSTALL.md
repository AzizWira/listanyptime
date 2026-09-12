# Pinky Pricelist v1.0.1 → v1.0.2

Replace/copy seluruh file patch ke root project.

Karena v1.0.2 memiliki perubahan dependency dan migration baru, jalankan:

```bash
composer update laravel/tinker --with-all-dependencies
php artisan optimize:clear
php artisan migrate
php artisan optimize
```

Jika `composer.lock` belum ada, jalankan `composer update` sebagai pengganti command Composer di atas.

Migration v1.0.2 hanya mengganti nilai setting lama jika masih sama dengan default v1.0.1:
- `Pinky List` → `@anyptime list`
- `6281234567890` → `628132628586`
- penutup WA default ber-emoji → versi plain text

Pengaturan yang sudah diubah manual oleh admin tidak akan ditimpa migration tersebut.
