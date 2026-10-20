@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')

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
            <x-admin.stat-card label="Program" :value="$programCount" icon="bi-journal-bookmark"
                               :hint="$publishedProgramCount.' terbit'" :route="route('admin.programs.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Fasilitas" :value="$facilityCount" icon="bi-building"
                               :hint="$publishedFacilityCount.' terbit'" :route="route('admin.facilities.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Foto galeri" :value="$galleryCount" icon="bi-images"
                               :hint="$publishedGalleryCount.' terbit'" :route="route('admin.gallery.index')" />
        </div>
        <div class="col-sm-6 col-xl-3">
            <x-admin.stat-card label="Berita" :value="$newsPublishedCount + $newsDraftCount" icon="bi-newspaper"
                               :hint="$newsPublishedCount.' terbit, '.$newsDraftCount.' draft'" :route="route('admin.news.index')" />
        </div>
    </div>

    <div class="tk-card p-3 mb-3">
        <h2 class="h5 mb-3">Akses cepat</h2>

        <div class="row g-2">
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-primary" href="{{ route('admin.programs.create') }}">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah program
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.facilities.create') }}">
                    <i class="bi bi-plus-lg me-1" aria-hidden="true"></i>Tambah fasilitas
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.gallery.create') }}">
                    <i class="bi bi-upload me-1" aria-hidden="true"></i>Unggah foto
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.news.create') }}">
                    <i class="bi bi-pencil-square me-1" aria-hidden="true"></i>Tulis berita
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.admission.edit') }}">
                    <i class="bi bi-clipboard-check me-1" aria-hidden="true"></i>Info PPDB
                </a>
            </div>
            <div class="col-6 col-md-4 col-xl-2 d-grid">
                <a class="btn btn-tk-outline" href="{{ route('admin.settings.edit') }}">
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
                        <a href="{{ route('admin.news.edit', $item) }}" class="fw-semibold">{{ $item->title }}</a>
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

        @if ($recentNews->isNotEmpty())
            <div class="p-3 pt-0">
                <a href="{{ route('admin.news.index') }}">Lihat semua berita</a>
            </div>
        @endif
    </div>

    <div class="tk-card p-3">
        <h2 class="h5 mb-2">Pengingat</h2>
        <ul class="mb-0">
            <li>Isi data sekolah yang sebenarnya sebelum website dipublikasikan sebagai situs resmi.</li>
            <li>Unggah foto anak hanya setelah ada izin dari orang tua/wali.</li>
            <li>Data contoh (<code>[CONTOH]</code>) harus dihapus atau diganti sebelum digunakan publik.</li>
        </ul>
    </div>
@endsection

