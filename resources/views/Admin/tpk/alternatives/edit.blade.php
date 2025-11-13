@extends('Admin.layouts.app')
@section('title','Edit Alternatif')
@section('content')
<div class="card"><div class="card-body">
  <h5 class="mb-3">Edit Data Alternatif</h5>
  @if ($errors->any())<div class="alert alert-danger">@foreach($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
  <form method="POST" action="{{ route('admin.tpk.alternatives.update', $alternative->id) }}" class="row g-3">
    @csrf @method('PUT')
    <div class="col-md-3"><label class="form-label">Kode</label><input name="code" class="form-control" value="{{ old('code',$alternative->code) }}" required></div>
    <div class="col-md-5"><label class="form-label">Nama</label><input name="name" class="form-control" value="{{ old('name',$alternative->name) }}" required></div>
    <div class="col-md-12"><label class="form-label">Catatan</label><input name="note" class="form-control" value="{{ old('note',$alternative->note) }}"></div>

    <div class="col-12"><hr><strong>Nilai Kriteria</strong></div>
    @foreach ($criteria as $c)
      <div class="col-md-3">
        <label class="form-label">{{ $c->code }} ({{ $c->name }})</label>
        <input type="number" step="0.0001" name="crit[{{ $c->id }}]" class="form-control" value="{{ old('crit.'.$c->id, $values[$c->id] ?? '') }}" placeholder="Nilai">
      </div>
    @endforeach

    <div class="col-12">
      <button class="btn btn-primary">Simpan</button>
      <a href="{{ route('admin.tpk.alternatives.index') }}" class="btn btn-light">Kembali</a>
    </div>
  </form>
</div></div>
@endsection

