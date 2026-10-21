@extends('layouts.public')

@section('title', 'Agenda')
@section('meta_description', 'Agenda kegiatan dan acara sekolah.')

@section('content')
    <section class="tk-page-head">
        <div class="container">
            <x-section-heading
                level="h1"
                title="Agenda"
                description="Jadwal kegiatan dan acara yang diselenggarakan sekolah."
                :compact="true"
            />
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if ($items->isNotEmpty())
                <div class="row g-3">
                    @foreach ($items as $item)
                        <div class="col-lg-6">
                            <article class="tk-card h-100 p-3 p-md-4">
                                <div class="d-flex flex-wrap align-items-start gap-3">
                                    <div class="tk-agenda-date" aria-hidden="true">
                                        <span class="tk-agenda-date-day">{{ $item->mulai->locale('id')->translatedFormat('d') }}</span>
                                        <span class="tk-agenda-date-month">{{ $item->mulai->locale('id')->translatedFormat('M Y') }}</span>
                                    </div>

                                    <div class="flex-grow-1">
                                        <p class="mb-2">
                                            <span class="tk-badge {{ $item->sudahSelesai() ? 'tk-badge-muted' : 'tk-badge-success' }}">
                                                {{ $item->sudahSelesai() ? 'Selesai' : 'Akan datang' }}
                                            </span>
                                        </p>
                                        <h2 class="h5 mb-2">
                                            <a class="stretched-link" href="{{ route('agenda.show', $item) }}">{{ $item->judul }}</a>
                                        </h2>
                                        <p class="text-muted-soft mb-2">
                                            <i class="bi bi-clock me-1" aria-hidden="true"></i>
                                            {{ \App\Support\IndonesianDate::longWithTime($item->mulai) }}
                                            @if ($item->selesai)
                                                &ndash; {{ \App\Support\IndonesianDate::longWithTime($item->selesai) }}
                                            @endif
                                        </p>
                                        @if (filled($item->lokasi))
                                            <p class="text-muted-soft small mb-0">
                                                <i class="bi bi-geo-alt me-1" aria-hidden="true"></i>{{ $item->lokasi }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                @if ($items->hasPages())
                    <div class="mt-4">{{ $items->links() }}</div>
                @endif
            @else
                <x-empty-state
                    icon="bi-calendar-event"
                    title="Belum ada agenda"
                    message="Agenda kegiatan akan tampil setelah pihak sekolah mempublikasikannya."
                />
            @endif
        </div>
    </section>
@endsection
