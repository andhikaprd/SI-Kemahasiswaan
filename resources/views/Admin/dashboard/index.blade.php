@extends('admin.layouts.app')

@section('title', 'Dashboard - Panel Admin')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold">Selamat Datang di Dashboard Admin 👋</h3>
        <p class="text-muted mb-0">Pantau ringkasan berita, pengguna, prestasi, laporan, sertifikat, pendaftaran, dan pelanggaran.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-primary h-100">
                <div class="card-body">
                    <i class="fas fa-newspaper fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalBerita }}</h5>
                    <p class="text-muted mb-0">Berita</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-success h-100">
                <div class="card-body">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalPengguna }}</h5>
                    <p class="text-muted mb-0">Pengguna</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-warning h-100">
                <div class="card-body">
                    <i class="fas fa-trophy fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalPrestasi }}</h5>
                    <p class="text-muted mb-0">Prestasi</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-info h-100">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalLaporan }}</h5>
                    <p class="text-muted mb-1">Laporan</p>
                    <small class="text-secondary">{{ $laporanPending }} menunggu verifikasi</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center h-100" style="color:#6f42c1;">
                <div class="card-body">
                    <i class="fas fa-certificate fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalSertifikat }}</h5>
                    <p class="text-muted mb-1">Sertifikat Prestasi</p>
                    <small class="text-secondary">{{ $pendingSertifikat }} menunggu approval</small>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center h-100" style="color:#0c9c8d;">
                <div class="card-body">
                    <i class="fas fa-clipboard-check fa-2x mb-2"></i>
                    <h5 class="fw-bold">{{ $totalPendaftaran }}</h5>
                    <p class="text-muted mb-1">Pendaftaran HIMA</p>
                    <small class="text-secondary">{{ $pendingPendaftaran }} menunggu diproses</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
