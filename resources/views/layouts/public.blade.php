@php
    // Data pengaturan situs bisa datang dari controller; pada halaman error diambil langsung dari database.
    $site = $site ?? rescue(fn () => \App\Models\SiteSetting::current(), null, false);

    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
    $metaTitle = trim($__env->yieldContent('title')) ?: ($site?->meta_title ?: $schoolName);
    $metaDescription = trim($__env->yieldContent('meta_description')) ?: ($site?->meta_description ?: 'Informasi profil sekolah, program, fasilitas, galeri, berita, dan PPDB '.$schoolName.'.');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Judul dan meta description unik per halaman (bagian 12) --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="robots" content="@yield('robots', 'index, follow')">

    @if (app()->environment('production'))
        <link rel="canonical" href="{{ url()->current() }}">
    @endif

    {{-- Open Graph dasar --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $schoolName }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="id_ID">

    @stack('head')

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">

    {{-- Font Google: Nunito (heading) dan Inter (isi) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Bootstrap 5.3 dan Bootstrap Icons via CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    {{-- CSS kustom proyek --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="d-flex flex-column min-vh-100">
    <x-demo-banner />

    <x-public.navbar :schoolName="$schoolName" />

    <main id="konten" class="flex-grow-1">
        <x-flash-message />
        @yield('content')
    </main>

    <x-public.footer :site="$site" :schoolName="$schoolName" />

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</body>
</html>
