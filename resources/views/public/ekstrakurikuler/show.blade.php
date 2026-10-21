@extends('layouts.public')
@section('title', $item->nama)
@section('meta_description', Str::limit((string) $item->deskripsi, 150))
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('ekstrakurikuler.index') }}">Ekstrakurikuler</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $item->nama }}</li>
                </ol>
            </nav>
            <x-section-heading level="h1" :title="$item->nama" description="Kegiatan ekstrakurikuler sekolah." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <x-public.media :url="$item->imageUrl()" :alt="$item->nama" icon="bi-stars" imgClass="rounded-4 w-100 mb-3" placeholderClass="tk-placeholder" :width="1200" :height="675" />
                    <div class="tk-prose">{{ $item->deskripsi }}</div>
                </div>

                <aside class="col-lg-4">
                    <div class="tk-card p-3 p-md-4">
                        <h2 class="h6 text-uppercase text-muted-soft mb-3">Informasi Kegiatan</h2>
                        <p class="mb-1"><strong>Pembina:</strong> {{ $item->pembina }}</p>
                        <p class="mb-0"><strong>Jadwal:</strong> {{ $item->jadwal }}</p>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection