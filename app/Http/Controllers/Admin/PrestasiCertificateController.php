<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PrestasiCertificateController extends Controller
{
    public function index(Request $r)
    {
        $q = PrestasiCertificate::query()
            ->with(['prestasi', 'user'])
            ->orderByDesc('created_at');

        $items = $q->paginate(15)->withQueryString();
        $counts = [
            'approved' => PrestasiCertificate::where('status', 'approved')->count(),
            'total'    => PrestasiCertificate::count(),
        ];

        return view('Admin.prestasi_certificates.index', compact('items', 'counts'));
    }

    public function download(PrestasiCertificate $certificate)
    {
        if (!$certificate->path) {
            Log::warning('prestasi_certificate_missing_path', [
                'scope' => 'admin',
                'certificate_id' => $certificate->id,
                'user_id' => auth()->id(),
            ]);
            abort(404);
        }
        $disk = Storage::disk('local')->exists($certificate->path) ? 'local' : (Storage::disk('public')->exists($certificate->path) ? 'public' : null);
        if (!$disk) {
            Log::warning('prestasi_certificate_file_not_found', [
                'scope' => 'admin',
                'certificate_id' => $certificate->id,
                'user_id' => auth()->id(),
                'path' => $certificate->path,
            ]);
            abort(404);
        }
        return Storage::disk($disk)->download($certificate->path, $certificate->original_name ?? 'sertifikat.pdf');
    }

    public function destroy(PrestasiCertificate $certificate)
    {
        $certificate->delete();
        return back()->with('success', 'Sertifikat berhasil dihapus.');
    }

    public function updateStatus(Request $request, PrestasiCertificate $certificate)
    {
        $data = $request->validate([
            'status' => ['required', 'in:approved,rejected,pending'],
            'note'   => ['nullable','string','max:500'],
        ]);

        $certificate->update($data);

        return back()->with('success', 'Status sertifikat diperbarui.');
    }
}
