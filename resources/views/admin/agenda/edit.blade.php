@extends('layouts.admin')
@section('title', 'Ubah Agenda')
@section('heading', 'Ubah Agenda')
@section('content')
    <div class="tk-card p-4">
        <form method="POST" action="{{ route('admin.agenda.update', $item) }}">
            @csrf
            @method('PUT')
            @include('admin.agenda.form', ['item' => $item])
            <div class="d-flex gap-2 mt-3"><button type="submit" class="btn btn-tk-primary">Simpan</button><a href="{{ route('admin.agenda.index') }}" class="btn btn-tk-outline">Batal</a></div>
        </form>
    </div>
@endsection
