<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['school_name', 'history', 'vision', 'mission', 'description', 'sejarah', 'visi', 'misi', 'sambutan_kepala_sekolah', 'nama_kepala_sekolah', 'foto_kepala_sekolah', 'akreditasi', 'npsn', 'tahun_berdiri', 'jumlah_siswa', 'jumlah_guru', 'jumlah_mitra'])]
class SchoolProfile extends Model
{
    protected $table = 'school_profiles';

    /**
     * Profil sekolah hanya satu record. Dipakai halaman publik dan dasbor.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate([]);
    }
}
