@extends('layouts.admin-guest')

@section('title', 'Masuk')

@section('content')
    <div class="tk-card p-4">
        <div class="text-center mb-4">
            <span class="brand-logo d-inline-flex mb-2" aria-hidden="true"><i class="bi bi-mortarboard-fill"></i></span>
            <h1 class="h4 mb-1">Masuk Dashboard</h1>
            <p class="text-muted-soft mb-0">Panel admin {{ $site?->school_name ?: config('school.fallback.school_name') }}</p>
        </div>

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

            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
                <label class="form-check-label" for="remember">Ingat saya di perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-tk-primary w-100">
                <i class="bi bi-box-arrow-in-right me-1" aria-hidden="true"></i>Masuk
            </button>
        </form>

        <p class="text-muted-soft small mt-4 mb-0">
            Tidak ada pendaftaran publik. Akun admin dibuat oleh pengelola melalui perintah
            <code>php artisan app:create-admin</code>.
        </p>
    </div>

    <p class="text-center mt-3 mb-0">
        <a href="{{ route('home') }}"><i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke situs</a>
    </p>
@endsection
