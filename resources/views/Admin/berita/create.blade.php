@extends('admin.layouts.app')

@section('title', 'Tambah Berita Baru - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Tambah Berita</h4>
        </div>
        <div class="card-body p-4">
            {{-- Form akan dikirim ke route store untuk disimpan --}}
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita *</label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita *</label>
                    <textarea class="form-control" id="isi" name="isi" rows="10" required>{{ old('isi') }}</textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori *</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Prestasi" {{ old('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Event" {{ old('kategori') == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama</label>
                    <input type="file" class="form-control" id="gambar" name="gambar">
                    <small class="text-muted">Kosongkan jika tidak ingin mengupload gambar.</small>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
