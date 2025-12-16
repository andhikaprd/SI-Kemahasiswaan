<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Kaprodi') - Himpunan Mahasiswa Teknologi Informasi Politala</title>

    {{-- Bootstrap (untuk layout cepat) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{-- Tailwind (CDN agar utilitas di view tetap bekerja) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        .kaprodi-header {
            background-color: #4A90E2;
            color: white;
        }
        .kaprodi-header h4 { font-weight: 700; }
        .btn-logout { background: #fff; color: #1f2937; font-weight: 500; border-radius: 10px; transition: .2s }
        .btn-logout:hover { background-color: #eef2ff; color: #111827 }

        .nav-tabs { border: none; }
        .nav-tabs .nav-link { border: none; color: #6c757d; transition: .2s; padding: 0.85rem 1rem; }
        .nav-tabs .nav-link:hover { color: #007bff }
        .nav-tabs .nav-link.active { font-weight: 600; color: #4A90E2; border-bottom: 3px solid #4A90E2; background: transparent }

        footer {
            color: #6b7280;
            font-size: 0.85rem;
            text-align: center;
            padding: 1.5rem 0;
        }
    </style>
</head>

<body>
    {{-- ====== HEADER PANEL ====== --}}
    <header class="kaprodi-header py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-2">
                <i class="fas fa-user-tie fa-lg"></i>
                <div>
                    <h4 class="mb-0">Panel Kaprodi</h4>
                    <p class="mb-0 small opacity-90">Kelola Data Mahasiswa dan Verifikasi Laporan</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('beranda') }}" class="btn btn-light btn-sm d-flex align-items-center gap-2">
                    <i class="fas fa-arrow-left"></i> <span>Kembali ke Beranda</span>
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-logout d-flex align-items-center gap-2 px-3 py-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- ====== NAV TABS ====== --}}
    <nav class="bg-white shadow-sm mb-4 border-b">
        <div class="container">
            @include('Kaprodi.partials.tabs')
        </div>
    </nav>

    {{-- ====== MAIN CONTENT ====== --}}
    <main class="container mb-5">
        @yield('content')
    </main>

    {{-- ====== FOOTER ====== --}}
    <footer>
        &copy; {{ date('Y') }} Himpunan Mahasiswa Teknologi Informasi Politala
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
