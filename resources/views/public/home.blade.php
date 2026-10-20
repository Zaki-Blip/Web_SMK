@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');

    // Ringkasan data kontak yang sudah benar-benar diisi (tidak menampilkan placeholder).
    $facts = [];

    if (filled($site?->address)) {
        $facts[] = ['bi-geo-alt', \Illuminate\Support\Str::limit($site->address, 64)];
    }

    if (filled($site?->opening_hours)) {
        $facts[] = ['bi-clock', $site->opening_hours];
    }

    if (filled($site?->phone)) {
        $facts[] = ['bi-telephone', $site->phone];
    }
@endphp

@section('title', $site?->meta_title ?: $schoolName.' — Taman Kanak-Kanak di Jakarta Timur')
@section('meta_description', $site?->meta_description ?: 'Profil, program, fasilitas, galeri, berita, dan informasi PPDB '.$schoolName.'.')

@section('content')
    {{-- Hero --}}
    <section class="tk-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <p class="tk-badge mb-2">Taman Kanak-Kanak</p>
                    <h1 class="mb-2">{{ $schoolName }}</h1>
                    <p class="text-muted-soft mb-3">
                        {{ $profile->description ? \Illuminate\Support\Str::limit($profile->description, 220) : 'Selamat datang di halaman informasi sekolah. Halaman ini memuat profil sekolah, program pembelajaran, fasilitas, galeri kegiatan, berita, dan informasi PPDB.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-tk-primary" href="{{ route('profile.index') }}">Profil Sekolah</a>
                        <a class="btn btn-tk-accent" href="{{ route('admission.index') }}">Informasi PPDB</a>
                    </div>

                    @if ($facts)
                        <ul class="tk-hero-facts">
                            @foreach ($facts as [$icon, $text])
                                <li><i class="bi {{ $icon }}" aria-hidden="true"></i>{{ $text }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="tk-hero-media">
                        <span class="text-center px-3">
                            <i class="bi bi-image d-block mb-2" style="font-size: 2.25rem;" aria-hidden="true"></i>
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
                :link="route('profile.index')"
                link-label="Profil lengkap"
            />

            @if (filled($profile->description))
                <div class="tk-card p-3 p-md-4">
                    <div class="tk-prose">{!! nl2br(e($profile->description)) !!}</div>
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
                :link="route('program.index')"
            />

            @if ($programs->isNotEmpty())
                <div class="row g-3">
                    @foreach ($programs as $program)
                        <div class="col-md-6 col-lg-4">
                            <x-public.program-card :program="$program" />
                        </div>
                    @endforeach
                </div>
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
                :link="route('facility.index')"
            />

            @if ($facilities->isNotEmpty())
                <div class="row g-3">
                    @foreach ($facilities as $facility)
                        <div class="col-md-6 col-lg-4">
                            <x-public.facility-card :facility="$facility" />
                        </div>
                    @endforeach
                </div>
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
                :link="route('gallery.index')"
                link-label="Semua foto"
            />

            @if ($galleryItems->isNotEmpty())
                <x-public.gallery-grid :items="$galleryItems" />
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
                :link="route('news.index')"
                link-label="Semua berita"
            />

            @if ($newsItems->isNotEmpty())
                <div class="row g-3">
                    @foreach ($newsItems as $news)
                        <div class="col-md-6 col-lg-4">
                            <x-public.news-card :news="$news" />
                        </div>
                    @endforeach
                </div>
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
    <section class="section section-tight bg-white border-top">
        <div class="container">
            <div class="p-3 p-md-4 rounded-4 border" style="background-color: var(--tk-sky);">
                <div class="row align-items-center g-3">
                    <div class="col-lg-8">
                        <h2 class="h4 mb-1">Informasi Penerimaan Peserta Didik Baru</h2>
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
                :link="route('contact.index')"
                link-label="Halaman kontak"
            />

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="tk-card p-3 h-100">
                        <h3 class="h6 mb-2">Alamat</h3>
                        <address class="mb-2">{{ $site?->address ?: config('school.fallback.address') }}</address>
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
                    <div class="tk-card p-3 h-100">
                        <h3 class="h6 mb-2">Kontak resmi</h3>
                        <ul class="list-unstyled mb-3 small">
                            <li class="mb-1">Telepon: {{ $site?->phone ?: 'Belum dikonfirmasi' }}</li>
                            <li class="mb-1">Email: {{ $site?->email ?: 'Belum dikonfirmasi' }}</li>
                            <li class="mb-1">Jam operasional: {{ $site?->opening_hours ?: 'Belum dikonfirmasi' }}</li>
                        </ul>
                        <x-public.admission-cta :whatsapp-url="$site?->whatsappUrl()" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
