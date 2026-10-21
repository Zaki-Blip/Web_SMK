# Spesifikasi Proyek — Website Profil SMKN 64 Jakarta

## 1. Tujuan dan status

Website profil SMK Negeri 64 Jakarta yang menyediakan informasi sekolah untuk
pengunjung umum dan dasbor bagi pengelola sekolah.

Status: **demo pengembangan**. Situs belum boleh diumumkan sebagai situs resmi
sebelum identitas, kontak, dan konten sekolah dikonfirmasi. Mode demo menampilkan
banner “Versi demo — bukan website resmi”.

Sasaran utama:

1. Menyajikan profil, jurusan, guru, struktur organisasi, fasilitas, prestasi,
   ekstrakurikuler, mitra industri, lowongan BKK, alur PKL, agenda, unduhan,
   berita, galeri, SPMB, dan kontak.
2. Memudahkan pengelola sekolah memperbarui konten tanpa mengubah kode.
3. Menjadi contoh aplikasi Laravel yang aman, responsif, dan mudah dipasang.

## 2. Batasan teknologi

| Komponen | Ketentuan |
|---|---|
| PHP | 8.3+ |
| Laravel | 13.x |
| Database | MySQL 8 (`smkn64_db`), SQLite in-memory untuk test |
| Frontend | Bootstrap 5.3.3, Bootstrap Icons, dan Google Fonts lewat CDN |
| CSS kustom | Hanya `public/css/app.css` |
| Build frontend | Tanpa Node/npm/Vite |
| Gambar | GD bawaan PHP; tanpa Intervention Image |
| Queue | `sync`; tidak ada worker |
| Session/cache | `database` |
| Zona waktu | `Asia/Jakarta` |
| Bahasa | Antarmuka dan konten formal Indonesia |

## 3. Konvensi nama

- Tabel, model, controller, route, folder view, dan komponen konten memakai
  bahasa Indonesia bentuk tunggal.
- Contoh tabel: `jurusan`, `guru`, `struktur_organisasi`, `ekstrakurikuler`,
  `prestasi`, `mitra_industri`, `lowongan_bkk`, `testimoni`, `faq`, `fasilitas`,
  `galeri`, `berita`, `alur_pkl`, `agenda`, `unduhan`.
- Contoh route publik: `beranda`, `profil.index`, `jurusan.index`,
  `jurusan.show`, `guru.index`, `struktur.index`, `fasilitas.index`,
  `galeri.index`, `alur-pkl.index`, `agenda.index`, `agenda.show`,
  `unduhan.index`, `berita.index`, `berita.show`, `spmb.index`, `kontak.index`.
- Route admin memakai prefix `admin.` dan nama modul Indonesia, misalnya
  `admin.jurusan.index`, `admin.berita.index`, `admin.fasilitas.index`.
- Nama route dan URL lama tidak dipertahankan sebagai alias. Hanya URL
  `/program` dan `/ppdb` yang dialihkan permanen 301.
- Teks antarmuka formal Indonesia; nama variabel internal boleh tetap deskriptif.

## 4. Halaman publik

| Halaman | URL | Isi utama |
|---|---|---|
| Beranda | `/` | Hero, profil singkat, jurusan, fasilitas, galeri, berita, prestasi, testimoni, FAQ, CTA SPMB, kontak |
| Profil | `/profil` | Sejarah, visi, misi, sambutan kepala sekolah, identitas sekolah |
| Jurusan | `/jurusan` | Daftar kompetensi keahlian |
| Detail jurusan | `/jurusan/{slug}` | Deskripsi, kompetensi, prospek karier, guru terkait |
| Guru dan staf | `/guru` | Daftar guru/staf dan filter jurusan |
| Fasilitas | `/fasilitas` | Daftar fasilitas yang terbit |
| Industri | `/industri` | Mitra industri |
| Prestasi | `/prestasi` | Prestasi dan peraih |
| Ekstrakurikuler | `/ekstrakurikuler` | Daftar kegiatan |
| Detail ekstrakurikuler | `/ekstrakurikuler/{slug}` | Deskripsi, pembina, jadwal |
| BKK | `/bkk` | Lowongan kerja yang terbit |
| Detail BKK | `/bkk/{id}` | Deskripsi, persyaratan, batas waktu, tautan daftar |
| Berita | `/berita` | Daftar berita terbit |
| Detail berita | `/berita/{slug}` | Isi berita; draf/terjadwal menghasilkan 404 |
| Galeri | `/galeri` | Grid foto dengan lightbox |
| Struktur organisasi | `/struktur-organisasi` | Hierarki jabatan dan unit kerja |
| Alur PKL | `/alur-pkl` | Tahapan pelaksanaan PKL |
| Agenda | `/agenda` | Daftar kegiatan sekolah |
| Detail agenda | `/agenda/{slug}` | Informasi lengkap kegiatan |
| Unduhan | `/unduhan` | Daftar berkas yang dapat diunduh |
| SPMB | `/spmb` | Informasi penerimaan murid baru |
| Kontak | `/kontak` | Alamat, telepon, email, WhatsApp, jam operasional, peta |
| Sitemap/robots | `/sitemap.xml`, `/robots.txt` | SEO dinamis |

