@extends('Admin.layouts.app')
@section('title','TPK - Hitung (SAW)')
@section('content')
<div class="card mb-3"><div class="card-body">
  @if (!empty($needs_migration))
    <div class="alert alert-warning">Tabel TPK belum dibuat. Jalankan migrasi: <code>php artisan migrate</code></div>
  @endif
  <div class="d-flex justify-content-between align-items-center mb-2">
    <h5 class="mb-0">Bobot</h5>
    <div>
      <a href="{{ route('admin.tpk.criteria.index') }}" class="btn btn-sm btn-outline-secondary">Kelola Kriteria</a>
      <a href="{{ route('admin.tpk.alternatives.index') }}" class="btn btn-sm btn-outline-secondary">Kelola Alternatif</a>
      <a href="{{ route('admin.tpk.compute.export') }}" class="btn btn-sm btn-success">Export CSV</a>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered align-middle mb-0">
      <thead class="table-light">
        <tr>
          @foreach ($criteria as $c)
            <th>{{ $c->code }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        <tr>
          @foreach ($criteria as $c)
            <td>{{ number_format($weights[$c->id] ?? 0, 3) }}</td>
          @endforeach
        </tr>
      </tbody>
    </table>
  </div>
</div></div>

<div class="card mb-3"><div class="card-body">
  <h5 class="mb-2">Normalisasi</h5>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>Kode Alternatif</th>
          @foreach ($criteria as $c)
            <th>{{ $c->code }}</th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @forelse ($alts as $a)
          <tr>
            <td>{{ $a->code }}</td>
            @foreach ($criteria as $c)
              <td>{{ number_format($normalized[$c->id][$a->id] ?? 0, 3) }}</td>
            @endforeach
          </tr>
        @empty
          <tr><td colspan="{{ 1 + count($criteria) }}" class="text-center text-muted">Tidak ada alternatif.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div></div>

<div class="card"><div class="card-body">
  <h5 class="mb-2">Hasil</h5>
  <div class="table-responsive">
    <table class="table table-hover align-middle">
      <thead class="table-light">
        <tr>
          <th>Rank</th>
          <th>Kode Alternatif</th>
          <th>Nama</th>
          <th class="text-end">Hasil</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($rows as $r)
          <tr>
            <td>{{ $r['rank'] }}</td>
            <td>{{ $r['alt']->code }}</td>
            <td>{{ $r['alt']->name }}</td>
            <td class="text-end">{{ number_format($r['score'], 4) }}</td>
          </tr>
        @empty
          <tr><td colspan="4" class="text-center text-muted">Tidak ada data.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div></div>
@endsection
