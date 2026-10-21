@extends('layouts.admin')
@section('title', 'Agenda')
@section('heading', 'Agenda')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Agenda</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.agenda.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari agenda..."></div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Judul', 'Mulai', 'Lokasi', 'Status', 'Aksi']">
            @forelse ($items as $item)
                <tr>
                    <td>
                        <span class="fw-semibold d-block">{{ $item->judul }}</span>
                        <span class="text-muted-soft small">{{ $item->slug }}</span>
                    </td>
                    <td>{{ \App\Support\IndonesianDate::longWithTime($item->mulai) }}</td>
                    <td>{{ $item->lokasi ?: '-' }}</td>
                    <td><x-admin.status-badge :state="$item->is_published ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($item->is_published)
                                <a class="btn btn-sm btn-tk-outline" href="{{ route('agenda.show', $item) }}" target="_blank" rel="noopener">Lihat</a>
                            @endif
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.agenda.edit', $item) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.agenda.destroy', $item) }}" data-delete-label="{{ $item->judul }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($items->hasPages()) <div class="p-3">{{ $items->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection
