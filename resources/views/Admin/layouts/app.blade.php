<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') - HIMA TI Politala</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome (untuk ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <!-- Custom CSS (Opsional) -->
    <style>
        body {
            background-color: #f0f2f5; /* Warna latar belakang abu-abu muda seperti di desain */
        }
        .header-admin {
            background-color: #4A90E2;
            color: white;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #4A90E2;
            border-bottom: 3px solid #4A90E2;
            background-color: transparent;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Header Panel Admin -->
        <header class="header-admin py-3 shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-0">Panel Admin</h4>
                    <p class="mb-0 small">Kelola Data Prestasi dan Akun Pengguna</p>
                </div>
                <a href="{{ route('beranda') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Beranda
                </a>
            </div>
        </header>

        <!-- Navigasi Tab -->
        <nav class="bg-white shadow-sm py-2 mb-4">
            <div class="container">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="#">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.mahasiswa-berprestasi.*') ? 'active' : '' }}" href="#">
                             <i class="fas fa-trophy me-2"></i>Kelola Prestasi
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.accounts.*') ? 'active' : '' }}" href="#">
                           <i class="fas fa-users-cog me-2"></i>Kelola Akun
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" href="#">
                           <i class="fas fa-newspaper me-2"></i>Kelola Berita
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" href="#">
                            <i class="fas fa-file-alt me-2"></i>Laporan
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Konten Halaman Utama -->
        <main class="py-4">
            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

