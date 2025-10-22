@extends('admin.layouts.app')

@section('title', 'Tambah Prestasi - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Tambah Prestasi</h4>
        </div>

        <div class="card-body p-4">
            <div class="alert alert-info mb-4">
                <strong>Mode Input:</strong>
                <label class="ms-2 me-3"><input type="radio" name="mode" value="single" checked> Satu Data</label>
                <label><input type="radio" name="mode" value="bulk"> Banyak (sekali submit)</label>
            </div>

            <form action="{{ route('admin.mahasiswa_berprestasi.store') }}" method="POST" enctype="multipart/form-data" id="form-single">
                @csrf

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Mahasiswa </label>
                        <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">NIM </label>
                        <input type="text" name="nim" value="{{ old('nim') }}" class="form-control" required>
                    </div>

                    {{-- Mode Satu Data: tidak ada Select2 multi, cukup isian satu mahasiswa --}}

                    <div class="col-md-4">
                        <label class="form-label">Jurusan </label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', 'Teknologi Informasi') }}" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Angkatan </label>
                        <input type="number" name="angkatan" value="{{ old('angkatan') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Kompetisi </label>
                        <input type="text" name="kompetisi" value="{{ old('kompetisi') }}" class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Jenis Kompetisi </label>
                        <input type="text" name="jenis" value="{{ old('jenis') }}" class="form-control" placeholder="Misal: Kompetisi Programming" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tingkat </label>
                        <select name="tingkat" class="form-select" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="Internasional" {{ old('tingkat')=='Internasional'?'selected':'' }}>Internasional</option>
                            <option value="Nasional" {{ old('tingkat')=='Nasional'?'selected':'' }}>Nasional</option>
                            <option value="Provinsi" {{ old('tingkat')=='Provinsi'?'selected':'' }}>Provinsi</option>
                            <option value="Kampus" {{ old('tingkat')=='Kampus'?'selected':'' }}>Kampus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Peringkat </label>
                        <input type="text" name="peringkat" value="{{ old('peringkat') }}" class="form-control" placeholder="Juara 1, 2, 3..." required>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" value="{{ old('poin') }}" class="form-control" placeholder="misal: 100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun </label>
                        <input type="number" name="tahun" value="{{ old('tahun') }}" class="form-control" placeholder="2025" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Penyelenggara </label>
                        <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}" class="form-control" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Upload Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Upload Foto Prestasi</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Status Publikasi </label>
                        <select name="status" class="form-select" required>
                            <option value="published" {{ old('status')=='published'?'selected':'' }}>Published</option>
                            <option value="draft" {{ old('status')=='draft'?'selected':'' }}>Draft</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label">Keterangan / Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.mahasiswa_berprestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Prestasi</button>
                </div>
            </form>

            {{-- ============ FORM TIM (Select2 banyak mahasiswa) ============ --}}
            <form action="{{ route('admin.mahasiswa_berprestasi.store') }}" method="POST" enctype="multipart/form-data" id="form-bulk" style="display:none">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Pilih Mahasiswa (bisa banyak)</label>
                        <select id="mahasiswa_ids" name="mahasiswa_ids[]" class="form-select" multiple>
                            @isset($mahasiswas)
                                @foreach($mahasiswas as $m)
                                    <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->nim }})</option>
                                @endforeach
                            @endisset
                        </select>
                        <small class="text-muted">Prestasi akan dibuat untuk setiap mahasiswa yang dipilih.</small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Jurusan </label>
                        <input type="text" name="jurusan" value="{{ old('jurusan', 'Teknologi Informasi') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Kompetisi </label>
                        <input type="text" name="kompetisi" value="{{ old('kompetisi') }}" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kompetisi </label>
                        <input type="text" name="jenis" value="{{ old('jenis') }}" class="form-control" placeholder="Misal: Kompetisi Programming">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tingkat </label>
                        <select name="tingkat" class="form-select" required>
                            <option value="">-- Pilih Tingkat --</option>
                            <option value="Internasional">Internasional</option>
                            <option value="Nasional">Nasional</option>
                            <option value="Provinsi">Provinsi</option>
                            <option value="Kampus">Kampus</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Peringkat </label>
                        <input type="text" name="peringkat" value="{{ old('peringkat') }}" class="form-control" placeholder="Juara 1, 2, 3...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Poin</label>
                        <input type="number" name="poin" value="{{ old('poin') }}" class="form-control" placeholder="misal: 100">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tahun </label>
                        <input type="number" name="tahun" value="{{ old('tahun') }}" class="form-control" placeholder="2025">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Penyelenggara </label>
                        <input type="text" name="penyelenggara" value="{{ old('penyelenggara') }}" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Upload Sertifikat (PDF/JPG/PNG)</label>
                        <input type="file" name="sertifikat" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Upload Foto Prestasi</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Status Publikasi </label>
                        <select name="status" class="form-select" required>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label">Keterangan / Deskripsi</label>
                        <textarea name="deskripsi" rows="4" class="form-control">{{ old('deskripsi') }}</textarea>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.mahasiswa_berprestasi.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Prestasi Tim</button>
                </div>
            </form>

            <script>
                (function(){
                    const modeRadios = document.querySelectorAll('input[name="mode"]');
                    const fSingle = document.getElementById('form-single');
                    const fBulk = document.getElementById('form-bulk');
                    function updateMode(){
                        const v = document.querySelector('input[name="mode"]:checked').value;
                        fSingle.style.display = v==='single' ? '' : 'none';
                        fBulk.style.display = v==='bulk' ? '' : 'none';
                    }
                    modeRadios.forEach(r=>r.addEventListener('change', updateMode));
                    updateMode();
                })();
            </script>
        </div>
    </div>
</div>
{{-- Select2 for multi mahasiswa --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(function(){
        $('#mahasiswa_ids').select2({
            width: '100%',
            placeholder: 'Pilih satu atau lebih mahasiswa',
            allowClear: true
        });
    })
</script>
@endsection
