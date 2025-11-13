<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index(Request $r)
    {
        $q = Mahasiswa::query()
            ->when($r->q, function ($qq) use ($r) {
                $qq->where(function ($w) use ($r) {
                    $w->where('nama', 'like', "%{$r->q}%")
                      ->orWhere('nim', 'like', "%{$r->q}%")
                      ->orWhere('angkatan', 'like', "%{$r->q}%");
                });
            })
            ->orderBy('nama');

        $mahasiswas = $q->paginate(15)->withQueryString();

        return view('Admin.mahasiswa.index', compact('mahasiswas'));
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $englishTypes = ['IELTS','TOEFL_IBT','TOEFL_ITP','CEFR'];
        return view('Admin.mahasiswa.edit', compact('mahasiswa','englishTypes'));
    }

    public function update(Request $r, Mahasiswa $mahasiswa)
    {
        $r->validate([
            'ipk' => 'nullable|numeric|min:0|max:4',
            'english_type' => 'nullable|string|in:IELTS,TOEFL_IBT,TOEFL_ITP,CEFR',
            'english_score' => 'nullable|numeric|min:0',
        ]);

        $data = $r->only(['ipk','english_type','english_score']);
        $mahasiswa->update($data);

        return redirect()->route('admin.mahasiswa.index')->with('success', 'Data mahasiswa berhasil diperbarui.');
    }
}

