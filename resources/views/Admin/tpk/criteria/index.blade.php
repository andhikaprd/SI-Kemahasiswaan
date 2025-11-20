@extends('Admin.layouts.app')
@section('title','TPK - Kriteria')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Data Kriteria</h5>
      <div class="d-flex gap-2">
        <a href="{{ route('admin.tpk.compute') }}" class="btn btn-outline-primary"><i class="fas fa-calculator me-1"></i> Hitung</a>
        <a href="{{ route('admin.tpk.criteria.create') }}" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Tambah Kriteria</a>
      </div>
    </div>
    @if (!empty($needs_migration))
      <div class="alert alert-warning">
        Tabel TPK belum dibuat. Jalankan migrasi: <code>php artisan migrate</code>
      </div>
    @endif
    @if (session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th>No.</th>
            <th>Kode Kriteria</th>
            <th>Kriteria</th>
            <th>Nilai Bobot</th>
            <th>Jenis Kriteria</th>
            <th class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
        @forelse($items as $i=>$c)
          <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $c->code }}</td>
            <td>{{ $c->name }}</td>
            <td>{{ number_format($c->weight,2) }}</td>
            <td>{{ ucfirst($c->type) }}</td>
            <td class="text-end">
              <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.tpk.criteria.edit', $c->id) }}"><i class="fas fa-pen"></i></a>
              <form action="{{ route('admin.tpk.criteria.destroy',$c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kriteria ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
              </form>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="text-center text-muted">Belum ada kriteria.</td></tr>
        @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
