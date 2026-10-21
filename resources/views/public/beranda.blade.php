@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');

    // Ringkasan data kontak yang sudah benar-benar diisi (tidak menampilkan placeholder).
    $facts = [];

    if (filled($site?->address)) {
        $facts[] = ['bi-geo-alt', $site->address];
    }

    if (filled($site?->opening_hours)) {
        $facts[] = ['bi-clock', $site->opening_hours];
    }

    if (filled($site?->phone)) {
        $facts[] = ['bi-telephone', $site->phone];
    }
@endphp

@section('title', $site?->meta_title ?: $schoolName.' — SMK Negeri 64 Jakarta')
@section('meta_description', $site?->meta_description ?: 'Profil, jurusan, fasilitas, galeri, berita, dan informasi SPMB '.$schoolName.'.')

@section('content')
    {{-- Hero --}}
    <section class="tk-hero">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-lg-6">
                    <p class="tk-badge mb-2">Sekolah Menengah Kejuruan</p>
                    <h1 class="mb-2">{{ $schoolName }}</h1>
                    <p class="text-muted-soft mb-3">
                        {{ $profile->description ? \Illuminate\Support\Str::limit($profile->description, 220) : 'Selamat datang di halaman informasi sekolah. Halaman ini memuat profil sekolah, kompetensi keahlian, fasilitas, galeri kegiatan, berita, dan informasi SPMB.' }}
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a class="btn btn-tk-primary" href="{{ route('profil.index') }}">Profil Sekolah</a>
                        <a class="btn btn-tk-accent" href="{{ route('spmb.index') }}">Informasi SPMB</a>
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
                :link="route('profil.index')"
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

    {{-- Jurusan --}}
    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="Jurusan"
                title="Kompetensi keahlian"
                :link="route('jurusan.index')"
            />

            @if ($jurusans->isNotEmpty())
                <div class="row g-3">
                    @foreach ($jurusans as $jurusan)
                        <div class="col-md-6">
                            <x-public.jurusan-card :jurusan="$jurusan" />
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state
                    icon="bi-journal-bookmark"
                    title="Belum ada jurusan yang dipublikasikan"
                    message="Daftar kompetensi keahlian akan tampil setelah pihak sekolah menambahkannya."
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
                :link="route('fasilitas.index')"
            />

            @if ($facilities->isNotEmpty())
                <div class="row g-3">
                    @foreach ($facilities as $facility)
                        <div class="col-md-6 col-lg-4">
                            <x-public.fasilitas-card :facility="$facility" />
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
                :link="route('galeri.index')"
                link-label="Semua foto"
            />

            @if ($galleryItems->isNotEmpty())
                <x-public.galeri-grid :items="$galleryItems" />
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
                :link="route('berita.index')"
                link-label="Semua berita"
            />

            @if ($newsItems->isNotEmpty())
                <div class="row g-3">
                    @foreach ($newsItems as $news)
                        <div class="col-md-6 col-lg-4">
                            <x-public.berita-card :news="$news" />
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

    {{-- Testimoni --}}
    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="Testimoni"
                title="Cerita alumni"
                description="Pengalaman alumni setelah menempuh pendidikan di sekolah."
            />

            @if ($testimonis->isNotEmpty())
                <div class="row g-3">
                    @foreach ($testimonis as $testimoni)
                        <div class="col-md-6 col-lg-3">
                            <x-public.testimoni-card :testimoni="$testimoni" />
                        </div>
                    @endforeach
                </div>
            @else
                <x-empty-state
                    icon="bi-chat-quote"
                    title="Belum ada testimoni"
                    message="Testimoni alumni akan tampil setelah pihak sekolah menambahkannya."
                />
            @endif
        </div>
    </section>

    {{-- Ajakan SPMB --}}
    <section class="section section-tight bg-white border-top">
        <div class="container">
            <div class="p-3 p-md-4 rounded-4 border" style="background-color: var(--tk-sky);">
                <div class="row align-items-center g-3">
                    <div class="col-lg-8">
                        <h2 class="h4 mb-1">Informasi Penerimaan Peserta Didik Baru</h2>
                        <p class="text-muted-soft mb-0">
                            Lihat periode, persyaratan, dan alur pendaftaran pada halaman SPMB.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a class="btn btn-tk-primary" href="{{ route('spmb.index') }}">Lihat info SPMB</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section class="section bg-white border-top">
        <div class="container">
            <x-section-heading
                eyebrow="FAQ"
                title="Pertanyaan yang sering diajukan"
                :link="route('spmb.index')"
                link-label="Lihat info SPMB"
            />

            <x-public.faq-list :items="$faqs" id="faq-beranda" />
        </div>
    </section>

    {{-- Kontak --}}
    <section class="section">
        <div class="container">
            <x-section-heading
                eyebrow="Kontak"
                title="Hubungi sekolah"
                :link="route('kontak.index')"
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
                        <x-public.spmb-cta :whatsapp-url="$site?->whatsappUrl()" />
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

