<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Akun::all();
        return view('admin.account.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.account.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'nullable|in:admin,kaprodi,mahasiswa',
            'status' => 'nullable|in:aktif,tidak aktif',
        ]);

        Akun::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role ?? 'mahasiswa',
            'status' => $request->status ?? 'aktif',
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('admin.account.index')->with('success', 'Akun berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $account = Akun::findOrFail($id);
        return view('admin.account.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = Akun::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $account->id,
            'role' => 'nullable|in:admin,kaprodi,mahasiswa',
            'status' => 'nullable|in:aktif,tidak aktif',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role ?? $account->role,
            'status' => $request->status ?? $account->status,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $account->update($data);

        return redirect()->route('admin.account.index')->with('success', 'Akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $account = Akun::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.account.index')->with('success', 'Akun berhasil dihapus!');
    }
}
