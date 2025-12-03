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
    @php
        $section = match (true) {
            request()->routeIs('beranda') => 'beranda',
            request()->routeIs('divisi') => 'divisi',
            request()->routeIs('pendaftaran.*') => 'pendaftaran',
            request()->routeIs('berita.*') => 'berita',
            request()->routeIs('profil') => 'profil',
            request()->routeIs('prestasi.*') => 'prestasi',
            default => 'default',
        };
        // Samakan warna navbar menjadi biru pada semua halaman
        $navColor = '#4A90E2';
    @endphp
    <style>
        .hero-section { background: linear-gradient(120deg, #4A90E2, #6EC1E4); padding: 5rem 0; }
        .navbar .nav-link { color: rgba(255,255,255,.9); font-weight: 500; }
        .navbar .nav-link:hover { color: #fff; }
        .navbar .nav-link.active { color: #fff; border-bottom: 2px solid #fff; }
        .navbar-brand img { border-radius: 50%; }
        .user-identity { max-width: 180px; overflow: hidden; }
        .user-identity .name { color:#fff; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .user-identity .meta { color: rgba(255,255,255,.8); font-size: 12px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: {{ $navColor }};">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('beranda') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo HIMA TI" class="d-inline-block align-text-top me-2" style="width:40px;height:40px;object-fit:contain;border-radius:50%;">
                HIMA TI
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('divisi') ? 'active' : '' }}" href="{{ route('divisi') }}">Divisi</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('pendaftaran.*') ? 'active' : '' }}" href="{{ route('pendaftaran.create') }}">Pendaftaran</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" href="{{ route('berita.index') }}">Berita</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profil</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('prestasi.*') ? 'active' : '' }}" href="{{ route('prestasi.index') }}">Prestasi Mahasiswa</a></li>
                    @auth
                        @if (auth()->user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @endif
                        @if (auth()->user()->role === 'kaprodi')
                            <li class="nav-item"><a class="nav-link" href="{{ route('kaprodi.pelanggaran_mahasiswa.index') }}">Pelanggaran Mahasiswa</a></li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-lg-3 align-items-center">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-user"></i>
                                @php($role = auth()->user()->role)
                                <div class="user-identity text-start">
                                    <div class="meta">{{ auth()->user()->nim ?? '' }}</div>
                                    <div class="name">{{ $role === 'admin' ? 'Admin' : auth()->user()->name }}</div>
                                </div>
                                <span class="badge ms-1" style="background: rgba(255,255,255,.25); border:1px solid rgba(255,255,255,.35); color:#fff;">
                                    {{ $role === 'admin' ? 'Admin' : ($role === 'kaprodi' ? 'Kaprodi' : 'Mahasiswa') }}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                @if (auth()->user()->role === 'admin')
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Panel Admin</a></li>
                                @endif
                                @if (auth()->user()->role === 'kaprodi')
                                    <li><a class="dropdown-item" href="{{ route('kaprodi.laporan.index') }}">Panel Kaprodi</a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="px-3 py-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">Keluar</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a href="{{ route('login') }}" class="btn btn-outline-light">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @if (session('status'))
            <div class="container mt-3">
                <div class="alert alert-info py-2 mb-0">{{ session('status') }}</div>
            </div>
        @endif
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
