@extends('admin.layouts.app')

@section('title', 'Detail Laporan')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h3 class="fw-bold mb-1">{{ $laporan->judul }}</h3>
            <div class="text-muted small">
                <span class="me-3"><strong>Periode:</strong> {{ $laporan->periode ?? '-' }}</span>
                <span class="me-3"><strong>Kategori:</strong> {{ $laporan->kategori ?? '-' }}</span>
                <span class="me-3"><strong>Status:</strong> {{ ucfirst($laporan->status ?? '-') }}</span>
            </div>
        </div>
        <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="mb-3">
        <p><strong>Mahasiswa:</strong> {{ optional($laporan->mahasiswa)->nama }} ({{ optional($laporan->mahasiswa)->nim }})</p>
        <p><strong>Mata Kuliah:</strong> {{ optional($laporan->mataKuliah)->nama }}</p>
    </div>

    <div class="card shadow-sm border-0 mb-3">
        <div class="card-body">
            <h6 class="fw-bold">Deskripsi</h6>
            <p class="mb-0">{{ $laporan->deskripsi ?? '-' }}</p>
        </div>
    </div>

    <div class="d-flex align-items-center gap-2">
        @if($laporan->file_path)
            <a href="{{ route('admin.laporan.download', $laporan) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-download me-1"></i> Unduh Laporan
            </a>
            <span class="text-muted small">Ukuran: {{ $laporan->file_size_formatted ?? '-' }}</span>
        @else
            <span class="text-muted">Tidak ada file laporan.</span>
        @endif
    </div>
</div>
@endsection
