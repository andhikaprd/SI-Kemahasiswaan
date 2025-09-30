@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hapus Berita</h1>

    <div class="alert alert-danger">
        <strong>Perhatian!</strong> Anda yakin ingin menghapus berita ini?
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h4>{{ $berita->judul }}</h4>
            <p>{{ $berita->isi }}</p>
            @if($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" width="200" class="mt-2">
            @endif
        </div>
    </div>

    <form action="{{ route('berita.destroy', $berita->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
