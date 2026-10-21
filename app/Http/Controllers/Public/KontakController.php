<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class KontakController extends Controller
{
    /**
     * Kontak sekolah: alamat, telepon, jam operasional, WhatsApp, dan peta.
     */
    public function __invoke(): View
    {
        return view('public.kontak', [
            'site' => SiteSetting::current(),
        ]);
    }
}
