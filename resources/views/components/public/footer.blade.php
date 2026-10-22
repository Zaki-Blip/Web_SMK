@props(['site' => null, 'schoolName' => null])

@php
    $schoolName = $schoolName ?: config('school.fallback.school_name');
    $address = $site?->address ?: config('school.fallback.address');
    $phone = $site?->phone;
    $email = $site?->email;
    $openingHours = $site?->opening_hours;
    $whatsappUrl = $site?->whatsappUrl();
    $mapsUrl = $site?->maps_url;
@endphp

<footer class="tk-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h2 class="h5 mb-3">{{ $schoolName }}</h2>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex gap-2 mb-2">
                        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                        <address class="mb-0">{{ $address }}</address>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                        <i class="bi bi-telephone-fill" aria-hidden="true"></i>
                        <span>Telepon: {{ $phone ?: 'Belum dikonfirmasi' }}</span>
                    </li>
                    <li class="d-flex gap-2 mb-2">
                        <i class="bi bi-envelope-fill" aria-hidden="true"></i>
                        <span>Email: {{ $email ?: 'Belum dikonfirmasi' }}</span>
                    </li>
                    <li class="d-flex gap-2">
                        <i class="bi bi-clock-fill" aria-hidden="true"></i>
                        <span>Jam operasional: {{ $openingHours ?: 'Belum dikonfirmasi' }}</span>
                    </li>
                </ul>

                @if (($site?->socialLinks() ?? []) !== [])
                    <h2 class="h6 mt-3 mb-2">Media sosial</h2>
                    <x-public.social-links :site="$site" />
                @endif
            </div>

            <div class="col-md-3 col-6">
                <h2 class="h6 mb-3">Informasi</h2>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('profil.index') }}">Profil Sekolah</a></li>
                    <li class="mb-2"><a href="{{ route('jurusan.index') }}">Jurusan</a></li>
                    <li class="mb-2"><a href="{{ route('struktur.index') }}">Struktur Organisasi</a></li>
                    <li class="mb-2"><a href="{{ route('fasilitas.index') }}">Fasilitas</a></li>
                    <li class="mb-2"><a href="{{ route('galeri.index') }}">Galeri</a></li>
                </ul>
            </div>

            <div class="col-md-2 col-6">
                <h2 class="h6 mb-3">Layanan</h2>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2"><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="mb-2"><a href="{{ route('spmb.index') }}">SPMB</a></li>
                    <li class="mb-2"><a href="{{ route('kontak.index') }}">Kontak</a></li>
                    @if ($mapsUrl)
                        <li class="mb-2">
                            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer">Lokasi (Google Maps)</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="col-md-2">
                <h2 class="h6 mb-3">Lainnya</h2>
                <ul class="list-unstyled mb-0">
                    @if ($whatsappUrl)
                        <li class="mb-2">
                            <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener noreferrer">WhatsApp</a>
                        </li>
                    @endif
                    <li class="mb-2"><a href="{{ route('admin.dasbor') }}">Masuk Admin</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between gap-2">
            <p class="mb-0">&copy; {{ now()->year }} {{ $schoolName }}. Seluruh hak dilindungi.</p>
            @if (config('school.demo_mode'))
                <p class="mb-0">Versi demo — bukan website resmi sekolah.</p>
            @endif
        </div>
    </div>
</footer>

