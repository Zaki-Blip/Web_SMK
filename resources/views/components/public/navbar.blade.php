@props(['schoolName' => null, 'site' => null])

@php
    $schoolName = $schoolName ?: config('school.fallback.school_name');
    $subtitle = config('school.fallback.subtitle');

    $logoUrl = $site?->logo_path
        ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.uploads_disk', 'public'))->url($site->logo_path)
        : null;
@endphp

<header class="tk-navbar sticky-top">
    <nav class="navbar navbar-expand-xl py-2" aria-label="Navigasi utama">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('beranda') }}">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="" class="brand-logo brand-logo-img" width="40" height="40">
                @else
                    <span class="brand-logo" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
                @endif
                <span>
                    {{ $schoolName }}
                    <span class="brand-sub">{{ $subtitle }}</span>
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu-utama"
                    aria-controls="menu-utama" aria-expanded="false" aria-label="Buka menu navigasi">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="menu-utama">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-1">
                    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profil.index') }}">Profil</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Akademik</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('jurusan.index') }}">Jurusan</a></li>
                            <li><a class="dropdown-item" href="{{ route('guru.index') }}">Guru & Staf</a></li>
                            <li><a class="dropdown-item" href="{{ route('struktur.index') }}">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
                            <li><a class="dropdown-item" href="{{ route('prestasi.index') }}">Prestasi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Industri & Karier</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('industri.index') }}">Mitra Industri</a></li>
                            <li><a class="dropdown-item" href="{{ route('alur-pkl.index') }}">Alur PKL</a></li>
                            <li><a class="dropdown-item" href="{{ route('bkk.index') }}">Lowongan BKK</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('fasilitas.index') }}">Fasilitas</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('galeri.index') }}">Galeri</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('unduhan.index') }}">Unduhan</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('spmb.index') }}">SPMB</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('kontak.index') }}">Kontak</a></li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-tk-accent w-100" href="{{ route('spmb.index') }}">Info SPMB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
