@extends('admin.layouts.app') {{-- <-- PENTING: Menggunakan layout ADMIN --}}

@section('title', 'Daftar Pendaftar - Admin Panel')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Manajemen Pendaftar HIMA TI</h2>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Angkatan</th>
                            <th>Divisi Pilihan</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pendaftaran as $key => $p)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $p->nama_lengkap }}</td>
                                <td>{{ $p->nim }}</td>
                                <td>{{ $p->angkatan }}</td>
                                <td>{{ $p->divisi_pilihan }}</td>
                                <td><span class="badge bg-warning text-dark">Pending</span></td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash me-1"></i> Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">Belum ada data pendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

