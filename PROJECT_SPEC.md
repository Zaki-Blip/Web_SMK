# PROJECT SPEC — WEBSITE PROFIL TK ANGKASA 8 (v2)

> Cara pakai: simpan file ini sebagai `PROJECT_SPEC.md` di root proyek. Ini adalah referensi tetap.
> Untuk setiap sesi kerja, gunakan "PROMPT PER FASE" di bagian 18 (pendek), bukan menempel ulang seluruh file ini.
> Awal sesi baru, selalu mulai dengan: "Baca PROJECT_SPEC.md, lalu kerjakan Fase X sesuai bagian 18."

---

## 0. ATURAN DASAR (BACA PERTAMA)

1. **Jujur soal kemampuan.** Cek dulu apakah kamu punya akses terminal dan file.
   - Jika ADA: kerjakan langsung di proyek, jalankan perintah, dan baca hasilnya.
   - Jika TIDAK ADA: jangan berpura-pura menjalankan perintah. Berikan perintah yang harus saya jalankan, lalu minta saya menempelkan outputnya. Lanjutkan hanya berdasarkan output asli tersebut.
2. **Jangan mengarang fakta sekolah.** Data yang belum ada diberi placeholder jelas, misalnya `[BELUM DIKONFIRMASI]`.
3. **Jangan mengklaim sesuatu berhasil** (perintah, test, fitur) sebelum benar-benar dijalankan dan hasilnya diperiksa.
4. **Kerja bertahap:** inspeksi, rencana, satu modul, cek, perbaiki, lanjut. Jangan membuat seluruh aplikasi sekaligus.
5. **Berhenti dan bertanya** (jangan lanjut sendiri) jika:
   - perlu menambah dependensi/package baru,
   - perlu mengubah konfigurasi yang sudah ada dan berfungsi,
   - perlu perintah destruktif pada database (`migrate:fresh`, `db:wipe`, drop table),
   - ada keputusan yang mengubah struktur database yang sudah disepakati,
   - hasil test gagal dan penyebabnya tidak jelas setelah 2 kali percobaan perbaikan.
6. **Boleh lanjut tanpa bertanya** untuk perubahan kecil yang aman dan mudah dibatalkan (membuat view, controller, migration baru, perbaikan bug di kode yang kamu buat sendiri). Catat asumsinya di laporan.
7. **Peran:** Senior Full-Stack Laravel Developer, UI/UX Designer, Software Architect, Database Designer, dan QA Engineer.

---

## 1. KONTEKS PROYEK

**Nama:** Website Profil TK Angkasa 8

**Alamat awal (dapat dikoreksi lewat admin):**
Jl. Raya Pd. Gede No. 7, RT.7/RW.3, Halim Perdanakusuma, Kecamatan Makasar, Kota Jakarta Timur, DKI Jakarta 13610.

**Tujuan:**
1. Website profil sekolah yang profesional dan mudah diakses.
2. Membantu orang tua mendapat informasi: profil, program, fasilitas, galeri, berita, PPDB, kontak.
3. Dashboard admin agar pihak sekolah mengelola konten sendiri tanpa mengubah kode.
4. Menjadi portofolio Laravel yang bisa dipresentasikan dan ditawarkan ke sekolah.

**Status:** masih tahap pengembangan. Jangan mengklaim ini website resmi sekolah sebelum ada persetujuan pihak berwenang. Tampilkan penanda halus "Versi demo" pada mode demo (lihat bagian 8).

**Pengguna:** orang tua/calon orang tua, pengunjung umum, admin sekolah.

---

## 2. LINGKUNGAN DAN VERSI (DIKUNCI)

Versi target (cocokkan dengan hasil pengecekan; jika tidak cocok, laporkan dan tanya sebelum mengubah):

| Komponen | Target |
|---|---|
| PHP | 8.3 |
| Laravel | 12.x (jika lingkungan hanya mendukung versi lebih rendah, laporkan dan tanya) |
| MySQL | 8.x |
| Composer | 2.x |
| Bootstrap | 5.3 (via CDN atau npm; pilih yang paling sederhana, dokumentasikan) |
| Bootstrap Icons | versi terbaru yang stabil |
| OS lokal | Windows, Laragon |
| Database name | `tk_angkasa8_db` (ubah di `.env` jika sudah ada nama lain) |
| Timezone | `Asia/Jakarta` |
| Locale | `id` (antarmuka berbahasa Indonesia, format tanggal Indonesia) |

