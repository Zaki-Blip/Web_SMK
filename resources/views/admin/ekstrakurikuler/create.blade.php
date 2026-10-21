@extends('layouts.admin')
@section('title', 'Tambah Ekstrakurikuler')
@section('heading', 'Tambah Ekstrakurikuler')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.ekstrakurikuler.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.ekstrakurikuler.form', ['item' => new \App\Models\Ekstrakurikuler(['is_active'=>true,'urutan'=>0])])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.ekstrakurikuler.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection