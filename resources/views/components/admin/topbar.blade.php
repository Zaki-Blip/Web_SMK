@php
    $user = auth()->user();
@endphp

<header class="tk-admin-topbar d-flex flex-wrap gap-2 align-items-center justify-content-between">
    <p class="mb-0 fw-semibold">@yield('heading', 'Dashboard')</p>

    <div class="d-flex flex-wrap align-items-center gap-2">
        <a class="btn btn-sm btn-tk-outline" href="{{ route('home') }}" target="_blank" rel="noopener">
            <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>Lihat situs
        </a>

        @if ($user)
            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.account.edit') }}">
                <i class="bi bi-person-circle me-1" aria-hidden="true"></i>{{ $user->name }}
            </a>

            {{-- Logout hanya lewat POST --}}
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-tk-outline">
                    <i class="bi bi-box-arrow-right me-1" aria-hidden="true"></i>Keluar
                </button>
            </form>
        @endif
    </div>
</header>
