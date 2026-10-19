@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
    $whatsappUrl = $site?->whatsappUrl();
@endphp

@section('title', 'Kontak — '.$schoolName)
@section('meta_description', 'Alamat, kontak, dan lokasi '.$schoolName.'.')

@section('content')
    <section class="tk-hero py-4">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Kontak"
                description="Alamat dan kanal komunikasi resmi sekolah."
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="tk-card p-4 mb-4">
                        <h2 class="h5 mb-3">Alamat</h2>
                        <address class="mb-0">{{ $site?->address ?: config('school.fallback.address') }}</address>
                    </div>

                    <div class="tk-card p-4">
                        <h2 class="h5 mb-3">Kontak resmi</h2>
                        <dl class="row mb-3">
                            <dt class="col-sm-5">Telepon</dt>
                            <dd class="col-sm-7">{{ $site?->phone ?: 'Belum dikonfirmasi' }}</dd>

                            <dt class="col-sm-5">Email</dt>
                            <dd class="col-sm-7">{{ $site?->email ?: 'Belum dikonfirmasi' }}</dd>

                            <dt class="col-sm-5">Jam operasional</dt>
                            <dd class="col-sm-7">{{ $site?->opening_hours ?: 'Belum dikonfirmasi' }}</dd>

                            <dt class="col-sm-5">WhatsApp</dt>
                            <dd class="col-sm-7 mb-0">{{ $whatsappUrl ? 'Tersedia' : 'Belum dikonfirmasi' }}</dd>
                        </dl>

                        <x-public.admission-cta :whatsapp-url="$whatsappUrl" />
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="tk-card p-4 h-100">
                        <h2 class="h5 mb-3">Lokasi</h2>

                        @if ($site?->maps_url)
                            <p class="text-muted-soft">
                                Peta dibuka pada tab baru agar halaman tetap ringan.
                            </p>
                            <a class="btn btn-tk-primary" href="{{ $site->maps_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>Buka lokasi di Google Maps
                            </a>
                        @else
                            <div class="tk-placeholder mb-3">
                                <i class="bi bi-map" aria-hidden="true"></i>
                            </div>
                            <p class="text-muted-soft mb-0">
                                Tautan Google Maps akan tampil setelah URL peta dikonfirmasi oleh pihak sekolah.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