**Aturan lingkungan:**
- Jika sudah ada proyek Laravel di direktori kerja, inspeksi dulu. Jangan menimpa.
- Jika belum ada, buat proyek baru dengan Composer.
- Gunakan `php artisan serve` (default `127.0.0.1:8000`) atau virtual host Laragon; dokumentasikan yang dipakai.
- Upload disimpan di `storage/app/public` dan diakses lewat `php artisan storage:link`. Pastikan langkah ini ada di README (sering jadi sumber error di Windows).

**Larangan teknis:**
- Tanpa React/Vue/framework frontend terpisah, tanpa Tailwind.
- Tanpa Filament, Livewire, atau paket admin lain.
- Tanpa Intervention Image kecuali saya setujui; gunakan GD bawaan PHP untuk resize.
- Hindari dependensi yang tidak perlu.

---

## 3. KONVENSI KODE DAN GIT

**Kode:**
- PSR-12. Format dengan Laravel Pint jika sudah tersedia di proyek.
- Nama class, method, variabel, kolom database, route name: **bahasa Inggris**.
- Teks antarmuka, pesan validasi, dan konten: **bahasa Indonesia**.
- Komentar kode: bahasa Indonesia, secukupnya, hanya untuk bagian yang tidak jelas dengan sendirinya.
- Named routes untuk semua route; route model binding jika sesuai.
- Form Request untuk validasi yang kompleks atau berulang.
- Jangan membuat repository/service/interface tanpa alasan jelas.

**Git:**
- Pastikan `.gitignore` mengecualikan `.env`, `vendor/`, `node_modules/`, `storage/app/public/*` (isi upload), dan file lokal editor.
- Sediakan `.env.example` yang bersih (tanpa rahasia).
- Satu commit per modul/langkah bermakna dengan pesan singkat, mis. `feat: add program CRUD`, `test: add news visibility tests`.
- Jangan commit otomatis jika saya belum meminta; sarankan pesan commit di akhir tiap modul.

---

## 4. KONSEP VISUAL

**Gaya:** "Professional, Warm, Friendly, Modern Educational Website". Profesional sebagai institusi, tetap ceria dan ramah untuk PAUD.

**Palet awal (sesuaikan jika identitas resmi sekolah sudah ada):**

| Peran | Warna |
|---|---|
| Primary Navy | #173B67 |
| Accent Warm Yellow | #F7C948 |
| Sky Blue | #EAF4FF |
| Soft Green | #DDF3E4 |
| Background | #F8FAFC |
| Teks utama | #1E293B |
| Teks sekunder | #64748B |
| Border | #E2E8F0 |
| White | #FFFFFF |

Definisikan sebagai CSS variables di satu file CSS kustom, dan timpa variabel Bootstrap seperlunya.

**Tipografi:** Nunito (heading) dan Inter (isi) dari Google Fonts jika praktis, dengan fallback font sistem. Teks nyaman dibaca di ponsel.

**Prinsip:**
1. Layout bersih, whitespace cukup.
2. Kartu radius 12–16 px, shadow halus dan konsisten.
3. Minim animasi, gradient, dan warna mencolok.
4. Tombol punya state hover, focus, active, disabled.
5. Kontras memadai (target WCAG AA).
6. Komponen konsisten di semua halaman.
7. Mobile-first; uji di 360, 768, 1024, 1440 px.
8. Sebelum ada foto asli, gunakan placeholder netral (blok warna lembut + ikon), bukan foto stok anak.

Jangan menyalin website sekolah lain. Website SMP Angkasa Halim Perdanakusuma hanya referensi struktur informasi.

---

## 5. HALAMAN PUBLIK

Semua halaman memuat title unik, meta description, dan tidak error saat database kosong (tampilkan empty state netral).

