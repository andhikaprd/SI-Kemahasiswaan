<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan halaman daftar semua berita.
     */
    public function index()
    {
        // Ambil semua berita yang statusnya 'published'
        // Urutkan dari yang paling baru dan gunakan paginasi (10 berita per halaman)
        $beritas = Berita::where('status', 'published')
                         ->latest('tanggal_publikasi')
                         ->paginate(10);

        return view('user.berita.index', compact('beritas'));
    }

    /**
     * Menampilkan detail dari satu berita.
     * Laravel akan otomatis mencari berita berdasarkan slug di URL.
     */
    public function show(Berita $berita)
    {
        // Pastikan hanya berita yang sudah 'published' yang bisa diakses
        if ($berita->status !== 'published') {
            abort(404); // Tampilkan halaman Not Found jika berita masih draft
        }

        // Kirim data berita yang ditemukan ke view
        return view('user.berita.show', compact('berita'));
    }
}

