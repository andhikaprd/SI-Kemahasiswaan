@extends('user.layouts.app')

@section('title', 'Divisi HIMA - TI')

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
            <style>
                .division-card { border: 1px solid #e6e6e6; border-radius: 12px; overflow: hidden; }
                .division-card .photo-placeholder { background:#E5E5E5; position:relative; height:180px; display:flex; align-items:center; justify-content:center; }
                .division-card .photo-placeholder .division-photo { width:100%; height:100%; object-fit:cover; display:block; }
                .division-card .photo-placeholder .photo-label { position:absolute; color:#333; font-weight:600; display:none; }
                .division-card .photo-placeholder.empty .photo-label { display:block; }
                .division-card .icon-wrap { width: 44px; height: 44px; border-radius: 8px; display:inline-flex; align-items:center; justify-content:center; }
                .division-card .lead-title { font-size: 1.1rem; font-weight: 700; }
                .division-card .meta { color: #6b7280; font-size: .9rem; }
                .division-card .desc { color: #4b5563; }
                .division-card .btn-detail i { margin-right:.5rem; }
                .check-list { list-style:none; padding-left:0; }
                .check-list li::before { content: "\2713\0020"; color:#0d6efd; font-weight:700; }
                @media (min-width: 992px){ .col-division { width: 50%; } }
            </style>

            <div class="row g-4">
                <!-- Kaderisasi -->
                <div class="col-12 col-lg-6 col-division">
                    <div class="division-card shadow-sm h-100">
                        <div class="photo-placeholder empty"><img src="{{ asset('images/divisi/kaderisasi.jpg') }}" alt="Foto Kaderisasi" class="division-photo" onload="this.parentElement.classList.remove('empty')" onerror="this.remove();"><span class="photo-label">Foto</span></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start mb-2">
                                <span class="icon-wrap bg-primary bg-opacity-10 text-primary me-3">
                                    <i class="fas fa-graduation-cap"></i>
                                </span>
                                <div>
                                    <div class="lead-title">Kaderisasi</div>
                                    <div class="meta">Ketua : Ujang</div>
                                </div>
                            </div>
                            <p class="desc mb-3">Divisi yang bertanggung jawab dalam mengembangkan kualitas sumber daya manusia dan pembentukan karakter mahasiswa TI melalui berbagai program.</p>
                            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="collapse" data-bs-target="#detailKaderisasi">
                                <i class="far fa-eye"></i> Lihat Detail
                            </button>
                            <div id="detailKaderisasi" class="collapse mt-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-clipboard-check me-2"></i>Program Kerja</h6>
                                        <ul class="check-list mb-0">
                                            <li>Latihan Kepemimpinan</li>
                                            <li>Mentoring Akademik</li>
                                            <li>Outbound Character Building</li>
                                            <li>Pelatihan Soft Skill</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-users me-2"></i>Anggota Divisi</h6>
                                        <ul class="mb-0 ps-3">
                                            <li>Ujang Numani (Ketua)</li>
                                            <li>Devia Agustina (Wakil)</li>
                                            <li>Dhqiq Maulana (Anggota)</li>
                                            <li>Anggota lainnya</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Media Informasi -->
                <div class="col-12 col-lg-6 col-division">
                    <div class="division-card shadow-sm h-100">
                        <div class="photo-placeholder empty"><img src="{{ asset('images/divisi/media-informasi.jpg') }}" alt="Foto Media Informasi" class="division-photo" onload="this.parentElement.classList.remove('empty')" onerror="this.remove();"><span class="photo-label">Foto</span></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start mb-2">
                                <span class="icon-wrap bg-success bg-opacity-10 text-success me-3">
                                    <i class="fas fa-info-circle"></i>
                                </span>
                                <div>
                                    <div class="lead-title">Media Informasi</div>
                                    <div class="meta">Ketua : Ujang</div>
                                </div>
                            </div>
                            <p class="desc mb-3">Divisi yang mengelola seluruh aspek komunikasi dan informasi HIMA - TI termasuk publikasi kegiatan, pengelolaan media sosial, dan penyebaran informasi kepada mahasiswa.</p>
                            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="collapse" data-bs-target="#detailMediainfo">
                                <i class="far fa-eye"></i> Lihat Detail
                            </button>
                            <div id="detailMediainfo" class="collapse mt-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-clipboard-check me-2"></i>Program Kerja</h6>
                                        <ul class="check-list mb-0">
                                            <li>Publikasi Kegiatan</li>
                                            <li>Pengelolaan Sosial Media</li>
                                            <li>Desain Konten</li>
                                            <li>Website & Dokumentasi</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-users me-2"></i>Anggota Divisi</h6>
                                        <ul class="mb-0 ps-3">
                                            <li>Ujang Numani (Ketua)</li>
                                            <li>Devia Agustina (Wakil)</li>
                                            <li>Tim Desain</li>
                                            <li>Tim Dokumentasi</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Technopreneurship -->
                <div class="col-12 col-lg-6 col-division">
                    <div class="division-card shadow-sm h-100">
                        <div class="photo-placeholder empty"><img src="{{ asset('images/divisi/technopreneurship.jpg') }}" alt="Foto Technopreneurship" class="division-photo" onload="this.parentElement.classList.remove('empty')" onerror="this.remove();"><span class="photo-label">Foto</span></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start mb-2">
                                <span class="icon-wrap bg-warning bg-opacity-10 text-warning me-3">
                                    <i class="fas fa-lightbulb"></i>
                                </span>
                                <div>
                                    <div class="lead-title">Technopreneurship</div>
                                    <div class="meta">Ketua : Ujang</div>
                                </div>
                            </div>
                            <p class="desc mb-3">Divisi yang fokus mengembangkan jiwa kewirausahaan berbasis teknologi, menyelenggarakan pelatihan digital dan memfasilitasi mahasiswa dalam mengembangkan startup teknologi.</p>
                            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="collapse" data-bs-target="#detailTechnopreneur">
                                <i class="far fa-eye"></i> Lihat Detail
                            </button>
                            <div id="detailTechnopreneur" class="collapse mt-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-clipboard-check me-2"></i>Program Kerja</h6>
                                        <ul class="check-list mb-0">
                                            <li>Pelatihan Produk Digital</li>
                                            <li>Kompetisi Inovasi</li>
                                            <li>Startup Camp</li>
                                            <li>Kolaborasi Industri</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-users me-2"></i>Anggota Divisi</h6>
                                        <ul class="mb-0 ps-3">
                                            <li>Ujang Numani (Ketua)</li>
                                            <li>Devia Agustina (Wakil)</li>
                                            <li>Dhqiq Maulana (Anggota)</li>
                                            <li>Anggota lainnya</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Public Relations (default detail terbuka) -->
                <div class="col-12 col-lg-6 col-division">
                    <div class="division-card shadow-sm h-100">
                        <div class="photo-placeholder empty"><img src="{{ asset('images/divisi/public-relations.jpg') }}" alt="Foto Public Relations" class="division-photo" onload="this.parentElement.classList.remove('empty')" onerror="this.remove();"><span class="photo-label">Foto</span></div>
                        <div class="p-4">
                            <div class="d-flex align-items-start mb-2">
                                <span class="icon-wrap bg-danger bg-opacity-10 text-danger me-3">
                                    <i class="fas fa-headset"></i>
                                </span>
                                <div>
                                    <div class="lead-title">Public Relations</div>
                                    <div class="meta">Ketua : Ujang</div>
                                </div>
                            </div>
                            <p class="desc mb-3">Divisi yang bertugas membangun dan memelihara hubungan baik dengan berbagai pihak eksternal, termasuk alumni dan organisasi mahasiswa lainnya.</p>
                            <button class="btn btn-primary btn-sm btn-detail" data-bs-toggle="collapse" data-bs-target="#detailPR" aria-expanded="true">
                                <i class="far fa-eye"></i> Tutup Detail
                            </button>
                            <div id="detailPR" class="collapse show mt-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-clipboard-check me-2"></i>Program Kerja</h6>
                                        <ul class="check-list mb-0">
                                            <li>Temu Kangen Alumni</li>
                                            <li>Seminar dengan Praktisi Industri</li>
                                            <li>Jaringan Kemitraan</li>
                                            <li>Publikasi dan Kehumasan</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="fw-bold mb-2"><i class="far fa-users me-2"></i>Anggota Divisi</h6>
                                        <ul class="mb-0 ps-3">
                                            <li>Ujang Numani (Ketua)</li>
                                            <li>Devia Agustina (Wakil)</li>
                                            <li>Dhqiq Maulana (Anggota)</li>
                                            <li>Dhia Maulana (Anggota)</li>
                                            <li>Anggota lainnya</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                // Toggle label tombol Lihat/Tutup Detail per card
                document.querySelectorAll('.btn-detail').forEach(function(btn){
                    var target = document.querySelector(btn.getAttribute('data-bs-target'));
                    if(!target) return;
                    target.addEventListener('shown.bs.collapse', function(){ btn.innerHTML = '<i class="far fa-eye"></i> Tutup Detail'; });
                    target.addEventListener('hidden.bs.collapse', function(){ btn.innerHTML = '<i class="far fa-eye"></i> Lihat Detail'; });
                });
            </script>
        </div>
    </section>
@endsection



