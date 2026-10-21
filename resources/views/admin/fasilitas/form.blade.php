@php
    $isEdit = $facility->exists;
    $action = $isEdit ? route('admin.fasilitas.update', $facility) : route('admin.fasilitas.store');
@endphp

<form method="post" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if ($isEdit)
        @method('PUT')
    @endif

    <div class="row g-3">
        <div class="col-lg-7">
            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Informasi fasilitas</h2>

                <x-admin.form-field name="name" label="Nama fasilitas" :value="$facility->name" required maxlength="150" />

                <x-admin.form-field name="slug" label="Slug" :value="$facility->slug"
                                    help="Kosongkan untuk dibuat otomatis dari nama." maxlength="150" />

                <x-admin.form-field name="description" type="textarea" label="Keterangan" :value="$facility->description"
                                    help="Deskripsikan fasilitas apa adanya. Hindari klaim yang belum diverifikasi." />
            </div>
        </div>

        <div class="col-lg-5">
            <div class="tk-card p-3 mb-3">
                <h2 class="h5 mb-3">Gambar</h2>

                <x-admin.image-uploader name="image" label="Gambar fasilitas" :current-url="$facility->imageUrl()"
                                        help="JPG, PNG, atau WebP maksimal 2 MB. Lebar diperkecil otomatis ke 800 px." />
            </div>

            <div class="tk-card p-3">
                <h2 class="h5 mb-3">Publikasi</h2>

                <x-admin.form-field name="sort_order" type="number" label="Urutan tampil" :value="$facility->sort_order"
                                    min="0" max="9999" help="Angka kecil tampil lebih dulu." required />

                <x-admin.form-field name="is_published" type="switch" label="Status" :value="$facility->is_published"
                                    placeholder="Tampilkan di website (terbit)" />

                <div class="d-flex flex-wrap gap-2 mt-3">
                    <button type="submit" class="btn btn-tk-primary">
                        <i class="bi bi-save me-1" aria-hidden="true"></i>{{ $isEdit ? 'Simpan perubahan' : 'Simpan fasilitas' }}
                    </button>
                    <a class="btn btn-tk-outline" href="{{ route('admin.fasilitas.index') }}">Batal</a>
                </div>
            </div>
        </div>
    </div>
</form>

