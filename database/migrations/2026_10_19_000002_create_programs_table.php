<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->string('slug')->unique();
            $table->string('ringkasan', 255)->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('kompetensi')->nullable();
            $table->text('prospek_karier')->nullable();
            $table->string('lama_belajar')->default('3 tahun');
            $table->string('gambar')->nullable();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('is_active');
            $table->index('urutan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jurusans');
    }
};
