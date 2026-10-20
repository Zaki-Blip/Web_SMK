<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\ImageUploader;
use App\Support\WhatsappNumber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use RuntimeException;

class SiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(Request $request, ImageUploader $uploader): RedirectResponse
    {
        $validated = $request->validate(
            [
                'school_name' => ['required', 'string', 'max:150'],
                'address' => ['nullable', 'string', 'max:255'],
                'phone' => ['nullable', 'string', 'max:30'],
                'email' => ['nullable', 'string', 'email', 'max:150'],
                'opening_hours' => ['nullable', 'string', 'max:150'],
                'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+()\-\s]+$/'],
                'maps_url' => ['nullable', 'string', 'url', 'max:500'],
                'meta_title' => ['nullable', 'string', 'max:150'],
                'meta_description' => ['nullable', 'string', 'max:300'],
                'logo' => [
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'mimetypes:image/jpeg,image/png,image/webp',
                    'max:'.ImageUploader::MAX_KILOBYTES,
                ],
            ],
            [
                'school_name.required' => 'Nama tampilan sekolah wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda hubung, kurung, dan tanda plus.',
                'maps_url.url' => 'URL Google Maps harus berupa tautan lengkap (diawali https://).',
                'logo.image' => 'Logo harus berupa gambar.',
                'logo.mimes' => 'Logo harus berformat JPG, PNG, atau WebP.',
                'logo.mimetypes' => 'Isi berkas logo tidak sesuai format yang diizinkan.',
                'logo.max' => 'Ukuran logo maksimal 2 MB.',
            ],
        );

        $data = Arr::except($validated, ['logo']);

        // Simpan dalam format internasional tanpa tanda plus (bagian 6).
        $data['whatsapp_number'] = WhatsappNumber::normalize($data['whatsapp_number'] ?? null);

        $settings = SiteSetting::current();

        try {
            if ($request->hasFile('logo')) {
                $newPath = $uploader->store($request->file('logo'), 'logo', ImageUploader::WIDTH_LOGO);
                $uploader->delete($settings->logo_path);
                $data['logo_path'] = $newPath;
            }
        } catch (RuntimeException $exception) {
            return back()->withInput()->with('error', $exception->getMessage());
        }

        $settings->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
