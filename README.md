# Website Profil SMK Negeri 64 Jakarta

Website profil sekolah dengan halaman publik dan dashboard admin untuk mengelola
seluruh konten tanpa menyentuh kode. Dibangun dengan **Laravel 13**, **MySQL 8**,
dan **Bootstrap 5.3** tanpa proses build (tanpa Node/npm/Vite).

> **Status: versi demo — bukan website resmi sekolah.**
> Selama `DEMO_MODE=true` di `.env`, halaman publik menampilkan banner
> "Versi demo — bukan website resmi". Data demo hanya untuk presentasi dan harus
> dikonfirmasi/diganti sebelum situs dipakai sebagai situs resmi.

---

## Daftar isi

1. [Tentang aplikasi](#1-tentang-aplikasi)
2. [Sorotan fitur](#2-sorotan-fitur)
3. [Peta halaman publik](#3-peta-halaman-publik)
4. [Modul dashboard admin](#4-modul-dashboard-admin)
5. [Teknologi dan arsitektur](#5-teknologi-dan-arsitektur)
6. [Tema dan identitas visual](#6-tema-dan-identitas-visual)
7. [Model data](#7-model-data)
8. [Alur kerja aplikasi](#8-alur-kerja-aplikasi)
9. [Keamanan](#9-keamanan)
10. [SEO dan aksesibilitas](#10-seo-dan-aksesibilitas)
11. [Mode demo dan data demo](#11-mode-demo-dan-data-demo)
12. [Instalasi dari nol](#12-instalasi-dari-nol)
13. [Konfigurasi `.env`](#13-konfigurasi-env)
14. [Perintah yang sering dipakai](#14-perintah-yang-sering-dipakai)
15. [Pengujian](#15-pengujian)
16. [Struktur folder](#16-struktur-folder)
17. [Deployment](#17-deployment)
18. [Keterbatasan versi ini](#18-keterbatasan-versi-ini)
19. [Dokumentasi](#19-dokumentasi)
20. [Lisensi](#20-lisensi)

---

## 1. Tentang aplikasi

Aplikasi ini adalah **website profil sekolah** yang menyajikan informasi publik
SMK Negeri 64 Jakarta, sekaligus menyediakan **dashboard admin** agar pihak sekolah
dapat memperbarui konten sendiri.

Aplikasi **bukan** sistem akademik, bukan sistem absensi, bukan e-learning, dan
bukan formulir pendaftaran siswa online. Halaman SPMB bersifat informasi; bila
sekolah mengisi tautan pendaftaran eksternal, tombol "Daftar Sekarang" akan
mengarah ke tautan tersebut.

**Pengguna yang dilayani:**

- Calon peserta didik dan orang tua yang mencari informasi sekolah, jurusan, dan SPMB.
- Masyarakat umum yang ingin melihat profil, prestasi, dan kegiatan sekolah.
- Alumni, industri, dan pencari kerja yang mengakses informasi BKK/mitra industri.
- Admin sekolah yang mengelola konten melalui dashboard.

**Tujuan:**

1. Menyajikan profil sekolah yang profesional, informatif, dan mudah diakses.
2. Menjadi sumber informasi resmi mengenai jurusan, fasilitas, prestasi, dan SPMB.
3. Memungkinkan admin sekolah mengelola konten tanpa mengubah kode.
4. Menjadi fondasi yang mudah dikembangkan untuk kebutuhan sekolah berikutnya.

**Prinsip versi ini:**

- Satu sekolah, satu bahasa (Indonesia), satu peran admin.
- Konten berupa teks biasa dan gambar; tanpa editor HTML/WYSIWYG.
- Tanpa proses build frontend; Bootstrap, ikon, dan font dimuat via CDN.
- Utamakan kejelasan informasi, aksesibilitas, dan keamanan dasar.

---

## 2. Sorotan fitur

**Halaman publik**

- Beranda dengan hero, profil singkat, jurusan, fasilitas, galeri, berita,
  testimoni, FAQ, ajakan SPMB, dan kontak.
- Profil sekolah: sejarah, visi, misi, sambutan kepala sekolah, dan identitas
  (NPSN, akreditasi, tahun berdiri, jumlah siswa/guru/mitra).
- Jurusan (kompetensi keahlian) beserta detail kompetensi dan prospek karier.
- Guru & staf, struktur organisasi, ekstrakurikuler, prestasi, mitra industri,
  dan lowongan BKK.
- Alur PKL, agenda kegiatan, serta daftar berkas unduhan.
- Fasilitas dan galeri dengan lightbox.
- Berita dengan halaman detail, dukungan status draf dan jadwal terbit.
- Halaman SPMB: tahun ajaran, jalur & kuota, persyaratan, alur, jadwal,
  tautan pendaftaran, kontak panitia, dan FAQ khusus SPMB.
- Halaman kontak: alamat, telepon, email, jam operasional, WhatsApp, peta, dan
  tautan media sosial.
- Sitemap XML dan robots.txt dinamis, halaman 404 yang ramah.
- Tampilan responsif 360–1440 px, navigasi yang dapat dioperasikan dengan keyboard.

**Dashboard admin**

- Login aman dengan pembatasan percobaan dan sesi yang diregenerasi.
- Dashboard ringkasan jumlah konten dan status SPMB.
- CRUD untuk jurusan, guru, struktur organisasi, ekstrakurikuler, prestasi,
  fasilitas, galeri, berita, mitra industri, lowongan BKK, testimoni, FAQ, alur
  PKL, agenda, dan unduhan.
- Pengaturan profil sekolah, identitas situs, logo, kontak, media sosial, dan
  metadata SEO.
- Pengaturan informasi SPMB.
- Ganti nama, email, dan kata sandi akun sendiri.
- Pencarian dan paginasi pada daftar konten admin.
- Konfirmasi sebelum menghapus data.

**Teknis**

- Validasi server-side melalui Form Request.
- Upload gambar JPG/PNG/WebP maksimal 2 MB, diperkecil otomatis dengan GD,
  nama file diacak, dan metadata EXIF dihapus saat proses encode ulang.
- Upload dokumen unduhan PDF/DOC/DOCX/XLS/XLSX/PPT/PPTX/ZIP/TXT maksimal 10 MB,
  nama file diacak, dan tautan unduh divalidasi status terbitnya.
- Penyimpanan gambar dan dokumen lokal (`storage/app/public`) atau S3/Cloudflare R2.
- CSRF pada seluruh form, middleware admin, dan `noindex` untuk halaman admin.
- Tanpa dependensi frontend: tidak ada `package.json`, `node_modules`, atau Vite.

---

## 3. Peta halaman publik

| Halaman | URL | Isi utama |
|---|---|---|
| Beranda | `/` | Hero, profil singkat, jurusan, fasilitas, galeri, berita, CTA SPMB, kontak |
| Profil | `/profil` | Sejarah, visi, misi, sambutan kepala sekolah, identitas sekolah |
| Jurusan | `/jurusan` | Daftar kompetensi keahlian |
| Detail jurusan | `/jurusan/{slug}` | Deskripsi, kompetensi, prospek karier, guru terkait |
| Guru & staf | `/guru` | Daftar tenaga pendidik dan kependidikan |
| Fasilitas | `/fasilitas` | Daftar fasilitas sekolah |
| Mitra industri | `/industri` | Daftar mitra PKL/prakerin |
| Prestasi | `/prestasi` | Prestasi akademik dan nonakademik |
| Ekstrakurikuler | `/ekstrakurikuler` | Daftar kegiatan ekstrakurikuler |
| Detail ekstrakurikuler | `/ekstrakurikuler/{slug}` | Deskripsi, pembina, jadwal |
| Lowongan BKK | `/bkk` | Daftar lowongan kerja |
| Detail lowongan | `/bkk/{id}` | Deskripsi, persyaratan, batas lamaran, tautan daftar |
| Berita | `/berita` | Daftar berita yang sudah terbit |
| Detail berita | `/berita/{slug}` | Isi berita dan tanggal publikasi |
| Galeri | `/galeri` | Foto kegiatan dengan lightbox |
| Struktur organisasi | `/struktur-organisasi` | Susunan jabatan dan unit kerja |
| Alur PKL | `/alur-pkl` | Tahapan pelaksanaan Praktik Kerja Lapangan |
| Agenda | `/agenda` | Daftar kegiatan dan acara sekolah |
| Detail agenda | `/agenda/{slug}` | Informasi lengkap satu kegiatan |
| Unduhan | `/unduhan` | Daftar dokumen yang dapat diunduh |
| SPMB | `/spmb` | Informasi penerimaan murid baru |
| Kontak | `/kontak` | Alamat, telepon, email, WhatsApp, jam operasional, peta |
| Sitemap | `/sitemap.xml` | Sitemap dinamis |
| Robots | `/robots.txt` | Aturan indeks mesin pencari |

**Route lama yang dipertahankan:**

- `/ppdb` → dialihkan permanen (301) ke `/spmb`.
- `/program` → dialihkan permanen (301) ke `/jurusan`.
- `/program/{slug}` → dialihkan permanen (301) ke `/jurusan/{slug}`.

---

## 4. Modul dashboard admin

Semua modul berada di bawah `/admin` dan hanya dapat diakses setelah login
dengan akun berperan `admin`.

| Modul | URL | Yang dapat dikelola |
|---|---|---|
| Dashboard | `/admin` | Ringkasan jurusan, guru, mitra, prestasi, lowongan, berita, status SPMB |
| Akun | `/admin/akun` | Nama, email, dan kata sandi sendiri |
| Profil Sekolah | `/admin/profil` | Sejarah, visi, misi, deskripsi, sambutan & foto kepala sekolah, NPSN, akreditasi, tahun berdiri, jumlah siswa/guru/mitra |
| Jurusan | `/admin/jurusan` | Nama, singkatan, slug, ringkasan, deskripsi, daftar kompetensi, prospek karier, lama belajar, gambar, urutan, status aktif |
| Guru & Staf | `/admin/guru` | Nama, jabatan, tipe, mata pelajaran, jurusan terkait, foto, urutan, status aktif |
| Ekstrakurikuler | `/admin/ekstrakurikuler` | Nama, slug, deskripsi, pembina, jadwal, gambar, urutan, status aktif |
| Prestasi | `/admin/prestasi` | Judul, tingkat, tahun, peraih, deskripsi, gambar, status aktif |
| Fasilitas | `/admin/fasilitas` | Nama, slug, deskripsi, kategori, gambar, urutan, status publikasi |
| Galeri | `/admin/galeri` | Judul, keterangan, kategori, gambar, urutan, status publikasi |
| Berita | `/admin/berita` | Judul, slug, ringkasan, kategori, isi, gambar, jadwal terbit, status draf/terbit |
| Mitra Industri | `/admin/mitra-industri` | Nama, bidang, logo, website, urutan, status aktif |
| Lowongan BKK | `/admin/lowongan-bkk` | Judul, perusahaan, lokasi, tipe, deskripsi, persyaratan, tautan daftar, batas waktu, status publikasi |
| Testimoni | `/admin/testimoni` | Nama, angkatan, jurusan, pekerjaan saat ini, isi testimoni, foto, status aktif |
| FAQ | `/admin/faq` | Pertanyaan, jawaban, kategori, urutan, status aktif |
| Struktur Organisasi | `/admin/struktur-organisasi` | Nama, jabatan, atasan langsung, urutan, status aktif |
| Alur PKL | `/admin/alur-pkl` | Judul langkah, deskripsi, urutan, status aktif |
| Agenda | `/admin/agenda` | Judul, slug, deskripsi, waktu mulai/selesai, lokasi, status terbit |
| Unduhan | `/admin/unduhan` | Judul, deskripsi, berkas, ukuran, urutan, status terbit |
| SPMB | `/admin/spmb` | Tahun ajaran, jalur & kuota, syarat, alur, jadwal, tautan pendaftaran, kontak panitia, status buka/tutup |
| Pengaturan Situs | `/admin/pengaturan` | Nama tampilan, logo, alamat, telepon, email, jam operasional, WhatsApp, Google Maps, media sosial, meta title/description |

> Testimoni aktif tampil di beranda. FAQ aktif tampil di beranda; FAQ dengan
> kategori `spmb` juga tampil di halaman SPMB. Struktur organisasi, alur PKL,
> agenda, dan unduhan masing-masing memiliki halaman publik sendiri.

**Status publikasi:**

- Jurusan, guru, struktur organisasi, ekstrakurikuler, prestasi, mitra,
  testimoni, FAQ, dan alur PKL memakai `is_active`.
- Fasilitas, galeri, lowongan BKK, agenda, dan unduhan memakai `is_published`.
- Berita memakai `status` (`draft`/`published`) **dan** `published_at`.
  Berita hanya tampil bila berstatus `published`, tanggal terbit tidak kosong,
  dan tanggal terbit sudah lewat/sama dengan waktu sekarang.

---

## 5. Teknologi dan arsitektur

| Komponen | Versi / catatan |
|---|---|
| PHP | 8.3+ (ekstensi: `gd`, `pdo_mysql`, `mbstring`, `fileinfo`, `intl`, `exif`, `zip`) |
| Laravel | 13.x |
| Database | MySQL 8 (`smkn64_db`), charset `utf8mb4` |
| Testing | PHPUnit 12, SQLite in-memory |
| CSS/JS | Bootstrap 5.3.3 + Bootstrap Icons 1.11.3 + Google Fonts via CDN |
| Build tool | Tidak ada (tanpa Node/npm/Vite) |
| CSS kustom | Hanya `public/css/app.css` |
| Penyimpanan gambar | Lokal (`storage/app/public`) atau S3/Cloudflare R2 (`UPLOADS_DISK`) |
| Zona waktu / locale | `Asia/Jakarta` / `id` |
| Autentikasi | Session Laravel, satu peran `admin` |

**Pola arsitektur:**

- **MVC Laravel** dengan controller publik dan admin yang terpisah.
- **Blade components** untuk navbar, footer, kartu, empty state, uploader,
  form field, dan komponen UI lain.
- **Form Request** untuk validasi form admin.
- **Middleware** `auth` + `admin` (`EnsureAdmin`) untuk melindungi dashboard.
- **Model `current()`** untuk tabel pengaturan satu baris
  (`school_profiles`, `site_settings`, `spmb`).
- **Support class** untuk logika yang dipakai berulang:
  - `ImageUploader` — simpan, perkecil, dan hapus gambar.
  - `WhatsappNumber` — normalisasi nomor ke format `62...`.
  - `IndonesianDate` — format tanggal Indonesia.
- **Storage abstraction** Laravel untuk mendukung disk lokal maupun S3/R2.

**Alur request publik:**

```
Browser → routes/web.php → Controller Public → Model Eloquent → Blade view → HTML
```

**Alur request admin:**

```
Browser → /admin/* → middleware auth + admin → Controller Admin
        → Form Request (validasi) → Model → redirect + flash message
```

---

## 6. Tema dan identitas visual

Tema mengikuti logo resmi sekolah: **hijau** pada perisai, **merah** pada pita,
dan **biru** pada bidang dalam perisai. Hijau dipakai sebagai warna utama,
merah sebagai aksen, dan biru hanya sebagai penyeimbang.

| Peran | Warna |
|---|---|
| Hijau utama | `#00843F` |
| Hijau tua | `#00602D` |
| Hijau sangat tua | `#004A23` |
| Merah aksen | `#D91F26` |
| Merah tua | `#B0161C` |
| Biru logo | `#0F51A1` |
| Latar hijau muda | `#EAF7EF` |
| Latar halaman | `#F6FAF7` |
| Teks utama | `#182720` |
| Teks sekunder | `#5A6B61` |

**Tipografi:**

- Heading: **Plus Jakarta Sans** (600/700/800).
- Isi: **Inter** (400/500/600).
- Dimuat dari Google Fonts; bila CDN tidak tersedia, fallback ke font sistem.

**Elemen visual:**

- Pita merah–hijau tipis di bawah navbar, mengikuti pita pada logo.
- Footer hijau tua dengan garis merah di atasnya.
- Hero bergradasi hijau lembut dengan aksen merah halus.
- Tombol utama hijau; tombol aksi SPMB merah.
- Logo sekolah tampil di navbar, halaman login admin, dan sidebar admin.
- Favicon dibuat dari logo sekolah.
- Fokus keyboard memakai outline merah yang jelas.
- Animasi dibatasi dan menghormati `prefers-reduced-motion`.

Seluruh warna dan tipografi didefinisikan sebagai CSS variables di
`public/css/app.css`, lalu menimpa variabel Bootstrap seperlunya.

---

## 7. Model data

Semua tabel dibuat melalui migrasi di `database/migrations/`.

| Kelompok | Tabel | Isi |
|---|---|---|
| Identitas & pengaturan | `site_settings` | Nama situs, logo, alamat, kontak, WhatsApp, peta, media sosial, meta SEO |
| Identitas & pengaturan | `school_profiles` | Sejarah, visi, misi, sambutan kepala sekolah, NPSN, akreditasi, statistik |
| Identitas & pengaturan | `spmb` | Tahun ajaran, jalur, syarat, alur, jadwal, tautan, kontak, status |
| Akademik | `jurusan` | Kompetensi keahlian, deskripsi, kompetensi, prospek karier |
| Akademik | `guru` | Guru dan staf, jabatan, mata pelajaran, jurusan terkait |
| Akademik | `struktur_organisasi` | Nama, jabatan, atasan langsung, urutan, status aktif |
| Akademik | `ekstrakurikuler` | Kegiatan ekstrakurikuler, pembina, jadwal |
| Akademik | `prestasi` | Prestasi, tingkat, tahun, peraih |
| Kemitraan & karier | `mitra_industri` | Mitra industri, bidang, logo, website |
| Kemitraan & karier | `lowongan_bkk` | Lowongan kerja BKK, persyaratan, batas waktu |
| Kemitraan & karier | `testimoni` | Testimoni alumni, angkatan, jurusan, pekerjaan |
| Kemitraan & karier | `alur_pkl` | Tahapan pelaksanaan PKL |
| Konten | `fasilitas` | Fasilitas sekolah |
| Konten | `galeri` | Foto galeri dan kategori |
| Konten | `berita` | Berita, kategori, status, jadwal terbit |
| Konten | `faq` | Pertanyaan umum dan jawaban |
| Konten | `agenda` | Agenda kegiatan, waktu, lokasi, status terbit |
| Konten | `unduhan` | Dokumen unduhan, path berkas, ukuran, status terbit |
| Akun | `users` | Akun admin (satu peran: `admin`) |
| Infrastruktur | `migrations`, `sessions`, `cache`, `cache_locks`, `jobs`, `job_batches`, `failed_jobs`, `password_reset_tokens` | Bawaan Laravel; tabel job tidak dipakai karena queue `sync` |

**Catatan kompatibilitas:**

- Tabel pengaturan SPMB lama sudah dihapus; data SPMB aktif disimpan di `spmb`.
- Hanya URL `/program` dan `/ppdb` yang dipertahankan, sebagai redirect permanen
  301. Nama route dan URL admin lama sudah dihapus.
- Semua nama tabel, model, controller, route, view, dan komponen memakai bahasa
  Indonesia bentuk tunggal.

**Aturan data pengaturan satu baris:**

`SchoolProfile::current()`, `SiteSetting::current()`, dan `Spmb::current()`
mengambil baris pertama atau membuatnya bila belum ada. Jangan membuat lebih dari
satu baris untuk tabel-tabel tersebut.

**Gambar dan dokumen:**

- Disimpan di disk sesuai `UPLOADS_DISK`.
- Lokal: `storage/app/public/{logo|profil|jurusan|guru|ekstrakurikuler|prestasi|mitra|fasilitas|galeri|berita|testimoni}/...`.
- Diakses lewat `public/storage` hasil `php artisan storage:link`, atau URL publik
  bucket untuk S3/R2.
- Nama file acak; nama asli unggahan tidak dipakai.
- Gambar maksimal 2 MB; lebar maksimal 400/800/1600 px sesuai konteks.
- Dokumen unduhan maksimal 10 MB dan disimpan di folder `unduhan/`; tautan
  unduh hanya tersedia untuk data berstatus terbit.
- File lama dihapus saat gambar/berkas diganti atau data dihapus.

---

## 8. Alur kerja aplikasi

### 8.1 Pengunjung

1. Pengunjung membuka beranda dan melihat ringkasan profil, jurusan, fasilitas,
   galeri, berita, dan ajakan SPMB.
2. Navigasi utama membuka halaman publik sesuai kebutuhan.
3. Halaman detail hanya menampilkan data yang aktif/terbit.
4. Kontak diarahkan ke WhatsApp, telepon, email, atau Google Maps.
5. Halaman SPMB menampilkan informasi; pendaftaran dilakukan melalui tautan
   eksternal bila sekolah menyediakannya.

### 8.2 Admin

1. Admin membuka `/admin/login`.
2. Sistem memvalidasi input, membatasi 5 percobaan per menit per email + IP,
   lalu meregenerasi session setelah login berhasil.
3. Admin mengelola konten melalui modul yang tersedia.
4. Setiap perubahan divalidasi di server dan disimpan ke database.
5. Perubahan langsung tampil di halaman publik sesuai status publikasi.

### 8.3 Upload gambar

1. Form mengirim berkas JPG/PNG/WebP maksimal 2 MB.
2. Form Request memvalidasi MIME, ekstensi, dan ukuran.
3. `ImageUploader` membaca gambar dengan GD, memperkecil bila melebihi lebar
   maksimal, lalu meng-encode ulang (sekaligus menghapus metadata EXIF).
4. Berkas disimpan dengan nama acak pada disk unggahan.
5. Bila mengganti gambar, berkas lama dihapus agar tidak menumpuk.
6. Bila GD tidak aktif, admin menerima pesan error yang jelas.

### 8.4 Berita terjadwal

Berita dengan `published_at` di masa depan belum tampil di publik dan ditandai
"Terjadwal" di dashboard. Tidak perlu cron: status dihitung saat halaman dibuka
berdasarkan `published_at <= sekarang`.

---

## 9. Keamanan

- **CSRF** aktif pada seluruh form (`@csrf`).
- **Validasi server-side** melalui Form Request dan `validate()`; input pengguna
  tidak dipercaya.
- **Middleware admin**: `auth` + `EnsureAdmin`; tamu diarahkan ke login, pengguna
  non-admin mendapat 403.
- **Throttle login**: maksimal 5 percobaan per 60 detik per kombinasi email + IP.
- **Session aman**: regenerasi setelah login, invalidasi + regenerasi token saat
  logout, dan `remember me` opsional.
- **Kata sandi** di-hash dengan bcrypt (`BCRYPT_ROUNDS=12`).
- **Tidak ada pendaftaran publik**; akun admin dibuat lewat Artisan command.
- **Upload aman**: MIME divalidasi, ukuran dibatasi, nama file diacak, gambar
  di-encode ulang, dan EXIF dihapus.
- **Output escaping**: data pengguna ditampilkan dengan `{{ }}`; `{!! !!}` hanya
  dipakai untuk `nl2br(e($teks))` agar baris baru tampil tanpa membuka celah XSS.
- **Halaman admin** memakai `noindex, nofollow`.
- **`.env`** tidak ikut di-commit. Jangan pernah mengunggahnya.
- **Produksi**: `APP_DEBUG=false`, `APP_ENV=production`, HTTPS, dan kata sandi
  database yang kuat.

---

## 10. SEO dan aksesibilitas

**SEO:**

- Judul dan meta description unik per halaman, dengan fallback dari pengaturan situs.
- Canonical URL untuk setiap halaman publik.
- Open Graph lengkap (`og:title`, `og:description`, `og:type`, `og:url`,
  `og:image`, `og:image:alt`, `og:locale`) dan Twitter Card.
- JSON-LD `EducationalOrganization`, `WebSite`, `WebPage`, `NewsArticle`,
  `Course`, `BreadcrumbList`, dan `ItemList`.
- Filter kategori berita di `/berita?kategori=...`.
- Sitemap XML dinamis (`/sitemap.xml`) dan robots.txt (`/robots.txt`).
- Halaman admin `noindex, nofollow`.
- Halaman 404 yang ramah dan tetap memakai layout publik.
- URL bersih dengan slug untuk jurusan, ekstrakurikuler, berita, dan agenda.

**Aksesibilitas:**

- Struktur heading hierarkis, label form, dan teks alternatif gambar.
- Fokus keyboard terlihat jelas (`:focus-visible`).
- Kontras warna diuji memenuhi WCAG AA.
- Tombol dan tautan memiliki area klik yang memadai.
- Animasi dibatasi dan menghormati `prefers-reduced-motion`.
- Audit Lighthouse lokal terakhir: **Accessibility 100, Best Practices 100,
  SEO 100** pada beranda dan halaman SPMB.

---

## 11. Mode demo dan data demo

Mode demo diaktifkan lewat `.env`:

```dotenv
DEMO_MODE=true
```

Saat aktif, halaman publik menampilkan banner merah
**"Versi demo — bukan website resmi"**.

Data demo disediakan oleh `DemoSeeder` dan bersifat **idempoten** (aman dijalankan
berulang karena memakai `updateOrCreate`). Isinya mencakup identitas sekolah,
logo resmi, dua jurusan, guru, fasilitas, galeri, berita, prestasi,
ekstrakurikuler, mitra industri, lowongan BKK, testimoni, FAQ, dan SPMB.

**Identitas yang dipakai pada data demo:**

- Nama tampilan: **SMKN 64 Jakarta**
- NPSN: **69992315**
- Alamat: Jl. Mpo Nori RT 09 RW 03, Bambu Apus, Cipayung, Jakarta Timur, DKI Jakarta 13890
- Telepon: 08978891895
- Email: info@smkn64-jkt.sch.id
- Kepala sekolah: Dewi Puspitasari, M.Par.
- Akreditasi: B
- Tahun berdiri: 2019
- Jurusan: Rekayasa Perangkat Lunak (RPL) dan Desain Komunikasi Visual (DKV)
- Motto: **SUKSES** (Smart, Unggul, Kreatif, Semangat, Empati, dan Sopan)
- Media sosial demo: `facebook.com/smkn64jakarta`, `instagram.com/smkn64jakarta`,
  `youtube.com/@smkn64jakarta`, dan `tiktok.com/@smkn64jakarta` (wajib dikonfirmasi
  sebelum dipakai sebagai akun resmi)

**Jumlah data demo saat ini:** 2 jurusan, 14 guru, 6 struktur organisasi,
8 fasilitas, 6 galeri, 9 berita, 8 prestasi, 6 ekstrakurikuler, 8 mitra industri,
5 lowongan BKK, 4 testimoni, 8 FAQ, 5 langkah alur PKL, 4 agenda, dan
2 berkas unduhan. Tautan media sosial demo juga diisi agar tampilan footer dan
halaman kontak dapat diuji.

**Cara memakai:**

```powershell
php artisan db:seed --class=DemoSeeder
```

Lalu set `DEMO_MODE=true`. Untuk kembali ke kondisi netral, set
`DEMO_MODE=false` dan hapus/ganti data demo lewat dashboard.

> Data identitas di atas berasal dari situs resmi sekolah dan tetap perlu
> dikonfirmasi sebelum situs dinyatakan resmi. Lihat
> [docs/konfirmasi-sekolah.md](docs/konfirmasi-sekolah.md).

---

## 12. Instalasi dari nol

### 12.1 Prasyarat

```powershell
php -v
php -m      # pastikan gd, pdo_mysql, mbstring, fileinfo, intl, exif, zip ada
composer -V
```

### 12.2 Ambil dependensi PHP

```powershell
composer install
```

### 12.3 Siapkan konfigurasi lingkungan

```powershell
Copy-Item .env.example .env
php artisan key:generate
```

### 12.4 Buat database

Lewat Laragon/phpMyAdmin atau CLI MySQL:

```sql
CREATE DATABASE smkn64_db
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
```

Sesuaikan bagian ini di `.env`:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=smkn64_db
DB_USERNAME=root
DB_PASSWORD=
```

### 12.5 Jalankan migrasi dan data awal

```powershell
php artisan migrate --seed
```

`--seed` hanya membuat record awal netral (profil, pengaturan situs, SPMB kosong).
Tidak ada akun dan tidak ada konten contoh.

### 12.6 Aktifkan penyimpanan gambar

```powershell
php artisan storage:link
```

Perintah ini membuat `public/storage` → `storage/app/public`. Tanpa langkah ini,
logo dan gambar unggahan tidak akan tampil. Bila gagal karena izin, aktifkan
*Developer Mode* Windows atau jalankan terminal sebagai Administrator.

### 12.7 Buat akun admin

```powershell
php artisan app:create-admin
```

Perintah akan menanyakan nama, email, dan kata sandi (minimal 8 karakter).
Bisa juga tanpa interaksi:

```powershell
php artisan app:create-admin --name="Administrator" --email=admin@sekolah.sch.id --password="kata-sandi-kuat"
```

Kata sandi juga dapat dibaca dari variabel lingkungan `ADMIN_PASSWORD`.

### 12.8 Jalankan server

```powershell
php artisan serve
```

- Website publik: <http://127.0.0.1:8000>
- Dashboard admin: <http://127.0.0.1:8000/admin/login>

Alternatif: buat virtual host Laragon yang mengarah ke folder `public/`.
**Jangan** mengarahkan document root ke folder proyek (root), karena `.env` bisa
terbaca publik.

### 12.9 (Opsional) Data demo

```powershell
php artisan db:seed --class=DemoSeeder
```

Lalu set `DEMO_MODE=true` di `.env` agar banner demo tampil. Bila konfigurasi
sedang di-cache, jalankan `php artisan optimize:clear`.

---

## 13. Konfigurasi `.env`

| Variabel | Kegunaan | Contoh |
|---|---|---|
| `APP_NAME` | Nama aplikasi | `"SMKN 64 Jakarta"` |
| `APP_ENV` | Lingkungan aplikasi | `local` / `production` |
| `APP_KEY` | Kunci enkripsi Laravel | hasil `key:generate` |
| `APP_DEBUG` | Tampilkan detail error | `false` (produksi) |
| `APP_URL` | URL dasar aplikasi | `https://smkn64.example.sch.id` |
| `APP_LOCALE` | Bahasa aplikasi | `id` |
| `DEMO_MODE` | Tampilkan banner demo | `true` / `false` |
| `ADMIN_PASSWORD` | Opsional, kata sandi `app:create-admin` | `kata-sandi-kuat` |
| `DB_CONNECTION` | Driver database | `mysql` |
| `DB_HOST` / `DB_PORT` | Alamat database | `127.0.0.1` / `3306` |
| `DB_DATABASE` | Nama database | `smkn64_db` |
| `DB_USERNAME` / `DB_PASSWORD` | Kredensial database | `root` / kosong |
| `SESSION_DRIVER` | Penyimpanan session | `database` |
| `CACHE_STORE` | Penyimpanan cache | `database` |
| `QUEUE_CONNECTION` | Driver queue | `sync` |
| `UPLOADS_DISK` | Disk gambar | `public` atau `s3` |
| `FILESYSTEM_DISK` | Disk default Laravel | `local` |
| `AWS_ACCESS_KEY_ID` | Kredensial S3/R2 | sesuai penyedia |
| `AWS_SECRET_ACCESS_KEY` | Kredensial S3/R2 | sesuai penyedia |
| `AWS_DEFAULT_REGION` | Region S3/R2 | `auto` untuk R2 |
| `AWS_BUCKET` | Nama bucket | `smkn64-assets` |
| `AWS_ENDPOINT` | Endpoint S3/R2 | endpoint penyedia |
| `AWS_URL` | URL publik bucket | URL publik bucket |

Jika `UPLOADS_DISK=s3`, seluruh gambar (termasuk logo) disimpan di bucket dan
harus dapat diakses publik. Untuk penggunaan lokal, cukup `public` +
`php artisan storage:link`.

---

## 14. Perintah yang sering dipakai

```powershell
php artisan route:list --except-vendor   # daftar route
php artisan migrate:status               # status migrasi
php artisan migrate --seed               # migrasi + data awal netral
php artisan db:seed --class=DemoSeeder   # data demo
php artisan app:create-admin             # buat/perbarui akun admin
php artisan storage:link                 # aktifkan akses gambar publik
php artisan config:clear                 # hapus cache konfigurasi
php artisan view:clear                   # hapus cache view
php artisan optimize:clear               # bersihkan semua cache
php artisan test                         # jalankan test
vendor\bin\pint                          # rapikan format kode
```

**Reset total database pengembangan** (menghapus semua data):

```powershell
php artisan migrate:fresh --seed
php artisan db:seed --class=DemoSeeder
```

> Perintah `migrate:fresh` bersifat destruktif. Jangan jalankan di produksi.

---

## 15. Pengujian

```powershell
php artisan test
vendor\bin\pint --test
```

- Test memakai **SQLite in-memory** (lihat `phpunit.xml`), sehingga tidak
  menyentuh database `smkn64_db`.
- Cakupan saat ini: **149 test, 596 assertion**, mencakup route publik, visibilitas
  konten, SEO, mode demo, autentikasi admin, CRUD admin, validasi upload gambar
  dan dokumen, pengaturan situs, media sosial, agenda, serta unduhan.
- `vendor\bin\pint --test` memastikan format kode sesuai standar Laravel Pint.

---

## 16. Struktur folder

```
app/
  Console/Commands/            perintah Artisan (termasuk app:create-admin)
  Http/Controllers/Admin/      controller dashboard admin
  Http/Controllers/Public/     controller halaman publik
  Http/Middleware/EnsureAdmin.php
  Http/Requests/Admin/         validasi form admin
  Models/                      model Eloquent
  Support/ImageUploader.php    resize + simpan + hapus gambar (GD)
  Support/DocumentUploader.php simpan + hapus dokumen unduhan
  Support/WhatsappNumber.php   normalisasi nomor WhatsApp
  Support/IndonesianDate.php   format tanggal Indonesia
database/
  factories/                   factory untuk pengujian
  migrations/                  skema tabel
  seeders/DatabaseSeeder.php   data awal netral
  seeders/DemoSeeder.php       data demo idempoten
docs/                          dokumentasi tambahan
public/
  css/app.css                  satu-satunya CSS kustom
  favicon.ico                  favicon dari logo sekolah
  storage/                     symlink hasil storage:link
resources/views/
  public/                      halaman publik
    bkk/                       daftar + detail lowongan
    ekstrakurikuler/           daftar + detail ekstrakurikuler
    guru/                      daftar guru
    industri/                  daftar mitra industri
    jurusan/                   daftar + detail jurusan
    berita/                    daftar + detail berita
    prestasi/                  daftar prestasi
    struktur/                  struktur organisasi
    alur-pkl/                  alur PKL
    agenda/                    daftar + detail agenda
    unduhan/                   daftar berkas unduhan
  admin/                       halaman dashboard
  components/                  komponen Blade publik dan admin
  layouts/                     layout publik, admin, dan login admin
routes/web.php                 semua route publik + admin
storage/app/public/            gambar unggahan + logo demo
tests/                         feature test
```

---

## 17. Deployment

Panduan lengkap tersedia di:

- [Deployment gratis: Render + MySQL + R2](docs/deployment-render.md)
- [Konfigurasi produksi dan backup](docs/deployment-dan-backup.md)

**Ringkasan langkah produksi:**

1. Set `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-sekolah`.
2. Siapkan database MySQL 8 dan jalankan `php artisan migrate --force`.
3. Jalankan `php artisan storage:link` bila memakai disk lokal, atau konfigurasi
   `UPLOADS_DISK=s3` + kredensial bucket.
4. Buat akun admin dengan `php artisan app:create-admin`.
5. Aktifkan HTTPS.
6. Jalankan `php artisan optimize` setelah konfigurasi final.
7. Pastikan folder `storage/` dan `bootstrap/cache/` dapat ditulis.
8. Siapkan backup database dan berkas unggahan secara berkala.
9. Set `DEMO_MODE=false` dan ganti/hapus data demo sebelum situs diumumkan.

> Jangan mengarahkan document root ke folder proyek. Arahkan ke `public/`.

---

## 18. Keterbatasan versi ini

- Satu sekolah, satu bahasa (Indonesia), satu peran `admin`.
- Bukan sistem akademik: tidak ada absensi, nilai, jadwal pelajaran, atau e-learning.
- SPMB hanya halaman informasi; tidak ada formulir pendaftaran online bawaan.
- Tidak ada formulir kontak (untuk menghindari spam); komunikasi lewat WhatsApp,
  telepon, atau email.
- Tidak ada editor WYSIWYG; teks panjang berupa teks biasa dengan baris baru.
- Tidak ada komentar, newsletter, pencarian publik, atau multi-bahasa.
- Tidak ada peran editor/kontributor, 2FA, log aktivitas, atau reset kata sandi
  lewat email.
- Testimoni, FAQ, struktur organisasi, alur PKL, agenda, dan unduhan dikelola di
  dasbor. Testimoni dan FAQ aktif tampil di beranda; FAQ kategori `spmb` juga
  tampil di halaman SPMB.
- Tidak ada tempat sampah/restore; data yang dihapus hilang permanen.
- Mengubah slug jurusan/berita membuat URL lama 404 (belum ada redirect otomatis).
- Gambar disimpan satu versi (bukan `srcset`/beberapa ukuran).
- Tampilan mengandalkan CDN Bootstrap, Bootstrap Icons, dan Google Fonts.
- Backup masih manual; cache dan session memakai database, queue memakai `sync`; belum Redis.
- Test berjalan di SQLite in-memory; perilaku MySQL di produksi diuji manual.
- Belum ada CI otomatis.

Daftar lengkap ada di [docs/keterbatasan.md](docs/keterbatasan.md).

---

## 19. Dokumentasi

- [Struktur database](docs/database.md)
- [Daftar route](docs/route.md)
- [Panduan dashboard admin](docs/panduan-admin.md)
- [Deployment gratis: Render + MySQL + R2](docs/deployment-render.md)
- [Konfigurasi produksi dan backup](docs/deployment-dan-backup.md)
- [Informasi sekolah yang masih perlu dikonfirmasi](docs/konfirmasi-sekolah.md)
- [Daftar keterbatasan](docs/keterbatasan.md)

---

## 20. Lisensi

Kode proyek ini disiapkan untuk SMK Negeri 64 Jakarta. Laravel dirilis dengan
lisensi MIT.
