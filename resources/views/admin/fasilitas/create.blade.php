@extends('layouts.admin')

@section('title', 'Tambah fasilitas')
@section('heading', 'Tambah fasilitas')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Tambah fasilitas</h1>
            <p class="text-muted-soft mb-0">Lengkapi informasi fasilitas, lalu simpan.</p>
        </div>
    </div>

    @include('admin.fasilitas.form', ['facility' => $facility])
@endsection

