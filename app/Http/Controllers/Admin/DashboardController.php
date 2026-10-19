<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Ringkasan jumlah konten dan akses cepat menambah konten.
     */
    public function __invoke(): View
    {
        // Fase 4: angka diambil dari database; autentikasi admin ditambahkan sebelum ini.
        return view('admin.dashboard');
    }
}
