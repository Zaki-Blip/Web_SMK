@extends('layouts.admin')
@section('title', 'Ubah Prestasi')
@section('heading', 'Ubah Prestasi')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.prestasi.update', $prestasi) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.prestasi.form', ['prestasi' => $prestasi])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.prestasi.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection