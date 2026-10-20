@extends('layouts.public')

@php
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
    $hasContent = filled($admission->description)
        || filled($admission->schedule)
        || filled($admission->requirements)
        || filled($admission->registration_steps)
        || filled($admission->fee_information);
    $whatsappUrl = $admission->whatsappUrl() ?: $site?->whatsappUrl();
@endphp

@section('title', 'Informasi PPDB — '.$schoolName)
@section('meta_description', 'Informasi periode, persyaratan, dan alur PPDB '.$schoolName.'.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="{{ $admission->title ?: 'Informasi PPDB' }}"
                description="Periode, persyaratan, dan alur pendaftaran peserta didik baru."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($admission->is_active && $hasContent)
                <div class="row g-3">
                    <div class="col-lg-7">
                        @if (filled($admission->description))
                            <div class="tk-card p-3 mb-3">
                                <div class="tk-prose">{!! nl2br(e($admission->description)) !!}</div>
                            </div>
                        @endif

                        @if (filled($admission->schedule))
                            <div class="tk-card p-3 mb-3">
                                <h2 class="h5 mb-2">Jadwal</h2>
                                <hr class="tk-divider">
                                <div class="tk-prose">{!! nl2br(e($admission->schedule)) !!}</div>
                            </div>
                        @endif

                        @if (filled($admission->registration_steps))
                            <div class="tk-card p-3">
                                <h2 class="h5 mb-2">Alur pendaftaran</h2>
                                <hr class="tk-divider">
                                <div class="tk-prose">{!! nl2br(e($admission->registration_steps)) !!}</div>
                            </div>
                        @endif
                    </div>

                    <div class="col-lg-5">
                        @if (filled($admission->requirements))
                            <div class="tk-card p-3 mb-3">
                                <h2 class="h5 mb-2">Persyaratan</h2>
                                <hr class="tk-divider">
                                <div class="tk-prose">{!! nl2br(e($admission->requirements)) !!}</div>
                            </div>
                        @endif

                        @if (filled($admission->fee_information))
                            <div class="tk-card p-3 mb-3">
                                <h2 class="h5 mb-2">Informasi biaya</h2>
                                <hr class="tk-divider">
                                <div class="tk-prose">{!! nl2br(e($admission->fee_information)) !!}</div>
                            </div>
                        @endif

                        <div class="tk-card p-3">
                            <h2 class="h5 mb-2">Kontak resmi</h2>
                            <hr class="tk-divider">
                            <ul class="list-unstyled mb-3 small">
                                <li class="mb-1">Telepon: {{ $site?->phone ?: 'Belum dikonfirmasi' }}</li>
                                <li class="mb-1">Email: {{ $site?->email ?: 'Belum dikonfirmasi' }}</li>
                            </ul>
                            <x-public.admission-cta :whatsapp-url="$whatsappUrl" />
                        </div>
                    </div>
                </div>
            @else
                <x-empty-state
                    icon="bi-clipboard-check"
                    title="Informasi pendaftaran akan diperbarui oleh pihak sekolah"
                    message="Data periode, persyaratan, alur pendaftaran, dan biaya akan tampil setelah pihak sekolah mengisinya melalui dashboard admin."
                />

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <div class="tk-card p-3 h-100">
                            <h2 class="h6 mb-2">Kontak resmi</h2>
                            <ul class="list-unstyled mb-0 small">
                                <li class="mb-1">Telepon: {{ $site?->phone ?: 'Belum dikonfirmasi' }}</li>
                                <li class="mb-1">Email: {{ $site?->email ?: 'Belum dikonfirmasi' }}</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="tk-card p-3 h-100">
                            <h2 class="h6 mb-2">Kanal pendaftaran</h2>
                            <p class="text-muted-soft small">
                                Tautan WhatsApp resmi akan ditampilkan setelah nomor dikonfirmasi oleh pihak sekolah.
                            </p>
                            <x-public.admission-cta :whatsapp-url="$whatsappUrl" :whatsapp-label="'Tanya via WhatsApp'" />
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
