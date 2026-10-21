@extends('layouts.admin')
@section('title', 'Prestasi')
@section('heading', 'Prestasi')
@section('content')
    <div class="tk-admin-page-head">
        <div><h1 class="h5 mb-1">Prestasi</h1></div>
        <a class="btn btn-tk-primary" href="{{ route('admin.prestasi.create') }}"><i class="bi bi-plus-lg me-1"></i>Tambah</a>
    </div>
    <div class="tk-card p-3 mb-3">
        <form method="GET" class="row g-2">
            <div class="col-md-4"><input type="text" name="q" value="{{ $search }}" class="form-control" placeholder="Cari judul..."></div>
            <div class="col-md-3">
                <select name="tingkat" class="form-select">
                    <option value="">Semua tingkat</option>
                    @foreach (['sekolah','kota','provinsi','nasional','internasional'] as $t)
                        <option value="{{ $t }}" @selected($tingkat===$t)>{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2"><button class="btn btn-tk-outline w-100">Cari</button></div>
        </form>
    </div>
    <div class="tk-card">
        <x-admin.data-table :columns="['Gambar', 'Judul', 'Tingkat', 'Tahun', 'Peraih', 'Status', 'Aksi']">
            @forelse ($prestasis as $p)
                <tr>
                    <td><x-public.media :url="$p->imageUrl()" :alt="$p->judul" icon="bi-trophy" imgClass="tk-thumb" placeholderClass="tk-placeholder" :width="80" :height="80" /></td>
                    <td class="fw-semibold">{{ $p->judul }}</td>
                    <td>{{ ucfirst($p->tingkat) }}</td>
                    <td>{{ $p->tahun }}</td>
                    <td>{{ $p->peraih }}</td>
                    <td><x-admin.status-badge :state="$p->is_active ? 'published' : 'draft'" /></td>
                    <td>
                        <div class="d-flex flex-wrap gap-2">
                            <a class="btn btn-sm btn-tk-outline" href="{{ route('admin.prestasi.edit', $p) }}">Ubah</a>
                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirm-delete" data-delete-url="{{ route('admin.prestasi.destroy', $p) }}" data-delete-label="{{ $p->judul }}">Hapus</button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="tk-empty-cell">Belum ada data.</td></tr>
            @endforelse
        </x-admin.data-table>
        @if ($prestasis->hasPages()) <div class="p-3">{{ $prestasis->links() }}</div> @endif
    </div>
    <x-admin.confirm-dialog title="Hapus data ini?" message="Data akan dihapus permanen." />
@endsection