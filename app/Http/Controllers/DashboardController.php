<?php

namespace App\Http\Controllers;

use App\Models\PenerimaManfaat;
use App\Models\Uep;
use App\Models\Kube;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
{
    $user = auth()->user();
$pendingPM   = \App\Models\PenerimaManfaat::where('status_verifikasi', 'pending')->count();
    $pendingUEP  = \App\Models\Uep::where('status_verifikasi', 'pending')->count();
    $pendingKUBE = \App\Models\Kube::where('status_verifikasi', 'pending')->count();
    // Logika: Jika PM ada yang pending, arahkan ke PM. Jika tidak, arahkan ke UEP.
    $targetRoute = 'penerima-manfaat.index'; // Default
    if ($pendingPM > 0) {
        $targetRoute = 'penerima-manfaat.index';
    } elseif ($pendingUEP > 0) {
        $targetRoute = 'uep.index';
    } elseif ($pendingKUBE > 0) {
        $targetRoute = 'kube.index';
    }
    // Data statistik untuk Admin/Verifikator
    $data = [
        'pendingVerifikasi' => $pendingPM + $pendingUEP + $pendingKUBE,
        'targetRoute'       => $targetRoute,
        'totalPM' => \App\Models\PenerimaManfaat::count(),
        'totalUEP' => \App\Models\Uep::count(),
        'totalKUBE' => \App\Models\Kube::count(),
        'totalProduk' => \App\Models\ProdukUmkm::count(),
        // Ringkasan data menunggu verifikasi 
        'pendingVerifikasi' => \App\Models\PenerimaManfaat::where('status_verifikasi', 'pending')->count() 
                               + \App\Models\Uep::where('status_verifikasi', 'pending')->count()
                               + \App\Models\Kube::where('status_verifikasi', 'pending')->count(),
    ];

    return view('dashboard', compact('user', 'data'));
}
public function verifikasi()
{
    // Ambil data yang statusnya masih 'pending'
    $dataPending = \App\Models\PenerimaManfaat::where('status', 'pending')->get();
    return view('verifikasi.index', compact('dataPending'));
}
}