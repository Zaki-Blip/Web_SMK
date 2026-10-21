<div class="mb-3">
    <label class="form-label" for="nama">Nama</label>
    <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $guru->nama ?? '') }}" required>
    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>
<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="jabatan">Jabatan</label>
        <input type="text" name="jabatan" id="jabatan" class="form-control" value="{{ old('jabatan', $guru->jabatan ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label" for="tipe">Tipe</label>
        <select name="tipe" id="tipe" class="form-select" required>
            <option value="guru" @selected(old('tipe', $guru->tipe ?? 'guru')==='guru')>Guru</option>
            <option value="staf" @selected(old('tipe', $guru->tipe ?? 'guru')==='staf')>Staf</option>
        </select>
    </div>
</div>
<div class="mb-3 mt-3">
    <label class="form-label" for="mata_pelajaran">Mata pelajaran</label>
    <input type="text" name="mata_pelajaran" id="mata_pelajaran" class="form-control" value="{{ old('mata_pelajaran', $guru->mata_pelajaran ?? '') }}">
</div>
<div class="mb-3">
    <label class="form-label" for="jurusan_id">Jurusan terkait</label>
    <select name="jurusan_id" id="jurusan_id" class="form-select">
        <option value="">-</option>
        @foreach (\App\Models\Jurusan::query()->ordered()->get() as $j)
            <option value="{{ $j->id }}" @selected(old('jurusan_id', $guru->jurusan_id ?? '')==$j->id)>{{ $j->nama }}</option>
        @endforeach
    </select>
</div>
<div class="row g-3">
    <div class="col-md-4">
        <label class="form-label" for="urutan">Urutan</label>
        <input type="number" name="urutan" id="urutan" class="form-control" min="0" max="9999" value="{{ old('urutan', $guru->urutan ?? 0) }}" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $guru->is_active ?? true) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_active">Aktif</label>
        </div>
    </div>
</div>
<div class="mb-3 mt-3">
    <x-admin.image-uploader name="foto" label="Foto" :current-url="$guru->imageUrl() ?? null" help="JPG, PNG, atau WebP maksimal 2 MB." />
</div>