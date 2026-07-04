<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Services\FonnteService;

class OtpController extends Controller
{
    // 1. Menampilkan Halaman Input OTP
    public function showOtpForm($id)
    {
        $user = User::findOrFail($id);

        return view('auth.otp-verify', compact('user'));
    }

    // 2. Memproses Validasi Kode OTP yang diinput oleh user Admin/Super Admin
    public function verifikasiOtp(Request $request, $id)
    {
        $request->validate([
            'otp_input' => 'required|numeric',
        ]);

        // Cari user berdasarkan ID dari URL route (Gunakan $id, bukan $request->user_id)
        $user = User::findOrFail($id);

        // ===================================================================
        // DEBUG TRIGGER: Pindahkan DD ke sini agar langsung tereksekusi murni
        // ===================================================================
        if ($user->role === 'superadmin') {
            dd([
                'Role User' => $user->role,
                'OTP di Database' => $user->otp_code,
                'Tipe OTP DB' => gettype($user->otp_code),
                'OTP yang Kamu Input' => $request->otp_input,
                'Tipe OTP Input' => gettype($request->otp_input),
            ]);
        }

        // Cek apakah kode OTP sudah kadaluwarsa
        if (now()->gt($user->otp_expires_at)) {
            return back()->withErrors(['otp_error' => 'Kode OTP telah kedaluwarsa. Silakan login kembali.']);
        }

        // Cek apakah kode OTP cocok (Menggunakan perbandingan standar)
        if (trim($user->otp_code) != trim($request->otp_input)) {
            return back()->withErrors(['otp_error' => 'Kode OTP salah, silakan periksa kembali WhatsApp Anda.']);
        }

        // Jika lolos pengecekan, bersihkan field OTP di database demi keamanan
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->save();

        // Login-kan user ke session Laravel secara resmi
        auth()->login($user);

        return redirect('/dashboard');
    }
}