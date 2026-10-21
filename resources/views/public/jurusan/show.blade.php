@extends('layouts.public')
@section('title', $jurusan->nama)
@section('meta_description', (string) $jurusan->ringkasan)
@section('og_image', (string) $jurusan->gambar)
@section('og_image_alt', $jurusan->nama)

@php
    $breadcrumbs = [
        ['name' => 'Beranda', 'url' => route('beranda')],
        ['name' => 'Jurusan', 'url' => route('jurusan.index')],
        ['name' => $jurusan->nama, 'url' => route('jurusan.show', $jurusan->slug)],
    ];
@endphp

@push('head')
    <x-seo.json-ld :data="\App\Support\Seo::course($jurusan, $site)" />
    <x-seo.json-ld :data="\App\Support\Seo::breadcrumb($breadcrumbs)" />
@endpush

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('jurusan.index') }}">Jurusan</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $jurusan->nama }}</li>
                </ol>
            </nav>
            <x-section-heading level="h1" :title="$jurusan->nama" :description="$jurusan->ringkasan" :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <x-public.media :url="$jurusan->imageUrl()" :alt="$jurusan->nama" icon="bi-mortarboard" imgClass="rounded-4 w-100 mb-3" placeholderClass="tk-placeholder" :width="1200" :height="675" />

                    <div class="tk-prose mb-3">{!! nl2br(e($jurusan->deskripsi)) !!}</div>

                    @if (is_array($jurusan->kompetensi))
                        <h2 class="h5 mt-4">Kompetensi</h2>
                        <ul>
                            @foreach ($jurusan->kompetensi as $k)
                                <li>{{ $k }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if ($jurusan->prospek_karier)
                        <h2 class="h5 mt-4">Prospek Karier</h2>
                        <p>{{ $jurusan->prospek_karier }}</p>
                    @endif
                </div>

                <aside class="col-lg-4">
                    <div class="tk-card p-3 p-md-4">
                        <h2 class="h6 text-uppercase text-muted-soft mb-3">Informasi Jurusan</h2>
                        <p class="mb-1"><strong>Lama belajar:</strong> {{ $jurusan->lama_belajar }}</p>

                        @if ($gurus->count())
                            <hr class="tk-divider my-3">
                            <h3 class="h6 mb-2">Guru Terkait</h3>
                            <ul class="list-unstyled mb-0 small">
                                @foreach ($gurus as $g)
                                    <li class="mb-1">{{ $g->nama }} &mdash; {{ $g->mata_pelajaran }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection