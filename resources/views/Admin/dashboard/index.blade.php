@extends('admin.layouts.app')

@section('title', 'Dashboard - Panel Admin')

@section('content')
<div class="container">
    <div class="mb-4">
        <h3 class="fw-bold">Selamat Datang di Dashboard Admin 👋</h3>
        <p class="text-muted">Pantau data berita, prestasi, akun, dan laporan secara real-time.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-primary">
                <div class="card-body">
                    <i class="fas fa-newspaper fa-2x mb-2"></i>
                    <h5>{{ $totalBerita }}</h5>
                    <p class="text-muted mb-0">Berita</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-success">
                <div class="card-body">
                    <i class="fas fa-users fa-2x mb-2"></i>
                    <h5>{{ $totalPengguna }}</h5>
                    <p class="text-muted mb-0">Pengguna</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-warning">
                <div class="card-body">
                    <i class="fas fa-trophy fa-2x mb-2"></i>
                    <h5>{{ $totalPrestasi }}</h5>
                    <p class="text-muted mb-0"> Prestasi</p>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm border-0 text-center text-info">
                <div class="card-body">
                    <i class="fas fa-file-alt fa-2x mb-2"></i>
                    <h5>{{ $totalLaporan }}</h5>
                    <p class="text-muted mb-0">Laporan</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
