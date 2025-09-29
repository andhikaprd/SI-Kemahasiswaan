<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pendaftaran;

class PendaftaranController extends Controller
{
    // 📌 Menampilkan form pendaftaran (default /pendaftaran)
    public function index()
    {
        return view('pendaftaran.form'); // resources/views/pendaftaran/form.blade.php
    }

    // 📌 Menampilkan daftar pendaftar (/pendaftaran/create)
    public function create()
    {
        $pendaftaran = Pendaftaran::all();
        return view('pendaftaran.index', compact('pendaftaran'));
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

        return redirect()->route('pendaftaran.create')->with('success', 'Pendaftaran berhasil dikirim!');
    }
}
