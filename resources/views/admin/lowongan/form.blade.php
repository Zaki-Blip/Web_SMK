<div class="mb-3">
    <label class="form-label" for="judul">Judul</label>
    <input type="text" name="judul" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $item->judul ?? '') }}" required>
    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="perusahaan">Perusahaan</label>
        <input type="text" name="perusahaan" id="perusahaan" class="form-control" value="{{ old('perusahaan', $item->perusahaan ?? '') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label" for="lokasi">Lokasi</label>
        <input type="text" name="lokasi" id="lokasi" class="form-control" value="{{ old('lokasi', $item->lokasi ?? '') }}">
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label" for="tipe">Tipe</label>
    <select name="tipe" id="tipe" class="form-select" required>
        @foreach (['penuh_waktu','kontrak','magang'] as $t)
            <option value="{{ $t }}" @selected(old('tipe', $item->tipe ?? 'penuh_waktu')===$t)>{{ str_replace('_',' ',ucfirst($t)) }}</option>
        @endforeach
    </select>
</div>
<div class="mb-3">
    <label class="form-label" for="deskripsi">Deskripsi</label>
    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label" for="persyaratan">Persyaratan</label>
    <textarea name="persyaratan" id="persyaratan" rows="3" class="form-control">{{ old('persyaratan', $item->persyaratan ?? '') }}</textarea>
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="tautan_daftar">Tautan daftar</label>
        <input type="url" name="tautan_daftar" id="tautan_daftar" class="form-control" value="{{ old('tautan_daftar', $item->tautan_daftar ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="batas_waktu">Batas waktu</label>
        <input type="date" name="batas_waktu" id="batas_waktu" class="form-control" value="{{ old('batas_waktu', optional($item->batas_waktu)->format('Y-m-d')) }}">
    </div>
</div>
<div class="mb-3 mt-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $item->is_published ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_published">Terbit</label>
    </div>
</div>