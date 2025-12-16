<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DownloadController extends Controller
{
    public function laporan(Laporan $laporan)
    {
        if (!$laporan->file_path) {
            Log::warning('laporan_download_missing_path', [
                'scope' => 'kaprodi_verifikasi',
                'laporan_id' => $laporan->id,
                'user_id' => auth()->id(),
            ]);
            abort(404);
        }
        $disk = Storage::disk('local')->exists($laporan->file_path) ? 'local' : (Storage::disk('public')->exists($laporan->file_path) ? 'public' : null);
        if (!$disk) {
            Log::warning('laporan_download_file_not_found', [
                'scope' => 'kaprodi_verifikasi',
                'laporan_id' => $laporan->id,
                'user_id' => auth()->id(),
                'path' => $laporan->file_path,
            ]);
            abort(404);
        }
        $filename = basename($laporan->file_path) ?: 'laporan.pdf';
        return Storage::disk($disk)->download($laporan->file_path, $filename);
    }
}
