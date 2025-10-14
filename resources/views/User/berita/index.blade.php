@extends('user.layouts.app')

@section('title', 'Berita Terbaru')

@section('content')
    <style>
        .fade-in-up{opacity:0;transform:translateY(16px);transition:all .6s ease}
        .fade-in-up.is-visible{opacity:1;transform:none}
        .stagger>*{opacity:0;transform:translateY(12px)}
        .stagger.is-visible>*{opacity:1;transform:none;transition:all .5s ease}
        .stagger.is-visible>*:nth-child(1){transition-delay:.05s}
        .stagger.is-visible>*:nth-child(2){transition-delay:.1s}
        .stagger.is-visible>*:nth-child(3){transition-delay:.15s}
        .stagger.is-visible>*:nth-child(4){transition-delay:.2s}
        .hover-lift{transition:transform .25s ease,box-shadow .25s ease}
        .hover-lift:hover{transform:translateY(-6px);box-shadow:0 12px 28px rgba(0,0,0,.12)}
    </style>
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold fade-in-up" data-animate>Berita & Pengumuman</h1>
            <p class="lead mt-3 fade-in-up" data-animate>Ikuti informasi terbaru seputar kegiatan dan prestasi HIMA TI Politala.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if($beritas->count())
                <div class="row g-4 stagger" data-animate>
                    @foreach($beritas as $berita)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm hover-lift">
                                @if($berita->gambar)
                                    <img src="{{ asset('storage/'.$berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <span class="text-muted small mb-2">
                                        {{ $berita->tanggal_publikasi ? \Illuminate\Support\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                    <h5 class="card-title fw-bold">{{ $berita->judul }}</h5>
                                    <p class="card-text text-muted">{{ \Illuminate\Support\Str::limit($berita->ringkasan, 160) }}</p>
                                    <a href="{{ route('berita.show', $berita->slug) }}" class="mt-auto btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $beritas->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <h5 class="fw-bold">Belum ada berita yang dipublikasikan.</h5>
                    <p class="text-muted mb-0">Nantikan update terbaru dari HIMA TI Politala.</p>
                </div>
            @endif
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
