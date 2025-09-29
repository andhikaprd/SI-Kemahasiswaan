@extends('layouts.app')

@section('title', 'Pendaftaran - HIMA TI Politala')

@section('content')
<section class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="fw-bold">Pendaftaran HIMA-TI</h1>
        <p class="mt-3">Bergabunglah dengan Himpunan Mahasiswa Teknologi Informasi dan wujudkan potensi terbaikmu bersama kami</p>
    </div>
</section>

<section class="py-5">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('pendaftaran.store') }}" method="POST" class="card shadow-sm p-4">
            @csrf

            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Lengkap *</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">NIM *</label>
                    <input type="text" name="nim" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Jurusan *</label>
                    <select name="jurusan" class="form-select" required>
                        <option value="">Pilih Jurusan</option>
                        <option>Teknologi Informasi</option>
                        <option>Sistem Informasi</option>
                        <option>Teknik Informatika</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Angkatan *</label>
                    <input type="text" name="angkatan" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Nomor Telepon *</label>
                    <input type="text" name="telepon" class="form-control" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Divisi Pilihan *</label>
                    <select name="divisi" class="form-select" required>
                        <option value="">Pilih Divisi</option>
                        <option>Kaderisasi</option>
                        <option>Media Informasi</option>
                        <option>Technopreneurship</option>
                        <option>Public Relations</option>
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Motivasi Bergabung *</label>
                    <textarea name="motivasi" class="form-control" rows="4" maxlength="500" required></textarea>
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
