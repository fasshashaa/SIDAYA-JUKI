<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProdukUmkm;

class MarketplaceController extends Controller
{
    public function index(Request $request)
    {
        // Hanya tampilkan produk yang statusnya "Ditampilkan" (Draft disembunyikan dari publik)
        $query = ProdukUmkm::query()
            ->where('status_publikasi', 'Ditampilkan');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $produks = $query->latest()->get();

        return view('marketplace.index', compact('produks'));
    }
}