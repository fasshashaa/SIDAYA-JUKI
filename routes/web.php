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
use App\Http\Controllers\MarketplaceController;
use App\Http\Controllers\RiwayatPesananController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\ActivityController;

// ==========================================
// PUBLIC ROUTES & API WILAYAH (Bebas OTP & Auth)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');

 
    // Antrian konfirmasi untuk pemilik usaha (UEP/KUBE miliknya) & admin/super_admin (semua)
    Route::get('/pesanan/konfirmasi', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan/{id}/konfirmasi', [PesananController::class, 'confirm'])->name('pesanan.confirm');
    Route::post('/pesanan/{id}/tolak', [PesananController::class, 'reject'])->name('pesanan.reject');

Route::middleware(['auth'])->group(function () {
    Route::get('/marketplace', [App\Http\Controllers\MarketplaceController::class, 'index'])
         ->name('marketplace.index');
         // Pastikan route ini ada di dalam file web.php
Route::get('/checkout/{id}', [MarketplaceController::class, 'checkout'])->name('checkout');
// Tambahkan baris ini:
// Route untuk Keranjang harus memanggil KeranjangController, bukan MarketplaceController
Route::get('/keranjang', [App\Http\Controllers\KeranjangController::class, 'index'])->name('keranjang');
Route::post('/keranjang/tambah', [App\Http\Controllers\KeranjangController::class, 'store'])->name('keranjang.store');
Route::get('/checkout-wa', [App\Http\Controllers\KeranjangController::class, 'checkoutWa'])->name('checkout.wa');
Route::post('/keranjang/update/{id}', [App\Http\Controllers\KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/hapus/{id}', [App\Http\Controllers\KeranjangController::class, 'destroy'])->name('keranjang.destroy');
 Route::get('/riwayat-pesanan', [PesananController::class, 'riwayat'])->name('riwayat.index');
// Route::get('/riwayat-pesanan', [App\Http\Controllers\RiwayatPesananController::class, 'index'])->name('riwayat.index')->middleware('auth');
// Route untuk Checkout dan Marketplace
Route::get('/marketplace', [App\Http\Controllers\MarketplaceController::class, 'index'])->name('marketplace.index');
// Tambahkan ini di routes/web.php
Route::post('/keranjang/checkout/{id}', [App\Http\Controllers\KeranjangController::class, 'checkout'])->name('keranjang.checkout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
Route::get('/uep/create', [UepController::class, 'create'])->name('uep.create');
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
    Route::resource('penerima-manfaat', PenerimaManfaatController::class);
    
    // 4. Modul UEP (Usaha Ekonomi Produktif)
    Route::prefix('uep')->group(function () {
        Route::get('/export/excel', [UepController::class, 'exportExcel'])->name('uep.export.excel');
        Route::get('/export/pdf', [UepController::class, 'exportPdf'])->name('uep.export.pdf');
        Route::post('/import', [UepController::class, 'import'])->name('uep.import');
        Route::get('/status/saya', [UepController::class, 'myStatus'])->name('uep.status');
    });
    Route::resource('uep', UepController::class);

    // 5. Modul KUBE (Kelompok Usaha Bersama)
    Route::prefix('kube')->group(function () {
        Route::get('/export/excel', [KubeController::class, 'exportExcel'])->name('kube.export.excel');
        Route::get('/export/pdf', [KubeController::class, 'exportPdf'])->name('kube.export.pdf');
        Route::post('/import', [KubeController::class, 'import'])->name('kube.import');
        Route::get('/status/saya', [KubeController::class, 'myStatus'])->name('kube.status');
    });
    Route::resource('kube', KubeController::class);

    // 6. Produk UMKM & Laporan Kegiatan
    Route::resource('produk', ProdukUmkmController::class);
    Route::resource('laporan-kegiatan', LaporanKegiatanController::class);

    // 7. Pengaturan Sistem
    Route::get('/settings', function () {
    // Ambil data audit log terbaru, urutkan dari yang paling baru, batasi 50 data untuk performa
    $auditLogs = \App\Models\AuditLog::with('user')
                    ->latest()
                    ->take(50)
                    ->get();

    return view('settings.index', compact('auditLogs'));
    })->name('settings.index');

    // 8. Khusus Fitur Super Admin (Prefix & Middleware Kelompok)
    Route::middleware(['EnsureIsSuperAdmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
        Route::resource('users', UserController::class);
        Route::put('users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });
    Route::post('/settings/toggle-otp', function (\Illuminate\Http\Request $request) {
        // Validasi input sakelar
        $request->validate(['otp_status' => 'required|in:on,off']);

        \Illuminate\Support\Facades\DB::table('settings')
            ->where('key', 'otp_gateway_status')
            ->update([
                'value' => $request->otp_status,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Status OTP Gateway berhasil diperbarui!');
    })->name('settings.toggle-otp');
    Route::get('/settings/audit-logs/export-pdf', [App\Http\Controllers\PenerimaManfaatController::class, 'exportAuditLogPdf'])->name('audit-logs.export-pdf');
});