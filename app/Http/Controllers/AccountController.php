<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    // 📌 Tampilkan semua account
    public function index()
    {
        $account = Akun::all();
        return view('account.index', compact('account'));
    }

    // 📌 Form tambah account
    public function create()
    {
        return view('account.create');
    }

    // 📌 Simpan data account baru
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:akun,email',
            'password' => 'required|min:6',
        ]);

        Akun::create([
            'username' => $request->username,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('account.index')->with('success', 'Account berhasil ditambahkan!');
    }

    // 📌 Form edit account
    public function edit($id)
    {
        $account = Akun::findOrFail($id);
        return view('account.edit', compact('account'));
    }

    // 📌 Update data account
    public function update(Request $request, $id)
    {
        $account = Akun::findOrFail($id);

        $request->validate([
            'username' => 'required',
            'email'    => 'required|email|unique:akun,email,' . $account->id_akun . ',id_akun',
        ]);

        $account->update([
            'username' => $request->username,
            'email'    => $request->email,
            // password hanya diubah kalau diisi
            'password' => $request->password ? bcrypt($request->password) : $account->password,
        ]);

        return redirect()->route('account.index')->with('success', 'Account berhasil diupdate!');
    }

    // 📌 Hapus data account
    public function destroy($id)
    {
        $account = Akun::findOrFail($id);
        $account->delete();

        return redirect()->route('account.index')->with('success', 'Account berhasil dihapus!');
    }
}
