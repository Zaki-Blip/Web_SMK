@extends('layouts.admin')
@section('title', 'Tambah Testimoni')
@section('heading', 'Tambah Testimoni')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.testimoni.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.testimoni.form', ['item' => new \App\Models\Testimoni(['is_active'=>true])])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.testimoni.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection