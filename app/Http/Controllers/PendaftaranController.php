<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    // 📌 Menampilkan daftar pendaftar
    public function index()
    {
        $pendaftaran = Pendaftaran::all();
        return view('pendaftaran.index', compact('pendaftaran'));
    }

    // 📌 Menampilkan form pendaftaran
    public function create()
    {
        return view('pendaftaran.create');
    }

    // 📌 Menyimpan data pendaftaran
    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:100',
            'nim'       => 'required|string|max:15|unique:pendaftaran,nim',
            'jurusan'   => 'required|string',
            'angkatan'  => 'required|string|max:4',
            'email'     => 'required|email|unique:pendaftaran,email',
            'telepon'   => 'required|string|max:15',
            'divisi'    => 'required|string',
            'motivasi'  => 'required|string|max:500',
        ]);

        Pendaftaran::create([
            'nama_lengkap'   => $request->nama,
            'nim'            => $request->nim,
            'jurusan'        => $request->jurusan,
            'angkatan'       => $request->angkatan,
            'email'          => $request->email,
            'no_telp'        => $request->telepon,
            'divisi_pilihan' => $request->divisi,
            'motivasi'       => $request->motivasi,
        ]);

        return redirect()->route('pendaftaran.index')->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
