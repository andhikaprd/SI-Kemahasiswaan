@extends('layouts.app')

@section('title', 'Form Pendaftaran - HIMA TI Politala')

@section('content')
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="fw-bold">Pendaftaran HIMA-TI</h1>
        <p class="mt-3">Bergabunglah dengan Himpunan Mahasiswa Teknologi Informasi dan wujudkan potensi terbaikmu bersama kami</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Notifikasi error --}}
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" class="card shadow-sm p-4">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" class="form-control" required>
                    @error('nama') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">NIM </label>
                    <input type="text" name="nim" value="{{ old('nim') }}" class="form-control" required>
                    @error('nim') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Jurusan </label>
                    <select name="jurusan" class="form-select" required>
                        <option value="">Pilih Jurusan</option>
                        <option {{ old('jurusan')=='Teknologi Informasi' ? 'selected' : '' }}>Teknologi Informasi</option>
                        <option {{ old('jurusan')=='Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                        <option {{ old('jurusan')=='Teknik Informatika' ? 'selected' : '' }}>Teknik Informatika</option>
                    </select>
                    @error('jurusan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Angkatan </label>
                    <input type="text" name="angkatan" value="{{ old('angkatan') }}" class="form-control" required>
                    @error('angkatan') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email </label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
                    @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nomor Telepon </label>
                    <input type="text" name="telepon" value="{{ old('telepon') }}" class="form-control" required>
                    @error('telepon') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-3">
                    <label class="form-label">Divisi Pilihan </label>
                    <select name="divisi" class="form-select" required>
                        <option value="">Pilih Divisi</option>
                        <option {{ old('divisi')=='Kaderisasi' ? 'selected' : '' }}>Kaderisasi</option>
                        <option {{ old('divisi')=='Media Informasi' ? 'selected' : '' }}>Media Informasi</option>
                        <option {{ old('divisi')=='Technopreneurship' ? 'selected' : '' }}>Technopreneurship</option>
                        <option {{ old('divisi')=='Public Relations' ? 'selected' : '' }}>Public Relations</option>
                    </select>
                    @error('divisi') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-12">
                    <label class="form-label">Motivasi Bergabung </label>
                    <textarea name="motivasi" class="form-control" rows="4" maxlength="500" required>{{ old('motivasi') }}</textarea>
                    @error('motivasi') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="form-check my-3">
                <input class="form-check-input" type="checkbox" required>
                <label class="form-check-label">Saya setuju dengan syarat dan ketentuan</label>
            </div>

            <button type="submit" class="btn btn-primary">Daftar Sekarang</button>
        </form>
    </div>
</section>
@endsection
