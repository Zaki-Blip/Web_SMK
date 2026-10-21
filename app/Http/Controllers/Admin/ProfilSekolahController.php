<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use App\Models\SiteSetting;
use App\Support\ImageUploader;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use RuntimeException;

class ProfilSekolahController extends Controller
{
    public function edit(): View
    {
        return view('admin.profil.edit', [
            'profile' => SchoolProfile::current(),
            'site' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request, ImageUploader $uploader): RedirectResponse
    {
        $data = $request->validate([
            'school_name' => ['nullable', 'string', 'max:150'],
            'sejarah' => ['nullable', 'string', 'max:50000'],
            'history' => ['nullable', 'string', 'max:50000'],
            'visi' => ['nullable', 'string', 'max:5000'],
            'vision' => ['nullable', 'string', 'max:5000'],
            'misi' => ['nullable', 'string', 'max:5000'],
            'mission' => ['nullable', 'string', 'max:5000'],
            'description' => ['nullable', 'string', 'max:5000'],
            'sambutan_kepala_sekolah' => ['nullable', 'string', 'max:5000'],
            'nama_kepala_sekolah' => ['nullable', 'string', 'max:150'],
            'akreditasi' => ['nullable', 'string', 'max:50'],
            'npsn' => ['nullable', 'string', 'max:20'],
            'tahun_berdiri' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'jumlah_siswa' => ['nullable', 'integer', 'min:0'],
            'jumlah_guru' => ['nullable', 'integer', 'min:0'],
            'jumlah_mitra' => ['nullable', 'integer', 'min:0'],
            'foto_kepala_sekolah' => [
                'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'mimetypes:image/jpeg,image/png,image/webp',
                'max:'.ImageUploader::MAX_KILOBYTES,
            ],
        ]);

        $profile = SchoolProfile::current();

        try {
            if ($request->hasFile('foto_kepala_sekolah')) {
                $new = $uploader->store($request->file('foto_kepala_sekolah'), 'profil', ImageUploader::WIDTH_CARD);
                $uploader->delete($profile->foto_kepala_sekolah);
                $data['foto_kepala_sekolah'] = $new;
            }
        } catch (RuntimeException $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }

        // sync aliases
        if (isset($data['sejarah']) && ! isset($data['history'])) {
            $data['history'] = $data['sejarah'];
        }
        if (isset($data['history']) && ! isset($data['sejarah'])) {
            $data['sejarah'] = $data['history'];
        }
        if (isset($data['visi']) && ! isset($data['vision'])) {
            $data['vision'] = $data['visi'];
        }
        if (isset($data['vision']) && ! isset($data['visi'])) {
            $data['visi'] = $data['vision'];
        }
        if (isset($data['misi']) && ! isset($data['mission'])) {
            $data['mission'] = $data['misi'];
        }
        if (isset($data['mission']) && ! isset($data['misi'])) {
            $data['misi'] = $data['mission'];
        }

        $profile->update($data);

        return redirect()->route('admin.profil.edit')->with('success', 'Profil sekolah berhasil diperbarui.');
    }
}
