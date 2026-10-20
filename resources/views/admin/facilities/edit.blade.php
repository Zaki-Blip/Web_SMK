@extends('layouts.admin')

@section('title', 'Ubah fasilitas')
@section('heading', 'Ubah fasilitas')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Ubah fasilitas</h1>
            <p class="text-muted-soft mb-0">{{ $facility->name }}</p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admin.facilities.index') }}">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke daftar
        </a>
    </div>

    @include('admin.facilities.form', ['facility' => $facility])
@endsection

