<?php

namespace App\Http\Controllers\Kaprodi;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function laporan(Laporan $laporan)
    {
        if (!$laporan->file_path || !Storage::disk('public')->exists($laporan->file_path)) {
            abort(404);
        }
        $filename = basename($laporan->file_path) ?: 'laporan.pdf';
        return Storage::disk('public')->download($laporan->file_path, $filename);
    }
}

