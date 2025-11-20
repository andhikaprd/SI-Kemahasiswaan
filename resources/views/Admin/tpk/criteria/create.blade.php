@extends('Admin.layouts.app')
@section('title','Tambah Kriteria')
@section('content')
<div class="card"><div class="card-body">
  <h5 class="mb-3">Tambah Data Kriteria</h5>
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form method="POST" action="{{ route('admin.tpk.criteria.store') }}" class="row g-3">
    @csrf
    <div class="col-md-2"><label class="form-label">Kode</label><input name="code" class="form-control" placeholder="C1" value="{{ old('code') }}" required></div>
    <div class="col-md-6"><label class="form-label">Kriteria</label><input name="name" class="form-control" placeholder="Nama Kriteria" value="{{ old('name') }}" required></div>
    <div class="col-md-2"><label class="form-label">Nilai Bobot</label><input name="weight" type="number" step="0.01" class="form-control" placeholder="50" value="{{ old('weight') }}" required></div>
    <div class="col-md-2"><label class="form-label">Jenis</label>
      <select name="type" class="form-select" required>
        <option value="benefit" @selected(old('type')==='benefit')>Benefit</option>
        <option value="cost" @selected(old('type')==='cost')>Cost</option>
      </select>
    </div>
    <div class="col-md-2"><label class="form-label">Urutan</label><input name="order" type="number" min="0" class="form-control" value="{{ old('order',0) }}"></div>
    <div class="col-12">
      <button class="btn btn-primary">Create</button>
      <a class="btn btn-light" href="{{ route('admin.tpk.criteria.index') }}">Kembali</a>
    </div>
  </form>
</div></div>
@endsection
