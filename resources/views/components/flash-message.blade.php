@props(['container' => true])

@php
    // $errors hanya tersedia saat middleware web aktif (mis. halaman 404 dari exception handler).
    $errorBag = $errors ?? null;
    $useContainer = filter_var($container, FILTER_VALIDATE_BOOLEAN);
@endphp

@if (session('success') || session('error') || ($errorBag && $errorBag->any()))
    <div class="{{ $useContainer ? 'container mt-3' : 'mb-3' }}">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($errorBag && $errorBag->any())
            <div class="alert alert-danger" role="alert">
                <p class="mb-2 fw-semibold">Periksa kembali isian berikut:</p>
                <ul class="mb-0">
                    @foreach ($errorBag->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endif
