<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Berita; // Kita butuh model Berita untuk mengambil berita terbaru
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Menampilkan halaman beranda untuk user.
     */
    public function index()
    {
        // Ambil 3 berita terbaru yang statusnya 'published'
        $beritaTerbaru = Berita::where('status', 'published')
                               ->latest('tanggal_publikasi')
                               ->take(3)
                               ->get();

        // Di sini Anda juga bisa mengambil data lain seperti jumlah mahasiswa,
        // jumlah prestasi, dll. untuk ditampilkan di halaman beranda.

        // Kirim data berita terbaru ke view
        return view('user.beranda', [
            'beritaTerbaru' => $beritaTerbaru
        ]);
    }
}

