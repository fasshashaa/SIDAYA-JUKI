<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Limiter untuk Form Login Pertama (Password)
        RateLimiter::for('login_tahap_satu', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())->response(function () use ($request) {
                // Mengambil sisa waktu kunci dalam hitungan detik
                $seconds = RateLimiter::availableIn('login_tahap_satu:' . $request->ip());
                
                return back()->withErrors([
                    'email' => 'Terlalu banyak percobaan login. Akses Anda ditangguhkan selama 1 menit demi keamanan.',
                ]);
            });
        });

        // Limiter untuk Verifikasi OTP (Mengamankan Kuota Fonnte)
        RateLimiter::for('otp_verify', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())->response(function () {
                return back()->withErrors([
                    'otp_error' => 'Terlalu banyak mencoba kode OTP. Akses ditangguhkan selama 1 menit demi keamanan.',
                ]);
            });
        });
    }
}