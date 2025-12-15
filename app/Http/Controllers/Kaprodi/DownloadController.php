<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function laporan(Laporan $laporan)
    {
        if (!$laporan->file_path) {
            abort(404);
        }
        $disk = Storage::disk('local')->exists($laporan->file_path) ? 'local' : (Storage::disk('public')->exists($laporan->file_path) ? 'public' : null);
        if (!$disk) {
            abort(404);
        }
        $filename = basename($laporan->file_path) ?: 'laporan.pdf';
        return Storage::disk($disk)->download($laporan->file_path, $filename);
    }
}
