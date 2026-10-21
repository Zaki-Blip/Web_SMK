@extends('layouts.admin')
@section('title', 'Tambah Agenda')
@section('heading', 'Tambah Agenda')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.agenda.store') }}">
            @csrf
            @include('admin.agenda.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.agenda.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
