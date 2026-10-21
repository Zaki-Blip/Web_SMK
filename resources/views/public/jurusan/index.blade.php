@extends('layouts.public')
@section('title', 'Jurusan')
@section('meta_description', 'Kompetensi keahlian yang tersedia di SMK Negeri 64 Jakarta.')

@php
    $itemList = $jurusans->getCollection()
        ->map(fn ($item) => ['name' => $item->nama, 'url' => route('jurusan.show', $item->slug)])
        ->all();
@endphp

@push('head')
    <x-seo.json-ld :data="\App\Support\Seo::itemList($itemList, 'Kompetensi keahlian')" />
@endpush

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Kompetensi Keahlian" description="Kompetensi keahlian unggulan yang dikembangkan sekolah." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse ($jurusans as $jurusan)
                    <div class="col-md-6">
                        <div class="tk-card h-100">
                            <x-public.media :url="$jurusan->imageUrl()" :alt="$jurusan->nama" icon="bi-mortarboard" imgClass="tk-card-img" placeholderClass="tk-placeholder" :width="800" :height="450" />
                            <div class="p-3">
                                <h2 class="h5">{{ $jurusan->nama }}</h2>
                                <p class="text-muted-soft small">{{ $jurusan->ringkasan }}</p>
                                <a href="{{ route('jurusan.show', $jurusan->slug) }}" class="btn btn-sm btn-tk-outline">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-mortarboard"
                            title="Belum ada jurusan"
                            message="Daftar kompetensi keahlian akan tampil setelah pihak sekolah menambahkannya."
                        />
                    </div>
                @endforelse
            </div>

            @if ($jurusans->hasPages())
                <div class="mt-3">{{ $jurusans->links() }}</div>
            @endif
        </div>
    </section>
@endsection