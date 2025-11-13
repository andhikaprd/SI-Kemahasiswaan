@extends('Admin.layouts.app')

@section('title','Mahasiswa')

@section('content')
<div class="card">
  <div class="card-body">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="mb-0">Daftar Mahasiswa</h5>
      <form method="GET" class="d-flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama/NIM/angkatan...">
        <button class="btn btn-primary">Cari</button>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-outline-secondary">Reset</a>
      </form>
    </div>

    @if (session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>Nama</th>
            <th>NIM</th>
            <th>Angkatan</th>
            <th class="text-center">IPK</th>
            <th>Bahasa Inggris</th>
            <th style="width: 100px;" class="text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($mahasiswas as $m)
            <tr>
              <td>{{ $m->nama }}</td>
              <td>{{ $m->nim }}</td>
              <td>{{ $m->angkatan ?? '-' }}</td>
              <td class="text-center">{{ $m->ipk !== null ? number_format($m->ipk,2) : '-' }}</td>
              <td>
                @if ($m->english_type && $m->english_score !== null)
                  <span class="badge bg-info text-dark">{{ $m->english_type }}</span>
                  <span class="ms-1">{{ $m->english_score }}</span>
                @else
                  <span class="text-muted">-</span>
                @endif
              </td>
              <td class="text-end">
                <a href="{{ route('admin.mahasiswa.edit', $m->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center text-muted py-4">Tidak ada data.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div>
      {{ $mahasiswas->links() }}
    </div>
  </div>
</div>
@endsection

