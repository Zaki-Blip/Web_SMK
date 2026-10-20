<?php

namespace Database\Seeders;

use App\Models\AdmissionSetting;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

/**
 * Seeder produksi: hanya membuat record tunggal yang kosong/netral.
 * Tidak membuat konten contoh dan tidak membuat akun.
 * Admin dibuat lewat perintah: php artisan app:create-admin (kata sandi dari input atau env ADMIN_PASSWORD).
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Profil sekolah: hanya nama sekolah, teks lain dibiarkan kosong.
        $profile = SchoolProfile::current();
        $profile->update(['school_name' => config('school.fallback.school_name')]);

        // Pengaturan situs: nama dan alamat awal sesuai data yang diberikan.
        $settings = SiteSetting::current();
        $settings->update([
            'school_name' => config('school.fallback.school_name'),
            'address' => config('school.fallback.address'),
        ]);

        // Pengaturan PPDB dibiarkan kosong agar halaman publik menampilkan pesan netral.
        AdmissionSetting::current();
    }
}
