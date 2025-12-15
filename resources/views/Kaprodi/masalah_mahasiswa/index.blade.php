@extends('Kaprodi.layouts.app')

@section('title', 'Pelanggaran Mahasiswa')

@section('content')
{{-- Hapus baris berikut karena sudah ada di layout --}}
{{-- @include('kaprodi.partials.header') --}}
{{-- @include('kaprodi.partials.tabs') --}}

<div class="bg-white shadow rounded-xl p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Daftar Pelanggaran Mahasiswa</h2>
        <a href="{{ route('kaprodi.pelanggaran_mahasiswa.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form method="GET" class="mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau NIM..."
               class="border rounded-lg px-4 py-2 w-full md:w-1/3">
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border">
            <thead class="bg-gray-50">
                <tr class="text-left text-gray-700">
                    <th class="px-4 py-2">Nama Mahasiswa</th>
                    <th class="px-4 py-2">NIM</th>
                    <th class="px-4 py-2 text-center">Semester/IPK</th>
                    <th class="px-4 py-2">Jenis Masalah</th>
                    <th class="px-4 py-2 text-center">Status</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kasus as $row)
                    <tr class="border-t">
                        <td class="px-4 py-2 font-medium">{{ $row->mahasiswa->nama ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $row->mahasiswa->nim ?? '-' }}</td>
                        <td class="px-4 py-2 text-center">
                            {{ $row->semester ?? '-' }} /
                            <span class="text-red-600 font-semibold">{{ $row->ipk ?? '-' }}</span>
                        </td>
                        <td class="px-4 py-2">{{ $row->jenis_masalah }}</td>
                        <td class="px-4 py-2 text-center">
                            <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">
                                {{ $row->status_peringatan }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('kaprodi.pelanggaran_mahasiswa.show', $row->id) }}" 
                                   class="text-blue-600 hover:text-blue-800" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('kaprodi.pelanggaran_mahasiswa.edit', $row->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-800" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('kaprodi.pelanggaran_mahasiswa.destroy', $row->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Yakin hapus data ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3 text-gray-500">
                            Tidak ada data pelanggaran.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $kasus->links() }}</div>
</div>
@endsection