Aturan tampil:

- Jurusan, guru, struktur organisasi, ekstrakurikuler, prestasi, mitra,
  testimoni, FAQ, dan alur PKL memakai `is_active`.
- Fasilitas, galeri, lowongan BKK, agenda, dan unduhan memakai `is_published`.
- Berita harus berstatus `published` dan `published_at` sudah lewat.
- Agenda draf dan berkas unduhan draf tidak dapat diakses publik.
- Halaman harus tetap tampil dengan empty state saat database kosong.

## 5. Dasbor admin

Prefix `/admin`, hanya untuk pengguna login dengan role `admin`. Tidak ada
pendaftaran publik. Login memakai throttle 5 percobaan per menit per email+IP,
regenerasi session saat login, dan logout POST.

Modul:

| Modul | URL dasar | Kemampuan |
|---|---|---|
| Dasbor | `/admin` | Statistik konten dan berita terbaru |
| Akun | `/admin/akun` | Ubah nama, email, kata sandi sendiri |
| Profil sekolah | `/admin/profil` | Sejarah, visi, misi, sambutan, identitas |
| Jurusan | `/admin/jurusan` | CRUD, pencarian, urutan, status aktif |
| Guru/staf | `/admin/guru` | CRUD, foto, jurusan terkait, status aktif |
| Mitra industri | `/admin/mitra-industri` | CRUD, logo, website, status aktif |
| Prestasi | `/admin/prestasi` | CRUD, tingkat, tahun, status aktif |
| Ekstrakurikuler | `/admin/ekstrakurikuler` | CRUD, gambar, status aktif |
| Lowongan BKK | `/admin/lowongan-bkk` | CRUD, batas waktu, status publikasi |
| Testimoni | `/admin/testimoni` | CRUD, foto, status aktif |
| FAQ | `/admin/faq` | CRUD, kategori, urutan, status aktif |
| Struktur organisasi | `/admin/struktur-organisasi` | CRUD, atasan langsung, urutan, status aktif |
| Alur PKL | `/admin/alur-pkl` | CRUD, urutan, status aktif |
| Agenda | `/admin/agenda` | CRUD, slug, jadwal, lokasi, status publikasi |
| Unduhan | `/admin/unduhan` | CRUD, unggah berkas, status publikasi |
| Fasilitas | `/admin/fasilitas` | CRUD, gambar, status publikasi |
| Galeri | `/admin/galeri` | CRUD, gambar, status publikasi |
| Berita | `/admin/berita` | CRUD, slug unik, jadwal, draf/terbit |
| SPMB | `/admin/spmb` | Tahun ajaran, jalur, syarat, alur, jadwal, kontak |
| Pengaturan situs | `/admin/pengaturan` | Identitas, kontak, logo, SEO dasar |

Semua form memakai CSRF, validasi server-side, dan konfirmasi hapus. Halaman
admin memakai `noindex`.

## 6. Database

Tabel utama:

- `jurusan`: nama, singkatan, slug unik, ringkasan, deskripsi, kompetensi JSON,
  prospek karier, lama belajar, gambar, urutan, status aktif.
- `guru`: nama, jabatan, tipe, mata pelajaran, `jurusan_id`, foto, urutan,
  status aktif.
- `ekstrakurikuler`: nama, slug unik, deskripsi, pembina, jadwal, gambar,
  urutan, status aktif.
- `prestasi`: judul, tingkat, tahun, peraih, deskripsi, gambar, status aktif.
- `mitra_industri`: nama, bidang, logo, website, urutan, status aktif.
- `lowongan_bkk`: judul, perusahaan, lokasi, tipe, deskripsi, persyaratan,
  tautan daftar, batas waktu, status publikasi.
- `testimoni`: nama, angkatan, `jurusan_id`, pekerjaan, isi, foto, status aktif.
- `faq`: pertanyaan, jawaban, kategori, urutan, status aktif.
- `struktur_organisasi`: nama, jabatan, `parent_id`, urutan, status aktif.
- `alur_pkl`: judul, deskripsi, urutan, status aktif.
- `agenda`: judul, slug unik, deskripsi, waktu mulai/selesai, lokasi, status
  publikasi.
- `unduhan`: judul, deskripsi, path berkas, ukuran, urutan, status publikasi.
- `fasilitas`: nama, slug unik, deskripsi, gambar, kategori, urutan, status
  publikasi.
- `galeri`: judul, keterangan, gambar, kategori, urutan, status publikasi.
- `berita`: judul, slug unik, ringkasan, isi, gambar, kategori, jadwal terbit,
  status draf/terbit.
