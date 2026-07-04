<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. Mencegah Clickjacking (Aplikasi tidak boleh di-frame di web lain)
        $response->headers->set('X-Frame-Options', 'DENY');

        // 2. Mencegah XSS Injection / Cross-Site Scripting
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 3. Mencegah MIME Sniffing (Memaksa browser mematuhi jenis file dari server)
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 4. Mengontrol informasi referer yang dikirim saat berpindah halaman
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Pembatasan fitur browser (Permissions Policy)
        $response->headers->set('Permissions-Policy', 'geolocation=(), microphone=(), camera=()');

        return $response;
    }
}