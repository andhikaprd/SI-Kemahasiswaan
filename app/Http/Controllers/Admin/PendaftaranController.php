<?php

namespace App\Http\Controllers\Admin;

// 1. TAMBAHKAN USE STATEMENT YANG DIPERLUKAN
use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * 📌 Menampilkan daftar semua pendaftar.
     * Fungsi index() adalah standar untuk menampilkan daftar data (resource).
     */
    public function index()
    {
        $pendaftaran = Pendaftaran::latest()->get();
        // 2. UBAH PATH VIEW KE FOLDER ADMIN
        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    /**
     * 📌 Menampilkan detail satu pendaftar.
     * Fungsi ini berguna untuk melihat detail lengkap dari satu pendaftar.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        // 2. UBAH PATH VIEW KE FOLDER ADMIN
        return view('admin.pendaftaran.show', compact('pendaftaran'));
    }

    /**
     * 📌 Menampilkan form untuk mengedit data pendaftar.
     * (Contoh: untuk mengubah status pendaftaran 'Diterima' atau 'Ditolak')
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        return view('admin.pendaftaran.edit', compact('pendaftaran'));
    }

    /**
     * 📌 Mengupdate data pendaftar di database.
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        // Logika untuk validasi dan update data, contoh:
        // $request->validate(['status' => 'required|string']);
        // $pendaftaran->update($request->only('status'));

        // 3. UBAH NAMA ROUTE PADA REDIRECT
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftar berhasil diupdate!');
    }

    /**
     * 📌 Menghapus data pendaftaran.
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        
        // 3. UBAH NAMA ROUTE PADA REDIRECT
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftar berhasil dihapus!');
    }
}
