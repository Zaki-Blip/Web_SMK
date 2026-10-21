@extends('layouts.admin')
@section('title', 'Ubah Mitra')
@section('heading', 'Ubah Mitra')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.mitra-industri.update', $mitra) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.mitra.form', ['mitra' => $mitra])
            <div class="d-flex gap-2 mt-3">
                <button type="submit" class="btn btn-tk-primary">Simpan</button>
                <a href="{{ route('admin.mitra-industri.index') }}" class="btn btn-tk-outline">Batal</a>
            </div>
        </form>
    </div>
@endsection