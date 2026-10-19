<?php

namespace Database\Seeders;

use App\Models\AdmissionSetting;
use App\Models\Facility;
use App\Models\GalleryItem;
use App\Models\News;
use App\Models\Program;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * Data DEMO. Hanya untuk presentasi lokal.
 *
 * Semua teks diawali [CONTOH] agar jelas bukan data sekolah yang sebenarnya,
 * dan tidak memuat klaim faktual (akreditasi, jumlah guru, fasilitas spesifik).
 *
 * Jalankan: php artisan db:seed --class=DemoSeeder
 * Aktifkan juga DEMO_MODE=true di .env agar banner "Versi demo" tampil.
 */
class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProfileAndSettings();
        $this->seedPrograms();
        $this->seedFacilities();
        $this->seedGallery();
        $this->seedNews();
        $this->seedAdmission();
    }

    private function seedProfileAndSettings(): void
    {
        SchoolProfile::current()->update([
            'school_name' => '[CONTOH] TK Angkasa 8',
            'history' => '[CONTOH] Teks ini adalah contoh pengisian sejarah sekolah. Ganti dengan cerita berdirinya sekolah yang sebenarnya.',
            'vision' => '[CONTOH] Menjadi taman kanak-kanak yang ramah, aman, dan menyenangkan bagi anak.',
            'mission' => "[CONTOH] Menyelenggarakan kegiatan belajar yang menyenangkan.\n[CONTOH] Melibatkan orang tua dalam proses belajar anak.\n[CONTOH] Menjaga lingkungan belajar yang aman dan bersih.",
            'description' => '[CONTOH] Teks ini adalah contoh deskripsi singkat sekolah untuk keperluan demo tampilan.',
        ]);

        SiteSetting::current()->update([
            'school_name' => '[CONTOH] TK Angkasa 8',
            'address' => '[CONTOH] Jl. Raya Pd. Gede No. 7, Halim Perdanakusuma, Kecamatan Makasar, Kota Jakarta Timur (contoh alamat)',
            'phone' => '[CONTOH] 021-0000000',
            'email' => '[CONTOH] info@contoh.sch.id',
            'opening_hours' => '[CONTOH] Senin-Jumat, 07.00-14.00 WIB',
            'whatsapp_number' => '6280000000000',
            'maps_url' => 'https://maps.google.com/?q=contoh-lokasi-sekolah',
            'meta_title' => '[CONTOH] Website Profil TK',
            'meta_description' => '[CONTOH] Deskripsi meta untuk keperluan demo tampilan.',
        ]);
    }

    private function seedPrograms(): void
    {
        $programs = [
            ['Kelompok Bermain (Contoh)', 'Contoh program untuk kelompok bermain.', 1],
            ['Kelompok A (Contoh)', 'Contoh program untuk anak usia 4-5 tahun.', 2],
            ['Kelompok B (Contoh)', 'Contoh program untuk anak usia 5-6 tahun.', 3],
            ['Kegiatan Ekstrakurikuler (Contoh)', 'Contoh kegiatan tambahan di luar jam belajar.', 4],
        ];

        foreach ($programs as $index => [$name, $short, $order]) {
            Program::updateOrCreate(
                ['slug' => 'contoh-program-'.($index + 1)],
                [
                    'name' => '[CONTOH] '.$name,
                    'short_description' => $short,
                    'description' => '[CONTOH] Uraian program ini hanya contoh untuk keperluan demo. Kegiatan sebenarnya diisi oleh pihak sekolah.',
                    'sort_order' => $order,
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedFacilities(): void
    {
        $facilities = [
            ['Ruang Kelas (Contoh)', 'Contoh keterangan ruang kelas.'],
            ['Area Bermain (Contoh)', 'Contoh keterangan area bermain.'],
            ['Ruang Perpustakaan (Contoh)', 'Contoh keterangan ruang perpustakaan.'],
        ];

        foreach ($facilities as $index => [$name, $description]) {
            Facility::updateOrCreate(
                ['slug' => 'contoh-fasilitas-'.($index + 1)],
                [
                    'name' => '[CONTOH] '.$name,
                    'description' => '[CONTOH] '.$description,
                    'sort_order' => $index + 1,
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedGallery(): void
    {
        $items = [
            ['Kegiatan Belajar (Contoh)', 'Kegiatan', 1],
            ['Kegiatan Bermain (Contoh)', 'Kegiatan', 2],
            ['Suasana Kelas (Contoh)', 'Kelas', 3],
            ['Kegiatan Bersama Orang Tua (Contoh)', 'Kegiatan', 4],
            ['Lingkungan Sekolah (Contoh)', 'Lingkungan', 5],
            ['Kegiatan Seni (Contoh)', 'Kelas', 6],
        ];

        foreach ($items as [$title, $category, $order]) {
            GalleryItem::updateOrCreate(
                ['title' => '[CONTOH] '.$title],
                [
                    'caption' => '[CONTOH] Keterangan foto hanya untuk keperluan demo tampilan.',
                    'category' => $category,
                    'sort_order' => $order,
                    'is_published' => true,
                    // image_path sengaja kosong: tampilan memakai placeholder netral,
                    // bukan foto anak tanpa persetujuan.
                    'image_path' => null,
                ],
            );
        }
    }

    private function seedNews(): void
    {
        $news = [
            ['Contoh Berita Pertama', 3, News::STATUS_PUBLISHED],
            ['Contoh Berita Kedua', 9, News::STATUS_PUBLISHED],
            ['Contoh Berita Ketiga', 20, News::STATUS_PUBLISHED],
            ['Contoh Berita Draf', null, News::STATUS_DRAFT],
        ];

        foreach ($news as $index => [$title, $daysAgo, $status]) {
            News::updateOrCreate(
                ['slug' => 'contoh-berita-'.($index + 1)],
                [
                    'title' => '[CONTOH] '.$title,
                    'excerpt' => '[CONTOH] Ringkasan berita ini hanya untuk keperluan demo tampilan.',
                    'body' => "[CONTOH] Isi berita ini hanya contoh untuk keperluan demo.\n\n[CONTOH] Berita sebenarnya diisi oleh pihak sekolah melalui dashboard admin.",
                    'published_at' => $daysAgo === null ? null : Carbon::now()->subDays($daysAgo),
                    'status' => $status,
                    'image_path' => null,
                ],
            );
        }
    }

    private function seedAdmission(): void
    {
        AdmissionSetting::current()->update([
            'title' => '[CONTOH] Penerimaan Peserta Didik Baru',
            'description' => '[CONTOH] Teks ini contoh informasi PPDB untuk keperluan demo tampilan.',
            'schedule' => "[CONTOH] Gelombang 1: Januari - Februari\n[CONTOH] Gelombang 2: Maret - April",
            'requirements' => "[CONTOH] Fotokopi akta kelahiran\n[CONTOH] Fotokopi kartu keluarga\n[CONTOH] Pas foto ukuran 3x4",
            'registration_steps' => "[CONTOH] Ambil formulir di sekolah\n[CONTOH] Lengkapi berkas persyaratan\n[CONTOH] Serahkan berkas dan tunggu konfirmasi",
            'fee_information' => '[CONTOH] Informasi biaya hanya contoh, mohon dikonfirmasi ke pihak sekolah.',
            'whatsapp_number' => '6280000000000',
            'is_active' => true,
        ]);
    }
}
