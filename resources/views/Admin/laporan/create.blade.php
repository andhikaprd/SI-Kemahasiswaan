@extends('admin.layouts.app')

@section('title', 'Tambah Laporan - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Tambah Laporan Baru</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.laporan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Laporan </label>
                    <input type="text" class="form-control" id="judul" name="judul" value="{{ old('judul') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="periode" class="form-label">Periode </label>
                        <input type="text" class="form-control" id="periode" name="periode" value="{{ old('periode') }}" placeholder="Contoh: Januari - Juli 2024" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori </label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Prestasi" {{ old('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Akademik" {{ old('kategori') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Kegiatan Kemahasiswaan" {{ old('kategori') == 'Kegiatan Kemahasiswaan' ? 'selected' : '' }}>Kegiatan Kemahasiswaan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status </label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                            <option value="Final" {{ old('status') == 'Final' ? 'selected' : '' }}>Final</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="file_laporan" class="form-label">File Laporan (PDF)</label>
                        <input type="file" class="form-control" id="file_laporan" name="file_laporan" accept=".pdf">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.laporan.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
