@extends('admin.layouts.app')

@section('title', 'Kelola Prestasi - Panel Admin')

@section('content')
<div class="container">
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
            <div class="row g-3">
                <div class="col-md-8">
                    <input type="text" class="form-control" placeholder="Cari prestasi berdasarkan nama atau kompetisi...">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Semua Tingkat</option>
                        <option value="internasional">Internasional</option>
                        <option value="nasional">Nasional</option>
                        <option value="regional">Regional</option>
                        <option value="lokal">Lokal</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <button class="btn btn-outline-secondary w-100">Cari</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Prestasi (Dinamis) -->
    @forelse ($prestasi as $item)
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-1 d-none d-md-flex align-items-center justify-content-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-trophy text-warning fa-lg"></i>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <h5 class="fw-bold mb-1">{{ $item->nama_mahasiswa }}</h5>
                        <small class="text-muted">{{ $item->nim }} - {{ $item->jurusan }}</small>
                        <div class="mt-2">
                            <p class="mb-1"><strong>Kompetisi:</strong> {{ $item->nama_kompetisi }}</p>
                            <p class="mb-0"><strong>Peringkat:</strong> {{ $item->peringkat }} ({{ $item->poin ?? 'N/A' }} Poin)</p>
                            <span class="badge bg-primary">{{ Str::ucfirst($item->tingkat) }}</span>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-center justify-content-end">
                        <a href="{{ route('admin.mahasiswa_berprestasi.edit', $item->id) }}" class="btn btn-sm btn-outline-secondary me-2">Edit</a>
                        <form action="{{ route('admin.mahasiswa_berprestasi.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus prestasi ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
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
</div>
@endsection
