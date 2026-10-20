# Daftar Route

Semua route didefinisikan di `routes/web.php` dan memiliki nama (named route).
Jalankan `php artisan route:list --except-vendor` untuk melihat daftar terkini
(total 47 route).

## Halaman publik

| Method | URL | Nama route | Keterangan |
|---|---|---|---|
| GET | `/` | `home` | Beranda |
| GET | `/profil` | `profile.index` | Profil sekolah |
| GET | `/program` | `program.index` | Daftar program (paginasi 9) |
| GET | `/fasilitas` | `facility.index` | Daftar fasilitas (paginasi 9) |
| GET | `/galeri` | `gallery.index` | Galeri (paginasi 12) |
| GET | `/berita` | `news.index` | Daftar berita (paginasi 6) |
| GET | `/berita/{slug}` | `news.show` | Detail berita |
| GET | `/ppdb` | `admission.index` | Informasi PPDB |
| GET | `/kontak` | `contact.index` | Kontak & lokasi |
| GET | `/sitemap.xml` | `sitemap` | Sitemap dinamis |
| GET | `/robots.txt` | `robots` | Robots dinamis (`Disallow: /admin`) |

Halaman publik hanya menampilkan data yang dipublikasikan. Berita draft atau
terjadwal menghasilkan **404**. Program/fasilitas/galeri yang belum dipublikasikan
tidak muncul di daftar maupun beranda.

## Autentikasi admin

| Method | URL | Nama route | Middleware |
|---|---|---|---|
| GET | `/admin/login` | `admin.login` | `guest` |
| POST | `/admin/login` | `admin.login.attempt` | `guest` + throttle 5/menit |
| POST | `/admin/logout` | `admin.logout` | `auth`, `admin` |

Login yang sudah berhasil diarahkan ke `/admin`. Pengguna yang sudah login dan
membuka `/admin/login` akan dialihkan ke dashboard. Logout hanya menerima POST
(disertai CSRF), bukan tautan GET.

## Dashboard admin

Semua route di bawah ini memakai middleware `auth` + `admin`. Pengguna tanpa role
`admin` mendapat **403**.

### Umum

| Method | URL | Nama route | Keterangan |
|---|---|---|---|
| GET | `/admin` | `admin.dashboard` | Statistik + berita terbaru |
| GET | `/admin/account` | `admin.account.edit` | Form akun sendiri |
| PUT | `/admin/account` | `admin.account.update` | Ubah nama/email/kata sandi |
| GET | `/admin/profile` | `admin.profile.edit` | Profil sekolah |
| PUT | `/admin/profile` | `admin.profile.update` | Simpan profil sekolah |
| GET | `/admin/admission` | `admin.admission.edit` | Informasi PPDB |
| PUT | `/admin/admission` | `admin.admission.update` | Simpan informasi PPDB |
| GET | `/admin/settings` | `admin.settings.edit` | Pengaturan situs |
| PUT | `/admin/settings` | `admin.settings.update` | Simpan pengaturan situs |

### Program, fasilitas, galeri, berita

Pola resource yang sama untuk keempat modul:

| Method | URL | Nama route |
|---|---|---|
| GET | `/admin/programs` | `admin.programs.index` |
| GET | `/admin/programs/create` | `admin.programs.create` |
| POST | `/admin/programs` | `admin.programs.store` |
| GET | `/admin/programs/{program}/edit` | `admin.programs.edit` |
| PUT/PATCH | `/admin/programs/{program}` | `admin.programs.update` |
| DELETE | `/admin/programs/{program}` | `admin.programs.destroy` |

Ganti `programs` dengan `facilities`, `gallery`, atau `news` untuk modul lain.
Route `show` tidak dipakai (detail publik memakai `news.show`).

## Konvensi

- Nama route publik tanpa prefix; route admin memakai prefix `admin.`.
- Semua form ubah data memakai `PUT`; hapus data memakai `DELETE` + modal konfirmasi.
- Pencarian daftar memakai query string `?q=...` (form GET, tanpa CSRF).
- Paginasi memakai query string `?page=N`.
