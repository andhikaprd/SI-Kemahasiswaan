@extends('Admin.layouts.app')

@section('title','Edit Mahasiswa')

@section('content')
<div class="card">
  <div class="card-body">
    <h5 class="mb-3">Edit Mahasiswa</h5>

    @if ($errors->any())
      <div class="alert alert-danger">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}">
      @csrf
      @method('PUT')

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" value="{{ $mahasiswa->nama }}" disabled />
        </div>
        <div class="col-md-3">
          <label class="form-label">NIM</label>
          <input type="text" class="form-control" value="{{ $mahasiswa->nim }}" disabled />
        </div>
        <div class="col-md-3">
          <label class="form-label">Angkatan</label>
          <input type="text" class="form-control" value="{{ $mahasiswa->angkatan }}" disabled />
        </div>

        <div class="col-md-3">
          <label class="form-label">IPK</label>
          <input type="number" step="0.01" min="0" max="4" name="ipk" value="{{ old('ipk', $mahasiswa->ipk) }}" class="form-control" placeholder="0.00 - 4.00" />
        </div>

        <div class="col-md-3">
          <label class="form-label">Tipe Bahasa Inggris</label>
          <select name="english_type" class="form-select">
            <option value="">-</option>
            @foreach ($englishTypes as $t)
              <option value="{{ $t }}" @selected(old('english_type', $mahasiswa->english_type) === $t)>{{ $t }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-3">
          <label class="form-label">Skor Bahasa Inggris</label>
          <input type="number" step="0.01" min="0" name="english_score" value="{{ old('english_score', $mahasiswa->english_score) }}" class="form-control" placeholder="cth: IELTS 6.5, iBT 60" />
        </div>
      </div>

      <div class="mt-3">
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-light">Kembali</a>
      </div>
    </form>
  </div>
</div>
@endsection

