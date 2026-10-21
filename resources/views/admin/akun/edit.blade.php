@extends('layouts.admin')

@section('title', 'Akun')
@section('heading', 'Akun Saya')

@section('content')
    <div class="row g-3">
        <div class="col-lg-7">
            <div class="tk-card p-3">
                <h2 class="h5 mb-1">Data akun</h2>
                <p class="text-muted-soft">Ubah nama, email, atau kata sandi akun admin Anda.</p>

                <form method="post" action="{{ route('admin.akun.update') }}">
                    @csrf
                    @method('PUT')

                    <x-admin.form-field name="name" label="Nama" :value="$user->name" required />
                    <x-admin.form-field name="email" type="email" label="Email" :value="$user->email" required />

                    <hr class="tk-divider">

                    <p class="text-muted-soft">
                        Kosongkan kolom kata sandi bila tidak ingin mengubahnya.
                    </p>

                    <x-admin.form-field name="current_password" type="password" label="Kata sandi saat ini"
                                        help="Wajib diisi hanya bila mengganti kata sandi." />

                    <x-admin.form-field name="password" type="password" label="Kata sandi baru"
                                        help="Minimal 8 karakter." />

                    <x-admin.form-field name="password_confirmation" type="password" label="Ulangi kata sandi baru" />

                    <div class="d-flex flex-wrap gap-2">
                        <button type="submit" class="btn btn-tk-primary">
                            <i class="bi bi-save me-1" aria-hidden="true"></i>Simpan perubahan
                        </button>
                        <a class="btn btn-tk-outline" href="{{ route('admin.dasbor') }}">Batal</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Informasi</h2>
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">Role: <span class="tk-badge">{{ $user->role }}</span></li>
                    <li class="mb-0 text-muted-soft">
                        Tidak ada pendaftaran publik. Akun admin baru dibuat lewat
                        <code>php artisan app:create-admin</code>.
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

