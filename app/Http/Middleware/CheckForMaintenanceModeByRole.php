<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckForMaintenanceModeByRole
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah file indikator maintenance ada
        $maintenanceFile = storage_path('framework/custom_maintenance.json');

        if (file_exists($maintenanceFile)) {
            $maintenanceData = json_decode(file_get_contents($maintenanceFile), true);

            // 2. Jika user BELUM login, atau dia login tapi BUKAN SuperAdmin
            // (Sesuaikan pengecekan role ini dengan sistem autentikasi Anda, misal: $user->hasRole('superadmin'))
            $user = auth()->user();
            
            if (!$user || $user->role !== 'super_admin') { 
                // Lempar ke halaman 503 Service Unavailable
                abort(503, $maintenanceData['message'] ?? 'Sistem sedang dalam pemeliharaan.');
            }
        }

        return $next($request);
    }
}