{{-- File ini sekarang ada di: resources/views/user/beranda.blade.php --}}

@extends('user.layouts.app') {{-- <-- PERUBAHAN PENTING ADA DI SINI --}}

@section('title', 'Beranda - HIMA TI Politala')

@section('content')

    <!-- Hero -->
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-4 fw-bold">HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI POLITALA</h1>
            <p class="lead mt-3">
                Platform digital untuk seluruh mahasiswa Teknologi Informasi. <br>
                Kelola informasi akademik, organisasi, dan prestasi dalam satu tempat.
            </p>
        </div>
    </section>

    <!-- Statistik -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold">300+</h3>
                    <p class="text-muted">Total Mahasiswa</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-sitemap fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold">4</h3>
                    <p class="text-muted">Divisi Aktif</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-clipboard-check fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold">4</h3>
                    <p class="text-muted">Program Kerja</p>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <i class="fas fa-trophy fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold">38</h3>
                    <p class="text-muted">Prestasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Divisi -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">4 Divisi Utama</h2>
            <p class="lead text-muted mb-5">Divisi yang menjalankan berbagai program kerja untuk mahasiswa TI</p>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Kaderisasi</h5>
                        <p class="text-muted">Mengembangkan kualitas SDM dan karakter mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-info-circle fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Media Informasi</h5>
                        <p class="text-muted">Mengelola informasi dan komunikasi HIMA - TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Technopreneurship</h5>
                        <p class="text-muted">Mengembangkan jiwa wirausaha berbasis teknologi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-headset fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Public Relations</h5>
                        <p class="text-muted">Membangun hubungan dengan pihak eksternal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Utama -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-3">Fitur Utama</h2>
            <p class="lead text-muted mb-5">Berbagai layanan dan informasi yang dapat Anda akses</p>
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Pendaftaran Online</h5>
                        <p class="text-muted">Daftar menjadi anggota HIMA - TI dengan mudah melalui formulir online</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-users-cog fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Informasi Divisi</h5>
                        <p class="text-muted">Pelajari lebih lanjut tentang setiap divisi dan program kerjanya</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-newspaper fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Berita Terkini</h5>
                        <p class="text-muted">Ikuti berita terbaru, pengumuman dan prestasi mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4">
                        <i class="fas fa-medal fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Prestasi Mahasiswa</h5>
                        <p class="text-muted">Lihat berbagai prestasi yang pernah diraih mahasiswa TI</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
