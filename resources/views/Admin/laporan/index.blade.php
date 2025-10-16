@extends('admin.layouts.app')

@section('title', 'Data Laporan - Panel Admin')

@section('content')
<div class="container">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Laporan</h3>
        <a href="{{ route('admin.laporan.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Laporan
        </a>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-warning">
                <div class="card-body">
                    <i class="fas fa-trophy fa-2x mb-2"></i>
                    <h5 class="card-title">{{ $totalPrestasi ?? 0 }}</h5>
                    <p class="card-text">Total Prestasi</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-success">
                <div class="card-body">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5 class="card-title">{{ $totalPengguna ?? 0 }}</h5>
                    <p class="card-text">Total Pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-info">
                <div class="card-body">
                    <i class="fas fa-newspaper fa-2x mb-2"></i>
                    <h5 class="card-title">{{ $totalBerita ?? 0 }}</h5>
                    <p class="card-text">Total Berita</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-primary">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <h5 class="card-title">{{ $totalLaporan ?? $laporans->count() }}</h5>
                    <p class="card-text">Total Laporan</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Laporan -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Laporan</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success mb-3">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Judul Laporan</th>
                            <th>Periode</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr>
                                <td>
                                    <strong>{{ $laporan->judul }}</strong>
                                </td>
                                <td>{{ $laporan->periode ?? '-' }}</td>
                                <td><span class="badge bg-primary">{{ $laporan->kategori ?? '-' }}</span></td>
                                <td>{{ $laporan->created_at?->format('d M Y') ?? '-' }}</td>
                                <td><span class="badge bg-success">{{ ucfirst($laporan->status ?? 'Final') }}</span></td>
                                <td class="text-center">
                                    @if($laporan->file_path)
                                        <a href="{{ $laporan->file_url }}" target="_blank" class="btn btn-sm btn-outline-info me-1">
                                            <i class="fas fa-file-pdf"></i>
                                        </a>
                                    @endif
                                    <a href="{{ route('admin.laporan.edit', $laporan->id) }}" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                    <form action="{{ route('admin.laporan.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus laporan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">Belum ada data laporan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
