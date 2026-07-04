<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
  public function store(LoginRequest $request)
    {
        // 1. Lakukan autentikasi
        $request->authenticate();

        // 2. Ambil user yang sedang login
        $user = auth()->user(); 

        // 3. Cek status akun (tetap pertahankan keamanan ini)
        if ($user->status === 'nonaktif') {
            auth()->guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        // --- TAMBAHAN: LOGIKA REDIRECT BERDASARKAN ROLE ---
        if ($user->role === 'pelanggan') {
            // Arahkan pelanggan ke marketplace
            return redirect()->intended(route('marketplace.index')); 
        }

        // Arahkan admin, user (UMKM), dan super_admin ke dashboard
        return redirect()->intended(route('dashboard', absolute: false));
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
