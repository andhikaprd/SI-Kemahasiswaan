@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Berita</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('berita.create') }}" class="btn btn-primary mb-3">+ Tambah Berita</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Isi</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($beritas as $berita)
                <tr>
                    <td>{{ $berita->judul }}</td>
                    <td>{{ Str::limit($berita->isi, 50) }}</td>
                    <td>
                        @if($berita->gambar)
                            <img src="{{ asset('storage/'.$berita->gambar) }}" width="100">
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('berita.edit', $berita->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('berita.destroy', $berita->id) }}" method="POST" style="display:inline;">
                            @csrf 
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus berita ini?')" class="btn btn-danger btn-sm">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Belum ada berita.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
