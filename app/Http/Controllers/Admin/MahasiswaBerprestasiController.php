<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class MahasiswaBerprestasiController extends Controller
{
    /**
     * Tampilkan daftar prestasi (admin panel)
     */
    public function index(Request $r)
    {
        $q = MahasiswaBerprestasi::query()
            ->when($r->q, fn($qq) =>
                $qq->where(function ($w) use ($r) {
                    $w->where('nama', 'like', "%{$r->q}%")
                      ->orWhere('nim', 'like', "%{$r->q}%")
                      ->orWhere('kompetisi', 'like', "%{$r->q}%")
                      ->orWhere('jurusan', 'like', "%{$r->q}%")
                      ->orWhere('penyelenggara', 'like', "%{$r->q}%");
                })
            )
            ->when($r->tingkat && $r->tingkat !== 'Semua', fn($qq) => $qq->where('tingkat', $r->tingkat))
            ->when($r->jurusan && $r->jurusan !== 'Semua', fn($qq) => $qq->where('jurusan', $r->jurusan))
            ->when($r->tahun && $r->tahun !== 'Semua', fn($qq) => $qq->where('tahun', (int)$r->tahun))
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        $items = $q->paginate(15)->withQueryString();

        $filterTingkat = MahasiswaBerprestasi::select('tingkat')->distinct()->pluck('tingkat')->filter()->values();
        $filterJurusan = MahasiswaBerprestasi::select('jurusan')->distinct()->pluck('jurusan')->filter()->values();
        $filterTahun   = MahasiswaBerprestasi::select('tahun')->distinct()->pluck('tahun')->filter()->sortDesc()->values();

        return view('Admin.mahasiswa_berprestasi.index', compact('items', 'filterTingkat', 'filterJurusan', 'filterTahun'));
    }

    /**
     * Form tambah data
     */
    public function create()
    {
        $filterTingkat = ['Internasional', 'Nasional', 'Provinsi', 'Kab/Kota', 'Kampus'];
        return view('Admin.mahasiswa_berprestasi.create', compact('filterTingkat'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $r)
    {
        $data = $r->validate([
            'nama'          => ['required', 'string', 'max:150'],
            'nim'           => ['nullable', 'string', 'max:50'],
            'jurusan'       => ['required', 'string', 'max:100'],
            'angkatan'      => ['nullable', 'string', 'max:20'],
            'kompetisi'     => ['required', 'string', 'max:200'],
            'jenis'         => ['nullable', 'string', 'max:150'],
            'tingkat'       => ['required', 'string', 'max:50'],
            'peringkat'     => ['nullable', 'string', 'max:50'],
            'poin'          => ['nullable', 'integer', 'min:0'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'tanggal'       => ['nullable', 'date'],
            'tahun'         => ['nullable', 'integer', 'digits:4'],
            'status'        => ['required', Rule::in(['published', 'draft'])],
            'sertifikat'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'foto'          => ['nullable', 'image', 'max:4096'],
        ]);

        // Upload file sertifikat & foto jika ada
        if ($r->hasFile('sertifikat')) {
            $data['sertifikat_path'] = $r->file('sertifikat')->store('prestasi/sertifikat', 'public');
        }
        if ($r->hasFile('foto')) {
            $data['foto_path'] = $r->file('foto')->store('prestasi/foto', 'public');
        }

        // Simpan data
        MahasiswaBerprestasi::create($data);

        // ✅ Perbaikan route redirect (sesuai resource route)
        return redirect()
            ->route('admin.mahasiswa_berprestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    /**
     * Form edit data
     */
    public function edit(MahasiswaBerprestasi $prestasi)
    {
        $filterTingkat = ['Internasional', 'Nasional', 'Provinsi', 'Kab/Kota', 'Kampus'];
        return view('Admin.mahasiswa_berprestasi.edit', compact('prestasi', 'filterTingkat'));
    }

    /**
     * Update data
     */
    public function update(Request $r, MahasiswaBerprestasi $prestasi)
    {
        $data = $r->validate([
            'nama'          => ['required', 'string', 'max:150'],
            'nim'           => ['nullable', 'string', 'max:50'],
            'jurusan'       => ['required', 'string', 'max:100'],
            'angkatan'      => ['nullable', 'string', 'max:20'],
            'kompetisi'     => ['required', 'string', 'max:200'],
            'jenis'         => ['nullable', 'string', 'max:150'],
            'tingkat'       => ['required', 'string', 'max:50'],
            'peringkat'     => ['nullable', 'string', 'max:50'],
            'poin'          => ['nullable', 'integer', 'min:0'],
            'penyelenggara' => ['nullable', 'string', 'max:150'],
            'tanggal'       => ['nullable', 'date'],
            'tahun'         => ['nullable', 'integer', 'digits:4'],
            'status'        => ['required', Rule::in(['published', 'draft'])],
            'sertifikat'    => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'foto'          => ['nullable', 'image', 'max:4096'],
        ]);

        // Update file sertifikat jika ada file baru
        if ($r->hasFile('sertifikat')) {
            if ($prestasi->sertifikat_path) {
                Storage::disk('public')->delete($prestasi->sertifikat_path);
            }
            $data['sertifikat_path'] = $r->file('sertifikat')->store('prestasi/sertifikat', 'public');
        }

        // Update file foto jika ada file baru
        if ($r->hasFile('foto')) {
            if ($prestasi->foto_path) {
                Storage::disk('public')->delete($prestasi->foto_path);
            }
            $data['foto_path'] = $r->file('foto')->store('prestasi/foto', 'public');
        }

        // Simpan update
        $prestasi->update($data);

        // ✅ Perbaikan route redirect (sesuai resource route)
        return redirect()
            ->route('admin.mahasiswa_berprestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    /**
     * Hapus data prestasi
     */
    public function destroy(MahasiswaBerprestasi $prestasi)
    {
        if ($prestasi->sertifikat_path) {
            Storage::disk('public')->delete($prestasi->sertifikat_path);
        }
        if ($prestasi->foto_path) {
            Storage::disk('public')->delete($prestasi->foto_path);
        }

        $prestasi->delete();

        return back()->with('success', 'Prestasi berhasil dihapus.');
    }
}