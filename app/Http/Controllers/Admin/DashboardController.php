<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// 1. IMPORT SEMUA MODEL YANG DIPERLUKAN
use App\Models\Berita;
use App\Models\Akun; // Ganti dengan model Akun/User Anda
use App\Models\MahasiswaBerprestasi; // Ganti dengan model Prestasi Anda
use App\Models\Laporan; // Ganti dengan model Laporan Anda

class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard admin dengan data statistik.
     */
    public function index()
    {
        // 2. HITUNG JUMLAH DATA DARI SETIAP MODEL
        $totalBerita = Berita::count();
        $totalPengguna = Akun::count(); // Ganti 'Akun' jika nama model Anda berbeda
        $totalPrestasi = MahasiswaBerprestasi::count(); // Ganti 'MahasiswaBerprestasi' jika nama model Anda berbeda
        $totalLaporan = Laporan::count(); // Ganti 'Laporan' jika nama model Anda berbeda

        // 3. KIRIM DATA KE VIEW
        return view('admin.dashboard', [
            'totalBerita' => $totalBerita,
            'totalPengguna' => $totalPengguna,
            'totalPrestasi' => $totalPrestasi,
            'totalLaporan' => $totalLaporan
        ]);
    }
}
