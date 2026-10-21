# Panduan Dashboard Admin

Panduan ini ditulis untuk pengelola sekolah (bukan programmer).

## Masuk dan keluar

1. Buka `http://alamat-website/admin/login`.
2. Isi **email** dan **kata sandi** yang diberikan pengelola sistem, lalu klik **Masuk**.
3. Setelah selesai, klik **Keluar** di kanan atas. Selalu keluar bila memakai
   komputer bersama.

- Tidak ada menu "daftar". Akun hanya dibuat oleh pengelola sistem.
- Lupa kata sandi? Minta pengelola sistem membuat ulang akun lewat perintah
  `php artisan app:create-admin`.

## Mengenal halaman dashboard

- **Dashboard** — jumlah jurusan, fasilitas, galeri, berita, agenda, dan
  unduhan; daftar berita terbaru; tombol akses cepat untuk menambah konten.
- **Sidebar kiri** — menu semua modul. Di layar HP, menu ini berupa deretan
  tombol yang bisa digeser ke samping.
- **Status publikasi** — setiap konten punya pilihan **Draf/Nonaktif** (belum
  tampil) atau **Terbit/Aktif** (tampil di website).
- **Hapus** selalu meminta konfirmasi lebih dulu.

## Profil Sekolah

Isi nama sekolah, sejarah, visi, misi, dan deskripsi singkat.

- **Deskripsi singkat** tampil di beranda dan di halaman profil.
- Tekan **Simpan** di bagian bawah. Perubahan langsung terlihat di website.

## Jurusan

1. Menu **Jurusan** → **Tambah jurusan**.
2. Isi nama, singkatan, ringkasan singkat (tampil di kartu), dan uraian.
3. Isi daftar kompetensi dan prospek karier bila sudah tersedia.
4. Unggah gambar bila ada.
5. Pilih **Aktif** agar muncul di website.
6. **Urutan** menentukan posisi tampil (angka kecil lebih dulu).

Slug (alamat halaman) dibuat otomatis dari nama. Bila perlu, slug bisa diubah;
pastikan tetap unik.

## Guru dan Staf

Isi nama, jabatan, tipe (guru/staf), mata pelajaran, dan jurusan terkait. Unggah
foto bila ada, lalu atur urutan dan status aktif.

## Fasilitas

Isi nama, deskripsi, kategori, dan gambar fasilitas. Pilih **Terbit** agar tampil
di halaman Fasilitas dan beranda.

## Galeri

1. Menu **Galeri** → **Unggah foto**.
2. Pilih berkas gambar, isi judul, keterangan (opsional), dan kategori (opsional).
3. Setelah tersimpan, foto muncul di halaman Galeri dan bisa diperbesar (lightbox).

Saat mengubah foto lama, gambar boleh dikosongkan: data tetap tersimpan dan gambar
lama tetap dipakai.

## Ekstrakurikuler

Isi nama, deskripsi, pembina, jadwal, gambar, urutan, dan status aktif. Halaman
publik menampilkan daftar dan detail ekstrakurikuler yang aktif.

## Prestasi

Isi judul, tingkat, tahun, peraih, dan deskripsi. Prestasi aktif tampil di halaman
Prestasi dan beranda.

## Mitra Industri

Isi nama, bidang, logo, dan website mitra. Mitra aktif tampil di halaman Industri.
Data ini juga dipakai sebagai informasi kerja sama sekolah.

## Lowongan BKK

Isi judul, perusahaan, lokasi, tipe pekerjaan, deskripsi, persyaratan, tautan
pendaftaran, dan batas waktu. Pilih **Terbit** agar lowongan tampil di halaman BKK.
Lowongan yang batas waktunya sudah lewat tetap tersimpan, tetapi sebaiknya
dinonaktifkan.

## Testimoni

Isi nama, angkatan, jurusan, pekerjaan saat ini, isi testimoni, dan foto. Testimoni
aktif tampil di beranda.

## FAQ

Isi pertanyaan, jawaban, kategori (`spmb` atau `umum`), urutan, dan status aktif.
FAQ aktif tampil di beranda. FAQ kategori `spmb` juga tampil di halaman SPMB.

## Struktur Organisasi

1. Menu **Struktur Organisasi** -> **Tambah**.
2. Isi nama, jabatan, atasan langsung, urutan, dan status aktif.
3. Kosongkan **Atasan langsung** untuk jabatan puncak (mis. kepala sekolah).
4. Jabatan dengan atasan akan tampil bertingkat di bawah atasannya.

Hindari memilih atasan yang berada di bawah jabatan yang sedang diubah agar
susunan tetap logis.

## Alur PKL

Isi judul langkah, deskripsi, urutan, dan status aktif. Langkah aktif tampil
berurutan di halaman **Alur PKL**. Gunakan deskripsi singkat dan konkret agar
siswa memahami tahapan yang harus dilalui.

