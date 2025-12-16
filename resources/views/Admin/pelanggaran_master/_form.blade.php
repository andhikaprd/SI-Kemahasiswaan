@php($mode = isset($item) ? 'edit' : 'create')
<div class="mb-3">
  <label class="form-label">Nama Pelanggaran</label>
  <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" class="form-control @error('nama') is-invalid @enderror" required>
  @error('nama')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Kategori</label>
    <select name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
      <option value="" disabled {{ old('kategori', $item->kategori ?? '') === '' ? 'selected' : '' }}>Pilih kategori</option>
      @foreach(['ringan' => 'Ringan','sedang' => 'Sedang','berat' => 'Berat'] as $val => $label)
        <option value="{{ $val }}" {{ old('kategori', $item->kategori ?? '') === $val ? 'selected' : '' }}>{{ $label }}</option>
      @endforeach
    </select>
    @error('kategori')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Sanksi Default (opsional)</label>
    <input type="text" name="sanksi_default" value="{{ old('sanksi_default', $item->sanksi_default ?? '') }}" class="form-control @error('sanksi_default') is-invalid @enderror">
    @error('sanksi_default')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>
<div class="mb-3">
  <label class="form-label">Deskripsi</label>
  <textarea name="deskripsi" rows="3" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
  @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>
<div class="d-flex justify-content-between">
  <a href="{{ route('admin.pelanggaran_master.index') }}" class="btn btn-light">Kembali</a>
  <button type="submit" class="btn btn-primary">{{ $mode === 'edit' ? 'Simpan Perubahan' : 'Simpan' }}</button>
</div>
