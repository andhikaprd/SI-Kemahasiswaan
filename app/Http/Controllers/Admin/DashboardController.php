<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\User; // ganti dari Akun ke User, jika model user default
use App\Models\MahasiswaBerprestasi;
use App\Models\Laporan;
use App\Models\PrestasiCertificate;
use App\Models\Pendaftaran;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBerita         = Berita::count();
        $totalPengguna       = User::count();
        $totalPrestasi       = MahasiswaBerprestasi::count();
        $totalLaporan        = Laporan::count();
        $laporanPending      = Laporan::where('status', 'pending')->count();
        $totalSertifikat     = PrestasiCertificate::count();
        $pendingSertifikat   = PrestasiCertificate::where('status', 'pending')->count();
        $totalPendaftaran    = Pendaftaran::count();
        $pendingPendaftaran  = Pendaftaran::where('status', 'Pending')->count();

        return view('Admin.dashboard.index', [
            'totalBerita'         => $totalBerita,
            'totalPengguna'       => $totalPengguna,
            'totalPrestasi'       => $totalPrestasi,
            'totalLaporan'        => $totalLaporan,
            'laporanPending'      => $laporanPending,
            'totalSertifikat'     => $totalSertifikat,
            'pendingSertifikat'   => $pendingSertifikat,
            'totalPendaftaran'    => $totalPendaftaran,
            'pendingPendaftaran'  => $pendingPendaftaran,
        ]);
    }
}
