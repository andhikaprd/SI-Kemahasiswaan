@extends('user.layouts.app')

@section('title', 'Profil HIMA TI')

@section('content')
    <style>
        .fade-in-up{opacity:0;transform:translateY(16px);transition:all .6s ease}
        .fade-in-up.is-visible{opacity:1;transform:none}
        .stagger>*{opacity:0;transform:translateY(12px)}
        .stagger.is-visible>*{opacity:1;transform:none;transition:all .5s ease}
        .stagger.is-visible>*:nth-child(1){transition-delay:.05s}
        .stagger.is-visible>*:nth-child(2){transition-delay:.1s}
        .hover-lift{transition:transform .25s ease,box-shadow .25s ease}
        .hover-lift:hover{transform:translateY(-6px);box-shadow:0 12px 28px rgba(0,0,0,.12)}
    </style>
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold fade-in-up" data-animate>Profil HIMA TI Politala</h1>
            <p class="lead mt-3 fade-in-up" data-animate>
                Mengenal sejarah, visi, dan misi Himpunan Mahasiswa Teknologi Informasi Politeknik Negeri Tanah Laut.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row g-4 stagger" data-animate>
                <div class="col-lg-6">
                    <div class="p-4 bg-light rounded-3 h-100 hover-lift">
                        <h2 class="fw-bold mb-3">Visi</h2>
                        <p class="mb-0">
                            Menjadi organisasi mahasiswa yang adaptif, kolaboratif, dan berdaya saing di bidang teknologi informasi.
                        </p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="p-4 bg-light rounded-3 h-100 hover-lift">
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
    <script>
        (function(){
            const els=document.querySelectorAll('[data-animate]');
            const io=new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');io.unobserve(e.target);}})},{threshold:.15});
            els.forEach(el=>io.observe(el));
        })();
    </script>
@endsection
