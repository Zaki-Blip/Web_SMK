<?php

namespace Database\Seeders;

use App\Models\Berita;
use App\Models\Ekstrakurikuler;
use App\Models\Faq;
use App\Models\Fasilitas;
use App\Models\Galeri;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Models\Spmb;
use App\Models\StrukturOrganisasi;
use App\Models\Testimoni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedProfilDanPengaturan();
        $this->seedJurusan();
        $this->seedGuru();
        $this->seedPrestasi();
        $this->seedEkstrakurikuler();
        $this->seedFasilitas();
        $this->seedGaleri();
        $this->seedBerita();
        $this->seedTestimoni();
        $this->seedFaq();
        $this->seedStrukturOrganisasi();
        $this->seedSpmb();
    }

    private function seedProfilDanPengaturan(): void
    {
        SchoolProfile::current()->update([
            'school_name' => 'SMKN 64 Jakarta',
            'nama_kepala_sekolah' => 'Dewi Puspitasari, M.Par.',
            'sambutan_kepala_sekolah' => 'Selamat datang di SMKN 64 Jakarta. Kami berkomitmen mencetak lulusan yang kompeten, berkarakter, dan siap kerja.',
            'sejarah' => 'SMKN 64 Jakarta berdiri sejak tahun 2019 sebagai sekolah kejuruan berbasis teknologi informasi dengan dua kompetensi unggulan, yaitu RPL dan DKV.',
            'history' => 'SMKN 64 Jakarta berdiri sejak tahun 2019 sebagai sekolah kejuruan berbasis teknologi informasi.',
            'visi' => 'Mewujudkan lulusan yang berkarakter mulia, berprestasi, berkualitas, dan berwawasan global.',
            'vision' => 'Mewujudkan lulusan yang berkarakter mulia, berprestasi, berkualitas, dan berwawasan global.',
            'misi' => "Menanamkan nilai iman, disiplin, tanggung jawab, dan karakter mulia.\nMengembangkan profesionalisme dengan penguasaan bahasa asing dan disiplin tinggi.\nMenjawab tuntutan perusahaan akan tenaga terampil yang memiliki standar profesionalisme tinggi.",
            'mission' => "Menanamkan nilai iman, disiplin, tanggung jawab, dan karakter mulia.\nMengembangkan profesionalisme dengan penguasaan bahasa asing dan disiplin tinggi.",
            'description' => 'SMKN 64 Jakarta adalah sekolah menengah kejuruan berbasis teknologi informasi dengan kompetensi keahlian RPL dan DKV.',
            'akreditasi' => 'B',
            'npsn' => '69992315',
            'tahun_berdiri' => 2019,
            'jumlah_siswa' => 600,
            'jumlah_guru' => 40,
        ]);

        SiteSetting::current()->update([
            'school_name' => 'SMKN 64 Jakarta',
            'logo_path' => 'logo/smkn64.png',
            'address' => 'Jl. Mpo Nori RT 09 RW 03, Bambu Apus, Cipayung, Jakarta Timur, DKI Jakarta 13890',
            'phone' => '08978891895',
            'email' => 'info@smkn64-jkt.sch.id',
            'opening_hours' => 'Senin-Jumat, 07.00-16.00 WIB',
            'whatsapp_number' => '628978891895',
            'maps_url' => 'https://maps.google.com/?q=SMKN+64+Jakarta+Cipayung',
            'meta_title' => 'SMKN 64 Jakarta — Sekolah Menengah Kejuruan',
            'meta_description' => 'Website resmi SMKN 64 Jakarta. Informasi jurusan RPL dan DKV, fasilitas, berita, dan SPMB.',
            'facebook_url' => 'https://www.facebook.com/smkn64jakarta',
            'instagram_url' => 'https://www.instagram.com/smkn64jakarta',
            'youtube_url' => 'https://www.youtube.com/@smkn64jakarta',
            'tiktok_url' => 'https://www.tiktok.com/@smkn64jakarta',
        ]);
    }

    private function seedJurusan(): void
    {
        $data = [
            ['Rekayasa Perangkat Lunak', 'RPL', 'Jurusan yang berfokus pada pengembangan perangkat lunak.', ['Pemrograman', 'Basis Data', 'Pemrograman Web', 'Pemrograman Mobile', 'Desain UI/UX', 'Pengujian Perangkat Lunak'], 'Software developer, web developer, mobile developer'],
            ['Desain Komunikasi Visual', 'DKV', 'Jurusan yang menggabungkan seni, komunikasi, dan teknologi.', ['Desain Grafis', 'Fotografi', 'Videografi', 'Branding', 'Ilustrasi', 'Motion Graphic'], 'Desainer grafis, ilustrator, videografer'],
        ];

        foreach ($data as $i => [$nama, $singkatan, $ringkasan, $kompetensi, $prospek]) {
            Jurusan::updateOrCreate(
                ['slug' => Str::slug($nama)],
                [
                    'nama' => $nama,
                    'singkatan' => $singkatan,
                    'ringkasan' => $ringkasan,
                    'deskripsi' => $ringkasan.' Kompetensi keahlian ini menekankan praktik dan kerja sama dengan industri.',
                    'kompetensi' => $kompetensi,
                    'prospek_karier' => $prospek,
                    'lama_belajar' => '3 tahun',
                    'urutan' => $i + 1,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedGuru(): void
    {
        $jurusans = Jurusan::query()->get();
        $names = ['Andi Wijaya', 'Siti Rahmawati', 'Budi Hartono', 'Dewi Lestari', 'Eko Prasetyo', 'Fitri Handayani', 'Gilang Ramadhan', 'Hana Pertiwi', 'Irfan Maulana', 'Joko Susilo', 'Kartika Sari', 'Lina Marlina'];
        foreach ($names as $i => $name) {
            Guru::updateOrCreate(
                ['nama' => $name],
                [
                    'jabatan' => $i === 0 ? 'Kepala Jurusan' : 'Guru',
                    'tipe' => 'guru',
                    'mata_pelajaran' => 'Mata pelajaran '.$i,
                    'jurusan_id' => $jurusans->count() ? $jurusans[$i % $jurusans->count()]->id : null,
                    'urutan' => $i + 1,
                    'is_active' => true,
                ],
            );
        }
        // staf
        foreach (['Rina Adm', 'Tono TU'] as $i => $name) {
            Guru::updateOrCreate(
                ['nama' => $name],
                [
                    'jabatan' => 'Staf TU',
                    'tipe' => 'staf',
                    'mata_pelajaran' => null,
                    'urutan' => 100 + $i,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedPrestasi(): void
    {
        for ($i = 1; $i <= 8; $i++) {
            Prestasi::updateOrCreate(
                ['judul' => 'Juara '.$i.' Lomba Kompetensi Siswa'],
                [
                    'tingkat' => ['sekolah', 'kota', 'provinsi', 'nasional', 'internasional'][$i % 5],
                    'tahun' => (int) now()->year - ($i % 3),
                    'peraih' => 'Tim SMKN 64',
                    'deskripsi' => 'Prestasi siswa pada kompetisi tingkat '.['sekolah', 'kota', 'provinsi', 'nasional', 'internasional'][$i % 5].'.',
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedEkstrakurikuler(): void
    {
        $items = ['Pramuka', 'Paskibra', 'Futsal', 'Seni Tari', 'Robotika', 'Jurnalistik'];
        foreach ($items as $i => $name) {
            Ekstrakurikuler::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'nama' => $name,
                    'deskripsi' => 'Kegiatan ekstrakurikuler '.$name.' untuk pengembangan minat dan bakat siswa.',
                    'pembina' => 'Guru pembina',
                    'jadwal' => 'Sabtu, 08.00-10.00 WIB',
                    'urutan' => $i + 1,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedFasilitas(): void
    {
        $items = [
            ['Ruang Kelas', 'kelas'],
            ['Laboratorium Komputer', 'laboratorium'],
            ['Bengkel TKJ', 'bengkel'],
            ['Studio Desain', 'bengkel'],
            ['Perpustakaan', 'perpustakaan'],
            ['Ruang UKS', 'lainnya'],
            ['Lapangan Olahraga', 'lainnya'],
            ['Aula', 'lainnya'],
        ];
        foreach ($items as $i => [$name, $kat]) {
            Fasilitas::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'description' => 'Fasilitas '.$name.' untuk mendukung pembelajaran.',
                    'category' => $kat,
                    'sort_order' => $i + 1,
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedGaleri(): void
    {
        for ($i = 1; $i <= 6; $i++) {
            Galeri::updateOrCreate(
                ['title' => 'Kegiatan '.$i],
                [
                    'caption' => 'Dokumentasi kegiatan sekolah.',
                    'category' => 'Kegiatan',
                    'sort_order' => $i,
                    'is_published' => true,
                ],
            );
        }
    }

    private function seedBerita(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Berita::updateOrCreate(
                ['slug' => 'berita-'.$i],
                [
                    'title' => 'Berita Sekolah '.$i,
                    'excerpt' => 'Ringkasan berita sekolah.',
                    'body' => "Isi berita sekolah nomor {$i}.\n\nParagraf kedua berita.",
                    'kategori' => $i <= 2 ? 'pengumuman' : 'berita',
                    'published_at' => Carbon::now()->subDays($i * 3),
                    'status' => Berita::STATUS_PUBLISHED,
                ],
            );
        }
        // draft
        Berita::updateOrCreate(
            ['slug' => 'berita-draf'],
            [
                'title' => 'Berita Draf',
                'excerpt' => 'Draf.',
                'body' => 'Draf berita.',
                'kategori' => 'berita',
                'published_at' => null,
                'status' => Berita::STATUS_DRAFT,
            ],
        );
        // pengumuman tambahan
        for ($i = 1; $i <= 3; $i++) {
            Berita::updateOrCreate(
                ['slug' => 'pengumuman-'.$i],
                [
                    'title' => 'Pengumuman '.$i,
                    'excerpt' => 'Pengumuman sekolah.',
                    'body' => 'Isi pengumuman '.$i.'.',
                    'kategori' => 'pengumuman',
                    'published_at' => Carbon::now()->subDays($i),
                    'status' => Berita::STATUS_PUBLISHED,
                ],
            );
        }
    }

    private function seedTestimoni(): void
    {
        $j = Jurusan::query()->first();
        for ($i = 1; $i <= 4; $i++) {
            Testimoni::updateOrCreate(
                ['nama' => 'Alumni '.$i],
                [
                    'angkatan' => '202'.(2 + $i),
                    'jurusan_id' => $j?->id,
                    'pekerjaan_saat_ini' => 'Staf di perusahaan',
                    'isi' => 'SMKN 64 Jakarta memberikan bekal yang sangat berguna untuk dunia kerja.',
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedFaq(): void
    {
        $items = [
            ['Bagaimana cara mendaftar?', 'Pendaftaran dilakukan melalui halaman SPMB.', 'spmb'],
            ['Kapan SPMB dibuka?', 'Informasi jadwal tersedia di halaman SPMB.', 'spmb'],
            ['Jurusan apa saja yang tersedia?', 'Lihat halaman Jurusan.', 'umum'],
        ];
        foreach ($items as $i => [$q, $a, $kat]) {
            Faq::updateOrCreate(
                ['pertanyaan' => $q],
                [
                    'jawaban' => $a,
                    'kategori' => $kat,
                    'urutan' => $i + 1,
                    'is_active' => true,
                ],
            );
        }
        // Pastikan tersedia 8 FAQ.
        for ($i = 4; $i <= 8; $i++) {
            Faq::updateOrCreate(
                ['pertanyaan' => 'Pertanyaan umum '.$i],
                [
                    'jawaban' => 'Jawaban contoh '.$i.'.',
                    'kategori' => $i % 2 === 0 ? 'spmb' : 'umum',
                    'urutan' => $i,
                    'is_active' => true,
                ],
            );
        }
    }

    private function seedStrukturOrganisasi(): void
    {
        $kepala = StrukturOrganisasi::updateOrCreate(
            ['nama' => 'Dewi Puspitasari, M.Par.', 'jabatan' => 'Kepala Sekolah'],
            ['parent_id' => null, 'urutan' => 1, 'is_active' => true],
        );

        $items = [
            ['Andi Wijaya', 'Wakil Kepala Bidang Kurikulum', $kepala->id, 2],
            ['Siti Rahmawati', 'Wakil Kepala Bidang Kesiswaan', $kepala->id, 3],
            ['Budi Hartono', 'Kepala Tata Usaha', $kepala->id, 4],
            ['Dewi Lestari', 'Kepala Program RPL', $kepala->id, 5],
            ['Eko Prasetyo', 'Kepala Program DKV', $kepala->id, 6],
        ];

        foreach ($items as [$nama, $jabatan, $parentId, $urutan]) {
            StrukturOrganisasi::updateOrCreate(
                ['nama' => $nama, 'jabatan' => $jabatan],
                ['parent_id' => $parentId, 'urutan' => $urutan, 'is_active' => true],
            );
        }
    }

    private function seedSpmb(): void
    {
        Spmb::current()->update([
            'tahun_ajaran' => '2026/2027',
            'jalur' => [
                ['nama' => 'Zonasi', 'kuota' => 120, 'keterangan' => 'Sesuai zonasi domisili'],
                ['nama' => 'Prestasi', 'kuota' => 60, 'keterangan' => 'Berdasarkan prestasi'],
                ['nama' => 'Afirmasi', 'kuota' => 40, 'keterangan' => 'Untuk calon siswa afirmasi'],
            ],
            'syarat' => "Fotokopi ijazah SMP\nFotokopi kartu keluarga\nPas foto 3x4",
            'alur' => ['Mengisi formulir online', 'Melengkapi berkas', 'Verifikasi', 'Pengumuman', 'Daftar ulang'],
            'jadwal' => [
                ['kegiatan' => 'Pendaftaran', 'mulai' => '2026-05-01', 'selesai' => '2026-05-31'],
                ['kegiatan' => 'Verifikasi', 'mulai' => '2026-06-01', 'selesai' => '2026-06-10'],
                ['kegiatan' => 'Pengumuman', 'mulai' => '2026-06-15', 'selesai' => '2026-06-15'],
                ['kegiatan' => 'Daftar Ulang', 'mulai' => '2026-06-20', 'selesai' => '2026-06-30'],
                ['kegiatan' => 'Mulai Belajar', 'mulai' => '2026-07-13', 'selesai' => '2026-07-13'],
            ],
            'tautan_pendaftaran' => 'https://example.com/spmb',
            'kontak_panitia' => 'Panitia SPMB SMKN 64 Jakarta',
            'is_open' => true,
        ]);
    }
}
