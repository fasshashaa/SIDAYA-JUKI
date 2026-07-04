<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaManfaatController;
use App\Http\Controllers\UepController;
use App\Http\Controllers\ProdukUmkmController;
use App\Http\Controllers\LaporanKegiatanController;
use App\Http\Controllers\KubeController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ActivityController;

// ==========================================
// PUBLIC ROUTES & API WILAYAH (Bebas OTP & Auth)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

// Proses Login Tahap 1 (Dibatasi maksimal 5 kali percobaan per menit)
Route::post('/login', [LoginController::class, 'loginTahapSatu'])
    ->middleware('throttle:login_tahap_satu')
    ->name('login.submit');

// Rute Alur Verifikasi OTP (Menggunakan OtpController)
Route::get('login/verify-otp/{id}', [OtpController::class, 'showOtpForm'])->name('login.otp-verify');

// Proses Validasi OTP (Dibatasi ketat maksimal 3 kali percobaan per menit)
Route::post('login/verify-otp/{id}/submit', [OtpController::class, 'verifikasiOtp'])
    ->middleware('throttle:otp_verify')
    ->name('login.otp-verify.submit');

// API Ambil Data Desa Berdasarkan Kecamatan
Route::get('/get-desa/{kecamatan}', function ($kecamatan) {
    $namaKecamatan = trim(urldecode($kecamatan));
    $desa = DB::table('wilayah_desas')
        ->where('kecamatan_nama', $namaKecamatan)
        ->distinct()
        ->orderBy('nama_desa', 'asc')
        ->pluck('nama_desa')
        ->toArray();

    return response()->json($desa);
})->name('get-desa');

// Memuat rute bawaan authentication (Register, Logout, dll)
require __DIR__.'/auth.php';


// ==========================================
// PROTECTED ROUTES (Wajib Login & Lolos OTP)
// ==========================================
Route::middleware(['auth', 'verified.otp', 'check.status'])->group(function () {
    
    // 1. Dashboard Utama & Verifikasi
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/verifikasi', [DashboardController::class, 'verifikasi'])->name('verifikasi.index');

    // 2. Aktivitas & Profil Pengguna
    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Modul Penerima Manfaat
    Route::post('penerima-manfaat/import', [PenerimaManfaatController::class, 'import'])->name('penerima-manfaat.import');
    Route::get('penerima-manfaat/export/pdf', [PenerimaManfaatController::class, 'exportPdf'])->name('penerima-manfaat.export.pdf');
    Route::get('penerima-manfaat/export/excel', [PenerimaManfaatController::class, 'exportExcel'])->name('penerima-manfaat.export.excel');
    
    // 🟢 EVIDENCE LOG AUDIT - PENERIMA MANFAAT
    Route::get('/penerima-manfaat/audit-log/export', [PenerimaManfaatController::class, 'exportAuditLogPdf'])
        ->name('penerima-manfaat.audit-log.export');
        
    Route::resource('penerima-manfaat', PenerimaManfaatController::class);
    
    // 4. Modul UEP (Usaha Ekonomi Produktif)
    Route::prefix('uep')->group(function () {
        Route::get('/export/excel', [UepController::class, 'exportExcel'])->name('uep.export.excel');
        Route::get('/export/pdf', [UepController::class, 'exportPdf'])->name('uep.export.pdf');
        Route::post('/import', [UepController::class, 'import'])->name('uep.import');
        Route::get('/status/saya', [UepController::class, 'myStatus'])->name('uep.status');
        
        // 🟢 EVIDENCE LOG AUDIT - UEP
        Route::get('/audit-log/export', [UepController::class, 'exportAuditLogPdf'])
            ->name('uep.audit-log.export');
    });
    Route::resource('uep', UepController::class);

    // 5. Modul KUBE (Kelompok Usaha Bersama)
    Route::prefix('kube')->group(function () {
        Route::get('/export/excel', [KubeController::class, 'exportExcel'])->name('kube.export.excel');
        Route::get('/export/pdf', [KubeController::class, 'exportPdf'])->name('kube.export.pdf');
        Route::post('/import', [KubeController::class, 'import'])->name('kube.import');
        Route::get('/status/saya', [KubeController::class, 'myStatus'])->name('kube.status');
        
        // 🟢 EVIDENCE LOG AUDIT - KUBE
        Route::get('/audit-log/export', [KubeController::class, 'exportAuditLogPdf'])
            ->name('kube.audit-log.export');
    });
    Route::resource('kube', KubeController::class);

    // 6. Produk UMKM & Laporan Kegiatan
    Route::resource('produk', ProdukUmkmController::class);
    Route::resource('laporan-kegiatan', LaporanKegiatanController::class);

    // 7. Pengaturan Sistem & Manajemen Konfigurasi Log Utama
    Route::get('/settings', function () {
        $auditLogs = \App\Models\AuditLog::with('user')
                        ->latest()
                        ->take(50)
                        ->get();

        return view('settings.index', compact('auditLogs'));
    })->name('settings.index');

    Route::post('/settings/toggle-otp', function (\Illuminate\Http\Request $request) {
        $request->validate(['otp_status' => 'required|in:on,off']);

        \Illuminate\Support\Facades\DB::table('settings')
            ->where('key', 'otp_gateway_status')
            ->update([
                'value' => $request->otp_status,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Status OTP Gateway berhasil diperbarui!');
    })->name('settings.toggle-otp');

    // 📄 LOG UTAMA SISTEM (ALL EVENTS) - Dihubungkan ke ActivityController agar global
    Route::get('/settings/audit-logs/export-pdf', [ActivityController::class, 'exportAllAuditLogsPdf'])
        ->name('audit-logs.export-pdf');

    // 8. Khusus Fitur Super Admin (Prefix & Middleware Kelompok)
    Route::middleware(['EnsureIsSuperAdmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::put('users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });
});