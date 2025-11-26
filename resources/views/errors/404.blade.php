<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body text-center py-5">
                        <div class="display-4 text-primary mb-3">404</div>
                        <h4 class="mb-2">Halaman tidak ditemukan</h4>
                        <p class="text-muted mb-4">Link yang Anda akses mungkin sudah dipindah atau tidak tersedia.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Kembali</a>
                            <a href="{{ route('beranda') }}" class="btn btn-primary">Ke Beranda</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
