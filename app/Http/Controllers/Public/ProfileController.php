<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;

class ProfileController extends Controller
{
    /**
     * Profil sekolah: sejarah, visi, misi, tujuan, dan identitas.
     */
    public function __invoke(): View
    {
        return view('public.profile', [
            'site' => SiteSetting::current(),
            'profile' => SchoolProfile::current(),
        ]);
    }
}
