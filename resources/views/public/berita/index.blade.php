@extends('layouts.public')

@section('title', 'Berita — '.($site?->school_name ?: config('school.fallback.school_name')))
@section('meta_description', 'Berita dan kegiatan terbaru '.($site?->school_name ?: config('school.fallback.school_name')).'.')

@php
    $itemList = $newsItems->getCollection()
        ->map(fn ($item) => ['name' => $item->title, 'url' => route('berita.show', $item->slug)])
        ->all();
@endphp

@push('head')
    <x-seo.json-ld :data="\App\Support\Seo::itemList($itemList, 'Berita sekolah')" />
@endpush

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Berita" description="Berita dan kegiatan terbaru sekolah." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($kategoris->isNotEmpty())
                <div class="d-flex flex-wrap gap-2 mb-3" aria-label="Filter kategori berita">
                    <a class="btn btn-sm {{ $kategori === '' ? 'btn-tk-primary' : 'btn-tk-outline' }}"
                       href="{{ route('berita.index') }}">Semua</a>
                    @foreach ($kategoris as $item)
                        <a class="btn btn-sm {{ $kategori === $item ? 'btn-tk-primary' : 'btn-tk-outline' }}"
                           href="{{ route('berita.index', ['kategori' => $item]) }}">{{ ucfirst($item) }}</a>
                    @endforeach
                </div>
            @endif

            @if ($newsItems->isNotEmpty())
                <div class="row g-3">
                    @foreach ($newsItems as $news)
                        <div class="col-md-6 col-lg-4">
                            <x-public.berita-card :news="$news" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-3">
                    {{ $newsItems->links() }}
                </div>
            @else
                <x-empty-state
                    icon="bi-newspaper"
                    title="{{ $kategori !== '' ? 'Tidak ada berita pada kategori ini' : 'Belum ada berita yang dipublikasikan' }}"
                    message="{{ $kategori !== '' ? 'Coba pilih kategori lain atau kembali ke semua berita.' : 'Berita terbaru akan tampil setelah pihak sekolah mempublikasikannya.' }}"
                />
            @endif
        </div>
    </section>
@endsection
