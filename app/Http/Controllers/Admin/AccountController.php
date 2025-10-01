<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Akun; // Pastikan nama Model ini sesuai dengan model Anda (bisa Akun atau User)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    /**
     * Menampilkan halaman daftar akun.
     */
    public function index()
    {
        $accounts = Akun::latest()->paginate(10);
        return view('admin.account.index', compact('accounts'));
    }

    /**
     * Menampilkan form untuk membuat akun baru.
     */
    public function create()
    {
        return view('admin.account.create');
    }

    /**
     * Menyimpan akun baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:akuns', // 'akuns' adalah nama tabel
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,mahasiswa,kaprodi',
            'status' => 'required|string',
            'nim' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'angkatan' => 'nullable|integer',
        ]);

        Akun::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status' => $request->status,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'angkatan' => $request->angkatan,
        ]);

        return redirect()->route('admin.account.index')->with('success', 'Akun pengguna berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit akun.
     */
    public function edit(Akun $account)
    {
        return view('admin.account.edit', compact('account'));
    }

    /**
     * Mengupdate akun di database.
     */
    public function update(Request $request, Akun $account)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('akuns')->ignore($account->id)],
            'role' => 'required|string|in:admin,mahasiswa,kaprodi',
            'status' => 'required|string',
            'nim' => 'nullable|string',
            'jurusan' => 'nullable|string',
            'angkatan' => 'nullable|integer',
            'password' => 'nullable|string|min:8',
        ]);

        $dataToUpdate = $request->except('password');

        // Jika ada password baru yang diinput, hash dan tambahkan ke data update
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password);
        }

        $account->update($dataToUpdate);

        return redirect()->route('admin.account.index')->with('success', 'Akun pengguna berhasil diperbarui!');
    }

    /**
     * Menghapus akun dari database.
     */
    public function destroy(Akun $account)
    {
        // Tambahkan logika untuk mencegah user menghapus akunnya sendiri jika perlu
        // if (auth()->id() == $account->id) {
        //     return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        // }

        $account->delete();

        return redirect()->route('admin.account.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}

