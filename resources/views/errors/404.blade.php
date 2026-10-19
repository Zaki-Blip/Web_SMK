@extends('layouts.public')

@section('title', 'Halaman tidak ditemukan — ' . config('school.fallback.school_name'))
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan.')
@section('robots', 'noindex, follow')

@section('content')
    <section class="section">
        <div class="container" style="max-width: 720px;">
            <p class="tk-badge mb-3">Error 404</p>
            <h1 class="mb-3">Halaman tidak ditemukan</h1>
            <p class="text-muted-soft">
                Halaman yang Anda cari mungkin sudah dipindahkan atau tidak pernah ada.
                Silakan kembali ke beranda atau gunakan menu di atas.
            </p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a class="btn btn-tk-primary" href="{{ route('home') }}">Kembali ke beranda</a>
                <a class="btn btn-tk-outline" href="{{ route('contact.index') }}">Hubungi sekolah</a>
            </div>
        </div>
    </section>
@endsection
