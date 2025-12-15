@extends('user.layouts.app')

@section('title', $berita->judul)

@section('content')
    <style>
        .fade-in-up{opacity:0;transform:translateY(16px);transition:all .6s ease}
        .fade-in-up.is-visible{opacity:1;transform:none}
        .hover-lift{transition:transform .25s ease,box-shadow .25s ease}
        .hover-lift:hover{transform:translateY(-6px);box-shadow:0 12px 28px rgba(0,0,0,.12)}
    </style>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <article class="mb-4 fade-in-up" data-animate>
                        <header class="mb-4">
                            <span class="badge bg-primary mb-2">{{ $berita->kategori }}</span>
                            <h1 class="fw-bold">{{ $berita->judul }}</h1>
                            <div class="text-muted">
                                Dipublikasikan {{ $berita->tanggal_publikasi ? \Illuminate\Support\Carbon::parse($berita->tanggal_publikasi)->translatedFormat('d F Y H:i') : '-' }}
                                oleh <strong>{{ $berita->penulis }}</strong>
                            </div>
                        </header>

                        @if($berita->gambar)
                            <figure class="mb-4 fade-in-up" data-animate>
                                <img src="{{ asset('storage/'.$berita->gambar) }}" class="img-fluid rounded-3 w-100" alt="{{ $berita->judul }}">
                            </figure>
                        @endif

                        <section class="fs-5 text-justify fade-in-up" data-animate>
                            {!! nl2br(e($berita->isi)) !!}
                        </section>
                    </article>

                    @if($berita->tags)
                        <div class="mb-4">
                            <h6 class="fw-bold">Tag:</h6>
                            @foreach(explode(',', $berita->tags) as $tag)
                                <span class="badge bg-light text-primary border">{{ trim($tag) }}</span>
                            @endforeach
                        </div>
                    @endif

                    <a href="{{ route('berita.index') }}" class="btn btn-outline-secondary">&larr; Kembali ke daftar berita</a>
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
