@php
    $mulaiValue = old('mulai', $item->mulai?->format('Y-m-d\TH:i') ?: now()->addWeek()->format('Y-m-d\TH:i'));
    $selesaiValue = old('selesai', $item->selesai?->format('Y-m-d\TH:i') ?: '');
@endphp

<x-admin.form-field name="judul" label="Judul agenda" :value="$item->judul" required maxlength="200" />
<x-admin.form-field name="slug" label="Slug" :value="$item->slug" maxlength="200" help="Kosongkan untuk dibuat otomatis dari judul." />
<x-admin.form-field name="deskripsi" type="textarea" label="Deskripsi" :value="$item->deskripsi" :rows="5" maxlength="10000" />
<div class="row g-3">
    <div class="col-md-6">
        <x-admin.form-field name="mulai" type="datetime-local" label="Mulai" :value="$mulaiValue" required />
    </div>
    <div class="col-md-6">
        <x-admin.form-field name="selesai" type="datetime-local" label="Selesai" :value="$selesaiValue" help="Boleh dikosongkan bila kegiatan selesai pada hari yang sama." />
    </div>
</div>
<x-admin.form-field name="lokasi" label="Lokasi" :value="$item->lokasi" maxlength="200" />
<div class="d-flex align-items-center">
    <x-admin.form-field name="is_published" type="switch" label="Status" :value="$item->is_published" placeholder="Terbit" />
</div>
