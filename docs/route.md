# Daftar Route

Semua route didefinisikan di `routes/web.php` dan memiliki nama (named route).
Jalankan `php artisan route:list --except-vendor` untuk melihat daftar terkini.

Nama route, model, controller, tabel, dan folder view memakai bahasa Indonesia
bentuk tunggal. URL lama hanya dipertahankan sebagai redirect permanen.

## Halaman publik

| Method | URL | Nama route | Keterangan |
|---|---|---|---|
| GET | `/` | `beranda` | Beranda |
| GET | `/profil` | `profil.index` | Profil sekolah |
| GET | `/jurusan` | `jurusan.index` | Daftar kompetensi keahlian |
| GET | `/jurusan/{slug}` | `jurusan.show` | Detail jurusan |
| GET | `/guru` | `guru.index` | Guru dan staf |
| GET | `/fasilitas` | `fasilitas.index` | Fasilitas sekolah |
| GET | `/prestasi` | `prestasi.index` | Prestasi |
| GET | `/ekstrakurikuler` | `ekstrakurikuler.index` | Daftar ekstrakurikuler |
| GET | `/ekstrakurikuler/{slug}` | `ekstrakurikuler.show` | Detail ekstrakurikuler |
| GET | `/berita` | `berita.index` | Daftar berita; filter opsional `?kategori=...` |
| GET | `/berita/{slug}` | `berita.show` | Detail berita |
| GET | `/galeri` | `galeri.index` | Galeri |
| GET | `/struktur-organisasi` | `struktur.index` | Struktur organisasi |
| GET | `/spmb` | `spmb.index` | Informasi SPMB |
| GET | `/kontak` | `kontak.index` | Kontak dan lokasi |
| GET | `/sitemap.xml` | `sitemap` | Sitemap dinamis |
| GET | `/robots.txt` | `robots` | Robots dinamis (`Disallow: /admin`) |

Halaman publik hanya menampilkan data yang dipublikasikan. Berita draf atau
terjadwal menghasilkan **404**. Jurusan, fasilitas, galeri, dan konten lain yang
belum dipublikasikan tidak muncul di daftar maupun beranda.

## Redirect URL lama

| Method | URL lama | Tujuan | Nama route |
|---|---|---|---|
| GET | `/ppdb` | `/spmb` (301) | `redirect.ppdb` |
| GET | `/program` | `/jurusan` (301) | `redirect.program` |
| GET | `/program/{slug}` | `/jurusan/{slug}` (301) | `redirect.program.show` |

Tidak ada route alias dengan nama lama. URL admin lama juga tidak tersedia.

## Autentikasi admin

| Method | URL | Nama route | Middleware |
|---|---|---|---|
| GET | `/admin/login` | `admin.login` | `guest` |
| POST | `/admin/login` | `admin.login.attempt` | `guest` + throttle 5/menit |
| POST | `/admin/logout` | `admin.logout` | `auth`, `admin` |

Login yang berhasil diarahkan ke `/admin`. Pengguna yang sudah login dan membuka
`/admin/login` akan dialihkan ke dasbor. Logout hanya menerima POST dengan CSRF.

## Dasbor admin

Semua route di bawah ini memakai middleware `auth` + `admin`. Pengguna tanpa role
`admin` mendapat **403**.

### Umum

| Method | URL | Nama route | Keterangan |
|---|---|---|---|
| GET | `/admin` | `admin.dasbor` | Statistik dan berita terbaru |
| GET | `/admin/akun` | `admin.akun.edit` | Form akun sendiri |
| PUT | `/admin/akun` | `admin.akun.update` | Ubah nama, email, kata sandi |
| GET | `/admin/profil` | `admin.profil.edit` | Profil sekolah |
| PUT | `/admin/profil` | `admin.profil.update` | Simpan profil sekolah |
| GET | `/admin/spmb` | `admin.spmb.edit` | Informasi SPMB |
| PUT | `/admin/spmb` | `admin.spmb.update` | Simpan informasi SPMB |
| GET | `/admin/pengaturan` | `admin.pengaturan.edit` | Pengaturan situs |
| PUT | `/admin/pengaturan` | `admin.pengaturan.update` | Simpan pengaturan situs |

### Modul konten

Setiap modul memakai resource controller kecuali method `show` (detail publik
ditangani controller publik). Pola route:

| Method | URL | Nama route |
|---|---|---|
| GET | `/admin/{modul}` | `admin.{modul}.index` |
| GET | `/admin/{modul}/create` | `admin.{modul}.create` |
| POST | `/admin/{modul}` | `admin.{modul}.store` |
| GET | `/admin/{modul}/{id}/edit` | `admin.{modul}.edit` |
| PUT/PATCH | `/admin/{modul}/{id}` | `admin.{modul}.update` |
| DELETE | `/admin/{modul}/{id}` | `admin.{modul}.destroy` |

Modul yang tersedia:

| Modul | URL dasar | Nama route |
|---|---|---|
| Jurusan | `/admin/jurusan` | `admin.jurusan.*` |
| Guru dan staf | `/admin/guru` | `admin.guru.*` |
| Prestasi | `/admin/prestasi` | `admin.prestasi.*` |
| Ekstrakurikuler | `/admin/ekstrakurikuler` | `admin.ekstrakurikuler.*` |
| Testimoni | `/admin/testimoni` | `admin.testimoni.*` |
| FAQ | `/admin/faq` | `admin.faq.*` |
| Struktur organisasi | `/admin/struktur-organisasi` | `admin.struktur-organisasi.*` |
| Fasilitas | `/admin/fasilitas` | `admin.fasilitas.*` |
| Galeri | `/admin/galeri` | `admin.galeri.*` |
| Berita | `/admin/berita` | `admin.berita.*` |

> Route admin struktur organisasi memakai parameter `{struktur}`.

## Konvensi

- Nama route publik tanpa prefix; route admin memakai prefix `admin.`.
- Semua form ubah data memakai `PUT`; hapus data memakai `DELETE` + modal konfirmasi.
- Pencarian daftar memakai query string `?q=...` (form GET, tanpa CSRF).
- Paginasi memakai query string `?page=N`.
- Semua input divalidasi di server; tidak ada input pengguna yang dirender sebagai HTML mentah.
