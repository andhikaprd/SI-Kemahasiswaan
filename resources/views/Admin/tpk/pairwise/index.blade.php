@extends('Admin.layouts.app')
@section('title','Perbandingan Kriteria (AHP)')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <div>
    <h5 class="mb-1">Perbandingan Berpasangan Kriteria</h5>
    <span class="badge bg-info text-dark">Metode AHP</span>
    <small class="text-muted ms-2">Isi nilai perbandingan (skala 1–9).</small>
  </div>
  <div class="d-flex gap-2">
    <a href="{{ route('admin.tpk.criteria.index') }}" class="btn btn-sm btn-outline-secondary">Kelola Kriteria</a>
    <a href="{{ route('admin.tpk.compute') }}" class="btn btn-sm btn-outline-primary">Hitung SAW</a>
  </div>
</div>

<div class="card mb-3"><div class="card-body">
  @if (!empty($needs_migration))
    <div class="alert alert-warning">Tabel TPK belum dibuat. Jalankan migrasi: <code>php artisan migrate</code></div>
  @endif
  @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif

  @if (!empty($needs_criteria))
    <div class="alert alert-info">
      Masukkan data kriteria terlebih dahulu. Setelah disimpan, form perbandingan AHP akan muncul.
    </div>
    <form method="POST" action="{{ route('admin.tpk.pairwise.criteria.store') }}" class="row g-3">
      @csrf
      @for ($i = 0; $i < 4; $i++)
        <div class="col-md-2">
          <label class="form-label">Kode</label>
          <input name="criteria[{{ $i }}][code]" class="form-control" placeholder="C{{ $i+1 }}" value="{{ old('criteria.'.$i.'.code') }}">
        </div>
        <div class="col-md-6">
          <label class="form-label">Kriteria</label>
          <input name="criteria[{{ $i }}][name]" class="form-control" placeholder="Nama Kriteria" value="{{ old('criteria.'.$i.'.name') }}">
        </div>
        <div class="col-md-2">
          <label class="form-label">Jenis</label>
          <select name="criteria[{{ $i }}][type]" class="form-select">
            <option value="benefit" @selected(old('criteria.'.$i.'.type')==='benefit')>Benefit</option>
            <option value="cost" @selected(old('criteria.'.$i.'.type')==='cost')>Cost</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label">Urutan</label>
          <input name="criteria[{{ $i }}][order]" type="number" min="0" class="form-control" value="{{ old('criteria.'.$i.'.order', $i+1) }}">
        </div>
      @endfor
      <div class="col-12">
        <button class="btn btn-primary">Simpan Kriteria</button>
      </div>
    </form>
  @else
    <form method="POST" action="{{ route('admin.tpk.pairwise.store') }}">
      @csrf
      <div class="table-responsive">
        <table class="table table-bordered align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Kriteria</th>
              @foreach ($criteria as $c)
                <th class="text-center">{{ $c->code }} - {{ $c->name }}</th>
              @endforeach
            </tr>
          </thead>
        <tbody>
          @foreach ($criteria as $row)
            <tr>
              <th>{{ $row->code }} - {{ $row->name }}</th>
              @foreach ($criteria as $col)
                <td class="text-center">
                  @if ($row->id === $col->id)
                    1
                  @else
                    <input
                      type="number"
                      step="0.0001"
                      min="0.1111"
                      max="9"
                      name="pairwise[{{ $row->id }}][{{ $col->id }}]"
                      value="{{ old('pairwise.'.$row->id.'.'.$col->id, $matrix[$row->id][$col->id] ?? 1) }}"
                      class="form-control form-control-sm text-center"
                    />
                  @endif
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
        <tfoot class="table-light">
          <tr>
            <th>Total</th>
            @foreach ($criteria as $c)
              <th class="text-center">{{ number_format($colSums[$c->id] ?? 0, 2) }}</th>
            @endforeach
          </tr>
        </tfoot>
      </table>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary">Simpan Perbandingan</button>
      </div>
    </form>
  @endif
</div></div>

<div class="row g-3">
  <div class="col-lg-6">
    <div class="card h-100"><div class="card-body">
      <h6 class="mb-2">Hasil Normalisasi Perbandingan Berpasangan Antar Kriteria</h6>
      <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th></th>
              @foreach ($criteria as $c)
                <th class="text-center">{{ $c->code }} - {{ $c->name }}</th>
              @endforeach
            </tr>
          </thead>
          <tbody>
            @foreach ($criteria as $row)
              <tr>
                <th>{{ $row->code }}</th>
                @foreach ($criteria as $col)
                  <td class="text-center">{{ number_format($normalized[$row->id][$col->id] ?? 0, 2) }}</td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
          <tfoot class="table-light">
            <tr>
              <th>Jumlah</th>
              @foreach ($criteria as $c)
                <th class="text-center">
                  {{
                    number_format(
                      collect($criteria)->sum(fn($r) => $normalized[$r->id][$c->id] ?? 0),
                      2
                    )
                  }}
                </th>
              @endforeach
            </tr>
          </tfoot>
        </table>
      </div>
    </div></div>
  </div>
  <div class="col-lg-6">
    <div class="card h-100"><div class="card-body">
      <h6 class="mb-2">Bobot (Normalisasi Perbandingan)</h6>
      <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
          <thead class="table-light">
            <tr>
              <th>Kode</th>
              <th>Kriteria</th>
              <th class="text-end">Bobot</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($criteria as $c)
              <tr>
                <td>{{ $c->code }}</td>
                <td>{{ $c->name }}</td>
                <td class="text-end">{{ number_format($weights[$c->id] ?? 0, 2) }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <small class="text-muted d-block mt-2">Bobot ini akan digunakan pada perhitungan SAW.</small>
    </div></div>
  </div>
</div>

@if (!empty($consistency))
  <div class="card mt-3"><div class="card-body">
    <h6 class="mb-3">Menghitung Rasio Konsistensi</h6>
    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-3">
        <thead class="table-light">
          <tr>
            <th>Kriteria</th>
            @foreach ($criteria as $c)
              <th class="text-center">{{ $c->code }} - {{ $c->name }}</th>
            @endforeach
            <th class="text-center">Jumlah</th>
            <th class="text-center">Jumlah / Eigen Vector</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($criteria as $row)
            <tr>
              <th>{{ $row->name }}</th>
              @foreach ($criteria as $col)
                <td class="text-center">{{ number_format($normalized[$row->id][$col->id] ?? 0, 2) }}</td>
              @endforeach
              <td class="text-center">{{ number_format($consistency['aw'][$row->id] ?? 0, 2) }}</td>
              <td class="text-center">{{ number_format($consistency['ratios'][$row->id] ?? 0, 2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="table-responsive">
      <table class="table table-bordered align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Lambda Maximum</th>
            <th>Consistency Index (CI)</th>
            <th>Random Index (RI)</th>
            <th>Consistency Ratio (CR)</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ number_format($consistency['lambda_max'] ?? 0, 4) }}</td>
            <td>{{ number_format($consistency['ci'] ?? 0, 4) }}</td>
            <td>{{ number_format($consistency['ri'] ?? 0, 4) }}</td>
            <td>{{ number_format($consistency['cr'] ?? 0, 4) }}</td>
            <td>
              @if (!empty($consistency['is_consistent']))
                Konsisten
              @else
                Tidak Konsisten
              @endif
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div></div>
@endif
@endsection
