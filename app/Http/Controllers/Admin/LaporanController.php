<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Menampilkan halaman daftar laporan.
     */
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Menyimpan laporan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'periode' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120', // Max 5MB
        ]);

        $pathFile = null;
        if ($request->hasFile('file_laporan')) {
            $pathFile = $request->file('file_laporan')->store('laporan', 'public');
        }

        Laporan::create([
            'judul' => $request->judul,
            'periode' => $request->periode,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'file_path' => $pathFile,
            // 'pembuat' => auth()->user()->name, // Contoh jika ingin menyimpan nama pembuat
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit laporan.
     * (Catatan: Laporan biasanya tidak diedit, tapi ini disediakan jika perlu)
     */
    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Mengupdate laporan di database.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'periode' => 'required|string',
            'kategori' => 'required|string',
            'status' => 'required|string',
            'deskripsi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $pathFile = $laporan->file_path;
        if ($request->hasFile('file_laporan')) {
            if ($laporan->file_path) {
                Storage::disk('public')->delete($laporan->file_path);
            }
            $pathFile = $request->file('file_laporan')->store('laporan', 'public');
        }

        $laporan->update([
            'judul' => $request->judul,
            'periode' => $request->periode,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'file_path' => $pathFile,
        ]);

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Menghapus laporan dari database.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file_path) {
            Storage::disk('public')->delete($laporan->file_path);
        }
        
        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }
}
