@extends('layouts.app')

@section('title', 'Detail Mahasiswa Bermasalah')

@section('content')
@include('Kaprodi.partials.header')
@include('Kaprodi.partials.tabs')

<div class="bg-white shadow rounded-xl p-6 max-w-2xl mx-auto">
    <h2 class="text-xl font-bold mb-4">Detail Mahasiswa Bermasalah</h2>

    <div class="grid gap-3">
        <p><strong>Nama:</strong> {{ $kasus->mahasiswa->nama ?? '-' }}</p>
        <p><strong>NIM:</strong> {{ $kasus->mahasiswa->nim ?? '-' }}</p>
        <p><strong>Semester:</strong> {{ $kasus->semester }}</p>
        <p><strong>IPK:</strong> {{ $kasus->ipk }}</p>
        <p><strong>Jenis Masalah:</strong> {{ $kasus->jenis_masalah }}</p>
        <p><strong>Status Peringatan:</strong> {{ $kasus->status_peringatan }}</p>
        <p><strong>Laporan Terakhir:</strong> {{ $kasus->laporan_terakhir?->format('Y-m-d') }}</p>
        <p><strong>Keterangan:</strong> {{ $kasus->keterangan }}</p>
    </div>

    <div class="mt-5 text-right">
        <a href="{{ route('kaprodi.masalah_mahasiswa.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">Kembali</a>
    </div>
</div>
@endsection
