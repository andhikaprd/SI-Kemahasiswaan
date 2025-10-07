@extends('user.layouts.app')

@section('title', 'Berita Terbaru')

@section('content')
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Berita & Pengumuman</h1>
            <p class="lead mt-3">Ikuti informasi terbaru seputar kegiatan dan prestasi HIMA TI Politala.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if($beritas->count())
                <div class="row g-4">
                    @foreach($beritas as $berita)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm">
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
@endsection
