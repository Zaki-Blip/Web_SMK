<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Nama berkas dipertahankan agar riwayat migrasi deployment lama tidak bentrok.
// Isi migrasi ini sudah diganti menjadi tabel spmb.
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spmb', function (Blueprint $table) {
            $table->id();
            $table->string('tahun_ajaran')->nullable();
            $table->json('jalur')->nullable();
            $table->text('syarat')->nullable();
            $table->json('alur')->nullable();
            $table->json('jadwal')->nullable();
            $table->string('tautan_pendaftaran')->nullable();
            $table->string('kontak_panitia')->nullable();
            $table->boolean('is_open')->default(false);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('spmb');
    }
};
