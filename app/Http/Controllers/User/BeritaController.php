<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    // Daftar berita untuk publik (hanya yang published)
    public function index()
    {
        $beritas = Berita::where('status', 'published')
            ->latest('tanggal_publikasi')
            ->paginate(10);

        return view('user.berita.index', compact('beritas'));
    }

    // Detail berita via slug; 404 jika belum published
    public function show(Berita $berita)
    {
        if ($berita->status !== 'published') {
            abort(404);
        }

        return view('user.berita.show', compact('berita'));
    }
}
