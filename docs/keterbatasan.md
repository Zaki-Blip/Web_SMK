# Daftar Keterbatasan dan Pekerjaan Tersisa

Dokumen ini menjelaskan apa yang **belum** ada pada versi ini agar tidak ada
kesalahpahaman saat serah terima.

## Cakupan

- Satu sekolah, satu bahasa (Indonesia). Tidak ada multi-bahasa atau multi-sekolah.
- Fokus pada profil, jurusan, struktur organisasi, fasilitas, galeri, berita,
  SPMB, dan kontak.
- Tidak ada sistem akademik, absensi, nilai, atau pembayaran online.

## Akun dan pengguna

- Hanya satu peran: `admin`. Tidak ada peran editor/kontributor.
- Tidak ada pendaftaran publik dan tidak ada "lupa kata sandi" lewat email;
  kata sandi hanya bisa diubah sendiri (setelah login) atau dibuat ulang lewat
  `php artisan app:create-admin`.
- Tidak ada autentikasi dua faktor (2FA).
- Tidak ada log aktivitas admin (siapa mengubah apa).
- Akun admin percobaan masih ada di database pengembangan dan **wajib dihapus**
  sebelum produksi.

## Konten

- Isi berita dan teks panjang berupa **teks biasa** (tanpa editor WYSIWYG/HTML).
  Baris baru dipertahankan, tetapi format tebal/miring/tautan tidak didukung.
- Tidak ada fitur komentar, newsletter, atau pencarian di halaman publik.
- Tidak ada formulir kontak (untuk menghindari spam dan konfigurasi email).
  Komunikasi diarahkan ke WhatsApp, telepon, atau email sekolah.
- Tidak ada tempat sampah/restore: data yang dihapus hilang permanen.
- Mengubah slug jurusan/berita membuat URL lama menjadi 404 (tidak ada redirect).
- Galeri tidak memiliki album; kategori hanya berupa teks bebas.
- Tidak ada pengurutan ulang dengan drag-and-drop; urutan diatur lewat angka.
- Struktur organisasi berupa hierarki sederhana; belum ada bagan grafis interaktif.
- Tidak ada penjadwalan otomatis berbasis cron untuk berita: status "terjadwal"
  dihitung saat halaman dibuka (`published_at <= sekarang`), jadi tidak perlu
  cron, tetapi juga tidak ada notifikasi saat berita terbit.

## Gambar

- Hanya satu berkas per gambar (diperkecil ke maks. 1600 px); belum ada
  `srcset`/varian responsif atau konversi otomatis ke WebP.
- Tidak ada pemotongan (crop) di dashboard; rasio tampilan diatur CSS.
- `storage:link` harus dijalankan manual di server (lihat README).
- Izin publikasi foto anak sepenuhnya tanggung jawab sekolah.

## Tampilan dan aksesibilitas

- Di layar HP (360 px), tabel admin dapat digeser ke samping; belum ada tampilan
  kartu khusus untuk tabel.
- Label, urutan fokus, dan `focus-visible` sudah disiapkan, tetapi belum ada audit
  menyeluruh dengan pembaca layar (screen reader).
- Belum ada `prefers-color-scheme` (mode gelap).
- Mengandalkan CDN untuk Bootstrap, Bootstrap Icons, dan Google Fonts. Tanpa
  internet, tampilan tidak akan lengkap.

## SEO

- Sitemap dan robots dinamis sudah ada.
- Open Graph dan Twitter Card sudah tersedia; gambar memakai gambar konten atau
  logo situs, belum ada gambar khusus 1200 x 630 px.
- JSON-LD tersedia untuk organisasi, situs, halaman, berita, jurusan, breadcrumb,
  dan daftar item.
- Belum ada integrasi Google Search Console/Analytics (bisa ditambahkan nanti).
- Tidak ada jaminan peringkat di mesin pencari.

## Operasional

- Backup masih manual (panduan tersedia di `docs/deployment-dan-backup.md`).
- Cache dan session memakai database; queue memakai `sync`; belum memakai Redis.
- Queue belum dipakai untuk pekerjaan latar (tidak ada job terjadwal). Tabel
  `jobs`, `job_batches`, dan `failed_jobs` tetap ada sebagai bawaan Laravel.
- Belum ada halaman pemeliharaan otomatis (`php artisan down` tersedia bawaan Laravel).
- Test berjalan di SQLite in-memory; perilaku MySQL di produksi diuji manual.

## Teknis

- `composer.json` masih memakai nama paket bawaan (`laravel/laravel`).
- Tabel `password_reset_tokens` ada (bawaan Laravel) tetapi belum dipakai.
- Beberapa berkas bawaan Laravel yang tidak terpakai dibiarkan agar pembaruan
  framework tetap mudah.
- Tidak ada CI (GitHub Actions) untuk menjalankan test otomatis.

## Sebelum dianggap selesai

1. Konfirmasi seluruh data pada [konfirmasi-sekolah.md](konfirmasi-sekolah.md).
2. Ganti/hapus data demo dan akun percobaan.
3. Set `DEMO_MODE=false`, `APP_ENV=production`, `APP_DEBUG=false`.
4. Pasang HTTPS, jalankan `storage:link`, dan uji backup/restore.
5. Minta persetujuan tertulis sebelum situs diumumkan sebagai situs resmi.


