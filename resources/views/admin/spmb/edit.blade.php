@extends('layouts.admin')
@section('title', 'SPMB')
@section('heading', 'SPMB')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.spmb.update') }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="tahun_ajaran">Tahun ajaran</label>
                <input type="text" name="tahun_ajaran" id="tahun_ajaran" class="form-control" value="{{ old('tahun_ajaran', $spmb->tahun_ajaran) }}">
            </div>

            <div class="mb-3">
                <label class="form-label" for="jalur">Jalur (satu per baris: nama|kuota|keterangan)</label>
                <textarea name="jalur" id="jalur" rows="4" class="form-control">@php
                    $jalur = old('jalur');
                    if ($jalur === null && is_array($spmb->jalur)) {
                        $jalur = implode("\n", array_map(fn($j) => ($j['nama'] ?? '').'|'.($j['kuota'] ?? '').'|'.($j['keterangan'] ?? ''), $spmb->jalur));
                    }
                    echo e($jalur);
                @endphp</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="syarat">Syarat (teks, satu per baris)</label>
                <textarea name="syarat" id="syarat" rows="4" class="form-control">{{ old('syarat', $spmb->syarat) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="alur">Alur (satu langkah per baris)</label>
                <textarea name="alur" id="alur" rows="4" class="form-control">@php
                    $alur = old('alur');
                    if ($alur === null && is_array($spmb->alur)) {
                        $alur = implode("\n", $spmb->alur);
                    }
                    echo e($alur);
                @endphp</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="jadwal">Jadwal (satu per baris: kegiatan|mulai|selesai)</label>
                <textarea name="jadwal" id="jadwal" rows="4" class="form-control">@php
                    $jadwal = old('jadwal');
                    if ($jadwal === null && is_array($spmb->jadwal)) {
                        $jadwal = implode("\n", array_map(fn($j) => ($j['kegiatan'] ?? '').'|'.($j['mulai'] ?? '').'|'.($j['selesai'] ?? ''), $spmb->jadwal));
                    }
                    echo e($jadwal);
                @endphp</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="tautan_pendaftaran">Tautan pendaftaran</label>
                <input type="url" name="tautan_pendaftaran" id="tautan_pendaftaran" class="form-control" value="{{ old('tautan_pendaftaran', $spmb->tautan_pendaftaran) }}">
            </div>

            <div class="mb-3">
                <label class="form-label" for="kontak_panitia">Kontak panitia</label>
                <input type="text" name="kontak_panitia" id="kontak_panitia" class="form-control" value="{{ old('kontak_panitia', $spmb->kontak_panitia) }}">
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_open" id="is_open" value="1" {{ old('is_open', $spmb->is_open) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_open">SPMB dibuka</label>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
            </div>
        </form>
    </div>
@endsection