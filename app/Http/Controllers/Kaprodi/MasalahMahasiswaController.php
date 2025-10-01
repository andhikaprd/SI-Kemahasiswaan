<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\MasalahMahasiswa; // Pastikan Anda sudah membuat Model ini
use Illuminate\Http\Request;

class MasalahMahasiswaController extends Controller
{
    /**
     * Menampilkan halaman daftar mahasiswa bermasalah.
     */
    public function index()
    {
        $kasus = MasalahMahasiswa::latest()->paginate(10);
        return view('kaprodi.masalah_mahasiswa.index', compact('kasus'));
    }

    /**
     * Menampilkan form untuk menambah data baru.
     */
    public function create()
    {
        return view('kaprodi.masalah_mahasiswa.create');
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'jenis_masalah' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string|in:Baru,Diproses,Selesai',
            'tanggal_laporan' => 'required|date',
        ]);

        MasalahMahasiswa::create($request->all());

        return redirect()->route('kaprodi.masalah_mahasiswa.index')->with('success', 'Data mahasiswa bermasalah berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail spesifik dari satu kasus.
     */
    public function show(MasalahMahasiswa $masalahMahasiswa)
    {
        return view('kaprodi.masalah_mahasiswa.show', ['kasus' => $masalahMahasiswa]);
    }


    /**
     * Menampilkan form untuk mengedit data.
     */
    public function edit(MasalahMahasiswa $masalahMahasiswa)
    {
        return view('kaprodi.masalah_mahasiswa.edit', ['kasus' => $masalahMahasiswa]);
    }

    /**
     * Mengupdate data di database.
     */
    public function update(Request $request, MasalahMahasiswa $masalahMahasiswa)
    {
        $request->validate([
            'nama_mahasiswa' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'angkatan' => 'required|integer',
            'jenis_masalah' => 'required|string',
            'deskripsi' => 'required|string',
            'status' => 'required|string|in:Baru,Diproses,Selesai',
            'tanggal_laporan' => 'required|date',
        ]);

        $masalahMahasiswa->update($request->all());

        return redirect()->route('kaprodi.masalah_mahasiswa.index')->with('success', 'Data mahasiswa bermasalah berhasil diperbarui.');
    }

    /**
     * Menghapus data dari database.
     */
    public function destroy(MasalahMahasiswa $masalahMahasiswa)
    {
        $masalahMahasiswa->delete();

        return redirect()->route('kaprodi.masalah_mahasiswa.index')->with('success', 'Data mahasiswa bermasalah berhasil dihapus.');
    }
}

