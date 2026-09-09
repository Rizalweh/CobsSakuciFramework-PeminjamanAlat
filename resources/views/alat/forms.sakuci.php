<div class="mb-3">
    <label for="kode_alat" class="form-label">Kode Alat</label>
    <input type="text" class="form-control" id="kode_alat" name="kode_alat" value="{{ old('kode_alat', $alat->kode_alat ?? '') }}">
    @error('kode_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3"></div>
    <label for="nama_alat" class="form-label">Nama Alat</label>
    <input type="text" class="form-control" id="nama_alat" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat ?? '') }}">
    @error('nama_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="stok" class="form-label">Stok</label>
    <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $alat->stok ?? '') }}">
    @error('stok')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="kondisi" class="form-label">Kondisi</label>
    <input type="text" class="form-control" id="kondisi" name="kondisi" value="{{ old('kondisi', $alat->kondisi ?? '') }}">
    @error('kondisi')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label for="foto_alat" class="form-label">Foto Alat</label>
    <input type="file" class="form-control" id="foto_alat" name="foto_alat" value="{{ old('foto_alat', $alat->foto_alat ?? '') }}">
    @error('foto_alat')
    <div class="text-danger">{{ $message }}</div>
    @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan</button>
<a href="{{ route('alat.index') }}" class="btn btn-secondary">Kembali</a>