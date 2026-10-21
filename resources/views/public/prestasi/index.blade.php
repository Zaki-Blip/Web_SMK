@extends('layouts.public')
@section('title', 'Prestasi')
@section('meta_description', 'Prestasi akademik dan nonakademik peserta didik SMK Negeri 64 Jakarta.')
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Prestasi" description="Capaian akademik dan nonakademik peserta didik." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse ($items as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="tk-card h-100">
                            <x-public.media :url="$item->imageUrl()" :alt="$item->judul" icon="bi-trophy" imgClass="tk-card-img" placeholderClass="tk-placeholder" :width="800" :height="450" />
                            <div class="p-3">
                                <h2 class="h5">{{ $item->judul }}</h2>
                                <p class="mb-2">
                                    <span class="tk-badge tk-badge-success">{{ ucfirst($item->tingkat) }}</span>
                                    <span class="tk-badge tk-badge-muted">{{ $item->tahun }}</span>
                                </p>
                                <p class="small mb-1">{{ $item->peraih }}</p>
                                <p class="mb-0">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-trophy"
                            title="Belum ada prestasi"
                            message="Daftar prestasi akan tampil setelah pihak sekolah menambahkannya."
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