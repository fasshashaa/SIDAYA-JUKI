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
            $pendingPM   = \App\Models\PenerimaManfaat::where('status_verifikasi', 'pending')->count();
            $pendingUEP  = \App\Models\Uep::where('status_verifikasi', 'pending')->count();
            $pendingKUBE = \App\Models\Kube::where('status_verifikasi', 'pending')->count();

            $targetRoute = 'penerima-manfaat.index';
            if ($pendingPM > 0)       $targetRoute = 'penerima-manfaat.index';
            elseif ($pendingUEP > 0)  $targetRoute = 'uep.index';
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
            $myUeps  = \App\Models\Uep::where('user_id', $user->id)->get();
            $myKubes = \App\Models\Kube::where('user_id', $user->id)->get();

            $myBusinesses = $myUeps->map(fn($u) => (object) [
                    'jenis'  => 'UEP',
                    'nama'   => $u->nama_usaha,
                    'status' => $u->status_verifikasi,
                ])
                ->concat($myKubes->map(fn($k) => (object) [
                    'jenis'  => 'KUBE',
                    'nama'   => $k->nama_kelompok_kube,
                    'status' => $k->status_verifikasi,
                ]));

            $totalProduk = \App\Models\ProdukUmkm::whereHas('uep', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->orWhereHas('kube', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->count();

            $data = [
                'totalPM'             => \App\Models\PenerimaManfaat::where('user_id', $user->id)->count(),
                'totalUEP'            => $myUeps->count(),
                'totalKUBE'           => $myKubes->count(),
                'totalProduk'         => $totalProduk,
                'recentActivities'    => \App\Models\Activity::where('user_id', $user->id)->latest()->take(5)->get(),
                'pendingVerifikasi'   => 0,
                'targetRoute'         => '#',
                'myBusinesses'        => $myBusinesses,
                'totalUsahaDisetujui' => $myBusinesses->where('status', 'disetujui')->count(),
                'totalUsahaPending'   => $myBusinesses->where('status', 'pending')->count(),
            ];
        }

        return view('dashboard', compact('user', 'data'));
    }

    public function verifikasi()
    {
        $dataPending = \App\Models\PenerimaManfaat::where('status', 'pending')->get();
        return view('verifikasi.index', compact('dataPending'));
    }
}