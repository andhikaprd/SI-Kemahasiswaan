@extends('admin.layouts.app')

@section('title', 'Edit Berita - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Edit Berita</h4>
        </div>
        <div class="card-body p-4">

            {{-- Pesan Error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Update Berita --}}
            <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Judul --}}
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Berita </label>
                    <input type="text" class="form-control" id="judul" name="judul"
                           value="{{ old('judul', $berita->judul) }}" required>
                </div>

                {{-- Ringkasan --}}
                <div class="mb-3">
                    <label for="ringkasan" class="form-label">Ringkasan </label>
                    <textarea class="form-control" id="ringkasan" name="ringkasan" rows="2" required>{{ old('ringkasan', $berita->ringkasan) }}</textarea>
                </div>

                {{-- Isi --}}
                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Berita</label>
                    <textarea class="form-control" id="isi" name="isi" rows="10" required>{{ old('isi', $berita->isi) }}</textarea>
                </div>

                {{-- Kategori dan Status --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Kategori *</label>
                        <select class="form-select" id="kategori" name="kategori" required>
                            <option value="Prestasi" {{ old('kategori', $berita->kategori) == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Event" {{ old('kategori', $berita->kategori) == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Pengumuman" {{ old('kategori', $berita->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status *</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                </div>

                {{-- Gambar Lama & Upload Baru --}}
                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Utama</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                    <small class="text-muted d-block mb-2">Kosongkan jika tidak ingin mengganti gambar.</small>

                    {{-- Preview Gambar Lama --}}
                    @if($berita->gambar)
                        <div class="mt-3">
                            <p class="fw-semibold mb-1">Gambar Saat Ini:</p>
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Gambar Lama"
                                 class="img-thumbnail shadow-sm" style="max-height: 200px;">
                        </div>
                    @else
                        <p class="text-muted">Tidak ada gambar saat ini.</p>
                    @endif

                    {{-- Preview Gambar Baru --}}
                    <div class="mt-3" id="preview-container" style="display: none;">
                        <p class="fw-semibold mb-1">Preview Gambar Baru:</p>
                        <img id="preview-image" class="img-thumbnail shadow-sm" style="max-height: 200px;">
                    </div>
                </div>

                {{-- Penulis dan Tanggal --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="penulis" class="form-label">Penulis</label>
                        <input type="text" class="form-control" id="penulis" name="penulis"
                               value="{{ old('penulis', $berita->penulis ?? Auth::user()->name ?? 'Admin') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                        <input type="date" class="form-control" id="tanggal_publikasi" name="tanggal_publikasi"
                               value="{{ old('tanggal_publikasi', $berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('Y-m-d') : now()->format('Y-m-d')) }}">
                    </div>
                </div>

                {{-- Tags --}}
                <div class="mb-3">
                    <label for="tags" class="form-label">Tags (pisahkan dengan koma)</label>
                    <input type="text" class="form-control" id="tags" name="tags"
                           value="{{ old('tags', $berita->tags) }}">
                </div>

                {{-- Tombol --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Berita</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script preview gambar baru --}}
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
