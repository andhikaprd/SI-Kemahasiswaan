@extends('Kaprodi.layouts.app')

@section('title', 'Tambah Master Pelanggaran')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-semibold mb-4">Tambah Master Pelanggaran</h2>
    <form method="POST" action="{{ route('kaprodi.pelanggaran_master.store') }}">
        @csrf
        @include('Kaprodi.pelanggaran_master._form')
    </form>
</div>
@endsection
