<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HIMA TI Politala')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}} {{-- <-- BARIS INI DIKOMENTARI --}}
    <style>
        .hero-section {
            background: linear-gradient(120deg, #4A90E2, #6EC1E4);
            padding: 5rem 0;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #4A90E2;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('beranda') }}">
                <img src="https://placehold.co/40x40/FFFFFF/4A90E2?text=TI" alt="Logo HIMA TI" class="d-inline-block align-text-top me-2" style="border-radius: 50%;">
                HIMA TI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('divisi') }}">Divisi</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('pendaftaran.create') }}">Pendaftaran</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('profil') }}">Profil</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('prestasi.index') }}">Prestasi Mahasiswa</a></li>
                </ul>
                <ul class="navbar-nav ms-lg-3">
                     <li class="nav-item"><a href="#" class="btn btn-outline-light">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="text-center py-3" style="background-color: #4A90E2; color: white;">
        <div class="container">
            <p class="mb-0">&copy; 2025 HIMA TI - Himpunan Mahasiswa Teknologi Informasi Politala</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

