{{-- File: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HIMA TI Politala')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body style="font-family: 'Poppins', sans-serif;">

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            {{-- Logo kiri --}}
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo HIMA TI" height="40" class="me-2">
                HIMA TI
            </a>

            {{-- Toggle button (mobile) --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            {{-- Menu --}}
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    {{-- Beranda --}}
                    <li class="nav-item">
                        <a href="{{ url('/') }}" 
                           class="nav-link {{ request()->is('/') ? 'active fw-bold text-primary' : '' }}">
                            Beranda
                        </a>
                    </li>

                    {{-- Divisi --}}
                    <li class="nav-item">
                        <a href="{{ url('/divisi') }}" 
                           class="nav-link {{ request()->is('divisi') ? 'active fw-bold text-primary' : '' }}">
                            Divisi
                        </a>
                    </li>

                    {{-- Pendaftaran (dropdown) --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('pendaftaran*') ? 'active fw-bold text-primary' : '' }}" 
                           href="#" id="navbarPendaftaran" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Pendaftaran
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarPendaftaran">
                            <li>
                                <a class="dropdown-item" href="{{ route('pendaftaran.index') }}">Daftar Sekarang</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('pendaftaran.create') }}">Lihat Data Pendaftar</a>
                            </li>
                        </ul>
                    </li>

                    {{-- Menu lainnya --}}
                    <li class="nav-item"><a href="#" class="nav-link">Berita</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Profil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Prestasi Mahasiswa</a></li>

                    {{-- Account (CRUD) --}}
                    <li class="nav-item">
                        <a href="{{ route('account.index') }}" 
                           class="nav-link {{ request()->is('account*') ? 'active fw-bold text-primary' : '' }}">
                            Account
                        </a>
                    </li>

                    {{-- Login (paling kanan) --}}
                    <li class="nav-item ms-lg-3">
                        <a href="#" class="btn btn-outline-primary px-3">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <div class="container">
            <p class="mb-0">&copy; 2024 HIMA TI - Himpunan Mahasiswa Teknologi Informasi</p>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
