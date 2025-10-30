<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    private function fallbackForRole(User $user): string
    {
        return match ($user->role) {
            'admin'   => route('admin.dashboard'),
            'kaprodi' => route('kaprodi.laporan.index'),
            default   => route('pendaftaran.create'),
        };
    }

    public function login(): \Illuminate\View\View
    {
        return view('auth.login');
    }

    public function handlePasswordLogin(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required','string'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = $request->user();
            return redirect()->intended($this->fallbackForRole($user));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->withInput(['email' => $request->email]);
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(): RedirectResponse
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName() ?: ($googleUser->getNickname() ?: 'User'),
                // set random password (not used for SSO)
                'password' => Str::password(),
                'role' => 'mahasiswa',
                'status' => 'aktif',
            ]
        );

        // If name changed on Google, keep our name in sync (optional)
        if ($googleUser->getName() && $user->name !== $googleUser->getName()) {
            $user->name = $googleUser->getName();
            $user->save();
        }

        Auth::login($user, remember: true);

        // Redirect intent: if user attempted protected page, go there; else by role
        return redirect()->intended($this->fallbackForRole($user));
    }
}
