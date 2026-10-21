# Struktur Database

Database: MySQL 8, nama `smkn64_db`, charset `utf8mb4`.
Semua tabel dibuat lewat migrasi di `database/migrations/`.

Nama tabel memakai bahasa Indonesia bentuk tunggal. Migrasi
`2026_10_21_000001_rename_content_tables_to_indonesian.php` mengganti nama tabel
lama dengan `RENAME TABLE`, sehingga data yang sudah ada tidak hilang.

> Beberapa nama berkas migrasi awal masih memakai nama lama agar riwayat
> deployment yang sudah berjalan tidak bentrok. Isi dan tabel akhirnya sudah
> memakai nama Indonesia; jangan mengganti nama berkas migrasi yang sudah
> diterapkan di server produksi.

Migrasi `2026_10_21_000003_add_phase_two_content.php` menambahkan tabel
`struktur_organisasi`, `alur_pkl`, `agenda`, dan `unduhan`, serta kolom media
sosial pada `site_settings`.

## Ringkasan tabel

| Kelompok | Tabel | Isi |
|---|---|---|
| Akademik | `jurusan` | Kompetensi keahlian |
| Akademik | `guru` | Guru dan staf |
| Akademik | `struktur_organisasi` | Struktur organisasi dan jabatan |
| Akademik | `ekstrakurikuler` | Kegiatan ekstrakurikuler |
| Akademik | `prestasi` | Prestasi sekolah/siswa |
| Kemitraan dan karier | `mitra_industri` | Mitra industri |
| Kemitraan dan karier | `lowongan_bkk` | Lowongan kerja BKK |
| Kemitraan dan karier | `testimoni` | Testimoni alumni |
| Kemitraan dan karier | `alur_pkl` | Tahapan pelaksanaan PKL |
| Konten | `fasilitas` | Fasilitas sekolah |
| Konten | `galeri` | Foto galeri |
| Konten | `berita` | Berita dan pengumuman |
| Konten | `faq` | Pertanyaan umum |
| Konten | `agenda` | Agenda kegiatan |
| Konten | `unduhan` | Berkas dan dokumen unduhan |
| Pengaturan | `school_profiles` | Profil sekolah (satu baris) |
| Pengaturan | `site_settings` | Identitas, kontak, media sosial, dan SEO situs (satu baris) |
| Pengaturan | `spmb` | Informasi SPMB (satu baris) |
| Akun | `users` | Akun admin |
| Infrastruktur | `migrations`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `password_reset_tokens` | Bawaan Laravel; tabel job tidak dipakai karena queue `sync` |

> Tabel `school_profiles`, `site_settings`, dan `spmb` dirancang **satu baris saja**.
> Model menyediakan `::current()` untuk mengambil atau membuat baris tersebut.

## Tabel akademik dan konten

### `jurusan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `nama` | varchar(255), wajib | Nama kompetensi keahlian |
| `singkatan` | varchar(255), opsional | Singkatan jurusan |
| `slug` | varchar(255), unik, wajib | Dipakai di URL `/jurusan/{slug}` |
| `ringkasan` | varchar(255), opsional | Tampil di kartu |
| `deskripsi` | text, opsional | Uraian lengkap |
| `kompetensi` | json, opsional | Daftar kompetensi |
| `prospek_karier` | text, opsional | Prospek karier |
| `lama_belajar` | varchar(255), default `3 tahun` | |
| `gambar` | varchar(255), opsional | Path relatif pada disk unggahan |
| `urutan` | int unsigned, default 0 | Urutan tampil |
| `is_active` | tinyint(1), default 1 | 1 = tampil di website |
| `created_at`, `updated_at` | timestamp | |

### `guru`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `nama` | varchar(255), wajib | |
| `jabatan` | varchar(255), opsional | |
| `tipe` | varchar(255), default `guru` | `guru` atau `staf` |
| `mata_pelajaran` | varchar(255), opsional | |
| `jurusan_id` | bigint unsigned, opsional, FK ke `jurusan` | `nullOnDelete` |
| `foto` | varchar(255), opsional | |
| `urutan` | int unsigned, default 0 | |
| `is_active` | tinyint(1), default 1 | |
| `created_at`, `updated_at` | timestamp | |

### `ekstrakurikuler`

`id`, `nama`, `slug` (unik), `deskripsi`, `pembina`, `jadwal`, `gambar`,
`urutan`, `is_active`, timestamps.

