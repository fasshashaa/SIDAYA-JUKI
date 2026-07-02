<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Jika user sudah login DAN statusnya 'nonaktif'
        if (Auth::check() && Auth::user()->status === 'nonaktif') {
            Auth::logout();
            
            // Redirect ke login dengan error
            return redirect()->route('login')->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan. Silakan hubungi Administrator.',
            ]);
        }

        return $next($request);
    }
}