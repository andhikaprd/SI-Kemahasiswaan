<div class="bg-white shadow-sm border-b rounded-t-xl">
    <div class="flex flex-wrap items-center gap-1 sm:gap-4 px-4 py-2 sm:px-6">
        {{-- Tab: Mahasiswa Bermasalah --}}
        <a href="{{ route('kaprodi.masalah_mahasiswa.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200
           {{ request()->routeIs('kaprodi.masalah_mahasiswa.*') 
               ? 'bg-blue-600 text-white shadow-sm' 
               : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-user-exclamation"></i>
            <span>Mahasiswa Bermasalah</span>
        </a>

        {{-- Tab: Daftar Laporan --}}
        <a href="{{ route('kaprodi.laporan.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200
           {{ request()->routeIs('kaprodi.laporan.*') 
               ? 'bg-blue-600 text-white shadow-sm' 
               : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-file-alt"></i>
            <span>Daftar Laporan</span>
        </a>

        {{-- Tab: Verifikasi Laporan --}}
        <a href="{{ route('kaprodi.verifikasi.index') }}"
           class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200
           {{ request()->routeIs('kaprodi.verifikasi.*') 
               ? 'bg-blue-600 text-white shadow-sm' 
               : 'text-gray-700 hover:bg-gray-100' }}">
            <i class="fas fa-check-square"></i>
            <span>Verifikasi Laporan</span>
        </a>
    </div>
</div>
