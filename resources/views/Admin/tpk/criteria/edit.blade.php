@extends('Admin.layouts.app')
@section('title','Edit Kriteria')
@section('content')
<div class="card"><div class="card-body">
  <h5 class="mb-3">Edit Data Kriteria</h5>
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form method="POST" action="{{ route('admin.tpk.criteria.update', $criterion->id) }}" class="row g-3">
    @csrf @method('PUT')
    <div class="col-md-2"><label class="form-label">Kode</label><input name="code" class="form-control" value="{{ old('code',$criterion->code) }}" required></div>
    <div class="col-md-6"><label class="form-label">Kriteria</label><input name="name" class="form-control" value="{{ old('name',$criterion->name) }}" required></div>
    <div class="col-md-2"><label class="form-label">Nilai Bobot</label><input name="weight" type="number" step="0.01" class="form-control" value="{{ old('weight',$criterion->weight) }}" required></div>
    <div class="col-md-2"><label class="form-label">Jenis</label>
      <select name="type" class="form-select" required>
        <option value="benefit" @selected(old('type',$criterion->type)==='benefit')>Benefit</option>
        <option value="cost" @selected(old('type',$criterion->type)==='cost')>Cost</option>
      </select>
    </div>
    <div class="col-md-2"><label class="form-label">Urutan</label><input name="order" type="number" min="0" class="form-control" value="{{ old('order',$criterion->order) }}"></div>
    <div class="col-12">
      <button class="btn btn-primary">Simpan</button>
      <a class="btn btn-light" href="{{ route('admin.tpk.criteria.index') }}">Kembali</a>
    </div>
  </form>
</div></div>
@endsection

