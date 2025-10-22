@extends('user.layouts.app')

@section('title', 'Daftar Prestasi Mahasiswa')

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
    <!-- Hero Section -->
    <section class="hero-section text-white text-center py-5" style="background-color: #2d5be3;">
        <div class="container">
            <h1 class="display-6 fw-bold mb-2 fade-in-up" data-animate>Daftar Prestasi Mahasiswa</h1>
            <p class="lead text-white-50 mb-0 fade-in-up" data-animate>
                Capaian gemilang mahasiswa Teknologi Informasi Politeknik Negeri Tanah Laut
            </p>
        </div>
    </section>

    <!-- Statistik Ringkas -->
    <section class="py-4">
        <div class="container">
            <div class="row g-3 text-center stagger" data-animate>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 hover-lift">
                        <div class="card-body">
                            <i class="bi bi-trophy-fill fs-2 text-warning"></i>
                            <h5 class="fw-bold mt-2" data-count="{{ $total }}">0</h5>
                            <p class="text-muted small mb-0">Total Prestasi</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 hover-lift">
                        <div class="card-body">
                            <i class="bi bi-globe fs-2 text-danger"></i>
                            <h5 class="fw-bold mt-2" data-count="{{ $internasional }}">0</h5>
                            <p class="text-muted small mb-0">Internasional</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 hover-lift">
                        <div class="card-body">
                            <i class="bi bi-award fs-2 text-primary"></i>
                            <h5 class="fw-bold mt-2" data-count="{{ $nasional }}">0</h5>
                            <p class="text-muted small mb-0">Nasional</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card shadow-sm border-0 hover-lift">
                        <div class="card-body">
                            <i class="bi bi-geo-alt fs-2 text-success"></i>
                            <h5 class="fw-bold mt-2" data-count="{{ $provinsi }}">0</h5>
                            <p class="text-muted small mb-0">Provinsi</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Filter & Pencarian -->
    <section class="py-4 border-top">
        <div class="container">
            <form method="GET" action="{{ route('prestasi.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label text-muted small">Cari Prestasi</label>
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control"
                        placeholder="Nama, kompetisi...">
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Tingkat</label>
                    <select name="tingkat" class="form-select">
                        <option value="Semua">Semua</option>
                        @foreach ($optTingkat as $t)
                            <option value="{{ $t }}" @selected(request('tingkat') == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Tahun</label>
                    <select name="tahun" class="form-select">
                        <option value="Semua">Semua</option>
                        @foreach ($optTahun as $t)
                            <option value="{{ $t }}" @selected(request('tahun') == $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label text-muted small">Jurusan</label>
                    <select name="jurusan" class="form-select">
                        <option value="Semua">Semua</option>
                        @foreach ($optJurusan as $j)
                            <option value="{{ $j }}" @selected(request('jurusan') == $j)>{{ $j }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Daftar Prestasi -->
    <section class="pb-5">
        <div class="container">
            @if ($items->count())
                @foreach ($items as $prestasi)
                    <div class="card shadow-sm mb-3 hover-lift fade-in-up" data-animate>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $prestasi->nama }}</h5>
                                    <p class="text-muted small mb-1">
                                        {{ $prestasi->jurusan ?? '-' }} &middot;
                                        Angkatan {{ $prestasi->angkatan ?? '-' }}
                                    </p>
                                    <p class="mb-0"><strong>{{ $prestasi->kompetisi }}</strong></p>
                                </div>
                                <div class="text-end">
                                    @if($prestasi->tingkat)
                                        <span class="badge bg-success-subtle text-success">{{ $prestasi->tingkat }}</span>
                                    @endif
                                    @if($prestasi->peringkat)
                                        <span class="badge bg-primary-subtle text-primary ms-1">{{ $prestasi->peringkat }}</span>
                                    @endif
                                    @if(!is_null($prestasi->poin))
                                        <div class="text-muted small mt-1">{{ (int)$prestasi->poin }} poin</div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mt-3 g-3">
                                <div class="col-md-6">
                                    <div class="text-muted small mb-1">Jenis Kompetisi</div>
                                    <div>{{ $prestasi->jenis ?? '-' }}</div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-muted small mb-1">Tahun</div>
                                    <div>{{ $prestasi->tahun ?? ($prestasi->tanggal ? $prestasi->tanggal->format('Y') : '-') }}</div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <div class="text-muted small mb-1">Tanggal</div>
                                    <div>{{ $prestasi->tanggal ? $prestasi->tanggal->format('d/m/Y') : '-' }}</div>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <span class="text-muted small">Penyelenggara:</span>
                                    <span class="fw-semibold">{{ $prestasi->penyelenggara ?? '-' }}</span>
                                </div>
                                <div class="text-end mt-2 mt-md-0">
                                    @if($prestasi->sertifikat_url)
                                        <a href="{{ $prestasi->sertifikat_url }}" target="_blank" class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-file-earmark-text me-1"></i> Sertifikat
                                        </a>
                                    @endif
                                    <a href="{{ route('prestasi.show', $prestasi->slug) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-4">
                    {{ $items->links() }}
                </div>
            @else
                <div class="alert alert-light border text-center py-5">
                    <h5 class="fw-bold">Belum ada data prestasi.</h5>
                    <p class="text-muted mb-0">Prestasi mahasiswa akan muncul setelah admin menambah data baru.</p>
                </div>
            @endif
        </div>
    </section>
    <script>
        (function(){
            const els=document.querySelectorAll('[data-animate]');
            const io=new IntersectionObserver((entries)=>{entries.forEach(e=>{if(e.isIntersecting){e.target.classList.add('is-visible');io.unobserve(e.target);}})},{threshold:.15});
            els.forEach(el=>io.observe(el));

            const counters=document.querySelectorAll('[data-count]');
            counters.forEach(el=>{
                const target=parseInt(el.getAttribute('data-count')||'0',10);
                const run=()=>{const d=900, s=performance.now(); const step=(n)=>{const p=Math.min(1,(n-s)/d); el.textContent=Math.floor(p*target); if(p<1) requestAnimationFrame(step)}; requestAnimationFrame(step)};
                const once=new IntersectionObserver((es)=>{es.forEach(en=>{if(en.isIntersecting){run(); once.disconnect();}})},{threshold:.6});
                once.observe(el);
            });
        })();
    </script>
@endsection