- `school_profiles`, `site_settings`, `spmb`: masing-masing satu baris,
  diakses lewat `::current()`.
- `users`: akun admin.
- Tabel bawaan Laravel: `migrations`, `sessions`, `cache`, `cache_locks`,
  `jobs`, `job_batches`, `failed_jobs`, `password_reset_tokens`. Tabel job tidak
  dipakai karena queue `sync`.

Relasi: `guru.jurusan_id` dan `testimoni.jurusan_id` ke `jurusan.id`, serta
`struktur_organisasi.parent_id` ke dirinya sendiri, dengan `nullOnDelete`.
Foreign key hanya untuk relasi nyata.

## 7. Gambar dan dokumen

- Format JPG/PNG/WebP; validasi MIME dan ekstensi.
- Batas saat ini 2 MB; target peningkatan 8 MB dan varian WebP/srcset pada fase
  pengembangan berikutnya.
- Resize GD: lebar maksimal 1600/800/400 px sesuai konteks; rasio dipertahankan.
- Nama file acak; EXIF dihapus saat encode ulang.
- Disimpan di disk `public` (`storage/app/public/{modul}`) atau S3/R2.
- File lama dihapus saat gambar diganti atau record dihapus.
- `alt`, `width`, `height`, dan `loading="lazy"` dipakai pada gambar konten.
- Dokumen unduhan: PDF/DOC/DOCX/XLS/XLSX/PPT/PPTX/ZIP/TXT, maksimal 10 MB,
  disimpan di folder `unduhan/`, dan hanya dapat diunduh setelah terbit.

## 8. SEO, keamanan, dan aksesibilitas

- Title unik, meta description, canonical, Open Graph, Twitter Card, dan JSON-LD.
- Sitemap mencakup halaman publik, berita terbit, dan agenda terbit.
- `robots.txt` mengizinkan publik dan melarang `/admin`; halaman admin `noindex`.
- CSRF pada semua form, validasi server-side, `$fillable`, password hashing,
  escape Blade, dan tanpa `{!! !!}` untuk input pengguna.
- Teks panjang dirender dengan `nl2br(e($teks))`.
- Login throttle, session regeneration, dan logout aman.
- Fokus terlihat, label input, kontras memadai, navigasi keyboard, dan layout
  responsif di 360/768/1024/1440 px.

## 9. Data demo

- `DatabaseSeeder` hanya membuat profil, pengaturan situs, dan SPMB netral.
- `DemoSeeder` terpisah, idempoten (`updateOrCreate`), dan tidak dipanggil
  otomatis di produksi.
- Data demo diberi label jelas dan tidak boleh berisi klaim faktual yang belum
  dikonfirmasi.
- `DEMO_MODE=true` menampilkan banner demo; produksi memakai `false`.

## 10. Pengujian

Perintah wajib setelah perubahan:

```powershell
php artisan test
vendor\bin\pint --test
php artisan migrate:fresh --seed
php artisan db:seed --class=DemoSeeder
```

Test minimal mencakup:

- semua halaman publik dengan database kosong;
- visibilitas data draf/terbit;
- redirect `/ppdb`, `/program`, dan `/program/{slug}`;
- tidak ada nama route/URL lama;
- CRUD admin, validasi, upload, dan keamanan;
- SEO, sitemap, robots, dan JSON-LD;
- perilaku demo mode.

## 11. Roadmap remediasi

1. **Fase 1** — hapus kode mati, seragamkan nama Indonesia, migrasi tabel aman,
   konfigurasi runtime, redirect lama, dan test nama lama.
2. **Fase 2 (selesai)** — publikasikan testimoni/FAQ, tautan sosial, SEO lengkap, kategori
   berita, struktur organisasi, alur PKL, agenda, dan unduhan.
3. **Fase 3** — upload 8 MB dengan varian WebP/srcset, slug terkunci + riwayat
   301, soft delete/tempat sampah, security header/CSP/SRI, throttle tulis admin,
   CI MySQL, dan optimasi query/index/cache.
4. **Fase 4** — identitas demo di `config/demo.php`, `DEMO_IDENTITY=fiktif|sekolah`,
   dan data demo untuk fitur baru.
5. **Fase 5** — README ringkas, dokumentasi route/database/admin/deployment,
   screenshot, dan daftar keterbatasan.
6. **Fase 6** — test lengkap halaman publik, redirect, SEO/JSON-LD, upload,
   soft delete, header keamanan, URL lama, dan jumlah query beranda.

## 12. Definition of done

- `php artisan test` dan `vendor\bin\pint --test` hijau.
- `migrate:fresh --seed` dan `DemoSeeder` berulang berhasil di MySQL.
- Tidak ada route/URL lama aktif selain redirect yang disetujui.
- Tidak ada data rahasia di repository.
- Aplikasi dapat dijalankan dari nol mengikuti README.
