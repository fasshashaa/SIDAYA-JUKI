<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Menghitung Metrik Total Utama dari tabel yang sudah ada
        $totalPenerima = DB::table('penerima_manfaats')->count();
        
        // Cek tabel 'ueps' (atau sesuaikan jika nama tabel uep kamu juga tunggal/berbeda)
        $totalUEP = Schema::hasTable('ueps') ? DB::table('ueps')->count() : 0; 

        // MEMAKAI TABEL 'kube' (Sesuai migration kamu)
        $totalKUBE = DB::table('kube')->count();

        // 2. Mengambil Data Sebaran Kecamatan Teratas
        $sebaranKecamatan = DB::table('penerima_manfaats')
            ->select('kecamatan', DB::raw('count(*) as total'))
            ->groupBy('kecamatan')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        // 3. Mengambil Aktivitas Registrasi Terakhir
        $aktivitasTerbaru = DB::table('penerima_manfaats')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('dashboard', compact(
            'totalPenerima', 
            'totalUEP', 
            'totalKUBE', 
            'sebaranKecamatan', 
            'aktivitasTerbaru'
        ));
    }
}