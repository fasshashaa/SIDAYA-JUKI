<?php

namespace App\Http\Controllers;

use App\Models\Kube; // Pastikan Anda sudah memiliki Model Kube
use Illuminate\Http\Request;

class KubeController extends Controller
{
    /**
     * Menampilkan daftar Kelompok KUBE Binaan Dinsos Cilacap.
     */
    public function index()
    {
        // Mengambil data KUBE dengan paginasi 10 data per halaman
        $daftarKube = class_exists(\App\Models\Kube::class) ? Kube::latest()->paginate(10) : collect([]);

        return view('kube.index', compact('daftarKube'));
    }
}