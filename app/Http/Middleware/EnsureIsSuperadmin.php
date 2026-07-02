<?php
namespace App\Http\Middleware; // Pastikan namespace-nya App\Http\Middleware

use Closure;
use Illuminate\Http\Request;

class EnsureIsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Pastikan pengecekan role sesuai dengan struktur tabelmu
        if (auth()->user() && auth()->user()->role === 'super_admin') {
            return $next($request);
        }
        return redirect('/dashboard')->with('error', 'Akses Ditolak!');
    }
}