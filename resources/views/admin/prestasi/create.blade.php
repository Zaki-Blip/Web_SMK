@extends('layouts.admin')
@section('title', 'Tambah Prestasi')
@section('heading', 'Tambah Prestasi')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.prestasi.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.prestasi.form', ['prestasi' => new \App\Models\Prestasi(['is_active'=>true,'tingkat'=>'sekolah','tahun'=>now()->year])])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.prestasi.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection