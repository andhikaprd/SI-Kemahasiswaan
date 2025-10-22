@extends('Kaprodi.layouts.app')

@section('title', 'Verifikasi Laporan')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Laporan Menunggu Verifikasi</h2>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Jika belum ada laporan --}}
    @if ($laporans->isEmpty())
        <p class="text-gray-500 text-center py-6">
            Belum ada laporan yang menunggu verifikasi.
        </p>
    @else
        <div class="space-y-4">
            @foreach ($laporans as $laporan)
                <div class="border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition">
                    <div class="flex justify-between items-start">
                        {{-- ======================== BAGIAN KIRI ======================== --}}
                        <div>
                            {{-- Judul --}}
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                                <i class="fas fa-file-alt text-blue-600"></i>
                                {{ $laporan->judul }}
                            </h3>

                            {{-- Kategori & Periode --}}
                            <p class="text-sm text-gray-500">
                                {{ $laporan->kategori ?? '-' }} • {{ $laporan->periode ?? '-' }}
                            </p>

                            {{-- Mahasiswa --}}
                            <p class="mt-2 text-sm leading-relaxed">
                                <strong>Mahasiswa:</strong> {{ $laporan->mahasiswa->nama ?? 'Nama tidak ditemukan' }}<br>
                                <strong>NIM:</strong> {{ $laporan->mahasiswa->nim ?? '-' }}
                            </p>

                            {{-- Mata Kuliah --}}
                            <p class="text-sm text-gray-600 mt-1">
                                <strong>Mata Kuliah:</strong> {{ $laporan->mataKuliah->nama ?? '-' }}
                            </p>

                            {{-- Deskripsi --}}
                            <p class="mt-2 text-sm text-gray-700">
                                {{ $laporan->deskripsi ?? 'Deskripsi laporan belum tersedia.' }}
                            </p>

                            {{-- Link File --}}
                            @if ($laporan->file_path)
                                <a href="{{ route('kaprodi.verifikasi.download', $laporan) }}" 
                                   class="text-blue-600 text-sm mt-3 inline-flex items-center gap-1 hover:underline">
                                    <i class="fas fa-download"></i> Unduh File
                                </a>
                            @endif
                        </div>

                        {{-- ======================== BAGIAN KANAN ======================== --}}
                        <div class="text-right text-sm text-gray-500">
                            {{-- Tanggal Submit --}}
                            <p>
                                <strong>Tanggal Submit:</strong>
                                {{ $laporan->tanggal_submit?->format('Y-m-d H:i') ?? '-' }}
                            </p>

                            {{-- Status --}}
                            @php
                                $status = strtolower($laporan->status);
                                $color = match($status) {
                                    'pending' => 'bg-yellow-100 text-yellow-700',
                                    'approved' => 'bg-green-100 text-green-700',
                                    'revisi' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700'
                                };
                            @endphp
                            <p class="mt-1">
                                <strong>Status:</strong>
                                <span class="px-2 py-1 text-xs rounded-full {{ $color }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- ======================== TOMBOL AKSI ======================== --}}
                    <div class="flex justify-end gap-2 mt-4">
                        <form action="{{ route('kaprodi.verifikasi.tolak', $laporan->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-red-50 text-red-600 border border-red-300 rounded-lg hover:bg-red-100 transition">
                                <i class="fas fa-times mr-1"></i> Revisi
                            </button>
                        </form>

                        <form action="{{ route('kaprodi.verifikasi.setujui', $laporan->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                <i class="fas fa-check mr-1"></i> Setujui
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
