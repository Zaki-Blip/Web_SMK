# Website Profil TK Angkasa 8

Website profil sekolah (Taman Kanak-Kanak) dengan halaman publik dan dashboard admin.
Dibangun dengan Laravel 13, MySQL, dan Bootstrap 5.3 tanpa proses build (tanpa Node/npm).

> **Status: versi demo — bukan website resmi sekolah.**
> Selama `DEMO_MODE=true` di `.env`, halaman publik menampilkan banner
> "Versi demo — bukan website resmi". Data berlabel `[CONTOH]` hanya untuk
> presentasi dan harus diganti sebelum situs dipakai sebagai situs resmi.

## Fitur

- **Publik:** beranda, profil, program, fasilitas, galeri (lightbox), berita + detail,
  informasi PPDB, kontak; sitemap.xml dan robots.txt dinamis; halaman 404 ramah.
- **Admin:** login, dashboard statistik, CRUD program/fasilitas/galeri/berita,
  profil sekolah, pengaturan situs, informasi PPDB, dan ganti kata sandi sendiri.
- **Keamanan:** middleware admin, CSRF, validasi server-side, throttling login
  (5 percobaan/menit), session regenerate saat login, upload gambar divalidasi
  (JPG/PNG/WebP, maks. 2 MB) dan diperkecil otomatis dengan GD.
- **SEO dasar:** judul/deskripsi unik per halaman, Open Graph, sitemap, robots,
  `noindex` untuk halaman admin.

## Teknologi

| Komponen | Versi / catatan |
|---|---|
| PHP | 8.3+ (ekstensi: `gd`, `pdo_mysql`, `mbstring`, `fileinfo`, `intl`, `exif`, `zip`) |
| Laravel | 13.37 |
| Database | MySQL 8 (`tk_angkasa8_db`) |
| CSS/JS | Bootstrap 5.3.3 + Bootstrap Icons 1.11.3 + Google Fonts via CDN |
| Build tool | Tidak ada (tanpa Node/npm/Vite) |
| Penyimpanan gambar | Lokal (`storage/app/public`) atau S3/Cloudflare R2 (`UPLOADS_DISK`) |
| Zona waktu / locale | `Asia/Jakarta` / `id` |

## Instalasi dari nol (Windows + Laragon)

1. **Siapkan prasyarat**

   ```powershell
   php -v
   php -m      # pastikan gd, pdo_mysql, mbstring, fileinfo, intl, exif, zip ada
   composer -V
   ```

2. **Ambil dependensi PHP**

   ```powershell
   composer install
   ```

3. **Salin konfigurasi lingkungan**

   ```powershell
   Copy-Item .env.example .env
   php artisan key:generate
   ```

4. **Buat database**

   Lewat Laragon/phpMyAdmin atau CLI MySQL:

   ```sql
   CREATE DATABASE tk_angkasa8_db
       CHARACTER SET utf8mb4
       COLLATE utf8mb4_unicode_ci;
   ```

   Sesuaikan bagian ini di `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tk_angkasa8_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Jalankan migrasi dan data awal**

   ```powershell
   php artisan migrate --seed
   ```

   `--seed` hanya membuat record awal yang netral (profil, pengaturan situs, PPDB kosong).
   Tidak ada akun dan tidak ada konten contoh.

6. **Aktifkan penyimpanan gambar** (langkah yang sering terlewat di Windows)

   ```powershell
   php artisan storage:link
   ```

   Perintah ini membuat `public/storage` → `storage/app/public`. Tanpa langkah ini,
   gambar yang diunggah tidak akan tampil. Bila gagal karena izin, aktifkan
   *Developer Mode* Windows atau jalankan terminal sebagai Administrator.

7. **Buat akun admin**

   ```powershell
   php artisan app:create-admin
   ```

   Perintah akan menanyakan nama, email, dan kata sandi (minimal 8 karakter).
   Bisa juga tanpa interaksi:

   ```powershell
   php artisan app:create-admin --name="Administrator" --email=admin@sekolah.sch.id --password="kata-sandi-kuat"
   ```

8. **Jalankan server**

   ```powershell
   php artisan serve
   ```

   - Website publik: <http://127.0.0.1:8000>
   - Dashboard admin: <http://127.0.0.1:8000/admin/login>

   Alternatif: buat virtual host di Laragon yang mengarah ke folder `public/`.
   Jangan mengarahkan document root ke folder proyek (root), karena `.env` bisa terbaca.

9. **(Opsional) Data demo**

   ```powershell
   php artisan db:seed --class=DemoSeeder
   ```

   Lalu set `DEMO_MODE=true` di `.env` agar banner demo tampil. Seeder demo bersifat
   idempoten dan semua teksnya berawalan `[CONTOH]`. Untuk kembali ke kondisi netral,
   set `DEMO_MODE=false` lalu hapus/ganti data `[CONTOH]` lewat dashboard.

## Menjalankan pengujian

```powershell
php artisan test
vendor\bin\pint
```

Test memakai SQLite in-memory (lihat `phpunit.xml`), jadi **tidak menyentuh** database
`tk_angkasa8_db`.

## Perintah yang sering dipakai

```powershell
php artisan route:list --except-vendor   # daftar route
php artisan migrate:status               # status migrasi
php artisan config:clear                 # hapus cache konfigurasi
php artisan view:clear                   # hapus cache view
php artisan optimize:clear               # bersihkan semua cache
```

## Struktur folder penting

```
app/
  Http/Controllers/Admin/      controller dashboard
  Http/Controllers/Public/     controller halaman publik
  Http/Middleware/EnsureAdmin.php
  Http/Requests/Admin/         validasi form admin
  Models/                      model Eloquent
  Support/ImageUploader.php    resize + simpan gambar (GD)
  Support/WhatsappNumber.php   normalisasi nomor WhatsApp
  Support/IndonesianDate.php   format tanggal Indonesia
database/
  migrations/                  skema tabel
  seeders/DatabaseSeeder.php   data awal netral
  seeders/DemoSeeder.php       data demo [CONTOH]
docs/                          dokumentasi tambahan
public/
  css/app.css                  satu-satunya CSS kustom
  storage/                     symlink hasil storage:link
resources/views/
  public/                      halaman publik
  admin/                       halaman dashboard
  components/                  komponen Blade
routes/web.php                 semua route
```

## Dokumentasi

- [Struktur database](docs/database.md)
- [Daftar route](docs/route.md)
- [Panduan dashboard admin](docs/panduan-admin.md)
- [Deployment gratis: Render + MySQL + R2](docs/deployment-render.md)
- [Konfigurasi produksi dan backup](docs/deployment-dan-backup.md)
- [Informasi sekolah yang masih perlu dikonfirmasi](docs/konfirmasi-sekolah.md)
- [Daftar keterbatasan](docs/keterbatasan.md)

## Catatan keamanan

- `.env` tidak ikut di-commit (lihat `.gitignore`). Jangan pernah mengunggahnya.
- `APP_DEBUG` harus `false` di produksi (sudah menjadi default di `.env.example`).
- Ganti/hapus akun admin percobaan sebelum situs dipakai publik.
- Gunakan HTTPS dan kata sandi database yang kuat di server produksi.

## Lisensi

Kode proyek ini disiapkan untuk TK Angkasa 8. Laravel dirilis dengan lisensi MIT.
