@extends('Kaprodi.layouts.app')

@section('title', 'Edit Master Pelanggaran')

@section('content')
<div class="bg-white shadow rounded-xl p-6">
    <h2 class="text-xl font-semibold mb-4">Edit Master Pelanggaran</h2>
    <form method="POST" action="{{ route('kaprodi.pelanggaran_master.update', $item->id) }}">
        @csrf
        @method('PUT')
        @include('Kaprodi.pelanggaran_master._form', ['item' => $item])
    </form>
</div>
@endsection
