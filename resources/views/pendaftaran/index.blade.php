@extends('layouts.app')

@section('title', 'Daftar Pendaftar - HIMA TI Politala')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 fw-bold">Daftar Pendaftar HIMA TI</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel daftar pendaftar --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>NIM</th>
                        <th>Jurusan</th>
                        <th>Angkatan</th>
                        <th>Email</th>
                        <th>No. Telp</th>
                        <th>Divisi Pilihan</th>
                        <th>Motivasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendaftaran as $key => $p)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $p->nama_lengkap }}</td>
                            <td>{{ $p->nim }}</td>
                            <td>{{ $p->jurusan }}</td>
                            <td>{{ $p->angkatan }}</td>
                            <td>{{ $p->email }}</td>
                            <td>{{ $p->no_telp }}</td>
                            <td>{{ $p->divisi_pilihan }}</td>
                            <td>{{ $p->motivasi }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Belum ada pendaftar</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
