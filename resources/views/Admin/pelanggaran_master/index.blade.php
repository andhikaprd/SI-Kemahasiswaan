@extends('Admin.layouts.app')
@php use Illuminate\Support\Str; @endphp
@section('title','Master Pelanggaran')
@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <h5 class="mb-1">Master Pelanggaran</h5>
        <p class="text-muted mb-0">Data referensi yang digunakan pada modul Pelanggaran Mahasiswa.</p>
      </div>
      <a href="{{ route('admin.pelanggaran_master.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tambah</a>
    </div>
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead class="table-light">
          <tr>
            <th style="width:40px;">#</th>
            <th>Nama</th>
            <th>Kategori</th>
            <th>Sanksi Default</th>
            <th style="width:140px;" class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $i => $item)
            <tr>
              <td>{{ $i+1 }}</td>
              <td>
                <div class="fw-semibold">{{ $item->nama }}</div>
                @if($item->deskripsi)
                  <div class="text-muted small">{{ Str::limit($item->deskripsi, 120) }}</div>
                @endif
              </td>
              <td><span class="badge bg-{{ $item->kategori === 'berat' ? 'danger' : ($item->kategori === 'sedang' ? 'warning text-dark' : 'secondary') }}">{{ ucfirst($item->kategori) }}</span></td>
              <td>{{ $item->sanksi_default ?: '—' }}</td>
              <td class="text-end">
                <a href="{{ route('admin.pelanggaran_master.edit', $item->id) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-pen"></i></a>
                <form action="{{ route('admin.pelanggaran_master.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus master ini?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada data master.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
