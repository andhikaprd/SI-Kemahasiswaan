<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use App\Models\Mahasiswa;
use App\Models\DecisionWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
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

    /**
     * Ranking (SAW) alternatif = Mahasiswa menggunakan bobot AHP yang disepakati.
     * Filter opsional: tahun.
     */
    public function ranking(Request $r)
    {
        [$rows, $weights, $tahun] = $this->computeRankingData($r->integer('tahun'));
        return view('Admin.mahasiswa_berprestasi.ranking', compact('rows','weights','tahun'));
    }

    public function rankingExportCsv(Request $r)
    {
        [$rows, $weights, $tahun] = $this->computeRankingData($r->integer('tahun'));
        $filename = 'ranking_prestasi' . ($tahun ? ('_'.$tahun) : '') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="'.$filename.'"',
        ];

        $out = fopen('php://temp', 'w+');
        // UTF-8 BOM for Excel compatibility
        fwrite($out, "\xEF\xBB\xBF");

        fputcsv($out, ['Peringkat','NIM','Nama','r(IPK)','Tingkat Terbaik','r(Tingkat)','Juara Terbaik','r(Juara)','r(Inggris)','Skor']);
        foreach ($rows as $row) {
            fputcsv($out, [
                $row['rank'],
                $row['nim'],
                $row['nama'],
                $row['r_ipk'],
                $row['best_tingkat_label'],
                $row['r_tingkat'],
                $row['best_juara_label'],
                $row['r_juara'],
                $row['r_eng'],
                $row['score'],
            ]);
        }
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return response($csv, 200, $headers);
    }

    public function rankingExportPdf(Request $r)
    {
        [$rows, $weights, $tahun] = $this->computeRankingData($r->integer('tahun'));
        $data = compact('rows','weights','tahun');
        $filename = 'ranking_prestasi' . ($tahun ? ('_'.$tahun) : '') . '.pdf';

        // Jika paket dompdf tersedia, gunakan; jika tidak, fallback ke HTML printable
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            /** @var \Barryvdh\DomPDF\PDF $pdf */
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Admin.mahasiswa_berprestasi.ranking_pdf', $data)
                ->setPaper('a4', 'portrait');
            return $pdf->download($filename);
        }

        // Fallback: tampilkan halaman HTML untuk dicetak ke PDF via browser
        return response()->view('Admin.mahasiswa_berprestasi.ranking_pdf', $data, 200, [
            'Content-Type' => 'text/html; charset=UTF-8',
        ]);
    }

    private function computeRankingData(?int $tahun): array
    {
        // Ambil bobot terbaru dari DB jika ada; fallback ke bobot contoh
        $latest = null; $weights = null;
        if (Schema::hasTable('decision_weights')) {
            $latest = DecisionWeight::query()
                ->where('context', 'prestasi_mahasiswa')
                ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                ->orderByDesc('id')
                ->first();
            $weights = $latest?->weights;
        }
        if (!is_array($weights)) {
            $weights = [
                'ipk'      => 0.4736,
                'tingkat'  => 0.1820,
                'juara'    => 0.2473,
                'english'  => 0.0971,
            ];
        }
        $weights = array_merge(['ipk'=>0,'tingkat'=>0,'juara'=>0,'english'=>0], $weights);

        $base = MahasiswaBerprestasi::published()
            ->when($tahun, fn($q) => $q->where('tahun', $tahun));

        $grouped = $base->get()->groupBy(function($m){
            return $m->nim ?: ('NONIM:' . mb_strtolower(trim($m->nama ?? '-')));
        });

        $rows = [];
        foreach ($grouped as $nimKey => $items) {
            $first = $items->first();
            $nim = str_starts_with($nimKey, 'NONIM:') ? null : $nimKey;
            $nama = $first->nama ?? '-';

            $bestTingkatNum = $items->map(fn($it) => $this->mapTingkat($it->tingkat))->filter()->min();
            if ($bestTingkatNum === null) { $bestTingkatNum = 5; }

            $bestJuaraNum = $items->map(fn($it) => $this->mapJuara($it->peringkat))->filter()->max();
            if ($bestJuaraNum === null) { $bestJuaraNum = 1; }

            $r_ipk = 0.0; $r_eng = 0.0;
            if ($nim) {
                $mhs = Mahasiswa::where('nim', $nim)->first();
                if ($mhs && is_numeric($mhs->ipk)) {
                    $r_ipk = max(0, min(1, ((float)$mhs->ipk) / 4.0));
                }
                if ($mhs && $mhs->english_type && is_numeric($mhs->english_score)) {
                    $r_eng = $this->normalizeEnglish((string)$mhs->english_type, (float)$mhs->english_score);
                }
            }

            $r_tingkat = $this->normalizeTingkatBenefit($bestTingkatNum);
            $r_juara   = $this->normalizeJuara($bestJuaraNum);

            $score = (
                $weights['ipk']     * $r_ipk +
                $weights['tingkat'] * $r_tingkat +
                $weights['juara']   * $r_juara +
                $weights['english'] * $r_eng
            );

            $rows[] = [
                'nim' => $nim,
                'nama' => $nama,
                'r_ipk' => round($r_ipk, 4),
                'r_tingkat' => round($r_tingkat, 4),
                'r_juara' => round($r_juara, 4),
                'r_eng' => round($r_eng, 4),
                'score' => round($score, 6),
                'best_tingkat_label' => $this->labelTingkat($bestTingkatNum),
                'best_juara_label' => $this->labelJuara($bestJuaraNum),
            ];
        }

        usort($rows, function($a, $b){
            if ($a['score'] === $b['score']) return 0;
            return $a['score'] < $b['score'] ? 1 : -1;
        });
        foreach ($rows as $i => &$row) { $row['rank'] = $i + 1; }
        unset($row);

        return [$rows, $weights, $tahun];
    }

    /**
     * Form bobot AHP (isi 6 nilai perbandingan) dan tampilkan bobot tersimpan terakhir.
     */
    public function weightsForm(Request $r)
    {
        $tahun = $r->integer('tahun');
        $latest = null;
        if (Schema::hasTable('decision_weights')) {
            $latest = DecisionWeight::query()
                ->where('context', 'prestasi_mahasiswa')
                ->when($tahun, fn($q) => $q->where('tahun', $tahun))
                ->orderByDesc('id')
                ->first();
        }

        return view('Admin.mahasiswa_berprestasi.weights', [
            'tahun' => $tahun,
            'latest' => $latest,
        ]);
    }

    /**
     * Hitung AHP (4x4) dari 6 input, uji konsistensi, simpan jika CR <= 0.10.
     */
    public function weightsStore(Request $r)
    {
        if (!Schema::hasTable('decision_weights')) {
            return back()->withInput()->withErrors([
                'database' => 'Tabel decision_weights belum ada. Jalankan migrasi: php artisan migrate',
            ]);
        }
        $data = $r->validate([
            'tahun' => 'nullable|integer',
            'a12' => 'required|numeric|gt:0',
            'a13' => 'required|numeric|gt:0',
            'a14' => 'required|numeric|gt:0',
            'a23' => 'required|numeric|gt:0',
            'a24' => 'required|numeric|gt:0',
            'a34' => 'required|numeric|gt:0',
        ]);

        // Build 4x4 matrix for [IPK, Tingkatan, Juara, English]
        $a12 = (float)$data['a12']; $a13=(float)$data['a13']; $a14=(float)$data['a14'];
        $a23 = (float)$data['a23']; $a24=(float)$data['a24']; $a34=(float)$data['a34'];

        $A = [
            [1,    $a12,  $a13,  $a14],
            [1/$a12, 1,    $a23,  $a24],
            [1/$a13, 1/$a23, 1,    $a34],
            [1/$a14, 1/$a24, 1/$a34, 1],
        ];

        // Column sums
        $colSums = [0,0,0,0];
        for ($j=0;$j<4;$j++) {
            $s=0; for ($i=0;$i<4;$i++) { $s += $A[$i][$j]; }
            $colSums[$j]=$s;
        }

        // Normalize columns and average rows to get weights
        $W = [0,0,0,0];
        for ($i=0;$i<4;$i++) {
            $rowAvg=0; for ($j=0;$j<4;$j++) { $rowAvg += $A[$i][$j]/$colSums[$j]; }
            $W[$i] = $rowAvg/4.0;
        }

        // Normalize W to sum 1
        $sumW = array_sum($W) ?: 1; $W = array_map(fn($x)=>$x/$sumW, $W);

        // Consistency check: v = A*W, lambda_max = avg(v_i / W_i)
        $v = [0,0,0,0];
        for ($i=0;$i<4;$i++) {
            $s=0; for ($j=0;$j<4;$j++) { $s += $A[$i][$j]*$W[$j]; }
            $v[$i]=$s;
        }
        $ratios = [];
        for ($i=0;$i<4;$i++) { $ratios[] = $W[$i] > 0 ? ($v[$i]/$W[$i]) : 0; }
        $lambda = array_sum($ratios)/4.0;
        $ci = ($lambda - 4)/3.0;
        $ri = 0.90; // RI untuk n=4
        $cr = $ri > 0 ? ($ci/$ri) : 0;

        // Susun output weights dengan key
        $outWeights = [
            'ipk' => $W[0],
            'tingkat' => $W[1],
            'juara' => $W[2],
            'english' => $W[3],
        ];

        // Simpan jika konsisten, kalau tidak kembalikan dengan error
        if ($cr > 0.10) {
            return back()->withInput()->withErrors([
                'matrix' => 'Rasio konsistensi (CR) = '.number_format($cr,3).' > 0.10. Mohon revisi penilaian.'
            ]);
        }

        DecisionWeight::create([
            'context' => 'prestasi_mahasiswa',
            'method' => 'AHP',
            'tahun' => $data['tahun'] ?? null,
            'matrix' => $A,
            'weights' => $outWeights,
            'lambda_max' => $lambda,
            'ci' => $ci,
            'cr' => $cr,
        ]);

        return redirect()->route('admin.mahasiswa_berprestasi.weights', ['tahun' => $data['tahun'] ?? null])
            ->with('success', 'Bobot AHP tersimpan. CR='.number_format($cr,3).'.');
    }

    private function mapTingkat(?string $tingkat): ?int
    {
        if (!$tingkat) return null;
        $t = mb_strtolower(trim($tingkat));
        return match (true) {
            str_contains($t, 'internasional') || str_contains($t, 'international') => 1,
            str_contains($t, 'nasional') || str_contains($t, 'national') => 2,
            str_contains($t, 'prov') || str_contains($t, 'province') => 3,
            str_contains($t, 'kab/') || str_contains($t, 'kabupaten') || str_contains($t, 'kota') => 4, // Kab/Kota
            str_contains($t, 'kampus') || str_contains($t, 'universitas') || str_contains($t, 'perguruan') => 5,
            default => null,
        };
    }

    private function labelTingkat(int $num): string
    {
        return match ($num) {
            1 => 'Internasional',
            2 => 'Nasional',
            3 => 'Provinsi',
            4 => 'Kabupaten/Kota',
            5 => 'Kampus',
            default => '-',
        };
    }

    private function mapJuara(?string $peringkat): int
    {
        if (!$peringkat) return 1;
        $p = mb_strtolower(trim($peringkat));

        // Numerik langsung
        if (is_numeric($p)) {
            $n = (int) $p;
            return match (true) {
                $n <= 1 => 5,
                $n === 2 => 4,
                $n === 3 => 3,
                default => 1,
            };
        }

        // Kata kunci umum
        if (str_contains($p, 'juara 1') || str_contains($p, 'gold') || str_contains($p, 'emas')) return 5;
        if (str_contains($p, 'juara 2') || str_contains($p, 'silver') || str_contains($p, 'perak')) return 4;
        if (str_contains($p, 'juara 3') || str_contains($p, 'bronze') || str_contains($p, 'perunggu')) return 3;
        if (str_contains($p, 'final') || str_contains($p, 'harapan')) return 2; // finalis/harapan
        if (str_contains($p, 'part') || str_contains($p, 'peserta')) return 1; // partisipasi

        return 1; // default aman
    }

    private function labelJuara(int $num): string
    {
        return match ($num) {
            5 => 'Juara 1/Gold',
            4 => 'Juara 2/Silver',
            3 => 'Juara 3/Bronze',
            2 => 'Finalis/Harapan',
            default => 'Partisipasi',
        };
    }

    private function normalizeTingkatBenefit(int $num): float
    {
        // mapping 1..5, lebih kecil lebih baik → ubah ke 0..1 sebagai benefit
        return max(0, min(1, (5 - $num) / 4));
    }

    private function normalizeJuara(int $num): float
    {
        // 1..5 → 0.2..1.0
        return max(0, min(1, $num / 5));
    }

    private function normalizeEnglish(string $type, float $score): float
    {
        $t = strtoupper(trim($type));
        if ($t === 'IELTS') {
            return max(0, min(1, $score / 9.0));
        }
        if ($t === 'TOEFL_IBT' || $t === 'TOEFL-IBT' || $t === 'IBT') {
            return max(0, min(1, $score / 120.0));
        }
        if ($t === 'TOEFL_ITP' || $t === 'TOEFL-ITP' || $t === 'ITP') {
            return max(0, min(1, $score / 677.0));
        }
        if ($t === 'CEFR') {
            // Jika skor angka, asumsikan level 1..6; jika huruf A1..C2, map ke 1..6
            $map = [
                'A1' => 1, 'A2' => 2, 'B1' => 3, 'B2' => 4, 'C1' => 5, 'C2' => 6,
            ];
            $level = $score;
            // Jika score bukan 1..6, coba parse dari string type/score (fallback aman)
            if ($score < 1 || $score > 6) {
                $level = 0;
            }
            return max(0, min(1, $level / 6.0));
        }
        // Default: skala maks 100
        return max(0, min(1, $score / 100.0));
    }
}
