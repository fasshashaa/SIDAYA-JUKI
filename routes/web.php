<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenerimaManfaatController;
use App\Http\Controllers\UepController;
use App\Http\Controllers\KubeController;
use App\Http\Controllers\ProdukUmkmController;
use App\Http\Controllers\LaporanKegiatanController;

// ==========================================
// PUBLIC ROUTES & API WILAYAH (Bebas OTP & Auth)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});

/**
 * API PATH UNTUK DEPENDENT DROPDOWN DESA
 * Dilengkapi dengan fallback data lokal jika query database mengalami kegagalan/kosong
 */
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

// Memuat rute bawaan authentication (Login, Register, OTP form, dll)
require __DIR__.'/auth.php';

// ==========================================
// PROTECTED ROUTES (Wajib Login & Lolos OTP)
// ==========================================
Route::middleware(['auth', 'verified.otp'])->group(function () {
    
    // 1. Dashboard Utama
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    // 2. Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 3. Modul Data Utama SIDAYA (Clean URL tanpa prefix)
    
    // Penerima Manfaat
    Route::get('penerima-manfaat/{id}/pdf', [PenerimaManfaatController::class, 'generatePdf'])->name('penerima-manfaat.pdf');
    Route::resource('penerima-manfaat', PenerimaManfaatController::class);
    
    // UEP (Usaha Ekonomi Produktif)
    Route::resource('uep', UepController::class);
    
    // KUBE (Kelompok Usaha Bersama)
    Route::resource('kube', KubeController::class);
    
    // Produk UMKM
    Route::resource('produk-umkm', ProdukUmkmController::class);

    // Laporan Kegiatan
    Route::resource('laporan-kegiatan', LaporanKegiatanController::class);

    // Pengaturan Sistem
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
});