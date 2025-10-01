<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use Illuminate\Http\Request;

class MahasiswaBerprestasiController extends Controller
{
    /**
     * Menampilkan halaman daftar prestasi.
     */
    public function index()
    {
        $prestasi = MahasiswaBerprestasi::latest()->paginate(10);
        return view('admin.mahasiswa_berprestasi.index', compact('prestasi'));
    }

    /**
     * Menampilkan form untuk menambah prestasi baru.
     */
    public function create()
    {
        return view('admin.mahasiswa_berprestasi.create');
    }

    /**
     * Menyimpan prestasi baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'jenis_prestasi' => 'required|string',
            'tingkat' => 'required|string',
            'nama_kompetisi' => 'required|string',
            'peringkat' => 'required|string',
            'tahun' => 'required|integer',
            'penyelenggara' => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'poin_prestasi' => 'required|integer',
            'status_sertifikat' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        MahasiswaBerprestasi::create($request->all());

        return redirect()->route('admin.mahasiswa_berprestasi.index')->with('success', 'Data prestasi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit prestasi.
     */
    public function edit(MahasiswaBerprestasi $mahasiswaBerprestasi)
    {
        return view('admin.mahasiswa_berprestasi.edit', ['prestasi' => $mahasiswaBerprestasi]);
    }

    /**
     * Mengupdate prestasi di database.
     */
    public function update(Request $request, MahasiswaBerprestasi $mahasiswaBerprestasi)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|integer',
            'jenis_prestasi' => 'required|string',
            'tingkat' => 'required|string',
            'nama_kompetisi' => 'required|string',
            'peringkat' => 'required|string',
            'tahun' => 'required|integer',
            'penyelenggara' => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'poin_prestasi' => 'required|integer',
            'status_sertifikat' => 'required|string',
            'deskripsi' => 'nullable|string',
        ]);

        $mahasiswaBerprestasi->update($request->all());

        return redirect()->route('admin.mahasiswa_berprestasi.index')->with('success', 'Data prestasi berhasil diperbarui!');
    }

    /**
     * Menghapus prestasi dari database.
     */
    public function destroy(MahasiswaBerprestasi $mahasiswaBerprestasi)
    {
        $mahasiswaBerprestasi->delete();

        return redirect()->route('admin.mahasiswa_berprestasi.index')->with('success', 'Data prestasi berhasil dihapus!');
    }
}
