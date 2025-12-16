<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran; // Pastikan Anda sudah membuat model Pendaftaran
use App\Models\Divisi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan form pendaftaran HIMA.
     */
    public function create()
    {
        $user = auth()->user();
        if ($user) {
            $sudahDaftar = Pendaftaran::where('email', $user->email)
                ->orWhere('nim', $user->nim)
                ->exists();
            if ($sudahDaftar) {
                return redirect()->route('beranda')
                    ->with('status', 'Anda sudah mengirim pendaftaran sebelumnya. Satu akun hanya bisa mendaftar sekali.');
            }
        }
        $divisis = collect();
        if (Schema::hasTable('divisis')) {
            $divisis = Divisi::orderBy('urutan')->orderBy('nama')->get();
        }
        $divisiOptions = $divisis->pluck('nama')->all();
        if (empty($divisiOptions)) {
            $divisiOptions = ['Kaderisasi','Media Informasi','Technopreneurship','Public Relations'];
        }

        return view('user.pendaftaran.form', compact('divisiOptions'));
    }

    /**
     * Menyimpan data pendaftaran baru ke database.
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $sudahDaftar = Pendaftaran::where('email', $user->email)
            ->orWhere('nim', $user->nim)
            ->exists();
        if ($sudahDaftar) {
            return redirect()->route('pendaftaran.create')
                ->withErrors(['email' => 'Anda sudah mengirim pendaftaran. Satu akun hanya bisa mendaftar sekali.']);
        }

        // Validasi semua input dari form
        $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20|unique:pendaftarans,nim', // 'pendaftarans' adalah nama tabel
            'angkatan' => 'required|integer',
            'email' => 'required|email|max:255|unique:pendaftarans,email',
            'telepon' => [
                'required',
                'string',
                'regex:/^(?:0|62)?[0-9]{8,13}$/',
            ],
            'divisi' => 'required|string',
            'motivasi' => 'required|string|max:1000',
        ], [
            'telepon.regex' => 'Format WA harus angka saja, boleh diawali 0 atau 62.',
        ]);

        Pendaftaran::create([
            'nama_lengkap' => $request->nama,
            'nim' => $request->nim,
            'angkatan' => $request->angkatan,
            // Kolom jurusan wajib di DB, set default TI
            'jurusan' => 'Teknologi Informasi',
            'email' => $request->email,
            'no_telp' => $this->normalizeWhatsapp($request->telepon),
            'divisi_pilihan' => $request->divisi,
            'motivasi' => $request->motivasi,
        ]);

        // Redirect kembali ke halaman form dengan pesan sukses
        return redirect()->route('pendaftaran.create')->with('success', 'Pendaftaran Anda telah berhasil dikirim! Terima kasih telah mendaftar.');
    }

    /**
     * Normalisasi nomor WA ke digit-only, prefiks 62 jika diawali 0.
     */
    private function normalizeWhatsapp(string $raw): string
    {
        $digits = preg_replace('/\\D+/', '', $raw) ?? '';
        if ($digits === '') {
            return '';
        }
        if (str_starts_with($digits, '0')) {
            $digits = '62' . ltrim($digits, '0');
        }
        return $digits;
    }
}
