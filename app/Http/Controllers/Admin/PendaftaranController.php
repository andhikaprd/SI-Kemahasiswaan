<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PendaftaranController extends Controller
{
    // Daftar pendaftar HIMA
    public function index()
    {
        $items = Pendaftaran::latest()->paginate(20);
        return view('Admin.pendaftaran.index', compact('items'));
    }

    // Perbarui status (Pending/Diterima/Ditolak)
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $request->validate([
            'status' => 'required|in:Pending,Diterima,Ditolak',
        ]);

        $pendaftaran->update(['status' => $request->status]);

        return back()->with('success', 'Status pendaftaran diperbarui.');
    }

    public function processBulk(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required','array','min:1'],
            'ids.*' => ['integer','exists:pendaftarans,id'],
            'status' => ['required','in:Pending,Diterima,Ditolak'],
        ]);

        Pendaftaran::whereIn('id', $data['ids'])
            ->update(['status' => $data['status']]);

        return back()->with('success', 'Status ' . count($data['ids']) . ' pendaftar diperbarui menjadi ' . $data['status'] . '.');
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'pendaftaran-hima-' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Lengkap','NIM','Jurusan','Angkatan','Email','No Telp','Divisi Pilihan','Motivasi','Status','Tanggal Daftar']);
            Pendaftaran::orderByDesc('created_at')->chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->nama_lengkap,
                        $row->nim,
                        $row->jurusan,
                        $row->angkatan,
                        $row->email,
                        $row->no_telp,
                        $row->divisi_pilihan,
                        $row->motivasi,
                        $row->status,
                        optional($row->created_at)?->format('Y-m-d H:i'),
                    ]);
                }
            });
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy(Pendaftaran $pendaftaran)
    {
        $pendaftaran->delete();
        return back()->with('success', 'Data pendaftaran dihapus.');
    }
}
