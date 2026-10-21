@extends('layouts.public')

@section('title', $item->judul)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((string) $item->deskripsi), 150))
@section('og_type', 'article')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('agenda.index') }}">Agenda</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $item->judul }}</li>
                </ol>
            </nav>

            <x-section-heading level="h1" :title="$item->judul" :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <article class="tk-card p-3 p-md-4">
                        @if (filled($item->deskripsi))
                            <div class="tk-prose">{!! nl2br(e($item->deskripsi)) !!}</div>
                        @else
                            <p class="text-muted-soft mb-0">Keterangan agenda belum diisi.</p>
                        @endif
                    </article>
                </div>

                <aside class="col-lg-4">
                    <div class="tk-card p-3 p-md-4">
                        <h2 class="h6 text-uppercase text-muted-soft mb-3">Informasi kegiatan</h2>
                        <dl class="row mb-0 small">
                            <dt class="col-5">Mulai</dt>
                            <dd class="col-7">{{ \App\Support\IndonesianDate::longWithTime($item->mulai) }}</dd>

                            @if ($item->selesai)
                                <dt class="col-5">Selesai</dt>
                                <dd class="col-7">{{ \App\Support\IndonesianDate::longWithTime($item->selesai) }}</dd>
                            @endif

                            @if (filled($item->lokasi))
                                <dt class="col-5">Lokasi</dt>
                                <dd class="col-7">{{ $item->lokasi }}</dd>
                            @endif

                            <dt class="col-5">Status</dt>
                            <dd class="col-7 mb-0">{{ $item->sudahSelesai() ? 'Selesai' : 'Akan datang' }}</dd>
                        </dl>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
