@extends('Admin.layouts.app')

@section('title','Bobot Kriteria (AHP)')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Bobot Kriteria (AHP) – Prestasi Mahasiswa</h5>
      <a class="btn btn-outline-secondary" href="{{ route('admin.mahasiswa_berprestasi.ranking', ['tahun'=>request('tahun')]) }}">Lihat Ranking</a>
    </div>

    @if ($errors->any())
      <div class="alert alert-danger">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif
    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.mahasiswa_berprestasi.weights.store') }}" class="mb-4">
      @csrf
      <div class="row g-3">
        <div class="col-md-2">
          <label class="form-label">Tahun (opsional)</label>
          <input type="number" name="tahun" value="{{ old('tahun', $tahun) }}" class="form-control" placeholder="cth: 2025" />
        </div>
      </div>

      <hr class="my-3">
      <div class="mb-2 fw-semibold">Isi 6 perbandingan (skala Saaty 1-9, boleh pecahan seperti 0.5=1/2):</div>
      <div class="row g-3">
        <div class="col-md-3">
          <label class="form-label">a12 = IPK vs Tingkatan</label>
          <input type="number" step="any" name="a12" value="{{ old('a12', 3) }}" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">a13 = IPK vs Juara</label>
          <input type="number" step="any" name="a13" value="{{ old('a13', 3) }}" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">a14 = IPK vs Bahasa Inggris</label>
          <input type="number" step="any" name="a14" value="{{ old('a14', 3) }}" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">a23 = Tingkatan vs Juara</label>
          <input type="number" step="any" name="a23" value="{{ old('a23', 0.5) }}" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">a24 = Tingkatan vs Bahasa Inggris</label>
          <input type="number" step="any" name="a24" value="{{ old('a24', 3) }}" class="form-control" required />
        </div>
        <div class="col-md-3">
          <label class="form-label">a34 = Juara vs Bahasa Inggris</label>
          <input type="number" step="any" name="a34" value="{{ old('a34', 3) }}" class="form-control" required />
        </div>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary">Hitung & Simpan Bobot</button>
        <a href="{{ route('admin.mahasiswa_berprestasi.weights', ['tahun'=>request('tahun')]) }}" class="btn btn-light">Reset</a>
      </div>
    </form>

    <hr>
    <h6 class="mb-2">Bobot Tersimpan Terakhir</h6>
    @if($latest)
      <div class="row g-3 mb-2">
        <div class="col-md-3">Tahun: <strong>{{ $latest->tahun ?? 'Semua' }}</strong></div>
        <div class="col-md-3">Metode: <strong>{{ $latest->method }}</strong></div>
        <div class="col-md-3">CR: <strong>{{ number_format($latest->cr,3) }}</strong></div>
      </div>
      @php($w = $latest->weights)
      <ul class="mb-3">
        <li>IPK: {{ number_format($w['ipk'] ?? 0, 4) }}</li>
        <li>Tingkatan: {{ number_format($w['tingkat'] ?? 0, 4) }}</li>
        <li>Juara: {{ number_format($w['juara'] ?? 0, 4) }}</li>
        <li>Bahasa Inggris: {{ number_format($w['english'] ?? 0, 4) }}</li>
      </ul>
      <div class="text-muted small">Disimpan: {{ $latest->created_at }}</div>
    @else
      <div class="text-muted">Belum ada bobot tersimpan.</div>
    @endif
  </div>
</div>
@endsection

