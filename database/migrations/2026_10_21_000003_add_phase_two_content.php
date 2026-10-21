<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('facebook_url', 500)->nullable();
            $table->string('instagram_url', 500)->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->string('tiktok_url', 500)->nullable();
        });

        Schema::create('struktur_organisasi', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->foreignId('parent_id')->nullable()->constrained('struktur_organisasi')->nullOnDelete();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('parent_id');
            $table->index('is_active');
            $table->index('urutan');
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

    public function down(): void
    {
        Schema::dropIfExists('unduhan');
        Schema::dropIfExists('agenda');
        Schema::dropIfExists('alur_pkl');
        Schema::dropIfExists('struktur_organisasi');

        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['facebook_url', 'instagram_url', 'youtube_url', 'tiktok_url']);
        });
    }
};
