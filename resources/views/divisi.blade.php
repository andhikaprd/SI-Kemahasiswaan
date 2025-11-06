{{-- File: resources/views/divisi.blade.php --}}

@extends('user.layouts.app')

@section('title', 'Divisi HIMA - TI')

@section('content')
    <!-- Hero -->
    <section class="bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="fw-bold">Divisi HIMA - TI</h1>
            <p class="mt-3">
                Kenali lebih dekat 4 divisi utama yang menjalankan berbagai program kerja untuk kemajuan 
                dan pengembangan mahasiswa Teknologi Informasi.
            </p>
        </div>
    </section>

    <!-- Divisi Cards -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Kaderisasi -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-user-graduate fa-2x text-primary mb-3"></i>
                            <h5 class="card-title">Kaderisasi</h5>
                            <p class="card-text">
                                Divisi yang bertanggung jawab dalam mengembangkan kualitas sumber daya manusia 
                                dan membentuk karakter mahasiswa TI melalui berbagai program.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Media Informasi -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-bullhorn fa-2x text-success mb-3"></i>
                            <h5 class="card-title">Media Informasi</h5>
                            <p class="card-text">
                                Divisi yang mengelola seluruh aspek komunikasi dan informasi HIMA - TI, 
                                termasuk publikasi kegiatan, media sosial, dan penyebaran informasi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Technopreneurship -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-lightbulb fa-2x text-warning mb-3"></i>
                            <h5 class="card-title">Technopreneurship</h5>
                            <p class="card-text">
                                Divisi yang fokus mengembangkan jiwa kewirausahaan berbasis teknologi 
                                melalui pelatihan digital dan pengembangan startup mahasiswa.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Public Relations -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body text-center">
                            <i class="fas fa-handshake fa-2x text-danger mb-3"></i>
                            <h5 class="card-title">Public Relations</h5>
                            <p class="card-text">
                                Divisi yang bertugas membangun hubungan baik dengan pihak eksternal, 
                                termasuk alumni, organisasi, dan mitra kerja lainnya.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
