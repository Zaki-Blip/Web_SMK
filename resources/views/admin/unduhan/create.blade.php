@extends('layouts.admin')
@section('title', 'Tambah Unduhan')
@section('heading', 'Tambah Unduhan')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.unduhan.store') }}" enctype="multipart/form-data">
            @csrf
            @include('admin.unduhan.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.unduhan.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
