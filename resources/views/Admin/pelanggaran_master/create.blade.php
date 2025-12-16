@extends('Admin.layouts.app')
@section('title','Tambah Master Pelanggaran')
@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="mb-3">Tambah Master Pelanggaran</h5>
    <form method="POST" action="{{ route('admin.pelanggaran_master.store') }}">
      @csrf
      @include('Admin.pelanggaran_master._form')
    </form>
  </div>
</div>
@endsection
