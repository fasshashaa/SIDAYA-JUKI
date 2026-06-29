<?php

namespace App\Http\Controllers;

use App\Models\Uep;
use Illuminate\Http\Request;

class ProdukUmkmController extends Controller
{
    /**
     * Menampilkan daftar Usaha Ekonomi Produktif (UEP).
     */
    public function index()
    {
        // Mengambil data UEP terbaru beserta data master Penerima Manfaat (pemiliknya)
        $daftarUep = Uep::with('penerimaManfaat')->latest()->paginate(10);

        return view('produk-umkm.index', compact('daftarUep'));
    }
}