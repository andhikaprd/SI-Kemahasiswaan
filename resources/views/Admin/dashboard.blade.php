@extends('admin.layouts.app')

@section('title', 'Dashboard - Panel Admin')

@section('content')
    
    <!-- Kartu Statistik -->
    <div class="row g-4 mb-5">
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-trophy fa-lg"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-0">2</h2>
                        <p class="text-muted mb-0">Total Prestasi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                             <i class="fas fa-users fa-lg"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-0">3</h2>
                        <p class="text-muted mb-0">Total Pengguna</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-newspaper fa-lg"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-0">4</h2>
                        <p class="text-muted mb-0">Total Berita</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-file-alt fa-lg"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <h2 class="fw-bold mb-0">3</h2>
                        <p class="text-muted mb-0">Total Laporan</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik dan Aktivitas Terbaru -->
    <div class="row g-4">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Fitur aktivitas terbaru akan segera tersedia.</p>
                </div>
            </div>
        </div>
    </div>

@endsection

