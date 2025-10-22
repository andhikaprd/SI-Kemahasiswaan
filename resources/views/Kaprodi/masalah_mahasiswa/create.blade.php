@extends('Kaprodi.layouts.app')

@section('title', 'Tambah Pelanggaran Mahasiswa')

@section('content')
<div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Tambah Pelanggaran Mahasiswa</h2>

    <div class="alert alert-info mb-4">
        <strong>Mode Input:</strong>
        <label class="ms-2 me-3"><input type="radio" name="mode" value="single" checked> Satu Data</label>
        <label><input type="radio" name="mode" value="bulk"> Banyak (sekali submit)</label>
    </div>

    <form method="POST" action="{{ route('kaprodi.pelanggaran_mahasiswa.store') }}">
        @csrf

        {{-- Pilih Mahasiswa (mode Satu Data) --}}
        <div class="mb-3" id="wrap-single">
            <label class="block font-medium mb-1">Mahasiswa</label>
            <select id="mahasiswa_id_single" name="mahasiswa_id" class="border rounded-lg w-full px-3 py-2">
                <option value="" selected disabled>Pilih satu mahasiswa...</option>
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

        {{-- Pilih Mahasiswa (mode Banyak) --}}
        <div class="mb-3" id="wrap-bulk" style="display:none">
            <label class="block font-medium mb-1">Mahasiswa (bisa pilih banyak)</label>
            <select id="mahasiswa_id_multi" name="mahasiswa_id[]" multiple class="border rounded-lg w-full px-3 py-2" disabled>
                @foreach ($mahasiswas as $m)
                    <option value="{{ $m->id }}" {{ collect(old('mahasiswa_id', []))->contains($m->id) ? 'selected' : '' }}>
                        {{ $m->nama }} ({{ $m->nim }})
                    </option>
                @endforeach
            </select>
            @error('mahasiswa_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
            @error('mahasiswa_id.*')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
            <p class="text-sm text-gray-500 mt-1">Pilih beberapa mahasiswa lalu isi detail yang sama di bawah. Sistem akan membuat satu entri untuk setiap mahasiswa terpilih.</p>
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
            <label class="block font-medium mb-1">Jenis Pelanggaran</label>
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

    {{-- Select2 assets dan init (CDN) --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(function () {
            const $single = $('#mahasiswa_id_single');
            const $multi = $('#mahasiswa_id_multi');
            const $wrapSingle = $('#wrap-single');
            const $wrapBulk = $('#wrap-bulk');
            const radios = $('input[name="mode"]');

            $single.select2({ width: '100%', placeholder: 'Pilih satu mahasiswa...', allowClear: true });
            $multi.select2({ width: '100%', placeholder: 'Pilih beberapa mahasiswa...', allowClear: true });

            function updateMode() {
                const v = $('input[name="mode"]:checked').val();
                if (v === 'single') {
                    $wrapSingle.show();
                    $wrapBulk.hide();
                    $multi.prop('disabled', true);
                    $single.prop('disabled', false);
                } else {
                    $wrapSingle.hide();
                    $wrapBulk.show();
                    $multi.prop('disabled', false);
                    $single.prop('disabled', true);
                }
            }
            radios.on('change', updateMode);
            updateMode();
        });
    </script>
</div>
@endsection
