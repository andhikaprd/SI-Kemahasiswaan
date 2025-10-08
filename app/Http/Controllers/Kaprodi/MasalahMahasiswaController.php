<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\MasalahMahasiswa;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MasalahMahasiswaController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa bermasalah.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kasus = MasalahMahasiswa::with('mahasiswa')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('mahasiswa', function ($q) use ($search) {
                    $q->where('nama', 'like', "%$search%")
                      ->orWhere('nim', 'like', "%$search%");
                });
            })
            ->latest('id') // ✅ ganti dari orderByDesc('created_at')
            ->paginate(10);

        return view('kaprodi.masalah_mahasiswa.index', compact('kasus', 'search'));
    }

    /**
     * Menampilkan form untuk menambah data baru.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all(); // daftar mahasiswa untuk dropdown
        return view('kaprodi.masalah_mahasiswa.create', compact('mahasiswas'));
    }

    /**
     * Menyimpan data baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester' => 'nullable|integer|min:1',
            'ipk' => 'nullable|numeric|between:0,4',
            'jenis_masalah' => 'required|string|max:255',
            'status_peringatan' => 'required|string|in:Peringatan 1,Peringatan 2,Peringatan 3,Skorsing',
            'laporan_terakhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        MasalahMahasiswa::create($request->all());

        return redirect()
            ->route('kaprodi.masalah_mahasiswa.index')
            ->with('success', 'Data mahasiswa bermasalah berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu kasus mahasiswa bermasalah.
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
        $mahasiswas = Mahasiswa::all();
        return view('kaprodi.masalah_mahasiswa.edit', [
            'kasus' => $masalahMahasiswa,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Mengupdate data di database.
     */
    public function update(Request $request, MasalahMahasiswa $masalahMahasiswa)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester' => 'nullable|integer|min:1',
            'ipk' => 'nullable|numeric|between:0,4',
            'jenis_masalah' => 'required|string|max:255',
            'status_peringatan' => 'required|string|in:Peringatan 1,Peringatan 2,Peringatan 3,Skorsing',
            'laporan_terakhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $masalahMahasiswa->update($request->all());

        return redirect()
            ->route('kaprodi.masalah_mahasiswa.index')
            ->with('success', 'Data mahasiswa bermasalah berhasil diperbarui.');
    }

    /**
     * Menghapus data mahasiswa bermasalah.
     */
    public function destroy(MasalahMahasiswa $masalahMahasiswa)
    {
        $masalahMahasiswa->delete();

        return redirect()
            ->route('kaprodi.masalah_mahasiswa.index')
            ->with('success', 'Data mahasiswa bermasalah berhasil dihapus.');
    }
}
