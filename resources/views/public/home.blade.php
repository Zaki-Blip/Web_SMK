@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
@endphp

@section('title', $site?->meta_title ?: $schoolName.' — Taman Kanak-Kanak di Jakarta Timur')
@section('meta_description', $site?->meta_description ?: 'Profil, program, fasilitas, galeri, berita, dan informasi PPDB '.$schoolName.'.')

@section('content')
    {{-- Hero --}}
    <section class="tk-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <p class="tk-badge mb-3">Taman Kanak-Kanak</p>
                    <h1 class="mb-3">{{ $schoolName }}</h1>
                    <p class="lead text-muted-soft mb-4">
                        {{ $profile->description ? \Illuminate\Support\Str::limit($profile->description, 220) : 'Selamat datang di halaman informasi sekolah. Halaman ini memuat profil sekolah, program pembelajaran, fasilitas, galeri kegiatan, berita, dan informasi PPDB.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-tk-primary" href="{{ route('profile.index') }}">Profil Sekolah</a>
                        <a class="btn btn-tk-outline" href="{{ route('admission.index') }}">Informasi PPDB</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="tk-hero-media">
                        <span class="text-center px-3">
                            <i class="bi bi-image d-block mb-2" style="font-size: 2.5rem;" aria-hidden="true"></i>
                            Foto sekolah belum tersedia
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Profil singkat --}}
    <section class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Profil Singkat"
                title="Tentang sekolah"
                :description="$profile->vision ?: null"
            />

            @if (filled($profile->description))
                <div class="tk-card p-4">
                    <p class="mb-0">{!! nl2br(e($profile->description)) !!}</p>
                    <p class="mt-3 mb-0"><a href="{{ route('profile.index') }}">Selengkapnya tentang sekolah</a></p>
                </div>
            @else
                <x-empty-state
                    icon="bi-info-circle"
                    title="Deskripsi sekolah belum diisi"
                    message="Deskripsi singkat sekolah akan ditampilkan setelah pihak sekolah mengisi data profil."
                />
            @endif
        </div>
    </section>

    {{-- Program --}}
    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="Program"
                title="Program pembelajaran"
                description="Program yang ditampilkan hanya yang berstatus dipublikasikan oleh sekolah."
            />

            @if ($programs->isNotEmpty())
                <div class="row g-3">
                    @foreach ($programs as $program)
                        <div class="col-md-6 col-lg-4">
                            <x-public.program-card :program="$program" />
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 mb-0"><a href="{{ route('program.index') }}">Lihat semua program</a></p>
            @else
                <x-empty-state
                    icon="bi-journal-bookmark"
                    title="Belum ada program yang dipublikasikan"
                    message="Daftar program pembelajaran akan tampil setelah pihak sekolah menambahkannya."
                />
            @endif
        </div>
    </section>

    {{-- Fasilitas --}}
    <section class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Fasilitas"
                title="Fasilitas sekolah"
                description="Informasi fasilitas hanya ditampilkan setelah dipublikasikan oleh pihak sekolah."
            />

            @if ($facilities->isNotEmpty())
                <div class="row g-3">
                    @foreach ($facilities as $facility)
                        <div class="col-md-6 col-lg-4">
                            <x-public.facility-card :facility="$facility" />
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 mb-0"><a href="{{ route('facility.index') }}">Lihat semua fasilitas</a></p>
            @else
                <x-empty-state
                    icon="bi-building"
                    title="Belum ada fasilitas yang dipublikasikan"
                    message="Daftar fasilitas akan tampil setelah pihak sekolah menambahkannya."
                />
            @endif
        </div>
    </section>

    {{-- Galeri --}}
    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="Galeri"
                title="Galeri kegiatan"
                description="Foto kegiatan hanya ditampilkan setelah ada persetujuan publikasi."
            />

            @if ($galleryItems->isNotEmpty())
                <x-public.gallery-grid :items="$galleryItems" />
                <p class="mt-3 mb-0"><a href="{{ route('gallery.index') }}">Lihat semua foto</a></p>
            @else
                <x-empty-state
                    icon="bi-images"
                    title="Belum ada foto pada galeri"
                    message="Foto kegiatan akan tampil setelah pihak sekolah mengunggahnya."
                />
            @endif
        </div>
    </section>

    {{-- Berita terbaru --}}
    <section class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Berita"
                title="Berita terbaru"
                description="Kabar dan kegiatan terbaru dari sekolah."
            />

            @if ($newsItems->isNotEmpty())
                <div class="row g-3">
                    @foreach ($newsItems as $news)
                        <div class="col-md-6 col-lg-4">
                            <x-public.news-card :news="$news" />
                        </div>
                    @endforeach
                </div>
                <p class="mt-3 mb-0"><a href="{{ route('news.index') }}">Lihat semua berita</a></p>
            @else
                <x-empty-state
                    icon="bi-newspaper"
                    title="Belum ada berita yang dipublikasikan"
                    message="Berita terbaru akan tampil setelah pihak sekolah mempublikasikannya."
                />
            @endif
        </div>
    </section>

    {{-- Ajakan PPDB --}}
    <section class="section bg-white border-top">
        <div class="container">
            <div class="p-4 p-md-5 rounded-4" style="background-color: var(--tk-sky);">
                <div class="row align-items-center g-3">
                    <div class="col-lg-8">
                        <h2 class="h3 mb-2">Informasi Penerimaan Peserta Didik Baru</h2>
                        <p class="text-muted-soft mb-0">
                            Lihat periode, persyaratan, dan alur pendaftaran pada halaman PPDB.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="btn btn-tk-primary" href="{{ route('admission.index') }}">Lihat info PPDB</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Kontak --}}
    <section class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Kontak"
                title="Hubungi sekolah"
                description="Alamat, kanal komunikasi resmi, dan lokasi sekolah."
            />

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="tk-card p-4">
                        <h3 class="h6 mb-3">Alamat</h3>
                        <address class="mb-3">{{ $site?->address ?: config('school.fallback.address') }}</address>
                        @if ($site?->maps_url)
                            <a href="{{ $site->maps_url }}" target="_blank" rel="noopener noreferrer">Buka di Google Maps</a>
                        @else
                            <p class="mb-0 text-muted-soft">
                                Tautan Google Maps akan ditampilkan setelah URL peta dikonfirmasi oleh sekolah.
                            </p>
                        @endif
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="tk-card p-4">
                        <h3 class="h6 mb-3">Kontak resmi</h3>
                        <ul class="list-unstyled mb-3">
                            <li class="mb-2">Telepon: {{ $site?->phone ?: 'Belum dikonfirmasi' }}</li>
                            <li class="mb-2">Email: {{ $site?->email ?: 'Belum dikonfirmasi' }}</li>
                            <li class="mb-2">Jam operasional: {{ $site?->opening_hours ?: 'Belum dikonfirmasi' }}</li>
                        </ul>
                        <x-public.admission-cta :whatsapp-url="$site?->whatsappUrl()" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
