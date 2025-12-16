@extends('Admin.layouts.app')
@section('title','Edit Master Pelanggaran')
@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="mb-3">Edit Master Pelanggaran</h5>
    <form method="POST" action="{{ route('admin.pelanggaran_master.update', $item->id) }}">
      @csrf
      @method('PUT')
      @include('Admin.pelanggaran_master._form', ['item' => $item])
    </form>
  </div>
</div>
@endsection
