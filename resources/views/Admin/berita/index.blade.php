@extends('admin.layouts.app')

@section('title', 'Kelola Berita - Panel Admin')

@section('content')
    <div class="container">
        <!-- Header Halaman -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0">Kelola Berita</h3>
            {{-- Link ini sekarang mengarah ke route untuk membuat berita baru --}}
            <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Berita
            </a>
        </div>

        <!-- Opsi Filter dan Pencarian -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" class="form-control" placeholder="Cari berita...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Semua Kategori</option>
                            <option value="1">Prestasi</option>
                            <option value="2">Event</option>
                            <option value="3">Pengumuman</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select">
                            <option selected>Semua Status</option>
                            <option value="published">Published</option>
                            <option value="draft">Draft</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-outline-secondary w-100">Cari</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Daftar Berita Dinamis -->
        {{-- Loop ini akan menampilkan setiap berita dari database --}}
        @forelse ($beritas as $berita)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                <i class="fas fa-newspaper text-primary fa-lg"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <h5 class="fw-bold">{{ $berita->judul }}</h5>
                            <div class="d-flex small text-muted mb-2">
                                <span class="me-3"><i class="fas fa-user me-1"></i> {{ $berita->penulis ?? 'Admin' }}</span>
                                <span class="me-3"><i class="fas fa-calendar-alt me-1"></i> {{ $berita->created_at->format('d M Y') }}</span>
                                <span><i class="fas fa-eye me-1"></i> {{ $berita->views ?? 0 }} views</span>
                            </div>
                            <div>
                                <span class="badge bg-warning text-dark">{{ $berita->kategori ?? 'Umum' }}</span>
                                <span class="badge bg-success">{{ Str::ucfirst($berita->status ?? 'Published') }}</span>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-end">
                            {{-- Tombol Edit dan Hapus sekarang dinamis --}}
                            <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                            <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            {{-- Ini akan ditampilkan jika tidak ada berita sama sekali --}}
            <div class="card shadow-sm border-0">
                <div class="card-body text-center py-5">
                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Berita</h5>
                    <p>Silakan tambahkan berita baru untuk menampilkannya di sini.</p>
                </div>
            </div>
        @endforelse

        <!-- Link Paginasi -->
        <div class="d-flex justify-content-center mt-4">
            {{-- $beritas->links() --}}
        </div>
    </div>
@endsection

