<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use App\Models\PrestasiCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PrestasiCertificateController extends Controller
{
    public function create(MahasiswaBerprestasi $prestasi)
    {
        $this->authorizeUpload($prestasi);
        return view('user.prestasi.upload_certificate', compact('prestasi'));
    }

    public function store(Request $r, MahasiswaBerprestasi $prestasi)
    {
        $this->authorizeUpload($prestasi);

        $data = $r->validate([
            'files'   => ['required','array','min:1'],
            'files.*' => ['file','mimes:pdf,jpg,jpeg,png','max:10240'],
        ]);

        foreach ($data['files'] as $file) {
            // Simpan di storage privat agar tidak bisa diakses bebas lewat URL
            $path = $file->store('prestasi/sertifikat', 'local');
            PrestasiCertificate::create([
                'prestasi_id'    => $prestasi->id,
                'user_id'        => $r->user()->id,
                'path'           => $path,
                'original_name'  => $file->getClientOriginalName(),
                'mime'           => $file->getClientMimeType(),
                'size'           => $file->getSize(),
                'status'         => 'pending',
            ]);
        }

        return redirect()->route('prestasi.show', $prestasi->slug)
            ->with('status','Sertifikat berhasil diunggah dan menunggu persetujuan admin.');
    }

    public function destroy(MahasiswaBerprestasi $prestasi, PrestasiCertificate $certificate)
    {
        $this->authorizeManage($prestasi, $certificate);
        $certificate->delete();

        return back()->with('status', 'Sertifikat berhasil dihapus.');
    }

    public function download(MahasiswaBerprestasi $prestasi, PrestasiCertificate $certificate)
    {
        $this->authorizeManage($prestasi, $certificate);
        if ($certificate->prestasi_id !== $prestasi->id) {
            abort(404);
        }

        if (!$certificate->path) {
            abort(404);
        }

        $disk = Storage::disk('local')->exists($certificate->path) ? 'local' : (Storage::disk('public')->exists($certificate->path) ? 'public' : null);
        if (!$disk) {
            abort(404);
        }

        return Storage::disk($disk)->download(
            $certificate->path,
            $certificate->original_name ?? 'sertifikat.pdf'
        );
    }

    private function authorizeUpload(MahasiswaBerprestasi $prestasi): void
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return;
        }
        $userNim = trim((string) ($user->nim ?? ''));
        $prestasiNim = trim((string) ($prestasi->nim ?? ''));
        $nameMatch = strcasecmp(trim((string)$user->name), trim((string)$prestasi->nama)) === 0;
        $nimMatch = $userNim !== '' && strcasecmp($userNim, $prestasiNim) === 0;

        if (!$nimMatch && !$nameMatch) {
            abort(403, 'Anda tidak dapat mengunggah sertifikat untuk prestasi ini.');
        }
    }

    private function authorizeManage(MahasiswaBerprestasi $prestasi, PrestasiCertificate $certificate): void
    {
        $user = auth()->user();
        if ($user && $user->role === 'admin') {
            return;
        }
        if ($certificate->prestasi_id !== $prestasi->id) {
            abort(404);
        }
        $userNim = trim((string) ($user->nim ?? ''));
        $prestasiNim = trim((string) ($prestasi->nim ?? ''));
        $isOwnerPrestasi = $userNim !== '' && strcasecmp($userNim, $prestasiNim) === 0;
        $isUploader = $certificate->user_id === ($user?->id ?? 0);

        if (!($isOwnerPrestasi && $isUploader)) {
            abort(403, 'Anda tidak dapat menghapus sertifikat ini.');
        }
    }
}
