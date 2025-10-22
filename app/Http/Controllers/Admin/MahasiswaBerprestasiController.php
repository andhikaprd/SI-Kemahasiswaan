<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use App\Models\Mahasiswa;
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
        $mahasiswas = Mahasiswa::orderBy('nama')->get(['id','nama','nim','angkatan']);
        return view('Admin.mahasiswa_berprestasi.create', compact('filterTingkat','mahasiswas'));
    }

    /**
     * Simpan data baru
     */
    public function store(Request $r)
    {
        // Mode: pilih banyak mahasiswa (prestasi tim) via Select2
        if ($r->filled('mahasiswa_ids')) {
            $validated = $r->validate([
                'mahasiswa_ids'   => ['array','min:1'],
                'mahasiswa_ids.*' => ['integer','exists:mahasiswas,id'],
                'jurusan'         => ['required', 'string', 'max:100'],
                'kompetisi'       => ['required', 'string', 'max:200'],
                'jenis'           => ['nullable', 'string', 'max:150'],
                'tingkat'         => ['required', 'string', 'max:50'],
                'peringkat'       => ['nullable', 'string', 'max:50'],
                'poin'            => ['nullable', 'integer', 'min:0'],
                'penyelenggara'   => ['nullable', 'string', 'max:150'],
                'tanggal'         => ['nullable', 'date'],
                'tahun'           => ['nullable', 'integer', 'digits:4'],
                'status'          => ['required', Rule::in(['published', 'draft'])],
                'deskripsi'       => ['nullable', 'string'],
                'sertifikat'      => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:5120'],
                'foto'            => ['nullable','image','max:4096'],
            ]);

            $sertifikatPath = null; $fotoPath = null;
            if ($r->hasFile('sertifikat')) {
                $sertifikatPath = $r->file('sertifikat')->store('prestasi/sertifikat','public');
            }
            if ($r->hasFile('foto')) {
                $fotoPath = $r->file('foto')->store('prestasi/foto','public');
            }

            $list = Mahasiswa::whereIn('id', $validated['mahasiswa_ids'])->get();
            foreach ($list as $m) {
                MahasiswaBerprestasi::create([
                    'nama'            => $m->nama,
                    'nim'             => $m->nim,
                    'jurusan'         => $validated['jurusan'],
                    'angkatan'        => $m->angkatan,
                    'kompetisi'       => $validated['kompetisi'],
                    'jenis'           => $validated['jenis'] ?? null,
                    'tingkat'         => $validated['tingkat'],
                    'peringkat'       => $validated['peringkat'] ?? null,
                    'poin'            => $validated['poin'] ?? null,
                    'penyelenggara'   => $validated['penyelenggara'] ?? null,
                    'tanggal'         => $validated['tanggal'] ?? null,
                    'tahun'           => $validated['tahun'] ?? null,
                    'status'          => $validated['status'],
                    'deskripsi'       => $validated['deskripsi'] ?? null,
                    'sertifikat_path' => $sertifikatPath,
                    'foto_path'       => $fotoPath,
                ]);
            }

            return redirect()->route('admin.mahasiswa_berprestasi.index')
                ->with('success', 'Prestasi tim berhasil ditambahkan untuk ' . $list->count() . ' mahasiswa.');
        }
        // Mode bulk: jika field nama adalah array, proses banyak baris sekaligus
        if (is_array($r->input('nama'))) {
            $r->validate([
                'nama'          => ['required','array','min:1'],
                'nama.*'        => ['required','string','max:150'],
                'nim'           => ['nullable','array'],
                'nim.*'         => ['nullable','string','max:50'],
                'jurusan'       => ['required','array'],
                'jurusan.*'     => ['required','string','max:100'],
                'angkatan'      => ['nullable','array'],
                'angkatan.*'    => ['nullable','string','max:20'],
                'kompetisi'     => ['required','array'],
                'kompetisi.*'   => ['required','string','max:200'],
                'jenis'         => ['nullable','array'],
                'jenis.*'       => ['nullable','string','max:150'],
                'tingkat'       => ['required','array'],
                'tingkat.*'     => ['required','string','max:50'],
                'peringkat'     => ['nullable','array'],
                'peringkat.*'   => ['nullable','string','max:50'],
                'poin'          => ['nullable','array'],
                'poin.*'        => ['nullable','integer','min:0'],
                'penyelenggara' => ['nullable','array'],
                'penyelenggara.*'=> ['nullable','string','max:150'],
                'tanggal'       => ['nullable','array'],
                'tanggal.*'     => ['nullable','date'],
                'tahun'         => ['nullable','array'],
                'tahun.*'       => ['nullable','integer','digits:4'],
                'status'        => ['required','array'],
                'status.*'      => ['required', Rule::in(['published','draft'])],
                'deskripsi'     => ['nullable','array'],
                'deskripsi.*'   => ['nullable','string'],
            ]);

            $count = count($r->input('nama'));
            for ($i=0; $i<$count; $i++) {
                MahasiswaBerprestasi::create([
                    'nama'          => $r->input("nama.$i"),
                    'nim'           => $r->input("nim.$i"),
                    'jurusan'       => $r->input("jurusan.$i"),
                    'angkatan'      => $r->input("angkatan.$i"),
                    'kompetisi'     => $r->input("kompetisi.$i"),
                    'jenis'         => $r->input("jenis.$i"),
                    'tingkat'       => $r->input("tingkat.$i"),
                    'peringkat'     => $r->input("peringkat.$i"),
                    'poin'          => $r->input("poin.$i"),
                    'penyelenggara' => $r->input("penyelenggara.$i"),
                    'tanggal'       => $r->input("tanggal.$i"),
                    'tahun'         => $r->input("tahun.$i"),
                    'status'        => $r->input("status.$i", 'draft'),
                    'deskripsi'     => $r->input("deskripsi.$i"),
                ]);
            }

            return redirect()->route('admin.mahasiswa_berprestasi.index')
                ->with('success', "Berhasil menambahkan {$count} data prestasi.");
        }
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
        $mahasiswas = \App\Models\Mahasiswa::orderBy('nama')->get(['id','nama','nim','angkatan']);
        return view('Admin.mahasiswa_berprestasi.edit', compact('prestasi', 'filterTingkat','mahasiswas'));
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

        // Jika pilih banyak mahasiswa tambahan saat edit, buat salinan data untuk mereka
        if ($r->filled('mahasiswa_ids')) {
            $ids = $r->validate([
                'mahasiswa_ids' => ['array','min:1'],
                'mahasiswa_ids.*' => ['integer','exists:mahasiswas,id'],
            ])['mahasiswa_ids'];

            $ms = \App\Models\Mahasiswa::whereIn('id', $ids)->get();
            foreach ($ms as $m) {
                MahasiswaBerprestasi::create([
                    'nama'            => $m->nama,
                    'nim'             => $m->nim,
                    'jurusan'         => $data['jurusan'],
                    'angkatan'        => $m->angkatan,
                    'kompetisi'       => $data['kompetisi'],
                    'jenis'           => $data['jenis'] ?? null,
                    'tingkat'         => $data['tingkat'],
                    'peringkat'       => $data['peringkat'] ?? null,
                    'poin'            => $data['poin'] ?? null,
                    'penyelenggara'   => $data['penyelenggara'] ?? null,
                    'tanggal'         => $data['tanggal'] ?? null,
                    'tahun'           => $data['tahun'] ?? null,
                    'status'          => $data['status'],
                    'deskripsi'       => $data['deskripsi'] ?? null,
                    'sertifikat_path' => $prestasi->sertifikat_path,
                    'foto_path'       => $prestasi->foto_path,
                ]);
            }
        }

        // ✅ Perbaikan route redirect (sesuai resource route)
        return redirect()->route('admin.mahasiswa_berprestasi.index')
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
