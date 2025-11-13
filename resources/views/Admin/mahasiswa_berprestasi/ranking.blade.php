@extends('Admin.layouts.app')

@section('title','Ranking Prestasi (SAW)')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
      <div>
        <h5 class="card-title mb-1">Ranking Prestasi Mahasiswa (SAW)</h5>
        <div class="text-muted small">Bobot AHP: IPK {{ number_format($weights['ipk'],4) }}, Tingkat {{ number_format($weights['tingkat'],4) }}, Juara {{ number_format($weights['juara'],4) }}, B.Ing {{ number_format($weights['english'],4) }}</div>
      </div>
      <form method="GET" class="d-flex align-items-end gap-2">
        <div>
          <label class="form-label mb-1">Tahun</label>
          <input type="number" name="tahun" value="{{ $tahun ?? '' }}" class="form-control" placeholder="cth: 2025" />
        </div>
        <div class="pb-1">
          <button class="btn btn-primary">Terapkan</button>
          <a href="{{ route('admin.mahasiswa_berprestasi.ranking') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
      </form>
      <div class="pb-1">
        <a class="btn btn-success" href="{{ route('admin.mahasiswa_berprestasi.ranking.export', array_filter(['tahun'=>$tahun])) }}">
          Export CSV
        </a>
        <a class="btn btn-danger" href="{{ route('admin.mahasiswa_berprestasi.ranking.export_pdf', array_filter(['tahun'=>$tahun])) }}">
          Export PDF
        </a>
      </div>
    </div>

    <div class="alert alert-info">
      Nilai IPK dan Bahasa Inggris dibaca dari tabel mahasiswa (IPK 0–4; English: IELTS/9, TOEFL iBT/120, ITP/677, CEFR/6). Jika kosong, dianggap 0.
    </div>

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th style="width: 70px;">Peringkat</th>
            <th>NIM</th>
            <th>Nama</th>
            <th class="text-center">r(IPK)</th>
            <th class="text-center">Tingkat Terbaik</th>
            <th class="text-center">r(Tingkat)</th>
            <th class="text-center">Juara Terbaik</th>
            <th class="text-center">r(Juara)</th>
            <th class="text-center">r(Inggris)</th>
            <th class="text-end">Skor</th>
          </tr>
        </thead>
        <tbody>
        @forelse($rows as $row)
          <tr>
            <td><span class="badge bg-primary">{{ $row['rank'] }}</span></td>
            <td>{{ $row['nim'] ?? '-' }}</td>
            <td>{{ $row['nama'] }}</td>
            <td class="text-center">{{ number_format($row['r_ipk'],3) }}</td>
            <td class="text-center">{{ $row['best_tingkat_label'] }}</td>
            <td class="text-center">{{ number_format($row['r_tingkat'],3) }}</td>
            <td class="text-center">{{ $row['best_juara_label'] }}</td>
            <td class="text-center">{{ number_format($row['r_juara'],3) }}</td>
            <td class="text-center">{{ number_format($row['r_eng'],3) }}</td>
            <td class="text-end fw-semibold">{{ number_format($row['score'],4) }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="10" class="text-center text-muted py-4">Tidak ada data prestasi untuk filter saat ini.</td>
          </tr>
        @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-2">
      <a href="{{ route('admin.mahasiswa_berprestasi.index') }}" class="btn btn-light">Kembali ke Daftar Prestasi</a>
    </div>
  </div>
</div>
@endsection
