<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Laporan::class, 'laporan');
    }

    /**
     * Menampilkan daftar laporan dengan pagination & filter status.
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
     * (Optional) Form tambah laporan baru.
     * Tidak wajib untuk Kaprodi, tapi disediakan jika dibutuhkan nanti.
     */
    public function create()
    {
        return view('Kaprodi.laporan.create');
    }

    /**
     * Menyimpan laporan baru (jika Kaprodi perlu input manual).
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:30',
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

        // Temukan/buat Mahasiswa dari input NIM
        $mahasiswa = \App\Models\Mahasiswa::firstOrCreate(
            ['nim' => $request->nim],
            ['nama' => $request->nama_mahasiswa]
        );
        if ($mahasiswa->nama !== $request->nama_mahasiswa) {
            $mahasiswa->nama = $request->nama_mahasiswa;
            $mahasiswa->save();
        }
        $mahasiswaId = $mahasiswa->id;
        $mataKuliahId = \App\Models\MataKuliah::value('id');

        if (!$mataKuliahId) {
            $mataKuliah = \App\Models\MataKuliah::create([
                'nama' => 'Umum',
                'kode' => 'UMUM',
            ]);
            $mataKuliahId = $mataKuliah->id;
        }

        // $mahasiswaId sudah terisi dari input pengguna

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

        return redirect()->route('kaprodi.laporan.index')->with('success', 'Laporan berhasil ditambahkan!');
    }

    /**
     * Form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        return view('Kaprodi.laporan.edit', compact('laporan'));
    }

    /**
     * Update data laporan.
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

        return redirect()->route('kaprodi.laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan dari sistem.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file_path) {
            Storage::disk('public')->delete($laporan->file_path);
        }

        $laporan->delete();

        return redirect()->route('kaprodi.laporan.index')->with('success', 'Laporan berhasil dihapus!');
    }

    /**
     * Unduh file laporan secara terproteksi.
     */
    public function download(Laporan $laporan)
    {
        if (!$laporan->file_path || !Storage::disk('public')->exists($laporan->file_path)) {
            abort(404);
        }
        $filename = basename($laporan->file_path) ?: 'laporan.pdf';
        return Storage::disk('public')->download($laporan->file_path, $filename);
    }
}

