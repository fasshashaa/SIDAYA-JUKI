<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Services\FonnteService;

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
        // 1. Lakukan autentikasi kredensial dasar (Email & Password) lewat Breeze Request
        $request->authenticate();

        // 2. Ambil data user yang berhasil lolos pengecekan password
        $user = auth()->user(); 

        // 3. Cek apakah status akun dinonaktifkan oleh administrator
        if ($user->status === 'nonaktif') {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
            ])->onlyInput('email');
        }

        // 4. PENYARINGAN ROLE & CEK TOGGLE GATEWAY (ISO 27001 Kontrol A.8.5)
        $roleUser = strtolower(trim($user->role));
        
        // Ambil status toggle OTP dari database, default-kan ke 'on' jika tidak ditemukan
        $otpSetting = \Illuminate\Support\Facades\DB::table('settings')
            ->where('key', 'otp_gateway_status')
            ->value('value') ?? 'on';

        if (($roleUser === 'super_admin' || $roleUser === 'superadmin' || $roleUser === 'admin') && $otpSetting === 'on') {
            
            // Generate 6 digit kode OTP acak
            $kodeOtp = rand(100000, 999999);
            
            // Simpan kode OTP dan masa berlaku ke database
            $user->otp_code = $kodeOtp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->save();

            // Kirim OTP menggunakan Service Fonnte ke nomor WhatsApp user
            FonnteService::sendOtp($user->nomor_wa, $kodeOtp);

            // LOGOUT SEMENTARA
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login.otp-verify', ['id' => $user->id])
                             ->with('info', 'Verifikasi tambahan diperlukan untuk akun administratif.');
        }

        // 5. JIKA ROLE USER BIASA ATAU TOGGLE OTP ='off': Langsung buat session login tanpa intersep OTP
        $request->session()->regenerate();

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