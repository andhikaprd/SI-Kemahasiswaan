@php $role = optional(Auth::user())->role; @endphp
<div class="container">
    @if ($role === 'kaprodi')
        <ul class="nav nav-tabs">
            @can('viewAny', \App\Models\MasalahMahasiswa::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kaprodi.pelanggaran_mahasiswa.*') ? 'active' : '' }}" href="{{ route('kaprodi.pelanggaran_mahasiswa.index') }}">
                        <i class="fas fa-user-times me-2"></i>Pelanggaran Mahasiswa
                    </a>
                </li>
            @endcan
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kaprodi.pelanggaran_master.*') ? 'active' : '' }}" href="{{ route('kaprodi.pelanggaran_master.index') }}">
                    <i class="fas fa-clipboard-list me-2"></i>Master Pelanggaran
                </a>
            </li>
            @can('viewAny', \App\Models\Laporan::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kaprodi.laporan.*') ? 'active' : '' }}" href="{{ route('kaprodi.laporan.index') }}">
                        <i class="fas fa-file-alt me-2"></i>Daftar Laporan
                    </a>
                </li>
            @endcan
            @can('viewAny', \App\Models\Laporan::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kaprodi.verifikasi.*') ? 'active' : '' }}" href="{{ route('kaprodi.verifikasi.index') }}">
                        <i class="fas fa-check-square me-2"></i>Verifikasi Laporan
                    </a>
                </li>
            @endcan
        </ul>
    @else
        <div class="alert alert-warning mb-0">
            Menu kaprodi tidak tersedia untuk role ini.
        </div>
    @endif
</div>
