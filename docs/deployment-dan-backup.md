# Panduan Konfigurasi Produksi dan Backup

Panduan ini untuk pengelola sistem yang akan memasang website di server.
Website **belum boleh diumumkan sebagai situs resmi** sebelum data sekolah
dikonfirmasi (lihat [konfirmasi-sekolah.md](konfirmasi-sekolah.md)).

## 1. Sebelum online — daftar periksa

- [ ] Data demo sudah dihapus/diganti dengan data sekolah yang sebenarnya.
- [ ] `DEMO_MODE=false` sehingga banner demo tidak tampil.
- [ ] `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-sekolah`.
- [ ] Akun admin percobaan dihapus, akun resmi dibuat dengan kata sandi kuat.
- [ ] HTTPS aktif (sertifikat SSL, biasanya gratis lewat hosting).
- [ ] `.env` tidak dapat diakses dari browser.
- [ ] `php artisan storage:link` sudah dijalankan.
- [ ] `php artisan migrate --force` sudah dijalankan.
- [ ] Backup pertama sudah dibuat dan diuji.

## 2. Konfigurasi `.env` produksi

```dotenv
APP_NAME="SMKN 64 Jakarta"
APP_ENV=production
APP_KEY=base64:...            # hasil php artisan key:generate
APP_DEBUG=false
APP_URL=https://domain-sekolah.sch.id

DEMO_MODE=false

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database
DB_USERNAME=nama_pengguna
DB_PASSWORD=kata-sandi-kuat

SESSION_DRIVER=database
CACHE_STORE=database
# Tidak ada job antrean; sync menghindari kebutuhan worker.
QUEUE_CONNECTION=sync

LOG_CHANNEL=stack
LOG_LEVEL=warning
```

Catatan:

- Jangan menyalin `.env` dari komputer lokal. Buat ulang di server dan jalankan
  `php artisan key:generate` bila `APP_KEY` belum ada.
- Jangan pernah menaruh `.env` di folder `public/`.

## 3. Unggah dan siapkan aplikasi

1. Unggah kode ke server (tanpa folder `vendor`, tanpa `.env`, tanpa
   `storage/app/public` lama bila ada).
2. Arahkan **document root** domain ke folder `public/`, bukan ke folder proyek.
3. Jalankan di server:

   ```bash
   composer install --no-dev --optimize-autoloader
   cp .env.example .env        # lalu edit sesuai bagian 2
   php artisan key:generate
   php artisan migrate --force
   php artisan db:seed          # hanya untuk instalasi baru
   php artisan storage:link
   php artisan optimize
   ```

4. Pastikan folder berikut dapat ditulis oleh web server:

   ```
   storage/
   bootstrap/cache/
   ```

5. Buat akun admin resmi:

   ```bash
   php artisan app:create-admin
   ```

### Contoh Nginx

```nginx
server {
    listen 443 ssl;
    server_name domain-sekolah.sch.id;
    root /var/www/smkn64/public;

    index index.php;
    client_max_body_size 4M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Contoh Apache (cPanel)

Arahkan domain/subdomain ke folder `public/`, lalu pastikan `.htaccess` di dalam
`public/` ikut terunggah. Bila document root tidak bisa diubah, gunakan subdomain
yang diarahkan ke `public/` atau tambahkan aturan rewrite ke `public/index.php`.

## 4. Setelah setiap pembaruan kode

```bash
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan optimize        # config + route + view cache
```

Bila ada perubahan yang tidak muncul, jalankan `php artisan optimize:clear`
lalu `php artisan optimize` kembali.

## 5. Backup

### Yang wajib dibackup

| Data | Lokasi |
|---|---|
| Database | seluruh tabel `smkn64_db` |
| Berkas unggahan (gambar & dokumen) | `storage/app/public/` |
| Konfigurasi | `.env` (simpan di tempat aman, jangan di folder publik) |

### Backup database

**Windows / Laragon** (jalankan di folder proyek):

```powershell
& "C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe" -u root smkn64_db > "backup\smkn64_db_$(Get-Date -Format yyyy-MM-dd).sql"
```

**Linux server:**

```bash
mysqldump -u USER -p smkn64_db > backup/smkn64_db_$(date +%F).sql
```

### Backup berkas unggahan

Kompres folder `storage/app/public`:

```powershell
Compress-Archive -Path storage\app\public -DestinationPath "backup\uploads_$(Get-Date -Format yyyy-MM-dd).zip"
```

```bash
tar -czf backup/uploads_$(date +%F).tar.gz storage/app/public
```

### Jadwal yang disarankan

- Database: setiap hari (otomatis lewat cron/Task Scheduler bila memungkinkan).
- Berkas unggahan (gambar dan dokumen): setiap minggu, atau setiap kali ada unggahan penting.
- Simpan salinan di **luar server** (komputer sekolah, Google Drive, atau layanan
  backup lain). Backup yang hanya ada di server yang sama tidak melindungi dari
  kerusakan server.

### Mengembalikan (restore)

```bash
mysql -u USER -p smkn64_db < backup/smkn64_db_2026-10-20.sql
```

Lalu ekstrak kembali `uploads_...zip` ke `storage/app/public/`, jalankan
`php artisan optimize:clear`, dan periksa halaman publik serta dashboard.

Uji restore minimal sekali sebelum situs dipakai publik.

## 6. Keamanan tambahan

- Perbarui dependensi secara berkala: `composer update` (uji dulu di lokal).
- Batasi akses panel admin bila memungkinkan (mis. aturan IP di firewall).
- Aktifkan HTTPS penuh; jangan biarkan login lewat HTTP.
- Hapus akun yang tidak dipakai.
- Periksa `storage/logs/laravel.log` bila terjadi error 500.
- Jangan mengaktifkan `APP_DEBUG` di produksi.

## 7. Bila terjadi masalah

| Gejala | Periksa |
|---|---|
| Halaman 500 | `storage/logs/laravel.log`, izin `storage/` dan `bootstrap/cache/` |
| Gambar tidak tampil | `php artisan storage:link`, izin `storage/app/public` |
| Perubahan tidak muncul | `php artisan optimize:clear` lalu `php artisan optimize` |
| Tidak bisa login | akun ada? (`php artisan app:create-admin`), kata sandi benar? |
| Error database | kredensial `.env`, server MySQL berjalan, database sudah dibuat |

