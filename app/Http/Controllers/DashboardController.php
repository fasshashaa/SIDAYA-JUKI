<?php

namespace App\Http\Controllers;

use App\Models\PenerimaManfaat;
use App\Models\Uep;
use App\Models\Kube;
use App\Models\User;
use App\Models\Activity;
use App\Models\ProdukUmkm;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
public function index()
{
    $user = auth()->user();
    
    // Inisialisasi default array agar tidak terjadi error "Undefined index"
    $data = [
        'pendingVerifikasi' => 0,
        'targetRoute'       => '#',
        'totalPM'           => 0,
        'totalUEP'          => 0,
        'totalKUBE'         => 0,
        'totalProduk'       => 0,
        'recentActivities'  => [],
    ];

    if ($user->role === 'admin' || $user->role === 'super_admin') {
        $pendingPM    = \App\Models\PenerimaManfaat::where('status_verifikasi', 'pending')->count();
        $pendingUEP   = \App\Models\Uep::where('status_verifikasi', 'pending')->count();
        $pendingKUBE  = \App\Models\Kube::where('status_verifikasi', 'pending')->count();

        $targetRoute = 'penerima-manfaat.index';
        if ($pendingPM > 0)      $targetRoute = 'penerima-manfaat.index';
        elseif ($pendingUEP > 0) $targetRoute = 'uep.index';
        elseif ($pendingKUBE > 0) $targetRoute = 'kube.index';

        $data = [
            'pendingVerifikasi' => $pendingPM + $pendingUEP + $pendingKUBE,
            'targetRoute'       => $targetRoute,
            'totalPM'           => \App\Models\PenerimaManfaat::count(),
            'totalUEP'          => \App\Models\Uep::count(),
            'totalKUBE'         => \App\Models\Kube::count(),
            'totalProduk'       => \App\Models\ProdukUmkm::count(),
            'recentActivities'  => \App\Models\Activity::latest()->take(5)->get(),
        ];

        if ($user->role === 'super_admin') {
            $data['totalUser'] = \App\Models\User::count();
        }
    } else {
        // Data Khusus User (Masyarakat)
        $data = [
            'totalPM'        => \App\Models\PenerimaManfaat::where('user_id', $user->id)->count(),
            'totalUEP'       => \App\Models\Uep::where('user_id', $user->id)->count(),
            'totalKUBE'      => \App\Models\Kube::where('user_id', $user->id)->count(),
            'totalProduk'    => \App\Models\ProdukUmkm::where('user_id', $user->id)->count(),
            'recentActivities' => \App\Models\Activity::where('user_id', $user->id)->latest()->take(5)->get(),
            // User tidak butuh pendingVerifikasi, beri nilai 0 saja
            'pendingVerifikasi' => 0, 
            'targetRoute'       => '#',
        ];
    }

    return view('dashboard', compact('user', 'data'));
}

public function verifikasi()
{
    // Ambil data yang statusnya masih 'pending'
    $dataPending = \App\Models\PenerimaManfaat::where('status', 'pending')->get();
    return view('verifikasi.index', compact('dataPending'));
}
}