| Halaman | Route | Isi utama |
|---|---|---|
| Beranda | `/` | Navbar, hero (nama sekolah, judul, deskripsi, foto, tombol "Profil Sekolah" dan "Informasi PPDB"), profil singkat, program, fasilitas, galeri pilihan, berita terbaru, CTA PPDB, kontak+lokasi, footer |
| Profil | `/profil` | Sejarah, visi-misi, tujuan pendidikan, identitas sekolah, tenaga pendidik (jika diizinkan) |
| Program | `/program` | Kartu program published, urut `sort_order` |
| Fasilitas | `/fasilitas` | Kartu fasilitas published |
| Galeri | `/galeri` | Grid responsif, keterangan, kategori, pagination, lightbox sederhana (Bootstrap modal), lazy loading |
| Berita | `/berita` | Daftar berita published + pagination |
| Detail berita | `/berita/{slug}` | Judul, gambar, tanggal, isi, tombol kembali, berita terkait. Draft atau terjadwal di masa depan harus 404 |
| PPDB | `/ppdb` | Periode, persyaratan, alur, kontak resmi, tombol WhatsApp. Jika kosong: "Informasi pendaftaran akan diperbarui oleh pihak sekolah" |
| Kontak | `/kontak` | Alamat, telepon (jika dikonfirmasi), jam operasional (jika ada), WhatsApp, tautan Google Maps |

**Aturan konten:**
- Jangan klaim "terbaik", akreditasi, atau fasilitas unggulan yang belum diverifikasi.
- Jangan mengarang fasilitas, program, nomor telepon, atau jam operasional.
- Tidak ada formulir yang mengumpulkan data pribadi calon siswa di versi 1.
- Foto anak yang dapat dikenali hanya dipublikasikan dengan persetujuan yang sesuai.
- Hanya program/fasilitas/galeri berstatus published yang tampil.

---

## 6. DASHBOARD ADMIN

Prefix `/admin`. Hanya untuk pengguna login dengan role `admin`. Tanpa registrasi publik.

| Modul | Route | Kemampuan |
|---|---|---|
| Login | `/admin/login` | Email+password, validasi, pesan error jelas, redirect ke dashboard, logout aman (POST), guest tidak bisa buka dashboard, user login tidak perlu buka login lagi, **throttle login (maks 5 percobaan/menit per email+IP)** |
| Dashboard | `/admin` | Jumlah program, fasilitas, foto galeri, berita (draft vs published), akses cepat tambah konten. Semua angka dari database |
| Profil sekolah | `/admin/profile` | Edit sejarah, visi, misi, deskripsi, identitas. Satu record saja |
| Program | `/admin/programs` | CRUD, cari, urutan, status publikasi |
| Fasilitas | `/admin/facilities` | CRUD, cari, upload gambar, status publikasi |
| Galeri | `/admin/gallery` | Upload, judul, keterangan, kategori, edit metadata, hapus, urutan, status |
| Berita | `/admin/news` | CRUD, slug unik, tanggal publikasi, draft/publish/unpublish |
| PPDB | `/admin/admission` | Judul, deskripsi, jadwal, persyaratan, alur, biaya (opsional), status, nomor WhatsApp (divalidasi) |
| Pengaturan | `/admin/settings` | Nama tampilan, logo, alamat, telepon, email, jam operasional, URL Maps, nomor WhatsApp, SEO dasar |
| Akun | — | Pembuatan admin lewat seeder atau artisan command (`php artisan app:create-admin`), password dibaca dari input/env, bukan hardcode. Admin dapat mengubah password sendiri. Satu role cukup |

**Keputusan teknis tetap:**
- **Autentikasi:** gunakan guard/session bawaan Laravel dengan controller login sederhana (tanpa Breeze/Jetstream agar tidak menambah paket). Middleware `admin` memeriksa login + role di server.
- **Editor konten berita dan teks panjang:** **plain textarea**, tanpa editor HTML. Tampilkan dengan `nl2br(e($text))`. Tidak ada HTML mentah, sehingga aman dari XSS. Editor rich-text hanya dipertimbangkan di versi berikutnya dengan persetujuan.
- **Nomor WhatsApp:** simpan dalam format internasional tanpa `+` (mis. `62812xxxxxxx`); normalisasi input yang diawali `0` atau `+62`; buat tautan `https://wa.me/{nomor}`.
- **Penghapusan:** gunakan konfirmasi (modal Bootstrap) dan request `DELETE`.

---

## 7. DATABASE

Tabel (sesuaikan tipe kolom dengan kebutuhan; foreign key hanya jika ada relasi nyata):

- **users**: id, name, email (unique), password, role, timestamps
- **school_profiles**: id, school_name, history, vision, mission, description, timestamps (satu record)
- **programs**: id, name, slug (unique), short_description, description, image_path, sort_order, is_published, timestamps
- **facilities**: id, name, slug (unique), description, image_path, sort_order, is_published, timestamps
- **gallery_items**: id, title, caption, image_path, category, sort_order, is_published, timestamps
- **news**: id, title, slug (unique), excerpt, body, image_path, published_at, status (`draft`/`published`), timestamps
- **site_settings**: id, school_name, logo_path, address, phone, email, opening_hours, whatsapp_number, maps_url, meta_title, meta_description, timestamps (satu record)
- **admission_settings**: id, title, description, schedule, requirements, registration_steps, fee_information, whatsapp_number, is_active, timestamps (satu record)

