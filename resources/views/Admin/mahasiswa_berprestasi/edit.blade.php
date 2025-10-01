@extends('admin.layouts.app')

@section('title', 'Edit Prestasi - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Edit Prestasi</h4>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.mahasiswa_berprestasi.update', $prestasi->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa *</label>
                        <input type="text" class="form-control" id="nama_mahasiswa" name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $prestasi->nama_mahasiswa) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nim" class="form-label">NIM *</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $prestasi->nim) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jurusan" class="form-label">Jurusan *</label>
                        <select class="form-select" id="jurusan" name="jurusan" required>
                            <option value="Teknologi Informasi" {{ old('jurusan', $prestasi->jurusan) == 'Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                            {{-- Tambahkan jurusan lain jika ada --}}
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="angkatan" class="form-label">Angkatan *</label>
                        <input type="number" class="form-control" id="angkatan" name="angkatan" value="{{ old('angkatan', $prestasi->angkatan) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis_prestasi" class="form-label">Jenis Prestasi *</label>
                        <input type="text" class="form-control" id="jenis_prestasi" name="jenis_prestasi" value="{{ old('jenis_prestasi', $prestasi->jenis_prestasi) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tingkat" class="form-label">Tingkat *</label>
                        <select class="form-select" id="tingkat" name="tingkat" required>
                            <option value="internasional" {{ old('tingkat', $prestasi->tingkat) == 'internasional' ? 'selected' : '' }}>Internasional</option>
                            <option value="nasional" {{ old('tingkat', $prestasi->tingkat) == 'nasional' ? 'selected' : '' }}>Nasional</option>
                            <option value="regional" {{ old('tingkat', $prestasi->tingkat) == 'regional' ? 'selected' : '' }}>Regional</option>
                            <option value="lokal" {{ old('tingkat', $prestasi->tingkat) == 'lokal' ? 'selected' : '' }}>Lokal</option>
                        </select>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="nama_kompetisi" class="form-label">Nama Kompetisi *</label>
                    <input type="text" class="form-control" id="nama_kompetisi" name="nama_kompetisi" value="{{ old('nama_kompetisi', $prestasi->nama_kompetisi) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="peringkat" class="form-label">Peringkat *</label>
                        <input type="text" class="form-control" id="peringkat" name="peringkat" value="{{ old('peringkat', $prestasi->peringkat) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tahun" class="form-label">Tahun *</label>
                        <input type="number" class="form-control" id="tahun" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="penyelenggara" class="form-label">Penyelenggara *</label>
                    <input type="text" class="form-control" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}" required>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="tanggal_perolehan" class="form-label">Tanggal Perolehan *</label>
                        <input type="date" class="form-control" id="tanggal_perolehan" name="tanggal_perolehan" value="{{ old('tanggal_perolehan', $prestasi->tanggal_perolehan) }}" required>
                    </div>
                     <div class="col-md-4 mb-3">
                        <label for="poin_prestasi" class="form-label">Poin Prestasi *</label>
                        <input type="number" class="form-control" id="poin_prestasi" name="poin_prestasi" value="{{ old('poin_prestasi', $prestasi->poin_prestasi) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="status_sertifikat" class="form-label">Status Sertifikat *</label>
                        <input type="text" class="form-control" id="status_sertifikat" name="status_sertifikat" value="{{ old('status_sertifikat', $prestasi->status_sertifikat) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.mahasiswa_berprestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Prestasi</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
