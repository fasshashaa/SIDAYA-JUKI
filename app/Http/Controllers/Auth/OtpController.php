<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function index()
    {
        // Tampilkan halaman form input OTP
        $user = Auth::user();
        if (!$user || $user->otp_code === null) {
            return redirect()->route('dashboard');
        }

        return view('auth.otp-verify', compact('user'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp_code' => 'required|string|size:6',
        ]);

        $user = Auth::user();

        // Cek apakah OTP cocok dan belum kedaluwarsa
        if ($user->otp_code === $request->otp_code && now()->lessThanOrEqualTo($user->otp_expires_at)) {
            // Kosongkan OTP di DB menandakan akun sukses diverifikasi
            $user->update([
                'otp_code' => null,
                'otp_expires_at' => null,
            ]);

            return redirect()->route('dashboard')->with('status', 'Verifikasi OTP berhasil!');
        }

        return back()->withErrors(['otp_code' => 'Kode OTP salah atau telah kedaluwarsa.']);
    }

    public function resend()
    {
        $user = Auth::user();
        
        // Generate ulang kode 6 digit baru dengan masa aktif 5 menit
        $newOtp = rand(100000, 999999);
        $user->update([
            'otp_code' => $newOtp,
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        // Kirim OTP via WA/Email Logika taruh di sini (sementara di-log atau langsung muncul di view)
        return back()->with('status', 'Kode OTP baru telah dikirim!');
    }
}