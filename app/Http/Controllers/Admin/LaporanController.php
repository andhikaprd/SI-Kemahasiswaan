<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\MahasiswaBerprestasi;
use App\Models\Berita;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    /**
     * Tampilkan daftar laporan dan statistik ringkasan.
     */
    public function index()
    {
        $laporans = Laporan::latest()->paginate(10);

        return view('admin.laporan.index', [
            'laporans' => $laporans,
            'totalPrestasi' => MahasiswaBerprestasi::count() ?? 0,
            'totalPengguna' => User::count() ?? 0,
            'totalBerita' => Berita::count() ?? 0,
            'totalLaporan' => Laporan::count(),
        ]);
    }

    /**
     * Tampilkan form tambah laporan.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Simpan laporan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:30',
            'judul' => 'required|string|max:255',
            'periode' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:pending,approved,revisi',
            'deskripsi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120', // 5MB
        ]);

        $pathFile = null;
        if ($request->hasFile('file_laporan')) {
            $pathFile = $request->file('file_laporan')->store('laporan', 'public');
        }

        // Temukan atau buat Mahasiswa dari NIM yang diinput
        $mahasiswa = \App\Models\Mahasiswa::firstOrCreate(
            ['nim' => $request->nim],
            ['nama' => $request->nama_mahasiswa]
        );
        // Sinkronkan nama jika berbeda
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

        // $mahasiswaId sudah pasti terisi dari input pengguna

        Laporan::create([
            'mahasiswa_id' => $mahasiswaId,
            'mata_kuliah_id' => $mataKuliahId,
            'judul' => $request->judul,
            'periode' => $request->periode,
            'kategori' => $request->kategori,
            'status' => $request->status,
            'deskripsi' => $request->deskripsi,
            'file_path' => $pathFile,
        ]);

        return redirect()->route('admin.laporan.index')->with('success', '✅ Laporan berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit laporan.
     */
    public function edit(Laporan $laporan)
    {
        return view('admin.laporan.edit', compact('laporan'));
    }

    /**
     * Update data laporan.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'periode' => 'required|string|max:100',
            'kategori' => 'required|string|max:100',
            'status' => 'required|in:pending,approved,revisi',
            'deskripsi' => 'nullable|string',
            'file_laporan' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        $data = $request->only(['judul', 'periode', 'kategori', 'status', 'deskripsi']);

        // Ganti file jika ada upload baru
        if ($request->hasFile('file_laporan')) {
            if ($laporan->file_path) {
                Storage::disk('public')->delete($laporan->file_path);
            }
            $data['file_path'] = $request->file('file_laporan')->store('laporan', 'public');
        }

        $laporan->update($data);

        return redirect()->route('admin.laporan.index')->with('success', '✅ Laporan berhasil diperbarui!');
    }

    /**
     * Hapus laporan.
     */
    public function destroy(Laporan $laporan)
    {
        if ($laporan->file_path) {
            Storage::disk('public')->delete($laporan->file_path);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', '🗑️ Laporan berhasil dihapus!');
    }
}
