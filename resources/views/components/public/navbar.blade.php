@props(['schoolName' => null, 'site' => null])

@php
    $schoolName = $schoolName ?: config('school.fallback.school_name');
    $subtitle = config('school.fallback.subtitle');

    $logoUrl = $site?->logo_path
        ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.uploads_disk', 'public'))->url($site->logo_path)
        : null;

    $menu = [
        ['label' => 'Beranda', 'route' => 'home'],
        ['label' => 'Profil', 'route' => 'profile.index'],
        ['label' => 'Program', 'route' => 'program.index'],
        ['label' => 'Fasilitas', 'route' => 'facility.index'],
        ['label' => 'Galeri', 'route' => 'gallery.index'],
        ['label' => 'Berita', 'route' => 'news.index', 'pattern' => 'news.*'],
        ['label' => 'Kontak', 'route' => 'contact.index'],
    ];
@endphp

<header class="tk-navbar sticky-top">
    <nav class="navbar navbar-expand-lg py-2" aria-label="Navigasi utama">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
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
                    @foreach ($menu as $item)
                        @php $isActive = request()->routeIs($item['pattern'] ?? $item['route']); @endphp
                        <li class="nav-item">
                            <a class="nav-link {{ $isActive ? 'active' : '' }}"
                               href="{{ route($item['route']) }}"
                               @if ($isActive) aria-current="page" @endif>
                                {{ $item['label'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-tk-accent w-100" href="{{ route('admission.index') }}">Informasi PPDB</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
