<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PenerimaManfaatController;

// Pastikan route ini berada di luar middleware auth/sanctum agar bisa diakses oleh AJAX frontend
Route::get('/get-desa/{kecamatan}', function ($kecamatan) {
    $namaKecamatan = trim(urldecode($kecamatan));

    $desa = DB::table('wilayah_desas')
        ->where('kecamatan', 'LIKE', $namaKecamatan)
        ->orderBy('nama_desa', 'asc')
        ->pluck('nama_desa');

    return response()->json($desa);
    Route::get('/get-desa/{kecamatanNama}', [PenerimaManfaatController::class, 'getDesaByKecamatan']);
    Route::get('/get-desa/{kecamatan}', [PenerimaManfaatController::class, 'getDesa'])->name('get-desa');
});