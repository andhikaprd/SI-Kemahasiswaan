<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class VerifikasiLaporanController extends Controller
{
    /**
     * Menampilkan daftar laporan yang menunggu verifikasi (status pending)
     */
    public function index()
    {
        // Ambil laporan yang masih pending atau revisi
        $laporans = Laporan::with(['mahasiswa', 'mataKuliah'])
            ->whereIn('status', ['pending', 'revisi'])
            ->orderBy('tanggal_submit', 'desc')
            ->get();

        return view('Kaprodi.verifikasi.index', compact('laporans'));
    }

    /**
     * Aksi untuk menyetujui laporan
     */
    public function setujui($id)
    {
        $laporan = Laporan::findOrFail($id);

        $laporan->update([
            'status' => 'approved',
            'verified_by' => auth()->id(),  // Kaprodi yang memverifikasi
            'verified_at' => now(),
        ]);

        return back()->with('success', "✅ Laporan '{$laporan->judul}' berhasil disetujui.");
    }

    /**
     * Aksi untuk menolak / revisi laporan
     */
    public function tolak($id)
    {
        $laporan = Laporan::findOrFail($id);

        $laporan->update([
            'status' => 'revisi',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return back()->with('success', "❌ Laporan '{$laporan->judul}' memerlukan revisi.");
    }
}
