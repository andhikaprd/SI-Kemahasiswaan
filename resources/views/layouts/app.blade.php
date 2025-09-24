{{-- File: resources/views/layouts/app.blade.php --}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'HIMA TI Politala')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <header class="header">
        <div class="container navbar">
            <a href="/" class="logo"><i class="fas fa-university"></i></a>
            <nav>
                <ul class="nav-links">
                    <li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
                    <li><a href="#">Divisi</a></li>
                    <li><a href="#">Pendaftaran</a></li>
                    <li><a href="#">Berita</a></li>
                    <li><a href="#">Profil</a></li>
                    <li><a href="#">Prestasi Mahasiswa</a></li>
                </ul>
            </nav>
            <a href="#" class="login-btn">Login</a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 HIMA TI - Himpunan Mahasiswa Teknologi Informasi</p>
        </div>
    </footer>

</body>
</html>