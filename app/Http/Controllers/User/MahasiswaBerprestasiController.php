<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi; // Pastikan Model ini sudah ada
use Illuminate\Http\Request;

class MahasiswaBerprestasiController extends Controller
{
    /**
     * Menampilkan halaman daftar prestasi mahasiswa.
     */
    public function index()
    {
        // Ambil semua data prestasi, urutkan dari yang terbaru, dan gunakan paginasi
        $prestasi = MahasiswaBerprestasi::latest('tanggal_perolehan')->paginate(10);

        // Kirim data ke view
        return view('user.mahasiswa_berprestasi', compact('prestasi'));
    }
}
