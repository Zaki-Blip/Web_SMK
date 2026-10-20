<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    /**
     * Profil sekolah hanya satu record (bagian 7).
     */
    public function edit(): View
    {
        return view('admin.profile.edit', [
            'profile' => SchoolProfile::current(),
            'site' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(
            [
                'school_name' => ['nullable', 'string', 'max:150'],
                'history' => ['nullable', 'string', 'max:20000'],
                'vision' => ['nullable', 'string', 'max:2000'],
                'mission' => ['nullable', 'string', 'max:2000'],
                'description' => ['nullable', 'string', 'max:5000'],
            ],
            [
                'school_name.max' => 'Nama sekolah maksimal 150 karakter.',
                'history.max' => 'Sejarah maksimal 20.000 karakter.',
                'vision.max' => 'Visi maksimal 2.000 karakter.',
                'mission.max' => 'Misi maksimal 2.000 karakter.',
                'description.max' => 'Deskripsi maksimal 5.000 karakter.',
            ],
        );

        SchoolProfile::current()->update($data);

        return redirect()
            ->route('admin.profile.edit')
            ->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
