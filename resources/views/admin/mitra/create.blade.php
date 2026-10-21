@extends('layouts.admin')
@section('title', 'Tambah Mitra')
@section('heading', 'Tambah Mitra')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.mitra-industri.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.mitra.form', ['mitra' => new \App\Models\MitraIndustri(['is_active'=>true,'urutan'=>0])])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.mitra-industri.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection