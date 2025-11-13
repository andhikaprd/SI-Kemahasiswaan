<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin') - HIMA TI Politala</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            background-color: #f0f2f5;
        }
        .header-admin {
            background-color: #4A90E2;
            color: white;
        }
        .nav-tabs .nav-link {
            border: none;
            color: #6c757d;
            transition: 0.2s;
        }
        .nav-tabs .nav-link:hover {
            color: #007bff;
        }
        .nav-tabs .nav-link.active {
            font-weight: bold;
            color: #4A90E2;
            border-bottom: 3px solid #4A90E2;
            background-color: transparent;
        }
        .dropdown-menu a:hover {
            background-color: #f0f2f5;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Header Panel Admin -->
        <header class="header-admin py-3 shadow-sm">
            <div class="container d-flex justify-content-between align-items-center">
                <!-- Kiri: Judul Panel -->
                <div>
                    <h4 class="fw-bold mb-0">Panel Admin</h4>
                    <p class="mb-0 small">Data Prestasi dan Akun Pengguna</p>
                </div>

                <!-- Kanan: Dropdown Profil -->
                <div class="d-flex align-items-center gap-3">
                    <a href="{{ route('beranda') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                    </a>

                    <!-- Dropdown User -->
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle fa-lg me-2 text-primary"></i>
                            <span>
                                @if(optional(Auth::user())->role === 'admin')
                                    Admin
                                @else
                                    {{ optional(Auth::user())->name ?? 'Pengguna' }}
                                @endif
                            </span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.account.index') }}">
                                    <i class="fas fa-user-cog me-2 text-secondary"></i> Kelola Akun
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <!-- Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>

        <!-- Navigasi Tab -->
        <nav class="bg-white shadow-sm py-2 mb-4">
            <div class="container">
                <ul class="nav nav-tabs">
                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>

                    <!-- Prestasi -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.mahasiswa_berprestasi.*') ? 'active' : '' }}" 
                           href="{{ route('admin.mahasiswa_berprestasi.index') }}">
                            <i class="fas fa-trophy me-2"></i>Prestasi
                        </a>
                    </li>

                    <!-- Akun -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.account.*') ? 'active' : '' }}" 
                           href="{{ route('admin.account.index') }}">
                            <i class="fas fa-users-cog me-2"></i>Akun
                        </a>
                    </li>

                    <!-- Berita -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}" 
                           href="{{ route('admin.berita.index') }}">
                            <i class="fas fa-newspaper me-2"></i>Berita
                        </a>
                    </li>

                    <!-- Laporan -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}" 
                           href="{{ route('admin.laporan.index') }}">
                            <i class="fas fa-file-alt me-2"></i>Laporan
                        </a>
                    </li>

                    <!-- Mahasiswa -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}" 
                           href="{{ route('admin.mahasiswa.index') }}">
                            <i class="fas fa-user-graduate me-2"></i>Mahasiswa
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Konten Halaman -->
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
