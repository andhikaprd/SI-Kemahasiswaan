@extends('Kaprodi.layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'Master Pelanggaran')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="text-xl font-semibold">Master Pelanggaran</h2>
            <p class="text-sm text-gray-500">Daftar referensi yang digunakan saat input pelanggaran mahasiswa.</p>
        </div>
        <a href="{{ route('kaprodi.pelanggaran_master.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i>Tambah
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-700">
                    <th class="px-4 py-2 w-12">#</th>
                    <th class="px-4 py-2">Nama</th>
                    <th class="px-4 py-2">Kategori</th>
                    <th class="px-4 py-2">Sanksi Default</th>
                    <th class="px-4 py-2 text-center w-36">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i => $item)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $i+1 }}</td>
                        <td class="px-4 py-2">
                            <div class="font-semibold">{{ $item->nama }}</div>
                            @if($item->deskripsi)
                                <div class="text-gray-500 text-xs">{{ Str::limit($item->deskripsi, 120) }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                {{ $item->kategori === 'berat' ? 'bg-red-100 text-red-700' : ($item->kategori === 'sedang' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($item->kategori) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $item->sanksi_default ?: '—' }}</td>
                        <td class="px-4 py-2 text-center">
                            <a href="{{ route('kaprodi.pelanggaran_master.edit', $item->id) }}" class="text-blue-600 hover:text-blue-800 mr-2"><i class="fas fa-pen"></i></a>
                            <form action="{{ route('kaprodi.pelanggaran_master.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus master ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500">Belum ada data master.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
