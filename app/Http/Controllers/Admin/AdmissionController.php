<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionSetting;
use App\Support\WhatsappNumber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function edit(): View
    {
        return view('admin.admission.edit', [
            'admission' => AdmissionSetting::current(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate(
            [
                'title' => ['nullable', 'string', 'max:150'],
                'description' => ['nullable', 'string', 'max:5000'],
                'schedule' => ['nullable', 'string', 'max:3000'],
                'requirements' => ['nullable', 'string', 'max:3000'],
                'registration_steps' => ['nullable', 'string', 'max:3000'],
                'fee_information' => ['nullable', 'string', 'max:3000'],
                'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^[0-9+()\-\s]+$/'],
                'is_active' => ['required', 'boolean'],
            ],
            [
                'title.max' => 'Judul maksimal 150 karakter.',
                'description.max' => 'Deskripsi maksimal 5.000 karakter.',
                'whatsapp_number.regex' => 'Nomor WhatsApp hanya boleh berisi angka, spasi, tanda hubung, kurung, dan tanda plus.',
                'whatsapp_number.max' => 'Nomor WhatsApp terlalu panjang.',
                'is_active.required' => 'Status PPDB wajib dipilih.',
            ],
        );

        // Simpan dalam format internasional tanpa tanda plus (bagian 6).
        $data['whatsapp_number'] = WhatsappNumber::normalize($data['whatsapp_number'] ?? null);

        AdmissionSetting::current()->update($data);

        return redirect()
            ->route('admin.admission.edit')
            ->with('success', 'Informasi PPDB berhasil diperbarui.');
    }
}
