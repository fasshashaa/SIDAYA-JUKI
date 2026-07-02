<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Gabungkan semua middleware ke dalam satu deklarasi alias
        $middleware->alias([
            'EnsureIsSuperAdmin' => \App\Http\Middleware\EnsureIsSuperAdmin::class,
            'verified.otp'       => \App\Http\Middleware\EnsureOtpIsVerified::class,
            'role'               => \App\Http\Middleware\RoleMiddleware::class, // Pilih salah satu yang aktif (disarankan RoleMiddleware)
            'check.status'       => \App\Http\Middleware\CheckUserStatus::class,
            
        ]);

        
    })
    
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
    