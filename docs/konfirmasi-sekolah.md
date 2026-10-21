# Daftar Informasi Sekolah yang Perlu Dikonfirmasi

Semua data di bawah ini **belum boleh dianggap benar** sampai dikonfirmasi pihak
sekolah. Data contoh hanya aktif bila `DemoSeeder` dijalankan; situs menampilkan
penanda `[BELUM DIKONFIRMASI]` untuk data yang belum ada.

## 1. Identitas sekolah

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 1 | Nama resmi sekolah | "SMKN 64 Jakarta" (dari data awal) | Ejaan resmi, termasuk singkatan dan tanda baca |
| 2 | NPSN | Belum ada | Nomor Pokok Sekolah Nasional |
| 3 | Status/akreditasi | Belum ada | Status dan tahun akreditasi (bila ada) |
| 4 | Tahun berdiri | Belum ada | Tahun dan tanggal (bila diketahui) |
| 5 | Logo sekolah | Logo sementara sudah tersedia | Konfirmasi berkas logo resmi (PNG/SVG, latar transparan) |
| 6 | Nama yayasan/penyelenggara | Belum ada | Bila relevan |

## 2. Profil

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 7 | Sejarah sekolah | Belum ada | Naskah resmi dari sekolah |
| 8 | Visi | Belum ada | Naskah resmi |
| 9 | Misi | Belum ada | Naskah resmi (boleh berupa daftar) |
| 10 | Deskripsi singkat | Belum ada | 2–4 kalimat untuk beranda |
| 11 | Struktur organisasi / guru | Halaman guru dan struktur organisasi sudah tersedia (data demo) | Data struktur organisasi resmi dan nama pejabat |

## 3. Jurusan dan fasilitas

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 12 | Kompetensi keahlian (mis. TKJ, RPL, dan lainnya) | Belum ada | Nama dan deskripsi sebenarnya |
| 13 | Fasilitas | Belum ada | Daftar fasilitas yang benar-benar ada |
| 14 | Jam praktik/laboratorium | Belum ada | Untuk ditambahkan di halaman jurusan |

## 4. Galeri dan izin foto

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 15 | Foto kegiatan | Placeholder netral | Berkas foto asli sekolah |
| 16 | Izin publikasi wajah siswa | **Belum ada** | Persetujuan tertulis orang tua/wali siswa |
| 17 | Foto fasilitas | Placeholder | Foto ruang kelas, laboratorium, perpustakaan, dll. |
| 18 | Kredit/nama fotografer | Tidak ada | Bila diperlukan |

> Jangan mengunggah foto siswa dari internet atau foto tanpa izin. Bila izin belum
> ada, gunakan foto bangunan, kegiatan tanpa wajah jelas, atau tetap placeholder.

## 5. Berita

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 19 | Berita | Belum ada (data contoh sudah dihapus) | Berita resmi yang akan diterbitkan |
| 20 | Penanggung jawab berita | Belum ada | Siapa yang menulis/menyetujui berita |

## 6. SPMB

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 21 | Judul informasi SPMB | Belum ada | Judul resmi |
| 22 | Jadwal/periode | Belum ada | Tanggal gelombang pendaftaran |
| 23 | Persyaratan | Belum ada | Daftar berkas yang benar |
| 24 | Alur pendaftaran | Belum ada | Langkah resmi |
| 25 | Biaya | Belum ada | Informasi biaya resmi atau "tidak dipungut biaya" |
| 26 | Kontak SPMB | Belum ada | Nomor WhatsApp petugas SPMB |

## 7. Alur PKL, agenda, dan unduhan

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 27a | Alur PKL | 5 langkah demo tersedia | Tahapan resmi, penanggung jawab, dan dokumen pendukung |
| 27b | Agenda kegiatan | 4 agenda demo tersedia | Jadwal resmi dan lokasi kegiatan |
| 27c | Berkas unduhan | 2 PDF contoh tersedia | Dokumen resmi yang boleh dipublikasikan |

## 8. Kontak dan lokasi

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 28 | Alamat lengkap | Alamat awal dari data proyek | Alamat resmi + kode pos |
| 29 | Telepon | `[BELUM DIKONFIRMASI]` | Nomor telepon sekolah |
| 30 | Email resmi | `[BELUM DIKONFIRMASI]` | Email yang benar-benar dipantau |
| 31 | Jam operasional | `[BELUM DIKONFIRMASI]` | Hari dan jam layanan |
| 32 | Nomor WhatsApp | Belum ada | Nomor resmi format `62...` |
| 33 | Tautan Google Maps | Belum ada | URL lokasi resmi |
| 34 | Media sosial | Tautan demo sudah tampil di footer dan halaman kontak | Akun resmi yang boleh ditautkan |

## 9. SEO, domain, dan operasional

| No | Data | Kondisi saat ini | Perlu dikonfirmasi |
|---|---|---|---|
| 35 | Judul meta | Belum ada (memakai nama sekolah) | Judul singkat untuk Google |
| 36 | Deskripsi meta | Belum ada | Ringkasan ±160 karakter |
| 37 | Nama domain | Belum ada | Domain resmi + kepemilikan akun |
| 38 | Email pengelola | Belum ada | Untuk notifikasi dan pemulihan akun |
| 39 | Hosting/server | Belum ada | Penyedia, masa aktif, dan penanggung jawab |
| 40 | Akun admin resmi | Akun percobaan | Nama, email, dan kata sandi resmi |
| 41 | Kebijakan privasi | Belum ada | Apakah perlu halaman khusus? |

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
2. Hapus sisa data demo.
3. Ganti akun admin percobaan.
4. Jalankan `php artisan optimize:clear` dan `php artisan optimize`.
5. Periksa ulang halaman publik di HP dan komputer.


