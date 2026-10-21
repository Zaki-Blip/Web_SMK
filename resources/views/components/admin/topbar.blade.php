@php
    $user = auth()->user();
@endphp

<header class="tk-admin-topbar d-flex flex-wrap gap-2 align-items-center justify-content-between">
    {{-- Judul di topbar disembunyikan di layar kecil karena halaman sudah punya judul sendiri --}}
    <p class="mb-0 fw-semibold d-none d-lg-block">@yield('heading', 'Dashboard')</p>

    <div class="d-flex flex-nowrap align-items-center gap-2 ms-auto">
        <a class="btn btn-sm btn-tk-outline" href="{{ route('beranda') }}" target="_blank" rel="noopener"
           title="Lihat situs" aria-label="Lihat situs">
            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
            <span class="d-none d-md-inline ms-1">Lihat situs</span>
        </a>

        @if ($user)
            <a class="btn btn-sm btn-tk-outline text-truncate" href="{{ route('admin.akun.edit') }}"
               title="Akun: {{ $user->name }}" aria-label="Akun: {{ $user->name }}" style="max-width: 14rem;">
                <i class="bi bi-person-circle" aria-hidden="true"></i>
                <span class="d-none d-md-inline ms-1">{{ $user->name }}</span>
            </a>

            {{-- Logout hanya lewat POST --}}
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-tk-outline" title="Keluar" aria-label="Keluar">
                    <i class="bi bi-box-arrow-right" aria-hidden="true"></i>
                    <span class="d-none d-md-inline ms-1">Keluar</span>
                </button>
            </form>
        @endif
    </div>
</header>
