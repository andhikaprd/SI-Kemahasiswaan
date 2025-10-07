<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Menampilkan semua akun.
     */
    public function index()
    {
        $account = Akun::all();
        return view('admin.account.index', compact('account'));
    }

    /**
     * Menampilkan form tambah akun.
     */
    public function create()
    {
        return view('admin.account.create');
    }

    /**
     * Menyimpan akun baru.
     */
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

        return redirect()->route('admin.account.index')->with('success', 'Account berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit akun.
     */
    public function edit($id)
    {
        $account = Akun::findOrFail($id);
        return view('admin.account.edit', compact('account'));
    }

    /**
     * Memperbarui data akun.
     */
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
            'password' => $request->password ? bcrypt($request->password) : $account->password,
        ]);

        return redirect()->route('admin.account.index')->with('success', 'Account berhasil diupdate!');
    }

    /**
     * Menghapus akun.
     */
    public function destroy($id)
    {
        $account = Akun::findOrFail($id);
        $account->delete();

        return redirect()->route('admin.account.index')->with('success', 'Account berhasil dihapus!');
    }
}

