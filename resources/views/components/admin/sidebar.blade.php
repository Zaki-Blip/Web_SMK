@props(['schoolName' => null, 'site' => null])

@php
    $schoolName = $schoolName ?: config('school.fallback.school_name');

    $logoUrl = $site?->logo_path
        ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.uploads_disk', 'public'))->url($site->logo_path)
        : null;

    // Menu dashboard; ditambah bertahap sesuai modul yang sudah selesai (bagian 6).
    $items = [
        ['label' => 'Dasbor', 'route' => 'admin.dasbor', 'icon' => 'bi-speedometer2'],
        ['label' => 'Profil Sekolah', 'route' => 'admin.profil.edit', 'icon' => 'bi-info-circle'],
        ['label' => 'Jurusan', 'route' => 'admin.jurusan.index', 'pattern' => 'admin.jurusan.*', 'icon' => 'bi-mortarboard'],
        ['label' => 'Guru & Staf', 'route' => 'admin.guru.index', 'pattern' => 'admin.guru.*', 'icon' => 'bi-people'],
        ['label' => 'Ekstrakurikuler', 'route' => 'admin.ekstrakurikuler.index', 'pattern' => 'admin.ekstrakurikuler.*', 'icon' => 'bi-stars'],
        ['label' => 'Prestasi', 'route' => 'admin.prestasi.index', 'pattern' => 'admin.prestasi.*', 'icon' => 'bi-trophy'],
        ['label' => 'Fasilitas', 'route' => 'admin.fasilitas.index', 'pattern' => 'admin.fasilitas.*', 'icon' => 'bi-building'],
        ['label' => 'Galeri', 'route' => 'admin.galeri.index', 'pattern' => 'admin.galeri.*', 'icon' => 'bi-images'],
        ['label' => 'Berita', 'route' => 'admin.berita.index', 'pattern' => 'admin.berita.*', 'icon' => 'bi-newspaper'],
        ['label' => 'Mitra Industri', 'route' => 'admin.mitra-industri.index', 'pattern' => 'admin.mitra-industri.*', 'icon' => 'bi-buildings'],
        ['label' => 'Lowongan BKK', 'route' => 'admin.lowongan-bkk.index', 'pattern' => 'admin.lowongan-bkk.*', 'icon' => 'bi-briefcase'],
        ['label' => 'Testimoni', 'route' => 'admin.testimoni.index', 'pattern' => 'admin.testimoni.*', 'icon' => 'bi-chat-quote'],
        ['label' => 'FAQ', 'route' => 'admin.faq.index', 'pattern' => 'admin.faq.*', 'icon' => 'bi-question-circle'],
        ['label' => 'Struktur Organisasi', 'route' => 'admin.struktur-organisasi.index', 'pattern' => 'admin.struktur-organisasi.*', 'icon' => 'bi-diagram-3'],
        ['label' => 'Alur PKL', 'route' => 'admin.alur-pkl.index', 'pattern' => 'admin.alur-pkl.*', 'icon' => 'bi-signpost-split'],
        ['label' => 'Agenda', 'route' => 'admin.agenda.index', 'pattern' => 'admin.agenda.*', 'icon' => 'bi-calendar-event'],
        ['label' => 'Unduhan', 'route' => 'admin.unduhan.index', 'pattern' => 'admin.unduhan.*', 'icon' => 'bi-download'],
        ['label' => 'SPMB', 'route' => 'admin.spmb.edit', 'icon' => 'bi-clipboard-check'],
        ['label' => 'Pengaturan', 'route' => 'admin.pengaturan.edit', 'icon' => 'bi-gear'],
        ['label' => 'Akun', 'route' => 'admin.akun.edit', 'pattern' => 'admin.akun.*', 'icon' => 'bi-person-gear'],
    ];
@endphp

<nav class="tk-admin-sidebar" aria-label="Navigasi dashboard admin">
    <a class="d-flex align-items-center gap-2 mb-3 text-white fw-bold" href="{{ route('admin.dasbor') }}">
        @if ($logoUrl)
            <img src="{{ $logoUrl }}" alt="" class="brand-logo brand-logo-img" width="40" height="40">
        @else
            <span class="brand-logo" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
        @endif
        <span>
            Admin
            <small class="d-block fw-normal opacity-75" style="font-size: .75rem;">
                {{ $schoolName }}
            </small>
        </span>
    </a>

    <ul class="tk-admin-menu">
        @foreach ($items as $item)
            @php $isActive = request()->routeIs($item['pattern'] ?? $item['route']); @endphp
            <li>
                <a class="{{ $isActive ? 'active' : '' }}"
                   href="{{ route($item['route']) }}"
                   @if ($isActive) aria-current="page" @endif>
                    <i class="bi {{ $item['icon'] }} me-2" aria-hidden="true"></i>{{ $item['label'] }}
                </a>
            </li>
        @endforeach
    </ul>
</nav>
