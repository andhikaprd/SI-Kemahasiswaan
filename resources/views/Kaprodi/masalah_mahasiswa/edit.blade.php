@extends('layouts.app')

@section('title', 'Edit Mahasiswa Bermasalah')

@section('content')
@include('Kaprodi.partials.header')
@include('Kaprodi.partials.tabs')

<div class="bg-white shadow rounded-xl p-6 max-w-3xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Edit Data Mahasiswa Bermasalah</h2>

    <form method="POST" action="{{ route('kaprodi.masalah_mahasiswa.update', $kasus->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="block font-medium mb-1">Mahasiswa</label>
            <select name="mahasiswa_id" class="border rounded-lg w-full px-3 py-2">
                @foreach ($mahasiswas as $m)
                    <option value="{{ $m->id }}" {{ $kasus->mahasiswa_id == $m->id ? 'selected' : '' }}>
                        {{ $m->nama }} ({{ $m->nim }})
                    </option>
                @endforeach
            </select>
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
            <a href="{{ route('kaprodi.masalah_mahasiswa.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700">Update</button>
        </div>
    </form>
</div>
@extends('Kaprodi.layouts.app')

