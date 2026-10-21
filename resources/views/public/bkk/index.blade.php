@extends('layouts.public')
@section('title', 'Lowongan BKK')
@section('meta_description', 'Informasi lowongan kerja dari Bursa Kerja Khusus SMK Negeri 64 Jakarta.')
@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading level="h1" title="Lowongan Bursa Kerja Khusus" description="Informasi lowongan kerja untuk lulusan dan alumni." :compact="true" />
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-3">
                @forelse ($items as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="tk-card h-100 p-3">
                            <p class="mb-2">
                                <span class="tk-badge">{{ ucfirst(str_replace('_', ' ', $item->tipe)) }}</span>
                            </p>
                            <h2 class="h5">{{ $item->judul }}</h2>
                            <div class="text-muted-soft small">{{ $item->perusahaan }} &bull; {{ $item->lokasi }}</div>
                            <div class="small mt-2">{{ Str::limit($item->deskripsi, 120) }}</div>
                            @if ($item->batas_waktu)
                                <div class="text-muted-soft small mt-2">
                                    Batas lamaran: {{ \App\Support\IndonesianDate::long($item->batas_waktu) }}
                                </div>
                            @endif
                            <div class="mt-3">
                                <a href="{{ route('bkk.show', $item->id) }}" class="btn btn-sm btn-tk-outline">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <x-empty-state
                            icon="bi-briefcase"
                            title="Belum ada lowongan"
                            message="Informasi lowongan kerja akan tampil setelah pihak sekolah menambahkannya."
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