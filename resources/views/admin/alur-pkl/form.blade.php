<x-admin.form-field name="judul" label="Judul langkah" :value="$item->judul" required maxlength="200" />
<x-admin.form-field name="deskripsi" type="textarea" label="Deskripsi" :value="$item->deskripsi" :rows="4" maxlength="5000" />
<div class="row g-3">
    <div class="col-md-4">
        <x-admin.form-field name="urutan" type="number" label="Urutan" :value="$item->urutan" min="0" max="9999" required />
    </div>
    <div class="col-md-8 d-flex align-items-center">
        <x-admin.form-field name="is_active" type="switch" label="Status" :value="$item->is_active" placeholder="Aktif" />
    </div>
</div>
