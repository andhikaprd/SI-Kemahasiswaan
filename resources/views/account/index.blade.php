@extends('layouts.app')

@section('title', 'Daftar Account')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Account</h2>

    {{-- Tombol tambah --}}
    <a href="{{ route('account.create') }}" class="btn btn-primary mb-3">+ Tambah Account</a>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabel account --}}
    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($account as $item)
                <tr>
                    <td>{{ $item->id_akun }}</td>
                    <td>{{ $item->username }}</td>
                    <td>{{ $item->email }}</td>
                    <td>
                        <a href="{{ route('account.edit', $item->id_akun) }}" class="btn btn-warning btn-sm">Edit</a>
                        
                        <form action="{{ route('account.destroy', $item->id_akun) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada data account</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
