@extends('user.layouts.app')

@section('title', 'Divisi HIMA TI')

@section('content')
    <!-- Hero -->
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Divisi HIMA TI</h1>
            <p class="lead mt-3">
                Kenali 4 divisi utama yang menjalankan program kerja untuk kemajuan mahasiswa Teknologi Informasi.
            </p>
        </div>
    </section>

    <!-- Divisi Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Kaderisasi</h5>
                            <p class="card-text">
                                Mengembangkan kualitas sumber daya manusia dan membentuk karakter mahasiswa TI melalui beragam program.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-bullhorn fa-2x text-success mb-3"></i>
                            <h5 class="card-title">Media Informasi</h5>
                            <p class="card-text">
                                Mengelola seluruh kanal komunikasi HIMA TI dan memastikan informasi sampai ke seluruh anggota.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-lightbulb fa-2x text-warning mb-3"></i>
                            <h5 class="card-title">Technopreneurship</h5>
                            <p class="card-text">
                                Menumbuhkan jiwa wirausaha berbasis teknologi melalui pelatihan dan pendampingan proyek inovatif.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-handshake fa-2x text-danger mb-3"></i>
                            <h5 class="card-title">Public Relations</h5>
                            <p class="card-text">
                                Membangun jejaring dan menjaga hubungan baik dengan mitra eksternal serta stakeholder kampus.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

