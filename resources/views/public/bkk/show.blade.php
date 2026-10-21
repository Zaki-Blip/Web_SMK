@extends('layouts.public')
@section('title', $item->judul)
@section('meta_description', Str::limit(strip_tags((string) $item->deskripsi), 150))
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb small mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('bkk.index') }}">Lowongan BKK</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $item->judul }}</li>
                </ol>
            </nav>
            <x-section-heading
                level="h1"
                :title="$item->judul"
                :description="$item->perusahaan.' • '.$item->lokasi.' • '.ucfirst(str_replace('_', ' ', $item->tipe))"
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="tk-card p-3 p-md-4">
                        <div class="tk-prose">{!! nl2br(e($item->deskripsi)) !!}</div>

                        @if ($item->persyaratan)
                            <hr class="tk-divider my-3">
                            <h2 class="h5">Persyaratan</h2>
                            <div class="tk-prose">{!! nl2br(e($item->persyaratan)) !!}</div>
                        @endif
                    </div>
                </div>

                <aside class="col-lg-4">
                    <div class="tk-card p-3 p-md-4">
                        <h2 class="h6 text-uppercase text-muted-soft mb-3">Ringkasan</h2>

                        @if ($item->batas_waktu)
                            <p class="mb-2">
                                <strong>Batas lamaran:</strong><br>
                                {{ \App\Support\IndonesianDate::long($item->batas_waktu) }}
                            </p>
                        @endif

                        @if ($item->tautan_daftar)
                            <a href="{{ $item->tautan_daftar }}" target="_blank" rel="noopener" class="btn btn-tk-primary w-100 mt-2">
                                Daftar
                            </a>
                        @else
                            <p class="text-muted-soft small mb-0">
                                Informasi cara melamar akan diumumkan oleh pihak sekolah.
                            </p>
                        @endif
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection