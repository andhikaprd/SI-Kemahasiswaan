{{-- File: resources/views/beranda.blade.php --}}

@extends('user.layouts.app')

@section('title', 'Beranda - HIMA TI Politala')

@section('content')

    <!-- Hero -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="fw-bold">HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI POLITALA</h1>
            <p class="mt-3">
                Platform digital untuk seluruh mahasiswa Teknologi Informasi. <br>
                Kelola informasi akademik, organisasi, dan prestasi dalam satu tempat.
            </p>
        </div>
    </section>

    <!-- Statistik -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 mb-4">
                    <i class="fas fa-users fa-2x text-primary mb-2"></i>
                    <h3>300+</h3>
                    <p>Total Mahasiswa</p>
                </div>
                <div class="col-md-3 mb-4">
                    <i class="fas fa-sitemap fa-2x text-success mb-2"></i>
                    <h3>4</h3>
                    <p>Divisi Aktif</p>
                </div>
                <div class="col-md-3 mb-4">
                    <i class="fas fa-clipboard-check fa-2x text-warning mb-2"></i>
                    <h3>4</h3>
                    <p>Program Kerja</p>
                </div>
                <div class="col-md-3 mb-4">
                    <i class="fas fa-trophy fa-2x text-danger mb-2"></i>
                    <h3>38</h3>
                    <p>Prestasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Divisi -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">4 Divisi Utama</h2>
            <p class="mb-5">Divisi yang menjalankan berbagai program kerja untuk mahasiswa TI</p>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-graduation-cap fa-2x text-primary mb-3"></i>
                        <h5>Kaderisasi</h5>
                        <p class="text-muted">Mengembangkan kualitas SDM dan karakter mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-info-circle fa-2x text-success mb-3"></i>
                        <h5>Media Informasi</h5>
                        <p class="text-muted">Mengelola informasi dan komunikasi HIMA - TI</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-lightbulb fa-2x text-warning mb-3"></i>
                        <h5>Technopreneurship</h5>
                        <p class="text-muted">Mengembangkan jiwa wirausaha berbasis teknologi</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-headset fa-2x text-danger mb-3"></i>
                        <h5>Public Relations</h5>
                        <p class="text-muted">Membangun hubungan dengan pihak eksternal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Utama -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="mb-4">Fitur Utama</h2>
            <p class="mb-5">Berbagai layanan dan informasi yang dapat Anda akses</p>
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
                        <h5>Pendaftaran Online</h5>
                        <p class="text-muted">Daftar menjadi anggota HIMA - TI dengan mudah melalui formulir online</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-users-cog fa-2x text-success mb-3"></i>
                        <h5>Informasi Divisi</h5>
                        <p class="text-muted">Pelajari lebih lanjut tentang setiap divisi dan program kerjanya</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-newspaper fa-2x text-warning mb-3"></i>
                        <h5>Berita Terkini</h5>
                        <p class="text-muted">Ikuti berita terbaru, pengumuman dan prestasi mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card h-100 shadow-sm p-3">
                        <i class="fas fa-medal fa-2x text-danger mb-3"></i>
                        <h5>Prestasi Mahasiswa</h5>
                        <p class="text-muted">Lihat berbagai prestasi yang pernah diraih mahasiswa TI</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
