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
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg custom-navbar">
        <div class="container">
            <a class="navbar-brand fw-bold text-white" href="/">
                <i class="fas fa-university me-2"></i> HIMA TI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">Beranda</a>
                    </li>
                    <li class="nav-item"><a href="#" class="nav-link">Divisi</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Pendaftaran</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Berita</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Profil</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Prestasi</a></li>
                </ul>
                <a href="#" class="btn btn-login ms-3">Login</a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="custom-footer text-center py-4 mt-5">
        <div class="container">
            <p class="mb-1 fw-semibold">&copy; 2024 HIMA TI</p>
            <small class="text-muted">Himpunan Mahasiswa Teknologi Informasi - Politeknik Negeri Tanah Laut</small>
        </div>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
