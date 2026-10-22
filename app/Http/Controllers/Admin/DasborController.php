<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Prestasi;
use App\Models\Spmb;
use Illuminate\Contracts\View\View;

class DasborController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dasbor', [
            'jurusanCount' => Jurusan::query()->count(),
            'guruCount' => Guru::query()->count(),
            'prestasiCount' => Prestasi::query()->count(),
            'beritaCount' => Berita::query()->count(),
            'spmbOpen' => Spmb::current()->is_open,
            'recentNews' => Berita::query()->latestFirst()->take(5)->get(),
        ]);
    }
}
