<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Berita;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\LowonganBkk;
use App\Models\MitraIndustri;
use App\Models\Prestasi;
use App\Models\Spmb;
use App\Models\Unduhan;
use Illuminate\Contracts\View\View;

class DasborController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dasbor', [
            'jurusanCount' => Jurusan::query()->count(),
            'guruCount' => Guru::query()->count(),
            'mitraCount' => MitraIndustri::query()->count(),
            'prestasiCount' => Prestasi::query()->count(),
            'lowonganAktifCount' => LowonganBkk::query()->where('is_published', true)->count(),
            'beritaCount' => Berita::query()->count(),
            'agendaCount' => Agenda::query()->where('is_published', true)->count(),
            'unduhanCount' => Unduhan::query()->count(),
            'spmbOpen' => Spmb::current()->is_open,
            'recentNews' => Berita::query()->latestFirst()->take(5)->get(),
        ]);
    }
}
