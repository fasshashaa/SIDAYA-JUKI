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

// ==========================================
// PUBLIC ROUTES & API WILAYAH (Bebas OTP & Auth)
// ==========================================
Route::get('/', function () {
    return view('welcome');
});



Route::get('/uep/create', [UepController::class, 'create'])->name('uep.create');
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
Route::get('/get-desa/{kecamatan}', [App\Http\Controllers\UepController::class, 'getDesa']);
Route::put('/uep/{id}', [UepController::class, 'update'])->name('uep.update');
Route::get('/uep/{id}', [UepController::class, 'show'])->name('uep.show');

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
    Route::get('/penerima-manfaat/{id}', [PenerimaManfaatController::class, 'show'])->name('penerima-manfaat.show');
    Route::get('/penerima-manfaat', [PenerimaManfaatController::class, 'index'])->name('penerima-manfaat.index');
    Route::get('/penerima-manfaat/{id}/edit', [PenerimaManfaatController::class, 'edit'])->name('penerima-manfaat.edit');
    Route::delete('/penerima-manfaat/{id}', [PenerimaManfaatController::class, 'destroy'])->name('penerima-manfaat.destroy');
    
    // UEP (Usaha Ekonomi Produktif)
    Route::resource('uep', UepController::class);

    // KUBE (Kelompok Usaha Bersama)
// Hapus atau ganti resource menjadi deklarasi rute manual untuk KUBE
Route::get('/kube', [KubeController::class, 'index'])->name('kube.index');
Route::get('/kube/create', [KubeController::class, 'create'])->name('kube.create');
Route::post('/kube', [KubeController::class, 'store'])->name('kube.store');
Route::get('/kube/{kube}/edit', [KubeController::class, 'edit'])->name('kube.edit');
Route::put('/kube/{kube}', [KubeController::class, 'update'])->name('kube.update');
Route::get('/kube/{kube}', [KubeController::class, 'show'])->name('kube.show');


// Tambahkan rute destroy secara manual di sini
Route::delete('/kube/{kube}', [KubeController::class, 'destroy'])->name('kube.destroy');
    // Produk UMKM
  Route::resource('produk', ProdukUmkmController::class);
  // routes/web.php
Route::get('/verifikasi', [App\Http\Controllers\DashboardController::class, 'verifikasi'])->name('verifikasi.index');
    // Laporan Kegiatan
    Route::resource('laporan-kegiatan', LaporanKegiatanController::class);

    // Pengaturan Sistem
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
});