<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\User; // ganti dari Akun ke User, jika model user default
use App\Models\MahasiswaBerprestasi;
use App\Models\Laporan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerita = Berita::count();
        $totalPengguna = User::count();
        $totalPrestasi = MahasiswaBerprestasi::count();
        $totalLaporan = Laporan::count();

        return view('admin.dashboard.index', [
            'totalBerita' => $totalBerita,
            'totalPengguna' => $totalPengguna,
            'totalPrestasi' => $totalPrestasi,
            'totalLaporan' => $totalLaporan
        ]);
    }
}
