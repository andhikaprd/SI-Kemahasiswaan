<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PrestasiCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        if (!$certificate->path || !Storage::disk('public')->exists($certificate->path)) {
            abort(404);
        }
        return Storage::disk('public')->download($certificate->path, $certificate->original_name ?? 'sertifikat.pdf');
    }

    public function destroy(PrestasiCertificate $certificate)
    {
        $certificate->delete();
        return back()->with('success', 'Sertifikat berhasil dihapus.');
    }
}