## Agenda

1. Menu **Agenda** -> **Tambah**.
2. Isi judul, deskripsi, waktu mulai, waktu selesai (opsional), dan lokasi.
3. Slug dibuat otomatis dari judul; biarkan kosong bila tidak perlu diubah.
4. Pilih **Terbit** agar agenda tampil di halaman publik. Agenda draf tidak dapat
   dibuka oleh pengunjung.

## Unduhan

1. Menu **Unduhan** -> **Tambah**.
2. Isi judul, deskripsi, urutan, dan pilih berkas.
3. Format yang didukung: PDF, DOC/DOCX, XLS/XLSX, PPT/PPTX, ZIP, atau TXT.
4. Ukuran maksimal **10 MB**. Berkas disimpan dengan nama acak.
5. Pilih **Terbit** agar tombol unduh aktif. Unduhan draf tidak dapat diakses.

## Berita

1. Menu **Berita** → **Tulis berita**.
2. Isi judul, ringkasan (maks. 300 karakter), kategori (mis. `berita`,
   `pengumuman`, atau `kegiatan`), dan isi berita. Kategori dipakai untuk filter
   di halaman berita publik.
3. Pilih status:
   - **Draf** — belum tampil.
   - **Terbit** — tampil di website. Bila tanggal publikasi dikosongkan, sistem
     memakai waktu saat disimpan.
   - **Terbit dengan tanggal mendatang** - tampil otomatis setelah tanggal tersebut
     lewat (di dasbor ditandai "Terjadwal").
4. Isi berita berupa **teks biasa**. Enter untuk baris baru. Jangan menulis kode HTML;
   HTML akan ditampilkan sebagai teks.

## Informasi SPMB

Isi periode/jadwal, persyaratan, alur pendaftaran, informasi biaya, dan nomor
WhatsApp. Hilangkan centang **Aktif** bila SPMB sedang tutup — halaman publik akan
menampilkan pesan netral beserta kontak sekolah.

Nomor WhatsApp ditulis dalam format internasional tanpa tanda `+`, misalnya
`6281234567890`. Tautan `wa.me` dibuat otomatis.

## Pengaturan Situs

Berisi identitas dan kontak yang dipakai di seluruh website: nama sekolah, alamat,
telepon, email, jam operasional, WhatsApp, tautan Google Maps, media sosial, serta
judul dan deskripsi untuk mesin pencari (SEO).

- **Media sosial** (Facebook, Instagram, YouTube, TikTok) boleh dikosongkan.
  Tautan yang diisi tampil di footer dan halaman kontak. Gunakan akun resmi yang
  sudah dikonfirmasi sekolah.

- **Judul meta** sebaiknya singkat, mis. `SMKN 64 Jakarta — Jakarta Timur`.
- **Deskripsi meta** maksimal sekitar 160 karakter.

## Akun Saya

Ubah nama, email, dan kata sandi sendiri. Untuk mengganti kata sandi, isi kata sandi
lama lalu kata sandi baru (minimal 8 karakter).

## Aturan unggah gambar

- Format: **JPG, PNG, atau WebP**.
- Ukuran maksimal **2 MB**.
- Gambar otomatis diperkecil (maksimal 1600 px) dan dioptimalkan.
- Gunakan foto asli sekolah. **Jangan memakai foto anak dari internet.**
- Unggah foto anak hanya setelah ada izin orang tua/wali.

## Aturan unggah berkas unduhan

- Format: **PDF, DOC/DOCX, XLS/XLSX, PPT/PPTX, ZIP, atau TXT**.
- Ukuran maksimal **10 MB**.
- Nama berkas asli tidak dipakai; sistem menyimpan nama acak.
- Periksa kembali isi dokumen sebelum memilih **Terbit**. Dokumen draf tidak dapat
  diunduh pengunjung.
- Jangan mengunggah dokumen berisi data pribadi siswa tanpa izin.

## Pertanyaan yang sering muncul

**Gambar tidak muncul setelah diunggah.**
Jalankan `php artisan storage:link` sekali di server (cukup sekali). Bila tetap
tidak muncul, hubungi pengelola sistem.

**Berita sudah disimpan tetapi tidak bisa dibuka.**
Periksa status (harus **Terbit**) dan tanggal publikasi (tidak boleh di masa depan).

**Jurusan/fasilitas/foto tidak tampil di website.**
Pastikan statusnya **Terbit**, bukan **Draf**.

**Ingin menghapus data demo.**
Hapus lewat daftar modul masing-masing, lalu isi dengan data sekolah yang sebenarnya.
Setelah itu set `DEMO_MODE=false` agar banner demo hilang.

**Website menampilkan "Belum dikonfirmasi".**
Artinya data tersebut belum diisi di **Pengaturan Situs**.


