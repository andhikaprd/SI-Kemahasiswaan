<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * 🔹 Menampilkan daftar laporan dengan pagination & filter status.
     */
    public function index(Request $request)
    {
        $query = Laporan::with(['mahasiswa', 'mataKuliah'])->latest();

        // Filter status jika ada
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $laporans = $query->paginate(10);

        return view('Kaprodi.laporan.index', compact('laporans'));
    }

    /**
     * 🔹 (Optional) Form tambah laporan baru.
     * Tidak wajib untuk Kaprodi, tapi disediakan jika dibutuhkan nanti.
     */
    public function create()
    {
        return view('Kaprodi.laporan.create');
    }

    /**
     * 🔹 Menyimpan laporan baru (jika Kaprodi perlu input manual).
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'periode' => 'required|string|max:50',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120', // max 5 MB
        ]);

        $filePath = null;
        $mime = null;
        $size = null;

        if ($request->hasFile('file_laporan')) {
            $file = $request->file('file_laporan');
            $filePath = $file->store('laporan', 'public');
            $mime = $file->getClientMimeType();
            $size = $file->getSize();
        }

        // Pastikan FK tersedia (hindari gagal di MySQL pada DB kosong)
        $mahasiswaId = \App\Models\Mahasiswa::value('id');
        $mataKuliahId = \App\Models\MataKuliah::value('id');

        if (!$mataKuliahId) {
            $mataKuliah = \App\Models\MataKuliah::create([
                'nama' => 'Umum',
                'kode' => 'UMUM',
            ]);
            $mataKuliahId = $mataKuliah->id;
        }

        if (!$mahasiswaId) {
            $m = \App\Models\Mahasiswa::create([
                'nama' => 'Tanpa Nama',
                'nim' => '0000000000',
                'prodi_id' => null,
                'angkatan' => null,
                'email' => null,
            ]);
            $mahasiswaId = $m->id;
        }

        Laporan::create([
            'judul' => $request->judul,
            'periode' => $request->periode,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'file_path' => $filePath,
            'file_mime' => $mime,
            'file_size' => $size,
            'status' => 'pending',
            'mahasiswa_id' => $mahasiswaId,
            'mata_kuliah_id' => $mataKuliahId,
        ]);

        return redirect()->route('kaprodi.laporan.index')->with('success', '✅ Laporan berhasil ditambahkan!');
    }

    /**
     * 🔹 Form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        return view('Kaprodi.laporan.edit', compact('laporan'));
    }

    /**
     * 🔹 Update data laporan.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'periode' => 'required|string|max:50',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:pending,approved,revisi',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $filePath = $laporan->file_path;
        $mime = $laporan->file_mime;
        $size = $laporan->file_size;

        if ($request->hasFile('file_laporan')) {
            // Hapus file lama jika ada
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }

            $file = $request->file('file_laporan');
            $filePath = $file->store('laporan', 'public');
            $mime = $file->getClientMimeType();
            $size = $file->getSize();
        }

        $laporan->update([
            'judul' => $request->judul,
            'periode' => $request->periode,
            'kategori' => $request->kategori,
            'deskripsi' => $request->deskripsi,
            'status' => $request->status,
            'file_path' => $filePath,
            'file_mime' => $mime,
            'file_size' => $size,
        ]);

        return redirect()->route('kaprodi.laporan.index')->with('success', '✅ Laporan berhasil diperbarui!');
    }

    /**
     * 🔹 Hapus laporan dari sistem.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file_path) {
            Storage::disk('public')->delete($laporan->file_path);
        }

        $laporan->delete();

        return redirect()->route('kaprodi.laporan.index')->with('success', '🗑️ Laporan berhasil dihapus!');
    }
}
