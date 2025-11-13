@extends('Kaprodi.layouts.app')

@section('title', 'Edit Laporan')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Laporan</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-3">
            <ul class="list-disc ms-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kaprodi.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="judul" value="{{ old('judul', $laporan->judul) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Periode</label>
                <input type="text" name="periode" value="{{ old('periode', $laporan->periode) }}" class="mt-1 w-full border rounded-lg px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    @foreach(['Prestasi','Akademik','Kegiatan Kemahasiswaan'] as $opt)
                        <option value="{{ $opt }}" {{ old('kategori', $laporan->kategori)===$opt?'selected':'' }}>{{ $opt }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" class="mt-1 w-full border rounded-lg px-3 py-2" required>
                    @foreach(['pending'=>'Pending','approved'=>'Disetujui','revisi'=>'Revisi'] as $val=>$label)
                        <option value="{{ $val }}" {{ old('status', $laporan->status)===$val?'selected':'' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Ganti File (PDF)</label>
                <input type="file" name="file_laporan" accept=".pdf" class="mt-1 w-full border rounded-lg px-3 py-2">
                @if($laporan->file_path)
                    <a href="{{ route('kaprodi.laporan.download', $laporan->id) }}" target="_blank" class="text-blue-600 text-sm inline-block mt-1">Lihat/Unduh file saat ini</a>
                @endif
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="mt-1 w-full border rounded-lg px-3 py-2">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
        </div>

        <div class="flex justify-end gap-2">
            <a href="{{ route('kaprodi.laporan.index') }}" class="px-4 py-2 bg-gray-100 rounded-lg">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan Perubahan</button>
        </div>
    </form>
</div>
@endsection
