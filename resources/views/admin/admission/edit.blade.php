@extends('layouts.admin')

@section('title', 'PPDB')
@section('heading', 'Informasi PPDB')

@section('content')
    <div class="tk-admin-page-head">
        <div>
            <h1 class="h5 mb-1">Informasi PPDB</h1>
            <p class="text-muted-soft mb-0">
                Halaman PPDB publik menampilkan pesan netral selama data ini masih kosong atau dinonaktifkan.
            </p>
        </div>

        <a class="btn btn-tk-outline" href="{{ route('admission.index') }}" target="_blank" rel="noopener">
            <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>Lihat halaman publik
        </a>
    </div>

    <form method="post" action="{{ route('admin.admission.update') }}">
        @csrf
        @method('PUT')

        <div class="row g-3">
            <div class="col-lg-7">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Informasi umum</h2>

                    <x-admin.form-field name="title" label="Judul halaman" :value="$admission->title"
                                        placeholder="Penerimaan Peserta Didik Baru" maxlength="150" />

                    <x-admin.form-field name="description" type="textarea" label="Deskripsi" :value="$admission->description" :rows="5" />

                    <x-admin.form-field name="schedule" type="textarea" label="Jadwal" :value="$admission->schedule" :rows="5"
                                        help="Tulis satu periode per baris, mis. Gelombang 1: Januari - Februari." />
                </div>

                <div class="tk-card p-3">
                    <h2 class="h5 mb-3">Persyaratan &amp; alur</h2>

                    <x-admin.form-field name="requirements" type="textarea" label="Persyaratan" :value="$admission->requirements"
                                        :rows="6" help="Tulis satu persyaratan per baris." />

                    <x-admin.form-field name="registration_steps" type="textarea" label="Alur pendaftaran"
                                        :value="$admission->registration_steps" :rows="6"
                                        help="Tulis satu langkah per baris." />
                </div>
            </div>

            <div class="col-lg-5">
                <div class="tk-card p-3 mb-3">
                    <h2 class="h5 mb-3">Biaya (opsional)</h2>
                    <x-admin.form-field name="fee_information" type="textarea" label="Informasi biaya"
                                        :value="$admission->fee_information" :rows="5"
                                        help="Boleh dikosongkan. Isi hanya nominal yang sudah resmi." />
                </div>

                <div class="tk-card p-3">
                    <h2 class="h5 mb-3">Kontak &amp; status</h2>

                    <x-admin.form-field name="whatsapp_number" label="Nomor WhatsApp PPDB" :value="$admission->whatsapp_number"
                                        placeholder="0812xxxxxxx atau 62812xxxxxxx"
                                        help="Nomor disimpan dalam format internasional (62812…). Boleh dikosongkan." />

                    <x-admin.form-field name="is_active" type="switch" label="Status PPDB" :value="$admission->is_active"
                                        placeholder="Tampilkan informasi PPDB" />

                    <div class="d-flex flex-wrap gap-2 mt-3">
                        <button type="submit" class="btn btn-tk-primary">
                            <i class="bi bi-save me-1" aria-hidden="true"></i>Simpan informasi
                        </button>
                        <a class="btn btn-tk-outline" href="{{ route('admin.dashboard') }}">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

