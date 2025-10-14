@extends('Kaprodi.layouts.app')

@section('title', 'Tambah Pelanggaran Mahasiswa')

@section('content')
<div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Pelanggaran Mahasiswa</h2>

    <form method="POST" action="{{ route('kaprodi.pelanggaran_mahasiswa.store') }}">
        @csrf

        {{-- Mahasiswa (select + Select2 agar bisa cari) --}}
        <div class="mb-3">
            <label for="mahasiswa_id" class="block font-medium mb-1">Mahasiswa</label>
            <select id="mahasiswa_id" name="mahasiswa_id" class="border rounded-lg w-full px-3 py-2">
                <option value="" disabled {{ old('mahasiswa_id') ? '' : 'selected' }}>Ketik atau pilih mahasiswa...</option>
                @foreach ($mahasiswas as $m)
                    <option value="{{ $m->id }}" {{ (string)old('mahasiswa_id') === (string)$m->id ? 'selected' : '' }}>
                        {{ $m->nama }} ({{ $m->nim }})
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Semester & IPK --}}
        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label class="block font-medium mb-1">Semester</label>
                <input type="number" name="semester" class="border rounded-lg w-full px-3 py-2" value="{{ old('semester') }}">
            </div>
            <div>
                <label class="block font-medium mb-1">IPK</label>
                <input type="number" step="0.01" max="4" name="ipk" class="border rounded-lg w-full px-3 py-2" value="{{ old('ipk') }}">
            </div>
        </div>

        {{-- Jenis Masalah --}}
        <div class="mt-3">
            <label class="block font-medium mb-1">Jenis Masalah</label>
            <input type="text" name="jenis_masalah" class="border rounded-lg w-full px-3 py-2" value="{{ old('jenis_masalah') }}">
        </div>

        {{-- Status Peringatan --}}
        <div class="mt-3">
            <label class="block font-medium mb-1">Status Peringatan</label>
            <select name="status_peringatan" class="border rounded-lg w-full px-3 py-2">
                <option value="Peringatan 1">Peringatan 1</option>
                <option value="Peringatan 2">Peringatan 2</option>
                <option value="Peringatan 3">Peringatan 3</option>
                <option value="Skorsing">Skorsing</option>
            </select>
        </div>

        {{-- Tanggal Laporan --}}
        <div class="mt-3">
            <label class="block font-medium mb-1">Tanggal Laporan Terakhir</label>
            <input type="date" name="laporan_terakhir" class="border rounded-lg w-full px-3 py-2" value="{{ old('laporan_terakhir') }}">
        </div>

        {{-- Keterangan --}}
        <div class="mt-3">
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3" class="border rounded-lg w-full px-3 py-2">{{ old('keterangan') }}</textarea>
        </div>

        {{-- Tombol --}}
        <div class="mt-5 flex justify-between">
            <a href="{{ route('kaprodi.masalah_mahasiswa.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>

    {{-- Select2 assets dan init (CDN, cukup di halaman ini) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            $('#mahasiswa_id').select2({
                width: '100%',
                placeholder: 'Ketik atau pilih mahasiswa...',
                allowClear: true
            });
        });
    </script>
</div>
@endsection

