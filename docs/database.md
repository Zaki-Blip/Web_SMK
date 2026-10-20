# Struktur Database

Database: MySQL 8, nama `tk_angkasa8_db`, charset `utf8mb4`.
Semua tabel dibuat lewat migrasi di `database/migrations/`.

## Ringkasan tabel

| Kelompok | Tabel | Isi |
|---|---|---|
| Konten | `programs` | Program pembelajaran |
| Konten | `facilities` | Fasilitas sekolah |
| Konten | `gallery_items` | Foto galeri |
| Konten | `news` | Berita |
| Pengaturan | `school_profiles` | Profil sekolah (satu baris) |
| Pengaturan | `site_settings` | Identitas & kontak situs (satu baris) |
| Pengaturan | `admission_settings` | Informasi PPDB (satu baris) |
| Akun | `users` | Akun admin |
| Infrastruktur | `migrations`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `password_reset_tokens` | Bawaan Laravel |

> Tabel `school_profiles`, `site_settings`, dan `admission_settings` dirancang
> **satu baris saja**. Model menyediakan `::current()` untuk mengambil/membuat
> baris tersebut.

## Tabel konten

### `programs`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `name` | varchar(255), wajib | Nama program |
| `slug` | varchar(255), unik, wajib | Dibuat dari `name`, bisa diubah |
| `short_description` | varchar(255), opsional | Tampil di kartu |
| `description` | text, opsional | Uraian lengkap |
| `image_path` | varchar(255), opsional | Path relatif pada disk `public` |
| `sort_order` | int unsigned, default 0 | Urutan tampil (kecil lebih dulu) |
| `is_published` | tinyint(1), default 0 | 1 = tampil di website |
| `created_at`, `updated_at` | timestamp | |

### `facilities`

Struktur sama dengan `programs`, tanpa `short_description`.

### `gallery_items`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `title` | varchar(255), wajib | Judul foto |
| `caption` | text, opsional | Keterangan |
| `image_path` | varchar(255), opsional | Kosong = placeholder netral |
| `category` | varchar(255), opsional | Teks bebas (mis. "Kegiatan") |
| `sort_order` | int unsigned, default 0 | |
| `is_published` | tinyint(1), default 0 | |
| `created_at`, `updated_at` | timestamp | |

### `news`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `title` | varchar(255), wajib | |
| `slug` | varchar(255), unik, wajib | Dipakai di URL `/berita/{slug}` |
| `excerpt` | varchar(255), opsional | Ringkasan + meta description |
| `body` | text, wajib | Teks biasa, bukan HTML |
| `image_path` | varchar(255), opsional | |
| `published_at` | timestamp, opsional | Null = belum dijadwalkan |
| `status` | varchar(255), default `draft` | `draft` atau `published` |
| `created_at`, `updated_at` | timestamp | |

**Aturan tampil di publik:** `status = 'published'` **dan** `published_at` tidak null
**dan** `published_at <= sekarang`. Berita terjadwal (tanggal di masa depan) belum
bisa diakses publik dan ditandai "Terjadwal" di dashboard.

## Tabel pengaturan

### `school_profiles`

`id`, `school_name`, `history`, `vision`, `mission`, `description`, timestamps.
Dipakai halaman Profil dan ringkasan di beranda.

### `site_settings`

`id`, `school_name`, `logo_path`, `address`, `phone`, `email`, `opening_hours`,
`whatsapp_number`, `maps_url`, `meta_title`, `meta_description`, timestamps.

- `whatsapp_number` disimpan dalam format internasional tanpa `+` (contoh `62812xxxxxxx`).
  Tautan dibuat dengan `https://wa.me/{nomor}`.
- `meta_title`/`meta_description` dipakai sebagai default SEO bila halaman tidak
  punya nilai sendiri.

### `admission_settings`

`id`, `title`, `description`, `schedule`, `requirements`, `registration_steps`,
`fee_information`, `whatsapp_number`, `is_active`, timestamps.

Bila `is_active = 0` atau semua kolom teks kosong, halaman PPDB menampilkan pesan
netral beserta kontak sekolah.

## Tabel akun

### `users`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `name` | varchar(255), wajib | |
| `email` | varchar(255), unik, wajib | Dipakai untuk login |
| `email_verified_at` | timestamp, opsional | Tidak dipakai di v1 |
| `password` | varchar(255), wajib | Hash bcrypt (cast `hashed`) |
| `role` | varchar(255), default `admin` | Satu peran di v1 |
| `remember_token` | varchar(100) | |
| `created_at`, `updated_at` | timestamp | |

Akun dibuat hanya lewat `php artisan app:create-admin`; tidak ada pendaftaran publik.

## Relasi

Saat ini antar tabel konten **tidak ada foreign key**: program, fasilitas, galeri, dan
berita berdiri sendiri. Yang berelasi hanya tabel infrastruktur Laravel
(`sessions.user_id`, `jobs`, `failed_jobs`).

## Berkas gambar

- Disimpan di disk unggahan sesuai `UPLOADS_DISK`:
  `public` → `storage/app/public/{programs|facilities|gallery|news}/...`;
  `s3` → bucket S3/Cloudflare R2 (untuk deployment tanpa disk permanen).
- Diakses lewat `public/storage` (hasil `php artisan storage:link`) untuk disk lokal,
  atau lewat URL publik bucket (R2/S3) untuk disk `s3`.
- Nama berkas acak, bukan nama asli unggahan.
- Ukuran maksimal 2 MB; gambar diperkecil dengan GD (lebar maks. 1600 px, 800 px,
  atau 400 px sesuai konteks). File lama dihapus saat diganti atau saat data dihapus.

## Seeder

| Seeder | Isi |
|---|---|
| `DatabaseSeeder` | Profil + pengaturan situs netral, PPDB kosong. Tanpa akun/konten. |
| `DemoSeeder` | Konten demo berlabel `[CONTOH]`; aman dijalankan berulang (`updateOrCreate`). |

Perintah:

```powershell
php artisan migrate --seed                          # data awal netral
php artisan db:seed --class=DemoSeeder              # data demo
```
