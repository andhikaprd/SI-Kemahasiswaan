<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HIMA TI Politala')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Google Fonts (Opsional, jika Anda ingin font custom) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Custom CSS (jika diperlukan) -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
        }
        .nav-link {
            color: #333 !important;
            font-weight: 500;
        }
        .nav-link.active, .nav-link:hover {
            color: #0d6efd !important;
        }
        .hero-section {
            background-color: #4A90E2; /* Warna biru dari desain */
            padding: 80px 0;
        }
        .card {
            border: none;
            border-radius: 10px;
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        footer {
            background-color: #343a40;
            color: white;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('beranda') }}">
                <!-- Ganti dengan logo Anda jika ada -->
                <img src="https://placehold.co/40x40/4A90E2/FFF?text=TI" alt="Logo HIMA TI" class="me-2"> 
                HIMA TI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Divisi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pendaftaran.create') ? 'active' : '' }}" href="{{ route('pendaftaran.create') }}">Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita.index') ? 'active' : '' }}" href="{{ route('berita.index') }}">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Prestasi Mahasiswa</a>
                    </li>
                </ul>
                <a href="#" class="btn btn-outline-primary">Login</a>
            </div>
        </div>
    </nav>

    <!-- Konten Halaman Dinamis -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="py-4 mt-auto">
        <div class="container text-center">
            <small>&copy; {{ date('Y') }} HIMA TI - Himpunan Mahasiswa Teknologi Informasi Politala</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
