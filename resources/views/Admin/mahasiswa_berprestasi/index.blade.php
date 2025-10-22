@extends('admin.layouts.app')

@section('title', 'Kelola Prestasi - Panel Admin')

@section('content')
<div class="container">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Prestasi Mahasiswa</h3>
        <a href="{{ route('admin.mahasiswa_berprestasi.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Prestasi
        </a>
    </div>

    <!-- Opsi Filter dan Pencarian -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.mahasiswa_berprestasi.index') }}">
                <div class="row g-3">
                    <!-- Kolom Pencarian -->
                    <div class="col-md-6">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}" 
                            class="form-control" 
                            placeholder="Cari prestasi berdasarkan nama, NIM, atau kompetisi...">
                    </div>

                    <!-- Filter Tingkat -->
                    <div class="col-md-3">
                        <select name="tingkat" class="form-select">
                            <option value="Semua">Semua Tingkat</option>
                            @foreach ($filterTingkat as $tingkat)
                                <option value="{{ $tingkat }}" {{ request('tingkat') == $tingkat ? 'selected' : '' }}>
                                    {{ ucfirst($tingkat) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="col-md-2">
                        <select name="tahun" class="form-select">
                            <option value="Semua">Semua Tahun</option>
                            @foreach ($filterTahun as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tombol Cari -->
                    <div class="col-md-1">
                        <button class="btn btn-outline-secondary w-100">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Prestasi (Dinamis) -->
    @forelse ($items as $item)
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <!-- Icon Trophy -->
                    <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-trophy text-warning fa-lg"></i>
                        </div>
                    </div>

                    <!-- Detail Prestasi -->
                    <div class="col-md-9">
                        <h5 class="fw-bold mb-1">{{ $item->nama }}</h5>
                        <small class="text-muted">{{ $item->nim }} - {{ $item->jurusan }}</small>
                        <div class="mt-2">
                            <p class="mb-1"><strong>Kompetisi:</strong> {{ $item->kompetisi }}</p>
                            <p class="mb-0">
                                <strong>Peringkat:</strong> {{ $item->peringkat ?? '-' }} 
                                ({{ $item->poin ?? 'N/A' }} Poin)
                            </p>
                            <span class="badge bg-primary">{{ ucfirst($item->tingkat) }}</span>
                            <span class="badge bg-secondary">{{ $item->tahun ?? '-' }}</span>
                        </div>
                    </div>

                    <!-- Aksi -->
                    <div class="col-md-2 d-flex align-items-center justify-content-end">
                        <a href="{{ route('admin.mahasiswa_berprestasi.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary me-2">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form 
                            action="{{ route('admin.mahasiswa_berprestasi.destroy', $item->id) }}" 
                            method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus prestasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-trophy fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Data Prestasi</h5>
                <p>Silakan tambahkan data prestasi baru untuk menampilkannya di sini.</p>
            </div>
        </div>
    @endforelse

    <!-- Pagination -->
    <div class="mt-4">
        {{ $items->links() }}
    </div>
</div>
@endsection
