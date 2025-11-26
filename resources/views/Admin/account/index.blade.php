@extends('admin.layouts.app')

@section('title', 'Kelola Akun - Panel Admin')

@section('content')
<div class="container">
    <!-- Header Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Kelola Akun Pengguna</h3>
        {{-- Tombol ini sekarang aktif dan mengarah ke form tambah pengguna --}}
        <a href="{{ route('admin.account.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Pengguna
        </a>
    </div>

    <!-- Opsi Filter dan Pencarian -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('admin.account.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-8">
                        <input type="text" name="q" class="form-control" value="{{ request('q') }}" placeholder="Cari pengguna berdasarkan nama atau email...">
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" name="role">
                            @php $r = request('role'); @endphp
                            <option value="Semua" {{ $r===null || $r==='Semua' ? 'selected' : '' }}>Semua Role</option>
                            <option value="admin" {{ $r==='admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kaprodi" {{ $r==='kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                            <option value="mahasiswa" {{ $r==='mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button class="btn btn-outline-secondary w-100" type="submit">Cari</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Daftar Pengguna Dinamis -->
    {{-- Loop ini akan menampilkan setiap akun dari database --}}
    @forelse ($accounts as $account)
        <div class="card shadow-sm border-0 mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-1 d-none d-md-flex justify-content-center">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            {{-- Ikon berubah berdasarkan role --}}
                            @if($account->role == 'admin')
                                <i class="fas fa-user-shield text-danger fa-lg"></i>
                            @elseif($account->role == 'kaprodi')
                                <i class="fas fa-user-tie text-primary fa-lg"></i>
                            @else
                                <i class="fas fa-user-graduate text-success fa-lg"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h5 class="fw-bold mb-0">{{ $account->name }}</h5>
                        <small class="text-muted">{{ $account->email }}</small>
                        @if($account->role == 'mahasiswa')
                            <div class="small text-muted mt-1">NIM: {{ $account->nim ?? '-' }}</div>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <span class="fw-bold">Role:</span>
                        {{-- Badge berubah berdasarkan role --}}
                        @if($account->role == 'admin')
                            <span class="badge bg-danger">Admin</span>
                        @elseif($account->role == 'kaprodi')
                             <span class="badge bg-primary">Kaprodi</span>
                        @else
                             <span class="badge bg-success">Mahasiswa</span>
                        @endif
                    </div>
                    <div class="col-md-2">
                        <span class="fw-bold">Status:</span>
                        @php $st = strtolower($account->status ?? 'aktif'); @endphp
                        <span class="badge {{ $st === 'aktif' ? 'bg-success' : 'bg-secondary' }}">{{ $account->status ?? 'aktif' }}</span>
                    </div>
                <div class="col-md-2 d-flex justify-content-end align-items-center gap-3">
                        <a href="{{ route('admin.account.edit', $account->id) }}" class="text-secondary" title="Edit">
                            <i class="fas fa-pen fa-lg"></i>
                        </a>
                        <form action="{{ route('admin.account.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0 text-danger" title="Hapus" style="text-decoration: none;">
                                <i class="fas fa-trash fa-lg"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">Belum Ada Akun</h5>
                <p>Silakan tambahkan akun baru untuk menampilkannya di sini.</p>
            </div>
        </div>
    @endforelse

</div>
@endsection

