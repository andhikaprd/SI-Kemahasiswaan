@extends('admin.layouts.app')

@section('title', 'Dashboard - Panel Admin')

@section('content')
<style>
    .dash-card { transition: transform .18s ease, box-shadow .18s ease; border: none; }
    .dash-card:hover { transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
    .dash-icon { width: 42px; height: 42px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 12px; }
    .muted-sm { color: #6c757d; font-size: 0.92rem; }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
        <div>
            <h3 class="fw-bold mb-1">Selamat Datang di Dashboard Admin 👋</h3>
            <p class="text-muted mb-0">Ringkasan berita, pengguna, prestasi, laporan, sertifikat, pendaftaran.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-primary btn-sm">Kelola Berita</a>
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm">Kelola Laporan</a>
        </div>
    </div>

    <div class="row g-3 row-cols-1 row-cols-md-3 row-cols-lg-4">
        <div class="col">
            <div class="card dash-card h-100 text-center p-3">
                <div class="dash-icon bg-primary-subtle text-primary"><i class="fas fa-newspaper"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalBerita }}</h4>
                <div class="muted-sm">Berita</div>
            </div>
        </div>
        <div class="col">
            <div class="card dash-card h-100 text-center p-3">
                <div class="dash-icon bg-success-subtle text-success"><i class="fas fa-users"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalPengguna }}</h4>
                <div class="muted-sm">Pengguna</div>
            </div>
        </div>
        <div class="col">
            <div class="card dash-card h-100 text-center p-3">
                <div class="dash-icon bg-warning-subtle text-warning"><i class="fas fa-trophy"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalPrestasi }}</h4>
                <div class="muted-sm">Prestasi</div>
            </div>
        </div>
        <div class="col">
            <div class="card dash-card h-100 text-center p-3">
                <div class="dash-icon bg-info-subtle text-info"><i class="fas fa-file-alt"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalLaporan }}</h4>
                <div class="muted-sm">Laporan</div>
                <small class="text-secondary">{{ $laporanPending }} menunggu verifikasi</small>
            </div>
        </div>
        <div class="col">
            <div class="card dash-card h-100 text-center p-3" style="color:#6f42c1;">
                <div class="dash-icon bg-light text-purple"><i class="fas fa-certificate"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalSertifikat }}</h4>
                <div class="muted-sm">Sertifikat Prestasi</div>
                <small class="text-secondary">{{ $pendingSertifikat }} menunggu approval</small>
            </div>
        </div>
        <div class="col">
            <div class="card dash-card h-100 text-center p-3" style="color:#0c9c8d;">
                <div class="dash-icon bg-light text-teal"><i class="fas fa-clipboard-check"></i></div>
                <h4 class="fw-bold mb-1">{{ $totalPendaftaran }}</h4>
                <div class="muted-sm">Pendaftaran HIMA</div>
                <small class="text-secondary">{{ $pendingPendaftaran }} menunggu diproses</small>
            </div>
        </div>
    </div>
</div>
@endsection
