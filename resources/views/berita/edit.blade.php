@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Berita</h1>

    {{-- Tampilkan error jika ada --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
        @csrf 
        @method('PUT')

        <div class="mb-3">
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" class="form-control" 
                   value="{{ old('judul', $berita->judul) }}" required>
        </div>

        <div class="mb-3">
            <label for="isi">Isi</label>
            <textarea id="isi" name="isi" class="form-control" rows="5" required>{{ old('isi', $berita->isi) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="gambar">Gambar (opsional)</label><br>
            @if($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" width="150" class="mb-2 img-thumbnail"><br>
            @endif
            <input type="file" id="gambar" name="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
