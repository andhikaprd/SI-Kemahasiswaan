<?php

namespace App\Http\Controllers\Admin;

// 1. TAMBAHKAN USE STATEMENT UNTUK BASE CONTROLLER
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\Divisi; // <-- Aktifkan baris ini setelah Anda membuat Model Divisi

class DivisiController extends Controller
{
    /**
     * Menampilkan daftar semua divisi.
     */
    public function index()
    {
        // Nanti bisa ambil data dari database, contoh:
        // $divisi = Divisi::all();
        // return view('admin.divisi.index', compact('divisi'));

        // 2. UBAH PATH VIEW AGAR SESUAI STRUKTUR FOLDER ADMIN
        return view('admin.divisi.index');
    }

    /**
     * Menampilkan form untuk membuat divisi baru.
     */
    public function create()
    {
        return view('admin.divisi.create');
    }

    /**
     * Menyimpan divisi baru ke database.
     */
    public function store(Request $request)
    {
        // Tambahkan validasi di sini
        // $request->validate(['nama_divisi' => 'required|string|unique:divisi']);

        // Kode untuk menyimpan ke database
        // Divisi::create($request->all());

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit divisi.
     * (Menggunakan route model binding jika modelnya sudah ada)
     */
    public function edit(/*Divisi $divisi*/)
    {
        // return view('admin.divisi.edit', compact('divisi'));
    }

    /**
     * Mengupdate data divisi di database.
     */
    public function update(Request $request, /*Divisi $divisi*/)
    {
        // Tambahkan validasi di sini
        // $request->validate(['nama_divisi' => 'required|string']);

        // Kode untuk update data
        // $divisi->update($request->all());

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil diupdate!');
    }

    /**
     * Menghapus divisi dari database.
     */
    public function destroy(/*Divisi $divisi*/)
    {
        // Kode untuk menghapus data
        // $divisi->delete();

        return redirect()->route('admin.divisi.index')->with('success', 'Divisi berhasil dihapus!');
    }
}