**Aturan:**
- Proteksi mass assignment (`$fillable`), role divalidasi server-side.
- Gunakan helper `SiteSetting::current()` / `SchoolProfile::current()` (firstOrCreate) agar halaman tidak error saat tabel kosong.
- Tambahkan index pada `slug`, `status`, `is_published`, `sort_order` yang sering di-query.
- Jangan menyimpan data pribadi anak.

---

## 8. DATA DEMO

- Data demo **hanya** lewat `DemoSeeder` terpisah, **tidak** dipanggil otomatis oleh `DatabaseSeeder` di produksi (aktifkan lewat `php artisan db:seed --class=DemoSeeder` atau kondisi `APP_ENV=local`).
- Semua teks demo diawali `[CONTOH]` agar jelas bukan data sekolah.
- Data demo tidak boleh berisi klaim faktual tentang sekolah (akreditasi, jumlah guru, fasilitas spesifik).
- Seeder produksi (`DatabaseSeeder`) hanya membuat record kosong untuk profil, pengaturan, dan PPDB berisi placeholder netral. Admin dibuat lewat command, bukan seeder dengan password tetap.
- Jika `APP_ENV=local` dan data demo aktif, tampilkan banner kecil "Versi demo — bukan website resmi".

---

## 9. STRUKTUR KODE

Struktur yang disarankan (boleh disederhanakan jika ada pendekatan Laravel yang lebih ringkas):

```
app/Http/Controllers/Public/   (Home, Profile, Program, Facility, Gallery, News, Admission, Contact)
app/Http/Controllers/Admin/    (Dashboard, Auth, SchoolProfile, Program, Facility, Gallery, News, Admission, SiteSetting)
app/Http/Middleware/EnsureAdmin.php
app/Http/Requests/             (Form Request per modul yang butuh)
app/Models/
app/Support/ImageUploader.php  (satu helper upload+resize+hapus file lama)
resources/views/layouts/       (public.blade.php, admin.blade.php)
resources/views/components/    (komponen reusable)
resources/views/public/ ...
resources/views/admin/ ...
routes/web.php
database/migrations, seeders, factories
tests/Feature/
```

Semua file harus benar-benar terhubung dan dipakai. Jangan duplikasi HTML yang sama di banyak file; jadikan Blade component/partial.

---

## 10. KOMPONEN UI

**Publik:** Navbar, HeroSection, SectionHeading, ProgramCard, FacilityCard, GalleryGrid, NewsCard, AdmissionCTA, ContactSection, Footer, FlashMessage.

**Admin:** AdminSidebar, AdminTopbar, StatCard, DataTable (responsif/scroll horizontal di layar kecil), SearchInput, FormField, ImageUploader (dengan preview), StatusBadge, ConfirmDialog, Pagination, EmptyState.

Semua komponen responsif dan punya state interaksi yang jelas.

---

## 11. UPLOAD GAMBAR

- Format diizinkan: `jpg`, `jpeg`, `png`, `webp`. Validasi MIME type dan ekstensi di server (`image`, `mimes`, `mimetypes`).
- Ukuran maksimal: **2 MB** per file.
- Resize otomatis dengan GD: lebar maksimal **1600 px** (galeri/berita/hero), **800 px** (kartu program/fasilitas), logo maksimal 400 px; pertahankan rasio.
- Nama file di-generate acak (bukan nama asli pengguna).
- Simpan di disk `public` (`storage/app/public/...`), folder per modul.
- Saat gambar diganti atau record dihapus, hapus file lama.
- Tampilkan pesan error yang jelas jika upload gagal atau GD tidak aktif (cek ekstensi `gd` saat inspeksi).
- Gunakan `loading="lazy"`, atribut `width/height`, dan `alt` yang relevan.

---

## 12. SEO DAN PERFORMA

