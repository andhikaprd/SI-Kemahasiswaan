@extends('admin.layouts.app')

@section('title', 'Edit Prestasi - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Edit Prestasi</h4>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('admin.mahasiswa_berprestasi.update', $prestasi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Mahasiswa </label>
                        <input type="text" name="nama" value="{{ old('nama', $prestasi->nama) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIM </label>
                        <input type="text" name="nim" value="{{ old('nim', $prestasi->nim) }}" class="form-control" required>
                    </div>

                    {{-- Tambahkan ke Mahasiswa Lain (opsional) --}}
                    <div class="col-12">
                        <label class="form-label">Tambahkan juga ke Mahasiswa (opsional, bisa banyak)</label>
                        <select id="mahasiswa_ids" name="mahasiswa_ids[]" class="form-select" multiple>
                            @isset($mahasiswas)
                                @foreach($mahasiswas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->nim }})</option>
                                @endforeach
                            @endisset
                        </select>
                        <small class="text-muted">Jika dipilih, sistem akan membuat salinan prestasi ini untuk setiap mahasiswa terpilih.</small>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Jurusan </label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', $prestasi->jurusan) }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Angkatan </label>
                        <input type="number" name="angkatan" value="{{ old('angkatan', $prestasi->angkatan) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Kompetisi *</label>
                        <input type="text" name="kompetisi" value="{{ old('kompetisi', $prestasi->kompetisi) }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kompetisi *</label>
                        <input type="text" name="jenis" value="{{ old('jenis', $prestasi->jenis) }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tingkat </label>
                        <select name="tingkat" class="form-select" required>
                            @foreach(['Internasional','Nasional','Provinsi','Kampus'] as $t)
                                <option value="{{ $t }}" @selected(old('tingkat', $prestasi->tingkat) == $t)>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Peringkat </label>
                        <input type="text" name="peringkat" value="{{ old('peringkat', $prestasi->peringkat) }}" class="form-control" required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" value="{{ old('poin', $prestasi->poin) }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun</label>
                        <input type="number" name="tahun" value="{{ old('tahun', $prestasi->tahun) }}" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', optional($prestasi->tanggal)->format('Y-m-d')) }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Penyelenggara </label>
                        <input type="text" name="penyelenggara" value="{{ old('penyelenggara', $prestasi->penyelenggara) }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Upload Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="sertifikat" class="form-control">
                        @if($prestasi->sertifikat_url)
                            <div class="form-text">
                                <a href="{{ $prestasi->sertifikat_url }}" target="_blank">Lihat Sertifikat Lama</a>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Upload Foto Prestasi</label>
                        <input type="file" name="foto" class="form-control">
                        @if($prestasi->foto_url)
                            <div class="form-text">
                                <a href="{{ $prestasi->foto_url }}" target="_blank">Lihat Foto Lama</a>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status Publikasi </label>
                        <select name="status" class="form-select" required>
                            <option value="published" @selected(old('status', $prestasi->status)=='published')>Published</option>
                            <option value="draft" @selected(old('status', $prestasi->status)=='draft')>Draft</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan / Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi', $prestasi->deskripsi) }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.mahasiswa_berprestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Prestasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function(){
        $('#mahasiswa_ids').select2({
            width: '100%', placeholder: 'Pilih mahasiswa lain', allowClear: true
        });
    });
    </script>
@endsection
