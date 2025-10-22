<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kaprodi.pelanggaran_mahasiswa.*') ? 'active' : '' }}" href="{{ route('kaprodi.pelanggaran_mahasiswa.index') }}">
                <i class="fas fa-user-times me-2"></i>Pelanggaran Mahasiswa
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kaprodi.laporan.*') ? 'active' : '' }}" href="{{ route('kaprodi.laporan.index') }}">
                <i class="fas fa-file-alt me-2"></i>Daftar Laporan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('kaprodi.verifikasi.*') ? 'active' : '' }}" href="{{ route('kaprodi.verifikasi.index') }}">
                <i class="fas fa-check-square me-2"></i>Verifikasi Laporan
            </a>
        </li>
    </ul>
</div>
