@extends('layouts.admin-guest')

@section('title', 'Masuk')

@php
    // Blade merender isi @section sebelum layout, jadi data sekolah diambil di sini juga.
    $site = $site ?? rescue(fn () => \App\Models\SiteSetting::current(), null, false);
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
    $address = $site?->address ?: config('school.fallback.address');

    $logoUrl = $site?->logo_path
        ? \Illuminate\Support\Facades\Storage::disk(config('filesystems.uploads_disk', 'public'))->url($site->logo_path)
        : null;
@endphp

@section('content')
    <div class="tk-auth">
        {{-- Panel identitas sekolah: memberi konteks bahwa ini panel resmi sekolah --}}
        <aside class="tk-auth__brand">
            <div class="d-flex align-items-center gap-2">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="" class="brand-logo brand-logo-img" width="40" height="40">
                @else
                    <span class="brand-logo" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
                @endif
                <p class="tk-auth__brand-name">
                    {{ $schoolName }}
                    <span>{{ config('school.fallback.subtitle') }}</span>
                </p>
            </div>

            <div class="d-none d-lg-block">
                <hr class="tk-auth__rule">
                <p class="tk-auth__brand-text">
                    Panel pengelolaan konten website sekolah: profil, program, fasilitas, galeri, berita, dan informasi SPMB.
                </p>
            </div>

            <div class="d-none d-lg-block">
                <ul class="tk-auth__meta">
                    <li><i class="bi bi-geo-alt me-1" aria-hidden="true"></i>{{ $address }}</li>
                    @if ($site?->phone)
                        <li><i class="bi bi-telephone me-1" aria-hidden="true"></i>{{ $site->phone }}</li>
                    @endif
                </ul>

                <a class="d-inline-block mt-3 small" href="{{ route('beranda') }}">
                    <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke situs
                </a>
            </div>
        </aside>

        <main class="tk-auth__form">
            <div class="tk-auth__form-inner">
                <x-flash-message :container="false" />

                <h1 class="h3 mb-1">Masuk Dashboard</h1>
                <p class="text-muted-soft mb-4">Gunakan akun admin yang diberikan pengelola sekolah.</p>

                <form method="post" action="{{ route('admin.login.attempt') }}" novalidate>
                    @csrf

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                               value="{{ old('email') }}" required autofocus autocomplete="username"
                               @error('email') aria-describedby="email-error" aria-invalid="true" @enderror>
                        @error('email')
                            <div class="invalid-feedback" id="email-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">Kata sandi</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                               required autocomplete="current-password"
                               @error('password') aria-describedby="password-error" aria-invalid="true" @enderror>
                        @error('password')
                            <div class="invalid-feedback" id="password-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
                        <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
                    </div>

                    <button type="submit" class="btn btn-tk-primary w-100">Masuk</button>
                </form>

                <p class="text-muted-soft small mt-4 mb-0">
                    Tidak ada pendaftaran publik. Akun admin dibuat lewat perintah
                    <code>php artisan app:create-admin</code>.
                </p>

                <p class="mt-3 mb-0 d-lg-none">
                    <a href="{{ route('beranda') }}"><i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke situs</a>
                </p>
            </div>
        </main>
    </div>
@endsection

