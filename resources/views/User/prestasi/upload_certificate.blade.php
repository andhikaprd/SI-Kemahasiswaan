@extends('user.layouts.app')

@section('title', 'Upload Sertifikat Prestasi')

@section('content')
<style>
    .card-upload{max-width:720px;margin:0 auto;}
</style>
<section class="py-5">
    <div class="container">
        <div class="card shadow-sm border-0 card-upload">
            <div class="card-body">
                <h4 class="fw-bold mb-3">Upload Sertifikat</h4>
                <p class="text-muted mb-4">Prestasi: <strong>{{ $prestasi->kompetisi }}</strong> ({{ $prestasi->nama }})</p>
                <form action="{{ route('prestasi.certificate.store', $prestasi) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih berkas sertifikat (pdf/jpg/png)</label>
                        <input type="file" name="files[]" class="form-control" multiple required accept=".pdf,.jpg,.jpeg,.png">
                        <div class="form-text">Bisa lebih dari satu file, maksimum 10MB per file.</div>
                        @error('files')<div class="text-danger small">{{ $message }}</div>@enderror
                        @error('files.*')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('prestasi.show', $prestasi) }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
