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
use App\Http\Controllers\ActivityController;;

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



Route::get('/activities', [App\Http\Controllers\ActivityController::class, 'index'])
    ->name('activities.index')
    ->middleware('auth');
Route::get('/get-desa/{kecamatan}', [App\Http\Controllers\UepController::class, 'getDesa']);
Route::put('/uep/{id}', [UepController::class, 'update'])->name('uep.update');
Route::get('/uep/{id}', [UepController::class, 'show'])->name('uep.show');

// Memuat rute bawaan authentication (Login, Register, OTP form, dll)
require __DIR__.'/auth.php';

// ==========================================
// PROTECTED ROUTES (Wajib Login & Lolos OTP)
// ==========================================
Route::middleware(['auth', 'verified.otp', 'check.status'])->group(function () {
    
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
    // Route::get('penerima-manfaat/{id}/pdf', [PenerimaManfaatController::class, 'generatePdf'])->name('penerima-manfaat.pdf');
    Route::post('penerima-manfaat/import', [PenerimaManfaatController::class, 'import'])->name('penerima-manfaat.import');
Route::get('penerima-manfaat/export/pdf', [PenerimaManfaatController::class, 'exportPdf'])->name('penerima-manfaat.export.pdf');
Route::get('penerima-manfaat/export/excel', [PenerimaManfaatController::class, 'exportExcel'])->name('penerima-manfaat.export.excel');
    Route::resource('penerima-manfaat', PenerimaManfaatController::class);
    Route::get('/penerima-manfaat/{id}', [PenerimaManfaatController::class, 'show'])->name('penerima-manfaat.show');
    Route::get('/penerima-manfaat', [PenerimaManfaatController::class, 'index'])->name('penerima-manfaat.index');
    Route::get('/penerima-manfaat/{id}/edit', [PenerimaManfaatController::class, 'edit'])->name('penerima-manfaat.edit');
    Route::delete('/penerima-manfaat/{id}', [PenerimaManfaatController::class, 'destroy'])->name('penerima-manfaat.destroy');
    
    Route::prefix('uep')->group(function () {
    Route::get('/export/excel', [UepController::class, 'exportExcel'])->name('uep.export.excel');
    Route::get('/export/pdf', [UepController::class, 'exportPdf'])->name('uep.export.pdf');
    Route::post('/import', [UepController::class, 'import'])->name('uep.import');
});
    // UEP (Usaha Ekonomi Produktif)
    Route::resource('uep', UepController::class);

    Route::prefix('kube')->group(function () {
    Route::get('/export/excel', [KubeController::class, 'exportExcel'])->name('kube.export.excel');
    Route::get('/export/pdf', [KubeController::class, 'exportPdf'])->name('kube.export.pdf');
    Route::post('/import', [KubeController::class, 'import'])->name('kube.import');
});
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


Route::middleware(['auth', 'EnsureIsSuperAdmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('users', UserController::class)->except(['show', 'edit', 'update']);
    Route::resource('users', UserController::class);
    Route::put('users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});
    // Produk UMKM
  Route::resource('produk', ProdukUmkmController::class);

  Route::middleware(['auth', 'EnsureIsSuperAdmin'])->prefix('superadmin')->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('superadmin.users.index');
    Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('superadmin.users.updateRole');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('superadmin.users.destroy');
});
Route::get('/uep/status/saya', [UepController::class, 'myStatus'])->name('uep.status');
Route::get('/kube/status/saya', [KubeController::class, 'myStatus'])->name('kube.status');
  // routes/web.php
Route::get('/verifikasi', [App\Http\Controllers\DashboardController::class, 'verifikasi'])->name('verifikasi.index');
    // Laporan Kegiatan
    Route::resource('laporan-kegiatan', LaporanKegiatanController::class);

    // Pengaturan Sistem
    Route::get('/settings', function () {
        return view('settings.index');
    })->name('settings.index');
});