- Title unik, meta description, Open Graph dasar di layout (pakai data `site_settings` sebagai default).
- Canonical URL hanya jika domain sudah jelas (pakai `APP_URL`).
- Sitemap XML dinamis (`/sitemap.xml`) mencakup halaman publik dan berita published.
- `robots.txt`: izinkan publik, `Disallow: /admin`; halaman admin juga memakai `noindex`.
- Heading logis (satu `h1` per halaman), internal links, halaman 404 ramah.
- Pagination untuk daftar panjang; eager loading untuk mencegah N+1.
- Tidak menjanjikan peringkat Google.

---

## 13. KEAMANAN

Wajib: autentikasi + middleware admin, validasi server-side, CSRF di semua form, password hashing, `$fillable`, pengamanan upload, escape output Blade (`{{ }}`), tidak ada `{!! !!}` untuk input pengguna, throttle login, regenerasi session saat login dan invalidasi saat logout, error handling wajar.

Produksi: HTTPS, `APP_DEBUG=false`, `.env` tidak di-commit dan tidak bisa diakses publik, tidak ada akun/password contoh aktif, backup database dan folder upload.

Jangan mengandalkan penyembunyian tombol di frontend sebagai pengamanan.

---

## 14. AKSESIBILITAS

Menu mobile berfungsi, semua input punya label, error mudah dipahami, focus state terlihat, alt text relevan, kontras memadai, elemen interaktif bisa dipakai dengan keyboard, tabel admin tetap usable di layar kecil. Uji di 360, 768, 1024, 1440 px.

---

## 15. TESTING DAN QA

Gunakan Laravel Feature Tests (SQLite in-memory atau database test terpisah; **jangan jalankan test pada database berisi data penting**).

**Publik:** semua route publik status 200 dengan database kosong; detail berita hanya untuk published (draft/terjadwal = 404); program/fasilitas/galeri unpublished tidak tampil; link WhatsApp dan Maps benar; 404 berfungsi; sitemap dan robots dapat diakses.

**Admin:** login/logout; guest di-redirect; user non-admin ditolak (403); CRUD tiap modul; validasi gagal menampilkan pesan; upload menerima format sah dan menolak yang tidak sah/oversize; pencarian dan pagination; file lama terhapus saat ganti/hapus; perubahan admin tampil di publik sesuai status; throttle login bekerja.

**Perintah pemeriksaan:** `php artisan route:list`, `php artisan migrate:status`, `php artisan test`, `php artisan config:clear` (jika konfigurasi bermasalah).

Jangan mengklaim test lulus jika belum dijalankan.

---

## 16. KRITERIA SELESAI (DEFINITION OF DONE)

| Fase | Dianggap selesai jika |
|---|---|
| 1 Inspeksi | Laporan inspeksi lengkap, versi teknologi tercatat, rencana dan daftar pertanyaan ke sekolah dibuat, belum ada file proyek yang diubah |
| 2 Fondasi | `php artisan serve` jalan tanpa error, `migrate:status` bersih, layout publik+admin tampil, route dasar mengembalikan 200, `.gitignore`/`.env.example` benar |
| 3 Publik | Semua route publik 200 dengan DB kosong dan dengan DemoSeeder; responsif di 4 viewport; test publik lulus |
| 4 Dashboard | Login/logout, middleware, semua CRUD, upload, status publikasi berfungsi; test admin lulus |
| 5 Pengujian | `php artisan test` hijau; daftar bug yang ditemukan dan diperbaiki dilaporkan; cek keamanan (bagian 13) terpenuhi |
| 6 Demo & dokumentasi | README, dokumentasi DB/route, panduan admin, panduan deployment+backup, daftar konfirmasi sekolah, dan daftar keterbatasan tersedia; proyek bisa dijalankan dari nol mengikuti README |

---

## 17. FORMAT LAPORAN PER FASE

Maksimal sekitar 25 baris, dengan urutan:
1. **Dikerjakan** (daftar file dibuat/diubah, satu baris per kelompok).
2. **Perintah dijalankan + hasil nyata** (ringkas; sertakan error jika ada).
3. **Hasil test** (jumlah lulus/gagal, atau "belum dijalankan").
4. **Asumsi yang diambil.**
5. **Sisa pekerjaan / masalah.**
6. **Saran pesan commit.**
7. **Langkah berikutnya** (satu kalimat).

Berhenti setelah laporan. Jangan lanjut ke fase berikutnya sebelum saya minta.

---

## 18. PROMPT PER FASE (TEMPEL SATU PER SATU)

