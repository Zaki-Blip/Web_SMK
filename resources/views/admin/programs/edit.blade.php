@extends('layouts.admin')

@section('title', 'Ubah program')
@section('heading', 'Ubah program')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Ubah program</h1>
            <p class="text-muted-soft mb-0">{{ $program->name }}</p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admin.programs.index') }}">
            <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Kembali ke daftar
        </a>
    </div>

    @include('admin.programs.form', ['program' => $program])
@endsection
