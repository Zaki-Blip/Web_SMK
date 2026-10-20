# Daftar Informasi Sekolah yang Perlu Dikonfirmasi

Semua data di bawah ini **belum boleh dianggap benar** sampai dikonfirmasi pihak
sekolah. Data contoh sudah dihapus; situs menampilkan penanda `[BELUM DIKONFIRMASI]` untuk data yang belum ada.

## 1. Identitas sekolah

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 1 | Nama resmi sekolah | "TK Angkasa 8" (dari data awal) | Ejaan resmi, termasuk singkatan dan tanda baca |
| 2 | NPSN | Belum ada | Nomor Pokok Sekolah Nasional |
| 3 | Status/akreditasi | Belum ada | Status dan tahun akreditasi (bila ada) |
| 4 | Tahun berdiri | Belum ada | Tahun dan tanggal (bila diketahui) |
| 5 | Logo sekolah | Belum ada (memakai ikon) | Berkas logo resmi (PNG/SVG, latar transparan) |
| 6 | Nama yayasan/penyelenggara | Belum ada | Bila relevan |

## 2. Profil

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 7 | Sejarah sekolah | Belum ada | Naskah resmi dari sekolah |
| 8 | Visi | Belum ada | Naskah resmi |
| 9 | Misi | Belum ada | Naskah resmi (boleh berupa daftar) |
| 10 | Deskripsi singkat | Belum ada | 2–4 kalimat untuk beranda |
| 11 | Struktur organisasi / guru | Tidak ada di v1 | Apakah perlu ditampilkan? |

## 3. Program dan fasilitas

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 12 | Jenis program (KB, A, B, ekstrakurikuler) | Belum ada | Nama dan deskripsi sebenarnya |
| 13 | Fasilitas | Belum ada | Daftar fasilitas yang benar-benar ada |
| 14 | Jam belajar per kelompok | Belum ada | Untuk ditambahkan di halaman program |

## 4. Galeri dan izin foto

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 15 | Foto kegiatan | Placeholder netral | Berkas foto asli sekolah |
| 16 | Izin publikasi wajah anak | **Belum ada** | Persetujuan tertulis orang tua/wali |
| 17 | Foto fasilitas | Placeholder | Foto ruang kelas, area bermain, dll. |
| 18 | Kredit/nama fotografer | Tidak ada | Bila diperlukan |

> Jangan mengunggah foto anak dari internet atau foto tanpa izin. Bila izin belum
> ada, gunakan foto bangunan, kegiatan tanpa wajah jelas, atau tetap placeholder.

## 5. Berita

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 19 | Berita | Belum ada (data contoh sudah dihapus) | Berita resmi yang akan diterbitkan |
| 20 | Penanggung jawab berita | Belum ada | Siapa yang menulis/menyetujui berita |

## 6. PPDB

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 21 | Judul informasi PPDB | Belum ada | Judul resmi |
| 22 | Jadwal/periode | Belum ada | Tanggal gelombang pendaftaran |
| 23 | Persyaratan | Belum ada | Daftar berkas yang benar |
| 24 | Alur pendaftaran | Belum ada | Langkah resmi |
| 25 | Biaya | Belum ada | Informasi biaya resmi atau "tidak dipungut biaya" |
| 26 | Kontak PPDB | Belum ada | Nomor WhatsApp petugas PPDB |

## 7. Kontak dan lokasi

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 27 | Alamat lengkap | Alamat awal dari data proyek | Alamat resmi + kode pos |
| 28 | Telepon | `[BELUM DIKONFIRMASI]` | Nomor telepon sekolah |
| 29 | Email resmi | `[BELUM DIKONFIRMASI]` | Email yang benar-benar dipantau |
| 30 | Jam operasional | `[BELUM DIKONFIRMASI]` | Hari dan jam layanan |
| 31 | Nomor WhatsApp | Belum ada | Nomor resmi format `62...` |
| 32 | Tautan Google Maps | Belum ada | URL lokasi resmi |
| 33 | Media sosial | Tidak ada di v1 | Apakah perlu ditambahkan? |

## 8. SEO, domain, dan operasional

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 34 | Judul meta | Belum ada (memakai nama sekolah) | Judul singkat untuk Google |
| 35 | Deskripsi meta | Belum ada | Ringkasan ±160 karakter |
| 36 | Nama domain | Belum ada | Domain resmi + kepemilikan akun |
| 37 | Email pengelola | Belum ada | Untuk notifikasi dan pemulihan akun |
| 38 | Hosting/server | Belum ada | Penyedia, masa aktif, dan penanggung jawab |
| 39 | Akun admin resmi | Akun percobaan | Nama, email, dan kata sandi resmi |
| 40 | Kebijakan privasi | Belum ada | Apakah perlu halaman khusus? |

## Format konfirmasi yang disarankan

Untuk setiap poin, minta sekolah mengisi:

```
Nomor:
Data yang benar:
Sumber (dokumen/narasumber):
Tanggal konfirmasi:
Disetujui oleh:
```

Setelah data dikonfirmasi, perbarui lewat dashboard admin, lalu:

1. Set `DEMO_MODE=false` di `.env`.
2. Hapus sisa data `[CONTOH]`.
3. Ganti akun admin percobaan.
4. Jalankan `php artisan optimize:clear` dan `php artisan optimize`.
5. Periksa ulang halaman publik di HP dan komputer.
