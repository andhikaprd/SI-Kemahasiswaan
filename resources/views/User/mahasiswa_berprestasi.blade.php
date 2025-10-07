@extends('user.layouts.app')

@section('title', 'Prestasi Mahasiswa TI')

@section('content')
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold">Prestasi Mahasiswa TI</h1>
            <p class="lead mt-3">
                Dokumentasi capaian mahasiswa Teknologi Informasi dalam kompetisi akademik maupun non-akademik.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if($prestasi->count())
                <div class="row g-4">
                    @foreach($prestasi as $item)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold">{{ $item->judul_prestasi }}</h5>
                                    <p class="card-text text-muted mb-2">{{ $item->nama_mahasiswa }} &middot; {{ $item->tingkat }}</p>
                                    <p class="card-text">{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}</p>
                                </div>
                                <div class="card-footer bg-white d-flex justify-content-between align-items-center">
                                    <span class="text-primary fw-semibold">{{ $item->penyelenggara }}</span>
                                    <span class="text-muted small">
                                        {{ $item->tanggal_perolehan ? \Illuminate\Support\Carbon::parse($item->tanggal_perolehan)->translatedFormat('d M Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    {{ $prestasi->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <h5 class="fw-bold">Belum ada data prestasi.</h5>
                    <p class="text-muted mb-0">Prestasi mahasiswa akan ditampilkan di sini setelah tersedia.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
