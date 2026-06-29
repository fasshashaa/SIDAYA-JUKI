<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOtpIsVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika user sudah masuk, namun kode OTP di akunnya belum diverifikasi/masih aktif di database
        if ($user && $user->otp_code !== null) {
            // Kecuali jika dia memang sedang mengakses halaman verifikasi OTP atau melakukan post OTP
            if (!$request->is('otp-verify', 'otp-verify/*')) {
                return redirect()->route('otp.index');
            }
        }

        return $next($request);
    }
}