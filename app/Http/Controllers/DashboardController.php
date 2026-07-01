<?php

namespace App\Http\Controllers;

use App\Models\PenerimaManfaat;
use App\Models\Uep;
use App\Models\Kube;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    $user = auth()->user();

    // Data statistik untuk Admin/Verifikator
    $data = [
        'totalPM' => \App\Models\PenerimaManfaat::count(),
        'totalUEP' => \App\Models\Uep::count(),
        'totalKUBE' => \App\Models\Kube::count(),
        'totalProduk' => \App\Models\Produk::count(),
        // Ringkasan data menunggu verifikasi 
        'pendingVerifikasi' => \App\Models\PenerimaManfaat::where('status_verifikasi', 'pending')->count() 
                               + \App\Models\Uep::where('status_verifikasi', 'pending')->count()
                               + \App\Models\Kube::where('status_verifikasi', 'pending')->count(),
    ];

    return view('dashboard', compact('user', 'data'));
}
}