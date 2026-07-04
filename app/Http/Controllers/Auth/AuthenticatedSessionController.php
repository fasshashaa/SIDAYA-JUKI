<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\FonnteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Autentikasi kredensial dasar (email & password) lewat Breeze Request
        $request->authenticate();

        $user = auth()->user();

        // 2. Cek apakah akun dinonaktifkan administrator
        if ($user->status === 'nonaktif') {
            $this->logoutSession($request);

            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
            ])->onlyInput('email');
        }

        // 3. Cek apakah role ini wajib verifikasi OTP tambahan (ISO 27001 Kontrol A.8.5)
        $role = strtolower(trim($user->role));
        $isPrivilegedRole = in_array($role, ['super_admin', 'superadmin', 'admin']);

        $otpGatewayOn = DB::table('settings')
            ->where('key', 'otp_gateway_status')
            ->value('value') ?? 'on';

        if ($isPrivilegedRole && $otpGatewayOn === 'on') {
            $kodeOtp = rand(100000, 999999);

            $user->otp_code = $kodeOtp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            FonnteService::sendOtp($user->nomor_wa, $kodeOtp);

            // Logout sementara — session penuh baru dibuat setelah OTP diverifikasi
            $this->logoutSession($request);

            return redirect()
                ->route('login.otp-verify', ['id' => $user->id])
                ->with('info', 'Verifikasi tambahan diperlukan untuk akun administratif.');
        }

        // 4. Role biasa atau toggle OTP mati: buat session penuh langsung
        $request->session()->regenerate();

        if ($role === 'pelanggan') {
            return redirect()->intended(route('marketplace.index'));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->logoutSession($request);

        return redirect('/');
    }

    /**
     * Logout guard "web" dan invalidasi session + regenerate token CSRF.
     */
    private function logoutSession(Request $request): void
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}