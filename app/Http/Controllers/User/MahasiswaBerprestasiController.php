<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use Illuminate\Http\Request;

class MahasiswaBerprestasiController extends Controller
{
    public function index(Request $r)
    {
        $base = MahasiswaBerprestasi::published();

        // untuk kartu statistik
        $total        = (clone $base)->count();
        $internasional= (clone $base)->where('tingkat','Internasional')->count();
        $nasional     = (clone $base)->where('tingkat','Nasional')->count();
        $provinsi     = (clone $base)->where('tingkat','Provinsi')->count();

        // filter dropdown (distinct dari DB agar akurat)
        $optTingkat = MahasiswaBerprestasi::published()->select('tingkat')->distinct()->pluck('tingkat')->filter()->values();
        $optJurusan = MahasiswaBerprestasi::published()->select('jurusan')->distinct()->pluck('jurusan')->filter()->values();
        $optTahun   = MahasiswaBerprestasi::published()->select('tahun')->distinct()->pluck('tahun')->filter()->sortDesc()->values();

        // query daftar
        $items = $base
            ->when($r->q, fn($q) => $q->where(function($w) use ($r) {
                $w->where('nama', 'like', "%{$r->q}%")
                  ->orWhere('nim', 'like', "%{$r->q}%")
                  ->orWhere('kompetisi', 'like', "%{$r->q}%")
                  ->orWhere('jurusan', 'like', "%{$r->q}%")
                  ->orWhere('penyelenggara', 'like', "%{$r->q}%");
            }))
            ->when($r->tingkat && $r->tingkat !== 'Semua', fn($q) => $q->where('tingkat', $r->tingkat))
            ->when($r->jurusan && $r->jurusan !== 'Semua', fn($q) => $q->where('jurusan', $r->jurusan))
            ->when($r->tahun && $r->tahun !== 'Semua', fn($q) => $q->where('tahun', (int)$r->tahun))
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('user.mahasiswa_berprestasi', compact(
            'items','optTingkat','optJurusan','optTahun',
            'total','internasional','nasional','provinsi'
        ));
    }

    public function show(MahasiswaBerprestasi $prestasi)
    {
        abort_if($prestasi->status !== 'published', 404);
        return view('user.prestasi.show', compact('prestasi'));
    }
}
