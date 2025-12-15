<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\MasalahMahasiswa;
use App\Models\Mahasiswa;
use App\Models\PelanggaranMaster;
use Illuminate\Http\Request;

class MasalahMahasiswaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(MasalahMahasiswa::class, 'masalahMahasiswa');
    }

    /**
     * Menampilkan daftar pelanggaran mahasiswa.
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
            ->latest('id') // ganti dari orderByDesc('created_at')
            ->paginate(10);

        return view('Kaprodi.masalah_mahasiswa.index', compact('kasus', 'search'));
    }

    /**
     * Menampilkan form untuk menambah pelanggaran baru.
     */
    public function create()
    {
        $mahasiswas = Mahasiswa::all(); // daftar mahasiswa untuk dropdown
        $pelanggarans = PelanggaranMaster::orderBy('kategori')->orderBy('nama')->get();
        // Hitung riwayat pelanggaran per mahasiswa (total)
        $riwayat = MasalahMahasiswa::selectRaw('mahasiswa_id, COUNT(*) as total')
            ->groupBy('mahasiswa_id')
            ->pluck('total', 'mahasiswa_id');

        return view('Kaprodi.masalah_mahasiswa.create', compact('mahasiswas','pelanggarans','riwayat'));
    }

    /**
     * Menyimpan pelanggaran baru ke database.
     */
    public function store(Request $request)
    {
        // Dukung input banyak: mahasiswa_id[] (multi-select)
        $ids = $request->input('mahasiswa_id');

        if (!is_array($ids)) {
            $raw = (string) ($ids ?? '');
            if (preg_match('/^\s*(\d+)/', $raw, $m)) {
                $ids = [(int) $m[1]];
            } elseif ($raw !== '') {
                $ids = [(int) $raw];
            } else {
                $ids = [];
            }
        }

        $request->merge(['mahasiswa_id' => $ids]);

        $validated = $request->validate([
            'mahasiswa_id' => 'required|array|min:1',
            'mahasiswa_id.*' => 'required|integer|exists:mahasiswas,id',
            'semester' => 'nullable|integer|min:1',
            'ipk' => 'nullable|numeric|between:0,4',
            'pelanggaran_id' => 'required|integer|exists:pelanggaran_masters,id',
            'laporan_terakhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $master = PelanggaranMaster::findOrFail($validated['pelanggaran_id']);

        $kategori = strtolower($master->kategori ?? '');
        $baseNama = $master->nama ?? 'Pelanggaran';

        $computeSanksi = function (int $count) use ($kategori) {
            if ($kategori === 'ringan') {
                if ($count >= 3) return 'Skorsing';
                if ($count == 2) return 'Peringatan 3';
                if ($count == 1) return 'Peringatan 2';
                return 'Peringatan 1';
            }
            if ($kategori === 'sedang') {
                return 'Skorsing';
            }
            if ($kategori === 'berat') {
                return 'Pemberhentian (DO)';
            }
            return 'Peringatan 1';
        };

        foreach ($ids as $mid) {
            $riwayatCount = MasalahMahasiswa::where('mahasiswa_id', $mid)->count();
            $status = $computeSanksi($riwayatCount);

            MasalahMahasiswa::create([
                'mahasiswa_id' => $mid,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
                'jenis_masalah' => $baseNama,
                'status_peringatan' => $status,
                'laporan_terakhir' => $request->laporan_terakhir,
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()->route('kaprodi.pelanggaran_mahasiswa.index')
            ->with('success', 'Data pelanggaran mahasiswa berhasil ditambahkan (' . count($ids) . ' entri).');
    }

    /**
     * Menampilkan detail satu pelanggaran.
     */
    public function show(MasalahMahasiswa $masalahMahasiswa)
    {
        return view('Kaprodi.masalah_mahasiswa.show', ['kasus' => $masalahMahasiswa]);
    }

    /**
     * Menampilkan form untuk mengedit pelanggaran.
     */
    public function edit(MasalahMahasiswa $masalahMahasiswa)
    {
        $mahasiswas = Mahasiswa::all();
        return view('Kaprodi.masalah_mahasiswa.edit', [
            'kasus' => $masalahMahasiswa,
            'mahasiswas' => $mahasiswas,
        ]);
    }

    /**
     * Mengupdate pelanggaran di database.
     */
    public function update(Request $request, MasalahMahasiswa $masalahMahasiswa)
    {
        // Normalisasi input mahasiswa_id jika diubah manual
        $raw = (string) $request->input('mahasiswa_id');
        if (preg_match('/^\s*(\d+)/', $raw, $m)) {
            $request->merge(['mahasiswa_id' => (int) $m[1]]);
        }

        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'semester' => 'nullable|integer|min:1',
            'ipk' => 'nullable|numeric|between:0,4',
            'laporan_terakhir' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'tambahkan_mahasiswa_ids' => 'nullable|array',
            'tambahkan_mahasiswa_ids.*' => 'integer|exists:mahasiswas,id',
        ]);

        $updateData = $request->only([
            'mahasiswa_id','semester','ipk','laporan_terakhir','keterangan'
        ]);
        $masalahMahasiswa->update($updateData);

        // Jika ada tambahan mahasiswa saat edit, buat salinan data untuk mereka
        $tambahan = (array) $request->input('tambahkan_mahasiswa_ids', []);
        foreach ($tambahan as $mid) {
            MasalahMahasiswa::create([
                'mahasiswa_id' => $mid,
                'semester' => $request->semester,
                'ipk' => $request->ipk,
                'jenis_masalah' => $request->jenis_masalah,
                'status_peringatan' => $request->status_peringatan,
                'laporan_terakhir' => $request->laporan_terakhir,
                'keterangan' => $request->keterangan,
            ]);
        }

        return redirect()
            ->route('kaprodi.pelanggaran_mahasiswa.index')
            ->with('success', 'Data pelanggaran mahasiswa berhasil diperbarui.');
    }

    /**
     * Menghapus pelanggaran mahasiswa.
     */
    public function destroy(MasalahMahasiswa $masalahMahasiswa)
    {
        $masalahMahasiswa->delete();

        return redirect()
            ->route('kaprodi.pelanggaran_mahasiswa.index')
            ->with('success', 'Data pelanggaran mahasiswa berhasil dihapus.');
    }
}
