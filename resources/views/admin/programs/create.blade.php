@extends('layouts.admin')

@section('title', 'Tambah program')
@section('heading', 'Tambah program')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Tambah program</h1>
            <p class="text-muted-soft mb-0">Lengkapi informasi program, lalu simpan.</p>
        </div>
    </div>

    @include('admin.programs.form', ['program' => $program])
@endsection

