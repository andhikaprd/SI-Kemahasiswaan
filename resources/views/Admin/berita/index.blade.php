@extends('admin.layouts.app')

@section('title', 'Kelola Berita - Panel Admin')

@section('content')
<div class="container">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Berita</h3>
        <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Berita
        </a>
    </div>

    <!-- Alert Success -->
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter & Pencarian -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.berita.index') }}">
                <div class="row g-3">
                    <div class="col-md-5">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                            placeholder="Cari berita berdasarkan judul atau isi...">
                    </div>
                    <div class="col-md-3">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="Prestasi" {{ request('kategori') == 'Prestasi' ? 'selected' : '' }}>Prestasi</option>
                            <option value="Event" {{ request('kategori') == 'Event' ? 'selected' : '' }}>Event</option>
                            <option value="Pengumuman" {{ request('kategori') == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-outline-secondary w-100">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Berita -->
    @forelse ($beritas as $berita)
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <!-- Gambar -->
                    <div class="col-md-2 text-center mb-3 mb-md-0">
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="gambar"
                                class="img-fluid rounded shadow-sm" style="max-height:100px;object-fit:cover;">
                        @else
                            <div class="bg-light border rounded d-flex align-items-center justify-content-center"
                                 style="height:100px;">
                                <i class="fas fa-image text-muted fa-lg"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Info Berita -->
                    <div class="col-md-8">
                        <h5 class="fw-bold mb-1">{{ $berita->judul }}</h5>
                        <div class="d-flex small text-muted mb-2 flex-wrap">
                            <span class="me-3"><i class="fas fa-user me-1"></i> {{ $berita->penulis ?? 'Admin' }}</span>
                            <span class="me-3"><i class="fas fa-calendar-alt me-1"></i> 
                                {{ $berita->tanggal_publikasi ? $berita->tanggal_publikasi->format('d M Y') : '-' }}
                            </span>
                        </div>
                        <p class="text-muted mb-1">{{ Str::limit($berita->ringkasan, 120) }}</p>
                        <div>
                            <span class="badge bg-warning text-dark">{{ $berita->kategori ?? 'Umum' }}</span>
                            <span class="badge bg-{{ $berita->status == 'published' ? 'success' : 'secondary' }}">
                                {{ ucfirst($berita->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="col-md-2 d-flex align-items-center justify-content-end">
                        <a href="{{ route('admin.berita.edit', $berita->id) }}"
                           class="btn btn-sm btn-outline-primary me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('admin.berita.destroy', $berita->id) }}"
                              method="POST" onsubmit="return confirm('Hapus berita ini?');" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Berita</h5>
                <p>Silakan tambahkan berita baru untuk menampilkannya di sini.</p>
            </div>
        </div>
    @endforelse

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-4">
        {{ $beritas->links() }}
    </div>
</div>
@endsection
