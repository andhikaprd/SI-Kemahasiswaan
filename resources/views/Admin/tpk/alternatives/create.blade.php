@extends('Admin.layouts.app')
@section('title','Tambah Alternatif')
@section('content')
<div class="card"><div class="card-body">
  <h5 class="mb-3">Tambah Data Alternatif</h5>
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form method="POST" action="{{ route('admin.tpk.alternatives.store') }}" class="row g-3">
    @csrf
    <div class="col-md-3"><label class="form-label">Kode</label><input name="code" class="form-control" placeholder="A1" value="{{ old('code') }}" required></div>
    <div class="col-md-5"><label class="form-label">Nama</label><input name="name" class="form-control" placeholder="Nama Alternatif" value="{{ old('name') }}" required></div>
    <div class="col-md-12"><label class="form-label">Catatan</label><input name="note" class="form-control" placeholder="Opsional" value="{{ old('note') }}"></div>

    <div class="col-12"><hr><strong>Nilai Kriteria</strong></div>
    @foreach ($criteria as $c)
      <div class="col-md-3">
        <label class="form-label">{{ $c->code }} ({{ $c->name }})</label>
        <input type="number" step="0.0001" name="crit[{{ $c->id }}]" class="form-control" value="{{ old('crit.'.$c->id) }}" placeholder="Nilai">
      </div>
    @endforeach

    <div class="col-12">
      <button class="btn btn-primary">Create</button>
      <a href="{{ route('admin.tpk.alternatives.index') }}" class="btn btn-light">Kembali</a>
    </div>
  </form>
</div></div>
@endsection
