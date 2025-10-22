@extends('Kaprodi.layouts.app')

@section('title', 'Edit Pelanggaran Mahasiswa')

@section('content')
<div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Data Pelanggaran Mahasiswa</h2>

    <form method="POST" action="{{ route('kaprodi.pelanggaran_mahasiswa.update', $kasus->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="mahasiswa_id" class="block font-medium mb-1">Mahasiswa</label>
            <select id="mahasiswa_id" name="mahasiswa_id" class="border rounded-lg w-full px-3 py-2">
                @foreach ($mahasiswas as $m)
                    <option value="{{ $m->id }}" {{ (string)$kasus->mahasiswa_id === (string)$m->id ? 'selected' : '' }}>
                        {{ $m->nama }} ({{ $m->nim }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label class="block font-medium mb-1">Tambahkan juga ke Mahasiswa (opsional)</label>
            <select id="tambahkan_mahasiswa_ids" name="tambahkan_mahasiswa_ids[]" class="border rounded-lg w-full px-3 py-2" multiple>
                @foreach ($mahasiswas as $m)
                    <option value="{{ $m->id }}">{{ $m->nama }} ({{ $m->nim }})</option>
                @endforeach
            </select>
            <p class="text-sm text-gray-500 mt-1">Sistem akan membuat salinan pelanggaran ini untuk setiap mahasiswa yang dipilih.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-3">
            <div>
                <label class="block font-medium mb-1">Semester</label>
                <input type="number" name="semester" value="{{ $kasus->semester }}" class="border rounded-lg w-full px-3 py-2">
            </div>
            <div>
                <label class="block font-medium mb-1">IPK</label>
                <input type="number" step="0.01" max="4" name="ipk" value="{{ $kasus->ipk }}" class="border rounded-lg w-full px-3 py-2">
            </div>
        </div>

        <div class="mt-3">
            <label class="block font-medium mb-1">Jenis Masalah</label>
            <input type="text" name="jenis_masalah" value="{{ $kasus->jenis_masalah }}" class="border rounded-lg w-full px-3 py-2">
        </div>

        <div class="mt-3">
            <label class="block font-medium mb-1">Status Peringatan</label>
            <select name="status_peringatan" class="border rounded-lg w-full px-3 py-2">
                @foreach (['Peringatan 1','Peringatan 2','Peringatan 3','Skorsing'] as $opt)
                    <option value="{{ $opt }}" {{ $kasus->status_peringatan == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                @endforeach
            </select>
        </div>

        <div class="mt-3">
            <label class="block font-medium mb-1">Tanggal Laporan Terakhir</label>
            <input type="date" name="laporan_terakhir" value="{{ $kasus->laporan_terakhir?->format('Y-m-d') }}" class="border rounded-lg w-full px-3 py-2">
        </div>

        <div class="mt-3">
            <label class="block font-medium mb-1">Keterangan</label>
            <textarea name="keterangan" rows="3" class="border rounded-lg w-full px-3 py-2">{{ $kasus->keterangan }}</textarea>
        </div>

        <div class="mt-5 flex justify-between">
            <a href="{{ route('kaprodi.masalah_mahasiswa.index') }}" class="text-gray-600 hover:underline">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Update</button>
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
            $('#tambahkan_mahasiswa_ids').select2({
                width: '100%',
                placeholder: 'Pilih tambahan mahasiswa',
                allowClear: true
            });
        });
    </script>
</div>
@endsection
