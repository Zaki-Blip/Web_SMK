@extends('layouts.public')

@section('title', 'Alur PKL')
@section('meta_description', 'Tahapan dan alur pelaksanaan Praktik Kerja Lapangan (PKL) siswa.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Alur Praktik Kerja Lapangan"
                description="Tahapan yang perlu dilalui siswa sebelum, selama, dan setelah PKL."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($items->isNotEmpty())
                <ol class="list-unstyled mb-0">
                    @foreach ($items as $index => $item)
                        <li class="d-flex gap-3 mb-3">
                            <span class="tk-step-number" aria-hidden="true">{{ $index + 1 }}</span>
                            <div class="tk-card p-3 p-md-4 flex-grow-1">
                                <h2 class="h5 mb-2">{{ $item->judul }}</h2>
                                @if (filled($item->deskripsi))
                                    <div class="tk-prose">{!! nl2br(e($item->deskripsi)) !!}</div>
                                @else
                                    <p class="text-muted-soft mb-0">Keterangan langkah ini belum diisi.</p>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ol>
            @else
                <x-empty-state
                    icon="bi-signpost-split"
                    title="Alur PKL belum diisi"
                    message="Tahapan PKL akan tampil setelah pihak sekolah menambahkannya."
                />
            @endif
        </div>
    </section>
@endsection
