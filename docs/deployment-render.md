# Deployment Gratis: Render + MySQL + Cloudflare R2

Panduan ini memasang website di **Render** (gratis), dengan **MySQL eksternal**
(Aiven atau TiDB Cloud) dan **Cloudflare R2** untuk menyimpan gambar.
Konfigurasi Docker sudah tersedia di repo (`Dockerfile`, `render.yaml`, `docker/`).

> Status: konfigurasi siap, tetapi proses deploy memerlukan akun Render,
> Cloudflare, dan penyedia MySQL. Akun tidak dapat dibuat otomatis.

## Arsitektur

```
Pengunjung
   │ HTTPS
   ▼
Render (Docker: PHP 8.3 + Apache)  ──►  MySQL eksternal (Aiven/TiDB)
   │
   └── gambar ──► Cloudflare R2 (bucket publik)
```

- Render gratis: 750 jam/bulan, 512 MB RAM, service **tidur setelah 15 menit**
  tanpa kunjungan (kunjungan pertama setelah tidur bisa 30–60 detik).
- R2 gratis: 10 GB penyimpanan, 1 juta operasi tulis/bulan.
- MySQL gratis: Aiven 1 GB atau TiDB Cloud Serverless 5 GB.

## 1. Siapkan Cloudflare R2

1. Buat akun Cloudflare → menu **R2** → **Create bucket**.
   Nama bucket: `tk-angkasa8`, region `Automatic`.
2. Buka bucket → **Settings** → **Public access** → aktifkan
   **R2.dev subdomain**. Catat URL publiknya, mis.
   `https://pub-xxxxxxxx.r2.dev`.
3. **Manage R2 API Tokens** → **Create API token** →
   permission **Object Read & Write**, batasi ke bucket tadi.
   Catat:
   - Access Key ID
   - Secret Access Key
   - Endpoint: `https://<account-id>.r2.cloudflarestorage.com`

## 2. Siapkan MySQL

### Opsi A — Aiven (1 GB gratis)

1. Buat service **MySQL** versi gratis.
2. Catat `host`, `port`, `user`, `password`, dan nama database.
   Buat database `tk_angkasa8` bila belum ada.
3. Unduh **CA certificate** (`ca.pem`) dari halaman service, simpan sebagai
   `docker/aiven-ca.pem` di repo. File ini akan ikut ke dalam image.

### Opsi B — TiDB Cloud Serverless (5 GB gratis)

1. Buat cluster **Serverless** → buat database `tk_angkasa8`.
2. Catat host, port `4000`, user, dan password.
3. Karena sertifikatnya dari CA publik, cukup set:
   `MYSQL_ATTR_SSL_CA=/etc/ssl/certs/ca-certificates.crt`

> Jangan memakai database lokal Laragon untuk produksi: komputer harus menyala
> terus dan tidak punya alamat publik yang aman.

## 3. Siapkan repo dan APP_KEY

1. Commit dan push kode ke GitHub (repo yang terhubung ke Render).
2. Buat kunci aplikasi dari komputer lokal:

   ```powershell
   php artisan key:generate --show
   ```

   Simpan hasil `base64:...`; akan dimasukkan sebagai `APP_KEY` di Render.

## 4. Deploy di Render

1. Masuk Render → **New** → **Blueprint** → pilih repo GitHub.
   Render membaca `render.yaml` dan membuat web service `tk-angkasa8`.
2. Isi variabel yang diminta (`sync: false`):
   - `APP_KEY` — hasil langkah 3.
   - `APP_URL` — `https://tk-angkasa8.onrender.com` (sesuaikan dengan nama
     service; bisa diubah setelah deploy pertama).
   - `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
   - `MYSQL_ATTR_SSL_CA` — path CA sesuai langkah 2.
   - `AWS_ACCESS_KEY_ID`, `AWS_SECRET_ACCESS_KEY`, `AWS_BUCKET`,
     `AWS_ENDPOINT`, `AWS_URL` — dari langkah 1.
3. Klik **Apply** / **Deploy**. Proses build memasang Composer, ekstensi PHP,
   dan menjalankan migrasi saat container start.
4. Setelah deploy, buka URL Render. Halaman publik harus tampil.
   Cek juga `https://<domain>/up` → `200 OK`.

## 5. Buat akun admin

Cara paling andal (Render gratis tidak selalu menyediakan Shell): jalankan dari
komputer lokal dengan kredensial database produksi.

```powershell
$env:DB_HOST = "host-dari-aiven-atau-tidb"
$env:DB_PORT = "3306"          # TiDB: 4000
$env:DB_DATABASE = "tk_angkasa8"
$env:DB_USERNAME = "user"
$env:DB_PASSWORD = "kata-sandi"
$env:MYSQL_ATTR_SSL_CA = "C:\path\ca.pem"   # TiDB: biarkan kosong
php artisan app:create-admin
```

Setelah selesai, tutup terminal agar variabel tidak tersimpan.

## 6. Pindahkan logo ke R2

Logo lama masih ada di `storage/app/public`. Setelah login ke dashboard:

1. Buka **Pengaturan Situs** → unggah ulang logo.
2. Simpan. Berkas baru otomatis masuk ke R2.

Alternatif: unggah manual berkas `logo/WPR5yJWGzXBy3PUk6XQAarcJBAGwO45TaH3Ds1fM.jpg`
ke bucket R2 pada folder `logo/`.

## 7. Verifikasi

- [ ] Beranda, profil, program, fasilitas, galeri, berita, PPDB, kontak → 200.
- [ ] Login admin berhasil, dashboard tampil.
- [ ] Unggah foto program → gambar tampil (berarti R2 benar).
- [ ] Ganti logo → logo baru tampil.
- [ ] `sitemap.xml` dan `robots.txt` dapat dibuka.
- [ ] Tidak ada banner demo; tidak ada teks `[CONTOH]`.

## 8. Perawatan

- Setiap push ke branch utama, Render otomatis build ulang.
- Migrasi baru dijalankan otomatis saat container start.
- Hapus akun admin percobaan; gunakan kata sandi kuat.
- Pantau **Logs** di dashboard Render bila ada error 500.
- Batas gratis dapat berubah; periksa halaman harga Render/Cloudflare/Aiven.

## 9. Pemecahan masalah

| Gejala | Penyebab umum | Solusi |
|---|---|---|
| Build gagal `composer install` | Lock file/vendor | Pastikan `composer.lock` ikut di-commit |
| 500 setelah deploy | `APP_KEY` kosong / DB salah | Isi env, lihat Logs |
| `SQLSTATE[HY000] [2002]` | Host/port salah atau DB tidur | Periksa kredensial, bangunkan database |
| `SSL connection error` | CA belum ada | Set `MYSQL_ATTR_SSL_CA` ke file yang benar |
| Gambar tidak tampil | R2 belum publik / env salah | Cek `AWS_URL`, public access bucket |
| Upload gagal | Kredensial R2 salah | Buat token R2 baru, redeploy |
| Situs lambat pertama kali | Render free tidur | Normal; pertimbangkan paket berbayar |

## 10. Batasan penting

- Render free **tidak** menyimpan file lokal secara permanen; semua unggahan
  wajib ke R2 (sudah diatur `UPLOADS_DISK=s3`).
- Tidak ada worker antrean; aplikasi tidak memakai job, jadi `QUEUE_CONNECTION=sync`.
- Tidak ada cron terjadwal; berita terjadwal tetap dihitung saat halaman dibuka.
- Untuk situs resmi jangka panjang, hosting PHP+MySQL berbayar yang murah
  (mis. shared hosting sekolah) biasanya lebih stabil daripada tier gratis.
