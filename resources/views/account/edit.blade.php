@extends('layouts.app')

@section('title', 'Daftar Account')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Daftar Account</h2>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tombol tambah --}}
    <a href="{{ route('account.create') }}" class="btn btn-primary mb-3">Tambah Account</a>

    {{-- Tabel daftar akun --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($account as $acc)
                <tr>
                    <td>{{ $acc->id_akun }}</td>
                    <td>{{ $acc->username }}</td>
                    <td>{{ $acc->email }}</td>
                    <td>
                        <a href="{{ route('account.edit', $acc->id_akun) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('account.destroy', $acc->id_akun) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Belum ada account.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
