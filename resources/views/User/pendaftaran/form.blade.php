@extends('user.layouts.app')

@section('title', 'Formulir Pendaftaran HIMA TI')

@section('content')
    <style>
        .fade-in-up{opacity:0;transform:translateY(18px);transition:all .6s ease}
        .fade-in-up.is-visible{opacity:1;transform:none}
        .hover-lift{transition:transform .25s ease,box-shadow .25s ease}
        .hover-lift:hover{transform:translateY(-4px);box-shadow:0 12px 28px rgba(0,0,0,.12)}
        .form-control:focus,.form-select:focus{box-shadow:0 0 0 .2rem rgba(74,144,226,.25)}
    </style>
    <section class="hero-section text-white text-center">
        <div class="container">
            <h1 class="display-5 fw-bold fade-in-up" data-animate>Daftar Anggota HIMA TI</h1>
            <p class="lead mt-3 fade-in-up" data-animate>
                Isi formulir berikut untuk bergabung bersama Himpunan Mahasiswa Teknologi Informasi Politala.
            </p>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card shadow-sm border-0 hover-lift fade-in-up" data-animate>
                        <div class="card-body p-4">
                            <h2 class="h4 fw-bold mb-4 text-center">Formulir Pendaftaran</h2>

                            <form action="{{ route('pendaftaran.store') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control @error('nama') is-invalid @enderror" required>
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" name="nim" id="nim" value="{{ old('nim') }}" class="form-control @error('nim') is-invalid @enderror" required>
                                        @error('nim')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="angkatan" class="form-label">Angkatan</label>
                                        <input type="number" name="angkatan" id="angkatan" value="{{ old('angkatan') }}" class="form-control @error('angkatan') is-invalid @enderror" placeholder="2023" required>
                                        @error('angkatan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="divisi" class="form-label">Divisi Pilihan</label>
                                    <select name="divisi" id="divisi" class="form-select @error('divisi') is-invalid @enderror" required>
                                        <option value="" disabled {{ old('divisi') ? '' : 'selected' }}>Pilih salah satu</option>
                                        @foreach(['Kaderisasi','Media Informasi','Technopreneurship','Public Relations'] as $divisi)
                                            <option value="{{ $divisi }}" {{ old('divisi') === $divisi ? 'selected' : '' }}>{{ $divisi }}</option>
                                        @endforeach
                                    </select>
                                    @error('divisi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih divisi yang paling sesuai dengan minatmu.</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon" class="form-label">No. WhatsApp</label>
                                        <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}" class="form-control @error('telepon') is-invalid @enderror" required>
                                        @error('telepon')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="motivasi" class="form-label">Motivasi Bergabung</label>
                                    <textarea name="motivasi" id="motivasi" rows="4" class="form-control @error('motivasi') is-invalid @enderror" required>{{ old('motivasi') }}</textarea>
                                    @error('motivasi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Kirim Pendaftaran</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        (function(){
            const els=document.querySelectorAll('[data-animate]');
            const io=new IntersectionObserver((entries)=>{
                entries.forEach(e=>{ if(e.isIntersecting){ e.target.classList.add('is-visible'); io.unobserve(e.target);} });
            },{threshold:.15});
            els.forEach(el=>io.observe(el));
        })();
    </script>
@endsection
