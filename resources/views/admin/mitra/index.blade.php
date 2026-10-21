@extends('layouts.admin')
@section('title', 'Mitra Industri')
@section('heading', 'Mitra Industri')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Mitra Industri</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.mitra-industri.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-6"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari nama..."></div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Logo', 'Nama', 'Bidang', 'Urutan', 'Status', 'Aksi']">
            @forelse ($mitras as $mitra)
                <tr>
                    <td><x-public.media :url="$mitra->imageUrl()" :alt="$mitra->nama" icon="bi-building" imgClass="tk-thumb" placeholderClass="tk-placeholder" :width="80" :height="80" /></td>
                    <td class="fw-semibold">{{ $mitra->nama }}</td>
                    <td>{{ $mitra->bidang }}</td>
                    <td>{{ $mitra->urutan }}</td>
                    <td><x-admin.status-badge :state="$mitra->is_active ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.mitra-industri.edit', $mitra) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.mitra-industri.destroy', $mitra) }}" data-delete-label="{{ $mitra->nama }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($mitras->hasPages()) <div class="p-3">{{ $mitras->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection