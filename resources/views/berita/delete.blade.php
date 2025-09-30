@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Hapus Berita</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="alert alert-danger">
        <strong>Perhatian!</strong> Apakah Anda yakin ingin menghapus berita ini?
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <h4>{{ $berita->judul }}</h4>
            <p>{{ Str::limit($berita->isi, 200) }}</p>
            @if($berita->gambar)
                <img src="{{ asset('storage/'.$berita->gambar) }}" 
                     alt="Gambar Berita" 
                     class="mt-2 img-thumbnail" 
                     width="200">
            @endif
        </div>
    </div>

    <form action="{{ route('berita.destroy', $berita->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Ya, Hapus
        </button>
        <a href="{{ route('berita.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
