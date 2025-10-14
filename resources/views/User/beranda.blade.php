{{-- File ini sekarang ada di: resources/views/user/beranda.blade.php --}}

@extends('user.layouts.app')


@section('title', 'Beranda - HIMA TI Politala')

@section('content')

    <style>
        @keyframes gradientMove { 0%{background-position:0% 50%} 50%{background-position:100% 50%} 100%{background-position:0% 50%} }
        @keyframes float { from{transform:translateY(0)} to{transform:translateY(-20px)} }
        .fade-in-up{opacity:0;transform:translateY(24px);transition:all .7s ease}
        .fade-in-up.is-visible{opacity:1;transform:none}
        .stagger>*{opacity:0;transform:translateY(20px)}
        .stagger.is-visible>*{opacity:1;transform:none;transition:all .6s ease}
        .stagger.is-visible>*:nth-child(1){transition-delay:.05s}
        .stagger.is-visible>*:nth-child(2){transition-delay:.1s}
        .stagger.is-visible>*:nth-child(3){transition-delay:.15s}
        .stagger.is-visible>*:nth-child(4){transition-delay:.2s}
        .hover-lift{transition:transform .25s ease,box-shadow .25s ease}
        .hover-lift:hover{transform:translateY(-6px);box-shadow:0 12px 28px rgba(0,0,0,.12)}
        .hero-section{position:relative;overflow:hidden;background:linear-gradient(120deg,#4A90E2,#6EC1E4,#5c8df6);background-size:300% 300%;animation:gradientMove 12s ease infinite}
        .hero-photo{position:absolute;inset:0;background-size:cover;background-position:center 60%;opacity:.20;mix-blend:overlay;z-index:1}
        .hero-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,28,61,.42),rgba(0,28,61,.42));z-index:2}
        .hero-shape{position:absolute;width:180px;height:180px;border-radius:50%;filter:blur(50px);opacity:.25;animation:float 6s ease-in-out infinite alternate;z-index:2}
        .hero-title{letter-spacing:.5px;text-shadow:0 2px 10px rgba(0,0,0,.35),0 0 1px rgba(0,0,0,.65)}
        .hero-subtitle{color:rgba(255,255,255,.9)!important;text-shadow:0 1px 6px rgba(0,0,0,.35)}
        .hero-section .container{position:relative;z-index:3}
        .hero-shape.one{left:-40px;top:-30px;background:#fff}
        .hero-shape.two{right:-50px;bottom:-40px;background:#c6e2ff;animation-duration:8s}
        .hero-badge{display:inline-flex;align-items:center;gap:.5rem;padding:.35rem .75rem;border-radius:999px;background:rgba(255,255,255,.15);backdrop-filter:blur(4px);font-size:.9rem}
        .stat-card h3{font-size:1.75rem;margin:0}
    </style>

    <!-- Hero -->
    <section class="hero-section text-white text-center">
        <span class="hero-photo" style="background-image:url('{{ asset('images/gedung-ti.jpg') }}')"></span>
        <span class="hero-overlay"></span>
        <span class="hero-shape one"></span>
        <span class="hero-shape two"></span>
        <div class="container py-5">
            <div class="hero-badge fade-in-up" data-animate>
                <i class="fas fa-bolt"></i>
                <span>Portal Kemahasiswaan TI</span>
            </div>
            <h1 class="display-5 fw-bold mt-3 fade-in-up hero-title" data-animate>
                HIMPUNAN MAHASISWA TEKNOLOGI INFORMASI POLITALA
            </h1>
            <p class="lead mt-3 fade-in-up hero-subtitle" data-animate>
                Platform digital untuk seluruh mahasiswa Teknologi Informasi. <br>
                Kelola informasi akademik, organisasi, dan prestasi dalam satu tempat.
            </p>
        </div>
    </section>

    <!-- Statistik -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center stagger" data-animate>
                <div class="col-md-3 col-6 mb-4 stat-card">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h3 class="fw-bold" data-count="300">0</h3>
                    <p class="text-muted">Total Mahasiswa</p>
                </div>
                <div class="col-md-3 col-6 mb-4 stat-card">
                    <i class="fas fa-sitemap fa-3x text-success mb-3"></i>
                    <h3 class="fw-bold" data-count="4">0</h3>
                    <p class="text-muted">Divisi Aktif</p>
                </div>
                <div class="col-md-3 col-6 mb-4 stat-card">
                    <i class="fas fa-clipboard-check fa-3x text-warning mb-3"></i>
                    <h3 class="fw-bold" data-count="4">0</h3>
                    <p class="text-muted">Program Kerja</p>
                </div>
                <div class="col-md-3 col-6 mb-4 stat-card">
                    <i class="fas fa-trophy fa-3x text-danger mb-3"></i>
                    <h3 class="fw-bold" data-count="38">0</h3>
                    <p class="text-muted">Prestasi</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Divisi -->
    <section class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="fw-bold mb-3 fade-in-up" data-animate>4 Divisi Utama</h2>
            <p class="lead text-muted mb-5 fade-in-up" data-animate>Divisi yang menjalankan berbagai program kerja untuk mahasiswa TI</p>
            <div class="row g-4 stagger" data-animate>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-graduation-cap fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Kaderisasi</h5>
                        <p class="text-muted">Mengembangkan kualitas SDM dan karakter mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-info-circle fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Media Informasi</h5>
                        <p class="text-muted">Mengelola informasi dan komunikasi HIMA - TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-lightbulb fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Technopreneurship</h5>
                        <p class="text-muted">Mengembangkan jiwa wirausaha berbasis teknologi</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
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
            <h2 class="fw-bold mb-3 fade-in-up" data-animate>Fitur Utama</h2>
            <p class="lead text-muted mb-5 fade-in-up" data-animate>Berbagai layanan dan informasi yang dapat Anda akses</p>
            <div class="row g-4 stagger" data-animate>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-file-alt fa-3x text-primary mb-3"></i>
                        <h5 class="fw-bold">Pendaftaran Online</h5>
                        <p class="text-muted">Daftar menjadi anggota HIMA - TI dengan mudah melalui formulir online</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-users-cog fa-3x text-success mb-3"></i>
                        <h5 class="fw-bold">Informasi Divisi</h5>
                        <p class="text-muted">Pelajari lebih lanjut tentang setiap divisi dan program kerjanya</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-newspaper fa-3x text-warning mb-3"></i>
                        <h5 class="fw-bold">Berita Terkini</h5>
                        <p class="text-muted">Ikuti berita terbaru, pengumuman dan prestasi mahasiswa TI</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card h-100 shadow-sm p-4 hover-lift">
                        <i class="fas fa-medal fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold">Prestasi Mahasiswa</h5>
                        <p class="text-muted">Lihat berbagai prestasi yang pernah diraih mahasiswa TI</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        (function(){
            const els = document.querySelectorAll('[data-animate]');
            const io = new IntersectionObserver((entries)=>{
                entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('is-visible'); io.unobserve(e.target); } });
            },{threshold:.15});
            els.forEach(el=>io.observe(el));

            const counters = document.querySelectorAll('[data-count]');
            counters.forEach(el=>{
                const target = parseInt(el.getAttribute('data-count')||'0',10);
                const run = ()=>{
                    const duration = 900, startTime = performance.now();
                    const step = (now)=>{ const p = Math.min(1,(now-startTime)/duration); const val = Math.floor(p*target); el.textContent = target>=100? val+'+': val; if(p<1) requestAnimationFrame(step); };
                    requestAnimationFrame(step);
                };
                const once = new IntersectionObserver((ents)=>{ ents.forEach(en=>{ if(en.isIntersecting){ run(); once.disconnect(); } }); },{threshold:.6});
                once.observe(el);
            });
        })();
    </script>

@endsection
