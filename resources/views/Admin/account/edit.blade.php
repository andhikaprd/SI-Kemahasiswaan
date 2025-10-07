@extends('admin.layouts.app')

@section('title', 'Edit Pengguna - Panel Admin')

@section('content')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0 fw-bold">Formulir Edit Pengguna</h4>
        </div>
        <div class="card-body p-4">
            {{-- Form akan dikirim ke route update untuk diperbarui --}}
            <form action="{{ route('admin.account.update', $account->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- Method spoofing untuk request UPDATE --}}

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        {{-- Menggunakan old() atau data dari $account --}}
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $account->name) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $account->email) }}" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="mahasiswa" {{ old('role', $account->role) == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="admin" {{ old('role', $account->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kaprodi" {{ old('role', $account->role) == 'kaprodi' ? 'selected' : '' }}>Kaprodi</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="aktif" {{ old('status', $account->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="tidak aktif" {{ old('status', $account->status) == 'tidak aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                    </div>
                </div>

                {{-- Kolom khusus untuk Mahasiswa --}}
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="nim" class="form-label">NIM (Jika Mahasiswa)</label>
                        <input type="text" class="form-control" id="nim" name="nim" value="{{ old('nim', $account->nim) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="jurusan" class="form-label">Jurusan (Jika Mahasiswa)</label>
                        <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ old('jurusan', $account->jurusan) }}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="angkatan" class="form-label">Angkatan (Jika Mahasiswa)</label>
                        <input type="number" class="form-control" id="angkatan" name="angkatan" value="{{ old('angkatan', $account->angkatan) }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                    <input type="password" class="form-control" id="password" name="password">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.account.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Pengguna</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
