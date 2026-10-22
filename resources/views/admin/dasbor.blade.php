@extends('layouts.admin')

@section('title', 'Dasbor')
@section('heading', 'Dasbor')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Ringkasan konten</h1>
            <p class="text-muted-soft mb-0">
                Selamat datang{{ auth()->user() ? ', '.auth()->user()->name : '' }}. Semua angka di bawah diambil dari database.
            </p>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Jurusan" :value="$jurusanCount" icon="bi-mortarboard" :route="route('admin.jurusan.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Guru & Staf" :value="$guruCount" icon="bi-people" :route="route('admin.guru.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Prestasi" :value="$prestasiCount" icon="bi-trophy" :route="route('admin.prestasi.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Berita" :value="$beritaCount" icon="bi-newspaper" :route="route('admin.berita.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Status SPMB" :value="$spmbOpen ? 'Buka' : 'Tutup'" icon="bi-clipboard-check" :route="route('admin.spmb.edit')" />
        </div>
    </div>

    <div class="tk-card p-3 mb-3">
        <h2 class="h5 mb-3">Akses cepat</h2>
        <div class="row g-2">
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-primary" href="{{ route('admin.berita.create') }}">
                    <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>Tambah berita
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.spmb.edit') }}">
                    <i class="bi bi-clipboard-check me-1" aria-hidden="true"></i>Ubah SPMB
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.pengaturan.edit') }}">
                    <i class="bi bi-gear me-1" aria-hidden="true"></i>Pengaturan
                </a>
            </div>
        </div>
    </div>

    <div class="tk-card mb-3">
        <div class="p-3 pb-0">
            <h2 class="h5 mb-1">Berita terbaru</h2>
            <p class="text-muted-soft mb-0">Termasuk draft dan berita terjadwal.</p>
        </div>

        <x-admin.data-table :columns="['Judul', 'Tanggal', 'Status']" :caption="null">
            @forelse ($recentNews as $item)
                <tr>
                    <td>
                        <a href="{{ route('admin.berita.edit', $item) }}" class="fw-semibold">{{ $item->title }}</a>
                    </td>
                    <td>{{ $item->published_at ? \App\Support\IndonesianDate::long($item->published_at) : '—' }}</td>
                    <td><x-admin.status-badge :state="$item->displayStatus()" /></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="tk-empty-cell">Belum ada berita.</td>
                </tr>
            @endforelse
        </x-admin.data-table>
    </div>
@endsection