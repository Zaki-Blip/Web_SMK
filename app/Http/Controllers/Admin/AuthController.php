<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Form login admin.
     */
    public function showLoginForm(): View
    {
        return view('admin.auth.login');
    }

    /**
     * Proses login: validasi, throttle, regenerasi session.
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $request->ensureIsNotRateLimited();

        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->hitRateLimiter();

            throw ValidationException::withMessages([
                'email' => 'Email atau kata sandi tidak cocok.',
            ]);
        }

        // Akun tanpa role admin tidak boleh masuk ke dashboard.
        if (! $request->user()?->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $request->hitRateLimiter();

            throw ValidationException::withMessages([
                'email' => 'Akun ini tidak memiliki akses ke dashboard admin.',
            ]);
        }

        $request->clearRateLimiter();
        $request->session()->regenerate();

        return redirect()->intended(route('admin.dasbor'))
            ->with('success', 'Selamat datang, '.$request->user()->name.'!');
    }

    /**
     * Logout aman: hanya menerima POST, session diinvalidasi.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'Anda telah keluar dari dashboard.');
    }
}
