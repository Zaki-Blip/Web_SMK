@php
    // Menu dashboard; ditambah bertahap sesuai modul yang sudah selesai (bagian 6).
    $items = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'icon' => 'bi-speedometer2'],
        ['label' => 'Profil Sekolah', 'route' => 'admin.profile.edit', 'icon' => 'bi-info-circle'],
        ['label' => 'Program', 'route' => 'admin.programs.index', 'pattern' => 'admin.programs.*', 'icon' => 'bi-journal-bookmark'],
        ['label' => 'Fasilitas', 'route' => 'admin.facilities.index', 'pattern' => 'admin.facilities.*', 'icon' => 'bi-building'],
        ['label' => 'Galeri', 'route' => 'admin.gallery.index', 'pattern' => 'admin.gallery.*', 'icon' => 'bi-images'],
        ['label' => 'Berita', 'route' => 'admin.news.index', 'pattern' => 'admin.news.*', 'icon' => 'bi-newspaper'],
        ['label' => 'PPDB', 'route' => 'admin.admission.edit', 'icon' => 'bi-clipboard-check'],
        ['label' => 'Pengaturan', 'route' => 'admin.settings.edit', 'icon' => 'bi-gear'],
        ['label' => 'Akun', 'route' => 'admin.account.edit', 'pattern' => 'admin.account.*', 'icon' => 'bi-person-gear'],
    ];
@endphp

<nav class="tk-admin-sidebar" aria-label="Navigasi dashboard admin">
    <a class="d-flex align-items-center gap-2 mb-3 text-white fw-bold" href="{{ route('admin.dashboard') }}">
        <span class="brand-logo" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
        <span>
            Admin
            <small class="d-block fw-normal opacity-75" style="font-size: .75rem;">
                {{ $site?->school_name ?: config('school.fallback.school_name') }}
            </small>
        </span>
    </a>

    <ul class="list-unstyled d-flex flex-wrap flex-lg-column gap-1 mb-0">
        @foreach ($items as $item)
            @php $isActive = request()->routeIs($item['pattern'] ?? $item['route']); @endphp
            <li class="flex-grow-1">
                <a class="{{ $isActive ? 'active' : '' }}"
                   href="{{ route($item['route']) }}"
                   @if ($isActive) aria-current="page" @endif>
                    <i class="bi {{ $item['icon'] }} me-2" aria-hidden="true"></i>{{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
