<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    private function fallbackForRole(User $user): string
    {
        $role = $user->role ?? 'mahasiswa';
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'kaprodi' => route('kaprodi.laporan.index'),
            default => route('beranda'),
        };
    }

    public function show(): \Illuminate\View\View
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:150', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'mahasiswa',
            'status' => 'aktif',
        ]);

        Auth::login($user, remember: true);

        return redirect()->intended($this->fallbackForRole($user));
    }
}
