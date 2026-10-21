@extends('layouts.public')
@section('title', 'Ekstrakurikuler')
@section('meta_description', 'Kegiatan ekstrakurikuler untuk mengembangkan minat dan bakat peserta didik.')
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Ekstrakurikuler" description="Kegiatan pengembangan minat, bakat, dan karakter peserta didik." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse ($items as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="tk-card h-100">
                            <x-public.media :url="$item->imageUrl()" :alt="$item->nama" icon="bi-stars" imgClass="tk-card-img" placeholderClass="tk-placeholder" :width="800" :height="450" />
                            <div class="p-3">
                                <h2 class="h5">{{ $item->nama }}</h2>
                                <p class="text-muted-soft small">{{ $item->pembina }}</p>
                                <p>{{ $item->deskripsi }}</p>
                                <a href="{{ route('ekstrakurikuler.show', $item->slug) }}" class="btn btn-sm btn-tk-outline">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-stars"
                            title="Belum ada ekstrakurikuler"
                            message="Daftar kegiatan ekstrakurikuler akan tampil setelah pihak sekolah menambahkannya."
                        />
                    </div>
                @endforelse
            </div>

            @if ($items->hasPages())
                <div class="mt-3">{{ $items->links() }}</div>
            @endif
        </div>
    </section>
@endsection