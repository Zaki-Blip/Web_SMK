@extends('layouts.admin')
@section('title', 'Ubah Testimoni')
@section('heading', 'Ubah Testimoni')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.testimoni.update', $item) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.testimoni.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.testimoni.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection