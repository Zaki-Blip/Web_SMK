@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h1 class="h4 mb-1">Ringkasan konten</h1>
        <p class="text-muted-soft mb-0">
            Modul dashboard sedang disiapkan. Angka di bawah akan diambil dari database pada Fase 4.
        </p>
    </div>

    <div class="row g-3 mb-4">
        @foreach ([['Program', 'bi-journal-bookmark'], ['Fasilitas', 'bi-building'], ['Foto Galeri', 'bi-images'], ['Berita', 'bi-newspaper']] as [$label, $icon])
            <div class="col-6 col-lg-3">
                <div class="tk-stat-card">
                    <p class="text-muted-soft mb-1"><i class="bi {{ $icon }} me-1" aria-hidden="true"></i>{{ $label }}</p>
                    <p class="stat-value mb-0">—</p>
                </div>
            </div>
        @endforeach
    </div>

    <x-empty-state
        icon="bi-tools"
        title="Modul admin akan aktif pada Fase 4"
        message="Login, CRUD program, fasilitas, galeri, berita, PPDB, profil sekolah, dan pengaturan dikerjakan setelah fondasi dan website publik selesai."
    />
@endsection
