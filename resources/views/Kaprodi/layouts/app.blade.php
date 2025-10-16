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

    {{-- Tailwind (CDN agar tidak error tanpa Vite) --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Inter', sans-serif;
        }
        .kaprodi-header {
            background-color: #2563eb;
            color: white;
        }
        .kaprodi-header h4 {
            font-weight: 700;
        }
        .btn-logout {
            background: white;
            color: #2563eb;
            font-weight: 500;
            border-radius: 8px;
            transition: 0.2s;
        }
        .btn-logout:hover {
            background-color: #e0e7ff;
            color: #1e3a8a;
        }
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
        <div class="container d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="mb-0">Panel Kaprodi</h4>
                <p class="mb-0 small opacity-90">Kelola Data Mahasiswa dan Verifikasi Laporan</p>
            </div>

            {{-- Tombol Logout --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-logout d-flex align-items-center gap-2 px-3 py-2">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </header>

    {{-- ====== NAV TABS ====== --}}
    <nav class="bg-white shadow-sm mb-4 border-b">
        @include('kaprodi.partials.tabs')
    </nav>

    {{-- ====== MAIN CONTENT ====== --}}
    <main class="container mb-5">
        @yield('content')
    </main>

    {{-- ====== FOOTER ====== --}}
    <footer>
        © {{ date('Y') }} Himpunan Mahasiswa Teknologi Informasi Politala
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
