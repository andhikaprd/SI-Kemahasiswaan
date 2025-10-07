@extends('user.layouts.app')

@section('title', 'Profil HIMA TI')

@section('content')
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Profil HIMA TI Politala</h1>
            <p class="lead mt-3">
                Mengenal sejarah, visi, dan misi Himpunan Mahasiswa Teknologi Informasi Politeknik Negeri Tanah Laut.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="p-4 bg-light rounded-3 h-100">
                        <h2 class="fw-bold mb-3">Visi</h2>
                        <p class="mb-0">
                            Menjadi organisasi mahasiswa yang adaptif, kolaboratif, dan berdaya saing di bidang teknologi informasi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 bg-light rounded-3 h-100">
                        <h2 class="fw-bold mb-3">Misi</h2>
                        <ul class="mb-0">
                            <li>Mengembangkan potensi akademik dan non-akademik mahasiswa TI.</li>
                            <li>Mendorong inovasi teknologi melalui program kerja berkelanjutan.</li>
                            <li>Membangun jejaring dengan industri dan komunitas teknologi.</li>
                            <li>Mewujudkan budaya organisasi yang inklusif dan profesional.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
