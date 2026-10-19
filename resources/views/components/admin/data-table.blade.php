@props(['columns' => [], 'caption' => null])

{{-- Tabel admin: dibungkus agar tetap bisa digulir horizontal di layar kecil (bagian 14). --}}
<div class="tk-table-wrap">
    <table class="table table-hover align-middle mb-0">
        @if ($caption)
            <caption class="px-3">{{ $caption }}</caption>
        @endif

        @if (count($columns))
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th scope="col">{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody>
            {{ $slot }}
        </tbody>
    </table>
</div>
