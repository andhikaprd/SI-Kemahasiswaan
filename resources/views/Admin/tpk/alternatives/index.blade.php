@extends('Admin.layouts.app')
@section('title','Hitung Prestasi - Alternatif')
@section('content')
<div class="card"><div class="card-body">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Data Alternatif</h5>
    <div class="d-flex gap-2">
      <a href="{{ route('admin.tpk.compute') }}" class="btn btn-outline-primary"><i class="fas fa-calculator me-1"></i> Hitung</a>
      <a href="{{ route('admin.tpk.alternatives.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Alternatif</a>
    </div>
  </div>
  @if (!empty($needs_migration))
    <div class="alert alert-warning">Tabel TPK belum dibuat. Jalankan migrasi: <code>php artisan migrate</code></div>
  @endif
  @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>No.</th>
          <th>Kode Alternatif</th>
          <th>Nama</th>
          @foreach ($criteria as $c)
            <th>{{ $c->code }}</th>
          @endforeach
          <th class="text-end">Aksi</th>
        </tr>
      </thead>
      <tbody>
      @forelse($items as $i=>$a)
        <tr>
          <td>{{ $i+1 }}</td>
          <td>{{ $a->code }}</td>
          <td>{{ $a->name }}</td>
          @foreach ($criteria as $c)
            <td>{{ isset($scores[$a->id][$c->id]) ? number_format($scores[$a->id][$c->id], 2) : '-' }}</td>
          @endforeach
          <td class="text-end">
            <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tpk.alternatives.edit', $a->id) }}"><i class="fas fa-pen"></i></a>
            <form action="{{ route('admin.tpk.alternatives.destroy',$a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus alternatif ini?')">
              @csrf @method('DELETE')
              <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="{{ 4 + count($criteria) }}" class="text-center text-muted">Belum ada alternatif.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div></div>
@endsection
