{{-- File: resources/views/beranda.blade.php --}}

@extends('layouts.app')

@section('title', 'Beranda - HIMA TI Politala')

@section('content')

    <section class="hero">
        <div class="container">
            <h1>HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI POLITALA</h1>
            <p>Platform digital untuk seluruh mahasiswa Teknologi Informasi. Kelola informasi akademik, organisasi, dan prestasi dalam satu tempat.</p>
        </div>
    </section>

    <section class="stats">
        <div class="container">
            <div class="stats-grid">
                {{-- Konten Statistik di sini --}}
                <div class="stat-item">
                    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
                    <h3>300 +</h3>
                    <p>Total Mahasiswa</p>
                </div>
                <div class="stat-item">
                    <div class="icon-wrapper"><i class="fas fa-sitemap"></i></div>
                    <h3>4</h3>
                    <p>Divisi Aktif</p>
                </div>
                <div class="stat-item">
                    <div class="icon-wrapper"><i class="fas fa-clipboard-check"></i></div>
                    <h3>4</h3>
                    <p>Program Kerja</p>
                </div>
                <div class="stat-item">
                    <div class="icon-wrapper"><i class="fas fa-trophy"></i></div>
                    <h3>38</h3>
                    <p>Prestasi</p>
                </div>
            </div>
        </div>
    </section>

    <section class="divisions">
        <div class="container">
            <h2 class="section-title">4 divisi utama yang menjalankan berbagai<br>program kerja untuk mahasiswa TI</h2>
            <div class="division-grid">
                 <div class="division-card">
                    <div class="icon-wrapper"><i class="fas fa-graduation-cap"></i></div>
                    <h3>Kaderisasi</h3>
                    <p>Mengembangkan kualitas SDM dan karakter mahasiswa TI</p>
                </div>
                <div class="division-card">
                    <div class="icon-wrapper"><i class="fas fa-info-circle"></i></div>
                    <h3>Media Informasi</h3>
                    <p>Mengelola informasi dan komunikasi HIMA - TI</p>
                </div>
                <div class="division-card">
                    <div class="icon-wrapper"><i class="fas fa-lightbulb"></i></div>
                    <h3>Technopreneurship</h3>
                    <p>Mengembangkan jiwa wirausaha berbasis teknologi</p>
                </div>
                <div class="division-card">
                    <div class="icon-wrapper"><i class="fas fa-headset"></i></div>
                    <h3>Public Relations</h3>
                    <p>Membangun hubungan dengan pihak eksternal</p>
                </div>
            </div>
        </div>
    </section>
    
    <section class="features">
        <div class="container">
            <h2 class="section-title">Fitur Utama</h2>
            <p class="section-subtitle">Berbagai layanan dan informasi yang dapat Anda akses</p>
            <div class="features-grid">
                <div class="feature-item">
                    <div class="icon-wrapper"><i class="fas fa-file-alt"></i></div>
                    <h3>Pendaftaran Online</h3>
                    <p>Daftar menjadi anggota HIMA - TI dengan mudah melalui formulir online</p>
                </div>
                <div class="feature-item">
                    <div class="icon-wrapper"><i class="fas fa-users-cog"></i></div>
                    <h3>Informasi Divisi</h3>
                    <p>Pelajari lebih lanjut tentang setiap divisi dan program kerjanya</p>
                </div>
                <div class="feature-item">
                    <div class="icon-wrapper"><i class="fas fa-newspaper"></i></div>
                    <h3>Berita Terkini</h3>
                    <p>Ikuti berita terbaru, pengumuman dan prestasi mahasiswa TI</p>
                </div>
                <div class="feature-item">
                    <div class="icon-wrapper"><i class="fas fa-medal"></i></div>
                    <h3>Prestasi Mahasiswa</h3>
                    <p>Lihat berbagai prestasi yang pernah diraih mahasiswa TI</p>
                </div>
            </div>
        </div>
    </section>
@endsection