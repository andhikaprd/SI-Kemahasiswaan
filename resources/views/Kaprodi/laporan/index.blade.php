@extends('Kaprodi.layouts.app')

@section('title', 'Daftar Laporan')

@section('content')
<div class="bg-white shadow rounded-xl p-6">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-5 pb-4 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Laporan Mahasiswa</h2>
            <p class="text-gray-500 text-sm">Kelola data laporan dan status verifikasinya.</p>
        </div>
        <a href="{{ route('kaprodi.laporan.create') }}"
           class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            <i class="fas fa-plus-circle mr-1"></i> Tambah Laporan
        </a>
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter & Pencarian --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
        <div class="relative w-full sm:w-1/3">
            <input type="text" placeholder="Cari laporan..."
                class="w-full border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:ring focus:ring-blue-100 focus:border-blue-400">
            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
        </div>

        <select class="border border-gray-300 rounded-lg px-3 py-2 focus:ring focus:ring-blue-100 focus:border-blue-400">
            <option value="all">Semua Status</option>
            <option value="pending">Menunggu Verifikasi</option>
            <option value="approved">Disetujui</option>
            <option value="revisi">Perlu Revisi</option>
        </select>
    </div>

    {{-- Tabel Laporan --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Laporan</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Mahasiswa</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Tanggal Submit</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold">Status</th>
                    <th class="py-3 px-4 text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($laporans as $laporan)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">{{ $laporan->judul }}</div>
                            <div class="text-sm text-gray-500">{{ $laporan->kategori ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div class="font-medium text-gray-800">{{ $laporan->mahasiswa->nama ?? '-' }}</div>
                            <div class="text-sm text-gray-500">{{ $laporan->mahasiswa->nim ?? '-' }}</div>
                        </td>
                        <td class="py-3 px-4 text-gray-700">
                            {{ $laporan->tanggal_submit ? $laporan->tanggal_submit->format('Y-m-d H:i') : '-' }}
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $status = $laporan->status;
                                $color = match($status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'revisi' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                $label = match($status) {
                                    'pending' => 'Menunggu Verifikasi',
                                    'approved' => 'Disetujui',
                                    'revisi' => 'Perlu Revisi',
                                    default => 'Belum Ditetapkan',
                                };
                            @endphp
                            <span class="px-3 py-1 text-xs font-medium rounded-full {{ $color }}">
                                {{ $label }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('kaprodi.laporan.edit', $laporan->id) }}"
                                   class="text-blue-600 hover:text-blue-800" title="Edit">
                                   <i class="fas fa-edit"></i>
                                </a>
                                @if ($laporan->file_path)
                                    <a href="{{ asset('storage/' . $laporan->file_path) }}"
                                       class="text-gray-600 hover:text-gray-800" title="Unduh">
                                       <i class="fas fa-download"></i>
                                    </a>
                                @endif
                                <form action="{{ route('kaprodi.laporan.destroy', $laporan->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-gray-500">
                            Belum ada laporan yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $laporans->links() }}
    </div>
</div>
@endsection