### `prestasi`

`id`, `judul`, `tingkat` (`sekolah`, `kota`, `provinsi`, `nasional`,
`internasional`), `tahun`, `peraih`, `deskripsi`, `gambar`, `is_active`,
timestamps.

### `mitra_industri`

`id`, `nama`, `bidang`, `logo`, `website`, `urutan`, `is_active`, timestamps.

### `lowongan_bkk`

`id`, `judul`, `perusahaan`, `lokasi`, `tipe` (`penuh_waktu`, `kontrak`,
`magang`), `deskripsi`, `persyaratan`, `tautan_daftar`, `batas_waktu`,
`is_published`, timestamps.

### `testimoni`

`id`, `nama`, `angkatan`, `jurusan_id` (FK ke `jurusan`, `nullOnDelete`),
`pekerjaan_saat_ini`, `isi`, `foto`, `is_active`, timestamps.

### `faq`

`id`, `pertanyaan`, `jawaban`, `kategori` (`spmb`, `umum`), `urutan`,
`is_active`, timestamps.

FAQ aktif tampil di beranda. FAQ dengan kategori `spmb` juga tampil di halaman
SPMB.

### `struktur_organisasi`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `nama` | varchar(255), wajib | Nama pejabat/pegawai |
| `jabatan` | varchar(255), wajib | Nama jabatan |
| `parent_id` | bigint unsigned, opsional, FK ke `struktur_organisasi` | Atasan langsung; `nullOnDelete` |
| `urutan` | int unsigned, default 0 | Urutan tampil |
| `is_active` | tinyint(1), default 1 | 1 = tampil di website |
| `created_at`, `updated_at` | timestamp | |

Relasi `parent_id` membentuk hierarki. Halaman publik hanya menampilkan data
aktif dan menyusunnya dari jabatan puncak (`parent_id = null`).

### `alur_pkl`

`id`, `judul`, `deskripsi`, `urutan`, `is_active`, timestamps.

Hanya langkah aktif yang tampil di `/alur-pkl`, diurutkan berdasarkan `urutan`.

### `agenda`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `judul` | varchar(255), wajib | |
| `slug` | varchar(255), unik, wajib | Dipakai di URL `/agenda/{slug}` |
| `deskripsi` | text, opsional | Teks biasa |
| `mulai` | datetime, wajib | Waktu mulai |
| `selesai` | datetime, opsional | Tidak boleh sebelum `mulai` |
| `lokasi` | varchar(255), opsional | |
| `is_published` | tinyint(1), default 0 | 1 = tampil di website |
| `created_at`, `updated_at` | timestamp | |

Agenda draf tidak muncul di daftar dan detailnya menghasilkan **404**.

### `unduhan`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `judul` | varchar(255), wajib | |
| `deskripsi` | text, opsional | |
| `berkas` | varchar(255), wajib | Path relatif pada disk unggahan |
| `ukuran` | bigint unsigned, default 0 | Ukuran berkas dalam byte |
| `is_published` | tinyint(1), default 0 | 1 = tampil dan dapat diunduh |
| `urutan` | int unsigned, default 0 | Urutan tampil |
| `created_at`, `updated_at` | timestamp | |

Unduhan draf tidak tampil di daftar; route unduh memeriksa status terbit dan
keberadaan berkas, lalu mengembalikan **404** bila tidak memenuhi syarat.

### `fasilitas`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `name` | varchar(255), wajib | Nama fasilitas |
| `slug` | varchar(255), unik, wajib | |
| `description` | text, opsional | |
| `image_path` | varchar(255), opsional | |
| `category` | varchar(255), opsional | Teks bebas |
| `sort_order` | int unsigned, default 0 | |
| `is_published` | tinyint(1), default 0 | |
| `created_at`, `updated_at` | timestamp | |

### `galeri`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `title` | varchar(255), wajib | Judul foto |
| `caption` | text, opsional | Keterangan |
| `image_path` | varchar(255), opsional | Kosong = placeholder netral |
| `category` | varchar(255), opsional | Teks bebas |
| `sort_order` | int unsigned, default 0 | |
| `is_published` | tinyint(1), default 0 | |
| `created_at`, `updated_at` | timestamp | |

