<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menghapus tabel fitur yang sudah tidak dipakai.
     */
    public function up(): void
    {
        Schema::dropIfExists('unduhan');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('alur_pkl');
        Schema::dropIfExists('lowongan_bkk');
        Schema::dropIfExists('mitra_industri');
    }

    /**
     * Mengembalikan struktur tabel bila migrasi di-rollback.
     */
    public function down(): void
    {
        Schema::create('mitra_industri', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('bidang')->nullable();
            $table->string('logo')->nullable();
            $table->string('website')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('urutan');
        });

        Schema::create('lowongan_bkk', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('perusahaan');
            $table->string('lokasi')->nullable();
            $table->string('tipe')->default('penuh_waktu');
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->string('tautan_daftar')->nullable();
            $table->date('batas_waktu')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->index('is_published');
            $table->index('batas_waktu');
        });

        Schema::create('alur_pkl', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('urutan');
        });

        Schema::create('agenda', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->dateTime('mulai');
            $table->dateTime('selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();

            $table->index('is_published');
            $table->index('mulai');
        });

        Schema::create('unduhan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('berkas');
            $table->unsignedBigInteger('ukuran')->default(0);
            $table->boolean('is_published')->default(false);
            $table->unsignedInteger('urutan')->default(0);
            $table->timestamps();

            $table->index('is_published');
            $table->index('urutan');
        });
    }
};
