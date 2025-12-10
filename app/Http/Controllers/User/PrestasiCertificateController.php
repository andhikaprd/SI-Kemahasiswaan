<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MahasiswaBerprestasi;
use App\Models\PrestasiCertificate;
use Illuminate\Http\Request;

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
            $path = $file->store('prestasi/sertifikat','public');
            PrestasiCertificate::create([
                'prestasi_id'    => $prestasi->id,
                'user_id'        => $r->user()->id,
                'path'           => $path,
                'original_name'  => $file->getClientOriginalName(),
                'mime'           => $file->getClientMimeType(),
                'size'           => $file->getSize(),
                'status'         => 'approved', // auto-approve untuk pemilik
            ]);
        }

        return redirect()->route('prestasi.show', $prestasi->slug)
            ->with('status','Sertifikat berhasil diunggah.');
    }

    public function destroy(MahasiswaBerprestasi $prestasi, PrestasiCertificate $certificate)
    {
        $this->authorizeManage($prestasi, $certificate);
        $certificate->delete();

        return back()->with('status', 'Sertifikat berhasil dihapus.');
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
        $userNim = trim((string) ($user->nim ?? ''));
        $prestasiNim = trim((string) ($prestasi->nim ?? ''));
        $isOwnerPrestasi = $userNim !== '' && strcasecmp($userNim, $prestasiNim) === 0;
        $isUploader = $certificate->user_id === ($user?->id ?? 0);

        if (!($isOwnerPrestasi && $isUploader)) {
            abort(403, 'Anda tidak dapat menghapus sertifikat ini.');
        }
    }
}
