@extends('user.layouts.app')

@section('title', $prestasi->kompetisi . ' - Prestasi Mahasiswa')

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
                <div class="col-lg-9">
                    <article class="card shadow-sm border-0 fade-in-up" data-animate>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                <div>
                                    <h3 class="fw-bold mb-1">{{ $prestasi->kompetisi }}</h3>
                                    <div class="text-muted small">{{ $prestasi->nama }}</div>
                                </div>
                                <div class="text-end">
                                    @if($prestasi->tingkat)
                                        <span class="badge bg-success-subtle text-success">{{ $prestasi->tingkat }}</span>
                                    @endif
                                    @if($prestasi->peringkat)
                                        <span class="badge bg-primary-subtle text-primary ms-1">{{ $prestasi->peringkat }}</span>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">Jurusan</div>
                                    <div>{{ $prestasi->jurusan ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted small mb-1">Angkatan</div>
                                    <div>{{ $prestasi->angkatan ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted small mb-1">Tahun</div>
                                    <div>{{ $prestasi->tahun ?? ($prestasi->tanggal ? $prestasi->tanggal->format('Y') : '-') }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">Jenis</div>
                                    <div>{{ $prestasi->jenis ?? '-' }}</div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">Penyelenggara</div>
                                    <div>{{ $prestasi->penyelenggara ?? '-' }}</div>
                                </div>
                            </div>

                            @if($prestasi->deskripsi)
                                <hr>
                                <div>
                                    <div class="text-muted small mb-1">Deskripsi</div>
                                    <div class="pre-wrap">{!! nl2br(e($prestasi->deskripsi)) !!}</div>
                                </div>
                            @endif

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('prestasi.index') }}" class="btn btn-outline-secondary">
                                    &larr; Kembali
                                </a>
                                <div class="d-flex gap-2">
                                    @if($prestasi->sertifikat_url)
                                        <a href="{{ $prestasi->sertifikat_url }}" target="_blank" class="btn btn-outline-success">
                                            <i class="bi bi-file-earmark-text me-1"></i> Sertifikat
                                        </a>
                                    @endif
                                    @if($prestasi->foto_url)
                                        <a href="{{ $prestasi->foto_url }}" target="_blank" class="btn btn-outline-primary">
                                            <i class="bi bi-image me-1"></i> Lihat Foto
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
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

