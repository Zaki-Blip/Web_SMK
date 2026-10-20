@php
    // $site dipakai sidebar untuk nama sekolah; halaman error diambil langsung dari database.
    $site = $site ?? rescue(fn () => \App\Models\SiteSetting::current(), null, false);
    $schoolName = $site?->school_name ?: config('school.fallback.school_name');
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Halaman admin tidak diindeks mesin pencari (bagian 12) --}}
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Dashboard') — Admin {{ $schoolName }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="tk-admin-body">
    {{-- Sidebar menetap saat konten digulir; konten di kanan memakai sisa lebar --}}
    <div class="tk-admin-shell">
        <div class="tk-admin-shell__sidebar">
            <x-admin.sidebar :school-name="$schoolName" />
        </div>

        <div class="tk-admin-shell__main">
            <x-admin.topbar />

            <main class="tk-admin-main">
                <x-flash-message :container="false" />
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
</body>
</html>
