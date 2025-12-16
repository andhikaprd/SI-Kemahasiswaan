<?php

namespace App\Http\Controllers;

use App\Models\PelanggaranMaster;
use Illuminate\Http\Request;

abstract class PelanggaranMasterController extends Controller
{
    protected string $viewBase;
    protected string $routeBase;

    public function index()
    {
        $items = PelanggaranMaster::orderBy('kategori')->orderBy('nama')->get();

        return view($this->view('index'), compact('items'));
    }

    public function create()
    {
        return view($this->view('create'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        PelanggaranMaster::create($data);

        return redirect()->route($this->route('index'))->with('success', 'Master pelanggaran berhasil ditambahkan.');
    }

    public function edit(PelanggaranMaster $pelanggaran_master)
    {
        return view($this->view('edit'), ['item' => $pelanggaran_master]);
    }

    public function update(Request $request, PelanggaranMaster $pelanggaran_master)
    {
        $data = $request->validate($this->rules($pelanggaran_master->id));
        $pelanggaran_master->update($data);

        return redirect()->route($this->route('index'))->with('success', 'Master pelanggaran berhasil diperbarui.');
    }

    public function destroy(PelanggaranMaster $pelanggaran_master)
    {
        $pelanggaran_master->delete();

        return redirect()->route($this->route('index'))->with('success', 'Master pelanggaran berhasil dihapus.');
    }

    protected function rules(?int $ignoreId = null): array
    {
        $uniqueNama = 'unique:pelanggaran_masters,nama';
        if ($ignoreId) {
            $uniqueNama .= ',' . $ignoreId;
        }

        return [
            'nama' => ['required', 'string', 'max:255', $uniqueNama],
            'kategori' => ['required', 'in:ringan,sedang,berat'],
            'deskripsi' => ['nullable', 'string'],
            'sanksi_default' => ['nullable', 'string', 'max:255'],
        ];
    }

    protected function view(string $view): string
    {
        return $this->viewBase . '.' . $view;
    }

    protected function route(string $name): string
    {
        return $this->routeBase . '.' . $name;
    }
}
