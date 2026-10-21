<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spmb;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SpmbController extends Controller
{
    public function edit(): View
    {
        return view('admin.spmb.edit', ['spmb' => Spmb::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'tahun_ajaran' => ['nullable', 'string', 'max:20'],
            'jalur' => ['nullable'],
            'syarat' => ['nullable', 'string', 'max:10000'],
            'alur' => ['nullable'],
            'jadwal' => ['nullable'],
            'tautan_pendaftaran' => ['nullable', 'string', 'url', 'max:500'],
            'kontak_panitia' => ['nullable', 'string', 'max:255'],
            'is_open' => ['required', 'boolean'],
        ], [
            'tautan_pendaftaran.url' => 'Tautan pendaftaran harus berupa URL lengkap.',
            'is_open.required' => 'Status SPMB wajib dipilih.',
        ]);

        $data['jalur'] = $this->normalizeJalur($request->input('jalur'));
        $data['alur'] = $this->normalizeList($request->input('alur'));
        $data['jadwal'] = $this->normalizeJadwal($request->input('jadwal'));
        $data['is_open'] = $request->boolean('is_open');

        Spmb::current()->update($data);

        return redirect()->route('admin.spmb.edit')->with('success', 'Informasi SPMB berhasil diperbarui.');
    }

    private function normalizeJalur($value): ?array
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $item) {
                if (is_array($item)) {
                    $out[] = [
                        'nama' => $item['nama'] ?? null,
                        'kuota' => isset($item['kuota']) ? (int) $item['kuota'] : null,
                        'keterangan' => $item['keterangan'] ?? null,
                    ];
                }
            }

            return $out ?: null;
        }
        if (is_string($value) && trim($value) !== '') {
            $out = [];
            foreach (preg_split('/\r\n|\r|\n/', $value) as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }
                $parts = array_map('trim', explode('|', $line));
                $out[] = [
                    'nama' => $parts[0] ?? null,
                    'kuota' => isset($parts[1]) && is_numeric($parts[1]) ? (int) $parts[1] : null,
                    'keterangan' => $parts[2] ?? null,
                ];
            }

            return $out ?: null;
        }

        return null;
    }

    private function normalizeList($value): ?array
    {
        if (is_array($value)) {
            $out = array_values(array_filter(array_map(function ($v) {
                return is_array($v) ? ($v['teks'] ?? $v['langkah'] ?? null) : (is_string($v) ? trim($v) : null);
            }, $value), fn ($v) => filled($v)));

            return $out ?: null;
        }
        if (is_string($value) && trim($value) !== '') {
            $out = array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $value)), fn ($v) => $v !== ''));

            return $out ?: null;
        }

        return null;
    }

    private function normalizeJadwal($value): ?array
    {
        if (is_array($value)) {
            $out = [];
            foreach ($value as $item) {
                if (is_array($item)) {
                    $out[] = [
                        'kegiatan' => $item['kegiatan'] ?? null,
                        'mulai' => $item['mulai'] ?? null,
                        'selesai' => $item['selesai'] ?? null,
                    ];
                }
            }

            return $out ?: null;
        }
        if (is_string($value) && trim($value) !== '') {
            $out = [];
            foreach (preg_split('/\r\n|\r|\n/', $value) as $line) {
                $line = trim($line);
                if ($line === '') {
                    continue;
                }
                $parts = array_map('trim', explode('|', $line));
                $out[] = [
                    'kegiatan' => $parts[0] ?? null,
                    'mulai' => $parts[1] ?? null,
                    'selesai' => $parts[2] ?? null,
                ];
            }

            return $out ?: null;
        }

        return null;
    }
}
