@php
    // Partial dipakai ulang oleh form tambah dan form ubah.
    $isEdit = $program->exists;
    $action = $isEdit ? route('admin.programs.update', $program) : route('admin.programs.store');
@endphp

<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="tk-card p-4">
                <h2 class="h5 mb-3">Informasi program</h2>

                <x-admin.form-field name="name" label="Nama program" :value="$program->name" required maxlength="150" />

                <x-admin.form-field name="slug" label="Slug" :value="$program->slug"
                                    help="Dipakai pada alamat halaman. Kosongkan untuk dibuat otomatis dari nama." maxlength="150" />

                <x-admin.form-field name="short_description" label="Ringkasan singkat" :value="$program->short_description"
                                    help="Tampil pada kartu program di halaman publik. Maksimal 255 karakter." maxlength="255" />

                <x-admin.form-field name="description" type="textarea" label="Deskripsi lengkap" :value="$program->description"
                                    help="Teks biasa. Baris baru akan ditampilkan apa adanya." />
            </div>
        </div>

        <div class="col-lg-5">
            <div class="tk-card p-4 mb-4">
                <h2 class="h5 mb-3">Gambar</h2>

                <x-admin.image-uploader name="image" label="Gambar program" :current-url="$program->imageUrl()"
                                        help="JPG, PNG, atau WebP maksimal 2 MB. Lebar diperkecil otomatis ke 800 px." />
            </div>

            <div class="tk-card p-4">
                <h2 class="h5 mb-3">Publikasi</h2>

                <x-admin.form-field name="sort_order" type="number" label="Urutan tampil" :value="$program->sort_order"
                                    min="0" max="9999" help="Angka kecil tampil lebih dulu." required />

                <x-admin.form-field name="is_published" type="switch" label="Status" :value="$program->is_published"
                                    placeholder="Tampilkan di website (terbit)" />

                <div class="d-flex flex-wrap gap-2 mt-3">
                    <button type="submit" class="btn btn-tk-primary">
                        <i class="bi bi-save me-1" aria-hidden="true"></i>{{ $isEdit ? 'Simpan perubahan' : 'Simpan program' }}
                    </button>
                    <a class="btn btn-tk-outline" href="{{ route('admin.programs.index') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>