### `berita`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint unsigned, PK | |
| `title` | varchar(255), wajib | |
| `slug` | varchar(255), unik, wajib | Dipakai di URL `/berita/{slug}` |
| `excerpt` | varchar(255), opsional | Ringkasan dan meta description |
| `body` | text, wajib | Teks biasa, bukan HTML |
| `image_path` | varchar(255), opsional | |
| `kategori` | varchar(255), default `berita` | Kategori berita |
| `published_at` | timestamp, opsional | Null = belum dijadwalkan |
| `status` | varchar(255), default `draft` | `draft` atau `published` |
| `created_at`, `updated_at` | timestamp | |

**Aturan tampil di publik:** `status = 'published'` **dan** `published_at` tidak
null **dan** `published_at <= sekarang`. Berita terjadwal belum dapat diakses
publik dan ditandai "Terjadwal" di dasbor. Kolom `kategori` dipakai untuk filter
`/berita?kategori=...`; nilai kosong diperlakukan sebagai tanpa kategori.

Migrasi `2026_10_21_000002_rename_berita_category_to_kategori.php` mengganti nama
kolom lama tanpa menghapus data.

## Tabel pengaturan

### `school_profiles`

`id`, `school_name`, `nama_kepala_sekolah`, `foto_kepala_sekolah`,
`sambutan_kepala_sekolah`, `sejarah`, `visi`, `misi`, `description`,
`akreditasi`, `npsn`, `tahun_berdiri`, `jumlah_siswa`, `jumlah_guru`,
`jumlah_mitra`, timestamps.

Kolom `history`, `vision`, dan `mission` tetap ada sebagai alias lama; form admin
menyinkronkan `sejarah`/`visi`/`misi` dengan kolom alias tersebut. Dipakai halaman
Profil dan ringkasan di beranda.

### `site_settings`

`id`, `school_name`, `logo_path`, `address`, `phone`, `email`, `opening_hours`,
`whatsapp_number`, `maps_url`, `facebook_url`, `instagram_url`, `youtube_url`,
`tiktok_url`, `meta_title`, `meta_description`, timestamps.

- `whatsapp_number` disimpan dalam format internasional tanpa `+`
  (contoh `62812xxxxxxx`). Tautan dibuat dengan `https://wa.me/{nomor}`.
- Kolom media sosial boleh kosong. Tautan yang diisi tampil di footer dan halaman
  kontak, serta dimasukkan sebagai `sameAs` pada JSON-LD organisasi.
- `meta_title`/`meta_description` dipakai sebagai default SEO bila halaman tidak
  punya nilai sendiri.

### `spmb`

`id`, `tahun_ajaran`, `jalur` (json), `syarat`, `alur` (json), `jadwal` (json),
`tautan_pendaftaran`, `kontak_panitia`, `is_open`, timestamps.

Bila `is_open = 0` atau semua kolom informasi kosong, halaman SPMB menampilkan
pesan netral beserta kontak sekolah.

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

- `guru.jurusan_id` → `jurusan.id`
- `testimoni.jurusan_id` → `jurusan.id`

`struktur_organisasi.parent_id` juga merupakan foreign key ke
`struktur_organisasi.id` (self-reference). Semua foreign key memakai
`nullOnDelete`. Tabel konten lain berdiri sendiri.

## Berkas unggahan

- Disimpan di disk unggahan sesuai `UPLOADS_DISK`:
  `public` → `storage/app/public/{logo|profil|jurusan|guru|ekstrakurikuler|prestasi|mitra|fasilitas|galeri|berita|testimoni|unduhan}/...`;
  `s3` → bucket S3/Cloudflare R2 untuk deployment tanpa disk permanen.
- Diakses lewat `public/storage` (hasil `php artisan storage:link`) untuk disk
  lokal, atau lewat URL publik bucket untuk disk `s3`.
- Nama berkas acak, bukan nama asli unggahan.
- Gambar mengikuti `App\Support\ImageUploader` (maksimal 2 MB).
- Dokumen unduhan disimpan di folder `unduhan/` dan mengikuti
  `App\Support\DocumentUploader` (maksimal 10 MB, ekstensi dibatasi).

## Seeder

| Seeder | Isi |
|---|---|
| `DatabaseSeeder` | Profil, pengaturan situs, dan SPMB awal yang netral. Tanpa akun/konten. |
| `DemoSeeder` | Konten demo berlabel jelas; aman dijalankan berulang (`updateOrCreate`). |

Perintah:

```powershell
php artisan migrate --seed
php artisan db:seed --class=DemoSeeder
```
