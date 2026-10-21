@extends('layouts.public')

@section('title', 'Unduhan')
@section('meta_description', 'Berkas dan dokumen yang dapat diunduh.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Unduhan"
                description="Dokumen dan formulir yang dapat diunduh untuk keperluan siswa, orang tua, dan mitra."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($items->isNotEmpty())
                <div class="tk-card">
                    @foreach ($items as $item)
                        <div class="d-flex flex-column flex-md-row align-items-md-center gap-3 p-3 {{ ! $loop->last ? 'border-bottom' : '' }}">
                            <div class="tk-download-icon" aria-hidden="true">
                                <i class="bi bi-file-earmark-arrow-down"></i>
                            </div>

                            <div class="flex-grow-1">
                                <h2 class="h6 mb-1">{{ $item->judul }}</h2>
                                @if (filled($item->deskripsi))
                                    <p class="text-muted-soft small mb-1">{{ \Illuminate\Support\Str::limit($item->deskripsi, 180) }}</p>
                                @endif
                                <p class="text-muted-soft small mb-0">Ukuran: {{ $item->ukuranTampil() }}</p>
                            </div>

                            <a class="btn btn-tk-primary" href="{{ route('unduhan.download', $item) }}">
                                <i class="bi bi-download me-1" aria-hidden="true"></i>Unduh
                            </a>
                        </div>
                    @endforeach
                </div>

                @if ($items->hasPages())
                    <div class="mt-4">{{ $items->links() }}</div>
                @endif
            @else
                <x-empty-state
                    icon="bi-folder2-open"
                    title="Belum ada berkas unduhan"
                    message="Dokumen yang dapat diunduh akan tampil setelah pihak sekolah mengunggahnya."
                />
            @endif
        </div>
    </section>
@endsection
