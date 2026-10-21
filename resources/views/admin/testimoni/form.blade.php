<div class="mb-3">
    <label class="form-label" for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $item->nama ?? '') }}" required>
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="angkatan">Angkatan</label>
        <input type="text" name="angkatan" id="angkatan" class="form-control" value="{{ old('angkatan', $item->angkatan ?? '') }}">
    </div>
    <div class="col-md-4">
        <label class="form-label" for="jurusan_id">Jurusan</label>
        <select name="jurusan_id" id="jurusan_id" class="form-select">
            <option value="">-</option>
            @foreach (\App\Models\Jurusan::query()->ordered()->get() as $j)
                <option value="{{ $j->id }}" @selected(old('jurusan_id', $item->jurusan_id ?? '')==$j->id)>{{ $j->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4">
        <label class="form-label" for="pekerjaan_saat_ini">Pekerjaan saat ini</label>
        <input type="text" name="pekerjaan_saat_ini" id="pekerjaan_saat_ini" class="form-control" value="{{ old('pekerjaan_saat_ini', $item->pekerjaan_saat_ini ?? '') }}">
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label" for="isi">Isi testimoni</label>
    <textarea name="isi" id="isi" rows="4" class="form-control @error('isi') is-invalid @enderror" required>{{ old('isi', $item->isi ?? '') }}</textarea>
    @error('isi') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="mb-3">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $item->is_active ?? true) ? 'checked' : '' }}>
        <label class="form-check-label" for="is_active">Aktif</label>
    </div>
</div>
<div class="mb-3">
    <x-admin.image-uploader name="foto" label="Foto" :current-url="$item->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>