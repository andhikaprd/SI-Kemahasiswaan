<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran; // Pastikan Anda sudah membuat model Pendaftaran
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan form pendaftaran HIMA.
     */
    public function create()
    {
        return view('user.pendaftaran.form');
    }

    /**
     * Menyimpan data pendaftaran baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi semua input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:pendaftarans,nim', // 'pendaftarans' adalah nama tabel
            'angkatan' => 'required|integer',
            'jurusan' => 'required|string',
            'email' => 'required|email|max:255|unique:pendaftarans,email',
            'telepon' => 'required|string|max:15',
            'divisi' => 'required|string',
            'motivasi' => 'required|string|max:1000',
        ]);

        Pendaftaran::create([
            'nama_lengkap' => $request->nama,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            'jurusan' => $request->jurusan,
            'email' => $request->email,
            'no_telp' => $request->telepon,
            'divisi_pilihan' => $request->divisi,
            'motivasi' => $request->motivasi,
        ]);

        // Redirect kembali ke halaman form dengan pesan sukses
        return redirect()->route('pendaftaran.create')->with('success', 'Pendaftaran Anda telah berhasil dikirim! Terima kasih telah mendaftar.');
    }
}

