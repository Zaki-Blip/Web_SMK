<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan')->nullable();
            $table->string('tipe')->default('guru');
            $table->string('mata_pelajaran')->nullable();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->string('foto')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tipe');
            $table->index('is_active');
            $table->index('urutan');
        });

        Schema::create('mitra_industris', function (Blueprint $table) {
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

        Schema::create('prestasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('tingkat')->default('sekolah');
            $table->unsignedSmallInteger('tahun')->nullable();
            $table->string('peraih')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('tingkat');
            $table->index('tahun');
            $table->index('is_active');
        });

        Schema::create('ekstrakurikulers', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('pembina')->nullable();
            $table->string('jadwal')->nullable();
            $table->string('gambar')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('urutan');
        });

        Schema::create('lowongan_bkks', function (Blueprint $table) {
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

        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('angkatan')->nullable();
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->nullOnDelete();
            $table->string('pekerjaan_saat_ini')->nullable();
            $table->text('isi');
            $table->string('foto')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
        });

        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('pertanyaan');
            $table->text('jawaban');
            $table->string('kategori')->default('umum');
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('kategori');
            $table->index('is_active');
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('testimonis');
        Schema::dropIfExists('lowongan_bkks');
        Schema::dropIfExists('ekstrakurikulers');
        Schema::dropIfExists('prestasis');
        Schema::dropIfExists('mitra_industris');
        Schema::dropIfExists('gurus');
    }
};
