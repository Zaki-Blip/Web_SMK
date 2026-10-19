@extends('layouts.public')

@section('title', 'Profil Sekolah — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Sejarah, visi, misi, dan identitas '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@section('content')
    <section class="tk-hero py-4">
        <div class="container">
            <x-section-heading level="h1" title="Profil Sekolah" description="Sejarah, visi, misi, dan identitas sekolah." />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-7">
                    <div class="tk-card p-4 mb-4">
                        <h2 class="h5">Sejarah</h2>
                        <hr class="tk-divider">
                        @if (filled($profile->history))
                            <p class="mb-0">{!! nl2br(e($profile->history)) !!}</p>
                        @else
                            <p class="text-muted-soft mb-0">Sejarah sekolah belum diisi oleh pihak sekolah.</p>
                        @endif
                    </div>

                    <div class="tk-card p-4">
                        <h2 class="h5">Deskripsi</h2>
                        <hr class="tk-divider">
                        @if (filled($profile->description))
                            <p class="mb-0">{!! nl2br(e($profile->description)) !!}</p>
                        @else
                            <p class="text-muted-soft mb-0">Deskripsi sekolah belum diisi oleh pihak sekolah.</p>
                        @endif
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="tk-card p-4 mb-4">
                        <h2 class="h5">Visi</h2>
                        <hr class="tk-divider">
                        @if (filled($profile->vision))
                            <p class="mb-0">{!! nl2br(e($profile->vision)) !!}</p>
                        @else
                            <p class="text-muted-soft mb-0">Visi sekolah belum diisi.</p>
                        @endif
                    </div>

                    <div class="tk-card p-4 mb-4">
                        <h2 class="h5">Misi</h2>
                        <hr class="tk-divider">
                        @if (filled($profile->mission))
                            <p class="mb-0">{!! nl2br(e($profile->mission)) !!}</p>
                        @else
                            <p class="text-muted-soft mb-0">Misi sekolah belum diisi.</p>
                        @endif
                    </div>

                    <div class="tk-card p-4">
                        <h2 class="h5">Identitas sekolah</h2>
                        <hr class="tk-divider">
                        <dl class="row mb-0">
                            <dt class="col-5">Nama</dt>
                            <dd class="col-7">{{ $profile->school_name ?: ($site?->school_name ?: config('school.fallback.school_name')) }}</dd>

                            <dt class="col-5">Alamat</dt>
                            <dd class="col-7">{{ $site?->address ?: config('school.fallback.address') }}</dd>

                            <dt class="col-5">Telepon</dt>
                            <dd class="col-7">{{ $site?->phone ?: 'Belum dikonfirmasi' }}</dd>

                            <dt class="col-5">Email</dt>
                            <dd class="col-7 mb-0">{{ $site?->email ?: 'Belum dikonfirmasi' }}</dd>
                        </dl>
                        <p class="text-muted-soft mt-3 mb-0">
                            Data identitas lain (mis. NPSN) akan ditampilkan setelah dikonfirmasi sekolah.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
