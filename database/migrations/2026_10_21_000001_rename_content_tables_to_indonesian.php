<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menyeragamkan nama tabel konten ke bentuk tunggal bahasa Indonesia.
     * Data lama tetap aman karena memakai RENAME TABLE, bukan drop/create.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('admission_settings');

        Schema::rename('jurusans', 'jurusan');
        Schema::rename('gurus', 'guru');
        Schema::rename('ekstrakurikulers', 'ekstrakurikuler');
        Schema::rename('prestasis', 'prestasi');
        Schema::rename('mitra_industris', 'mitra_industri');
        Schema::rename('lowongan_bkks', 'lowongan_bkk');
        Schema::rename('testimonis', 'testimoni');
        Schema::rename('faqs', 'faq');
        Schema::rename('facilities', 'fasilitas');
        Schema::rename('gallery_items', 'galeri');
        Schema::rename('news', 'berita');

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::rename('berita', 'news');
        Schema::rename('galeri', 'gallery_items');
        Schema::rename('fasilitas', 'facilities');
        Schema::rename('faq', 'faqs');
        Schema::rename('testimoni', 'testimonis');
        Schema::rename('lowongan_bkk', 'lowongan_bkks');
        Schema::rename('mitra_industri', 'mitra_industris');
        Schema::rename('prestasi', 'prestasis');
        Schema::rename('ekstrakurikuler', 'ekstrakurikulers');
        Schema::rename('guru', 'gurus');
        Schema::rename('jurusan', 'jurusans');

        Schema::enableForeignKeyConstraints();
    }
};