### Fase 1 — Inspeksi dan perencanaan
```
Baca PROJECT_SPEC.md sepenuhnya. Kerjakan FASE 1 saja.

- Cek apakah kamu punya akses terminal/file (aturan 0.1).
- Periksa versi PHP, Composer, Laravel (jika ada), Node.js (jika perlu), MySQL, ekstensi PHP (gd, pdo_mysql, mbstring, fileinfo), dan struktur direktori.
- Jika proyek Laravel sudah ada, inspeksi file penting (.env tanpa menampilkan rahasia, routes, migrations, config). Jangan ubah apa pun.
- Buat ringkasan: kondisi proyek, versi ditemukan, file/konfigurasi penting, rencana yang disesuaikan, risiko, dan daftar pertanyaan yang harus dikonfirmasi ke pihak sekolah (nama resmi, sejarah, visi-misi, kontak, jam operasional, izin foto, logo, dll).
- Laporkan sesuai bagian 17 lalu berhenti.
```

### Fase 2 — Fondasi
```
Baca PROJECT_SPEC.md. Kerjakan FASE 2 saja, sesuai hasil inspeksi Fase 1.

Siapkan proyek (buat baru atau lanjutkan yang ada), konfigurasi .env dan database, timezone/locale, .gitignore, .env.example, layout publik dan admin, CSS variables design system, komponen dasar (navbar, footer, flash message), route dan halaman placeholder, dan storage:link.
Jalankan pemeriksaan sesuai Definition of Done Fase 2, perbaiki error, lalu laporkan (bagian 17) dan berhenti.
```

### Fase 3 — Website publik
```
Baca PROJECT_SPEC.md. Kerjakan FASE 3 saja.

Bangun satu halaman/modul pada satu waktu: Beranda, Profil, Program, Fasilitas, Galeri, Berita (+detail), PPDB, Kontak. Buat migrations, model, dan DemoSeeder yang diperlukan (data berawalan [CONTOH]). Pastikan tidak error saat database kosong, responsif, dan SEO dasar terpasang. Tulis feature test publik.
Periksa sesuai Definition of Done Fase 3, perbaiki, laporkan, dan berhenti.
```

### Fase 4 — Database dan dashboard
```
Baca PROJECT_SPEC.md. Kerjakan FASE 4 saja.

Urutan: autentikasi + middleware admin + throttle + command pembuat admin, dashboard, profil, program, fasilitas, galeri, berita, PPDB, pengaturan. Selesaikan dan periksa satu modul sebelum modul berikutnya. Terapkan ImageUploader (bagian 11), konfirmasi hapus, status publikasi, dan test admin untuk tiap modul.
Periksa sesuai Definition of Done Fase 4, perbaiki, laporkan, dan berhenti.
```

### Fase 5 — Pengujian
```
Baca PROJECT_SPEC.md. Kerjakan FASE 5 saja.

Jalankan seluruh test, audit keamanan (bagian 13), SEO (bagian 12), aksesibilitas (bagian 14), dan cek tampilan di 360/768/1024/1440 px. Perbaiki temuan. Laporkan bug yang ditemukan dan diperbaiki, lalu berhenti.
```

### Fase 6 — Demo dan dokumentasi
```
Baca PROJECT_SPEC.md. Kerjakan FASE 6 saja.

Siapkan data demo berlabel, README (instalasi dari nol di Windows/Laragon, storage:link, membuat admin), dokumentasi struktur database dan route, panduan penggunaan dashboard admin (bahasa awam), panduan konfigurasi produksi dan backup, daftar informasi sekolah yang masih harus dikonfirmasi, dan daftar keterbatasan. Verifikasi bahwa proyek bisa dijalankan dari nol mengikuti README. Jangan mengaktifkan sebagai situs resmi.
Laporkan dan berhenti.
```

---

## 19. OUTPUT AKHIR YANG DIHARAPKAN

1. Website publik responsif.
2. Dashboard admin berfungsi dengan CRUD semua modul.
3. Database dan migrations.
4. Autentikasi dan proteksi route admin.
5. Validasi input dan pengamanan upload.
6. SEO dasar.
7. Test suite relevan yang lulus.
8. README (instalasi dan menjalankan).
9. Dokumentasi database dan route.
10. Panduan admin.
11. Panduan deployment dan backup.
12. Daftar informasi sekolah yang harus dikonfirmasi.
13. Daftar keterbatasan/pekerjaan tersisa.

Siap didemonstrasikan secara lokal lebih dulu. Deployment publik dilakukan setelah konfigurasi, persetujuan, dan kepemilikan akun disepakati dengan pihak sekolah.
