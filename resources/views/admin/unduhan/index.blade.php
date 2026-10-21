@extends('layouts.admin')
@section('title', 'Unduhan')
@section('heading', 'Unduhan')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Unduhan</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.unduhan.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari judul..."></div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Judul', 'Berkas', 'Ukuran', 'Urutan', 'Status', 'Aksi']">
            @forelse ($items as $item)
                <tr>
                    <td class="fw-semibold">{{ $item->judul }}</td>
                    <td>
                        @if ($item->fileUrl())
                            <a href="{{ $item->fileUrl() }}" target="_blank" rel="noopener">{{ basename($item->berkas) }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $item->ukuranTampil() }}</td>
                    <td>{{ $item->urutan }}</td>
                    <td><x-admin.status-badge :state="$item->is_published ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            @if ($item->is_published)
                                <a class="btn btn-sm btn-tk-outline" href="{{ route('unduhan.download', $item) }}">Unduh</a>
                            @endif
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.unduhan.edit', $item) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.unduhan.destroy', $item) }}" data-delete-label="{{ $item->judul }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($items->hasPages()) <div class="p-3">{{ $items->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection
