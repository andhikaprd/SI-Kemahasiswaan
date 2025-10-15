@extends('admin.layouts.app')

@section('title', 'Tambah Berita Baru - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Tambah Berita</h4>
        </div>
        <div class="card-body p-4">
            
            {{-- Pesan Error Validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form simpan berita --}}
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita </label>
                    <input type="text" class="form-control" id="judul" name="judul"
                        value="{{ old('judul') }}" required>
                </div>

                {{-- Ringkasan --}}
                <div class="mb-3">
                    <label for="ringkasan" class="form-label">Ringkasan </label>
                    <textarea class="form-control" id="ringkasan" name="ringkasan" rows="2" required>{{ old('ringkasan') }}</textarea>
                </div>

                {{-- Isi --}}
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita </label>
                    <textarea class="form-control" id="isi" name="isi" rows="10" required>{{ old('isi') }}</textarea>
                </div>
                
                {{-- Baris 2 Kolom --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori </label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Prestasi" {{ old('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Event" {{ old('kategori') == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Pengumuman" {{ old('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status </label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                {{-- Penulis --}}
                <div class="mb-3">
                    <label for="penulis" class="form-label">Penulis</label>
                    <input type="text" class="form-control" id="penulis" name="penulis"
                        value="{{ old('penulis') ?? Auth::user()->name ?? '' }}">
                </div>

                {{-- Upload Gambar --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted">Kosongkan jika tidak ingin mengupload gambar.</small>
                    
                    {{-- Preview gambar --}}
                    <div class="mt-3" id="preview-container" style="display: none;">
                        <p class="mb-1 fw-semibold">Preview:</p>
                        <img id="preview-image" class="img-thumbnail" style="max-height: 250px;">
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Berita</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- Script preview gambar --}}
<script>
function previewImage(event) {
    const input = event.target;
    const reader = new FileReader();

    reader.onload = function() {
        const img = document.getElementById('preview-image');
        const container = document.getElementById('preview-container');
        img.src = reader.result;
        container.style.display = 'block';
    };

    if (input.files && input.files[0]) {
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection