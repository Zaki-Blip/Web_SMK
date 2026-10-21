@php
    $parentOptions = ['' => '- Tidak ada atasan langsung -'];
    foreach ($parents as $parent) {
        $parentOptions[$parent->id] = $parent->jabatan.' - '.$parent->nama;
    }
@endphp

<x-admin.form-field name="nama" label="Nama" :value="$item->nama" required maxlength="150" />
<x-admin.form-field name="jabatan" label="Jabatan" :value="$item->jabatan" required maxlength="150" />
<x-admin.form-field name="parent_id" type="select" label="Atasan langsung" :value="$item->parent_id" :options="$parentOptions" help="Kosongkan untuk jabatan puncak." />
<div class="row g-3">
    <div class="col-md-4">
        <x-admin.form-field name="urutan" type="number" label="Urutan" :value="$item->urutan" min="0" max="9999" required />
    </div>
    <div class="col-md-8 d-flex align-items-center">
        <x-admin.form-field name="is_active" type="switch" label="Status" :value="$item->is_active" placeholder="Aktif" />
    </div>
</div>
