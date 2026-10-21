<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('school_name')->nullable();
            $table->string('nama_kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->text('sambutan_kepala_sekolah')->nullable();
            $table->text('sejarah')->nullable();
            $table->text('history')->nullable();
            $table->text('visi')->nullable();
            $table->text('vision')->nullable();
            $table->text('misi')->nullable();
            $table->text('mission')->nullable();
            $table->text('description')->nullable();
            $table->string('akreditasi')->nullable();
            $table->string('npsn')->nullable();
            $table->unsignedSmallInteger('tahun_berdiri')->nullable();
            $table->unsignedInteger('jumlah_siswa')->nullable();
            $table->unsignedInteger('jumlah_guru')->nullable();
            $table->unsignedInteger('jumlah_mitra')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
