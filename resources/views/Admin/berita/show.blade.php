@extends('admin.layouts.app')

@section('title', 'Detail Berita - ' . ($berita->judul ?? 'Berita'))

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="fw-bold mb-1">{{ $berita->judul }}</h3>
            <div class="text-muted small">
                <i class="fas fa-calendar-alt me-1"></i>
                {{ $berita->tanggal_publikasi?->translatedFormat('d F Y H:i') ?? '-' }}
                <span class="ms-3"><i class="fas fa-user me-1"></i>{{ $berita->penulis ?? 'Admin' }}</span>
            </div>
        </div>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="mb-3">
        <span class="badge bg-warning text-dark">{{ $berita->kategori ?? 'Umum' }}</span>
        <span class="badge bg-{{ $berita->status === 'published' ? 'success' : 'secondary' }}">
            {{ ucfirst($berita->status) }}
        </span>
    </div>

    @if($berita->gambar)
        <div class="mb-3">
            <img src="{{ asset('storage/' . $berita->gambar) }}" alt="gambar" class="img-fluid rounded shadow-sm">
        </div>
    @endif

    <p class="text-muted">{{ $berita->ringkasan }}</p>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            {!! $berita->isi !!}
        </div>
    </div>
</div>
@endsection
