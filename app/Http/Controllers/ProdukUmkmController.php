<?php

namespace App\Http\Controllers;

use App\Models\Uep;
use Illuminate\Http\Request;
use App\Models\ProdukUmkm;

class ProdukUmkmController extends Controller
{
    /**
     * Menampilkan daftar Usaha Ekonomi Produktif (UEP).
     */
    public function index()
{
    // Mengambil semua data produk
    $produks = \App\Models\ProdukUmkm::all();
    return view('produk.index', compact('produks'));
}
public function store(Request $request)
{
    // 1. Validasi Input (Ganti pemilik_select jadi pemilik_id sesuai nama di HTML)
    $validated = $request->validate([
        'pemilik_id'       => 'required', 
        'nama_produk'      => 'required|string|max:255',
        'kategori'         => 'required|string|max:100',
        'harga_jual'       => 'required|numeric|min:0',
        'stok'             => 'required|integer|min:0',
        'deskripsi_produk' => 'nullable|string',
        'whatsapp_sales'   => 'nullable|string|max:20',
        'status_publikasi' => 'required|in:Ditampilkan,Draft',
        'foto_produk'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Pecah nilai pemilik_id (yang isinya "kube_6" atau "uep_1")
    $pemilik = explode('_', $request->pemilik_id);
    $jenis = $pemilik[0]; 
    $id    = $pemilik[1];

    // 3. Persiapan Data (Gunakan $validated agar lebih aman)
    $data = $validated;
    
    // Hapus pemilik_id dari $data karena di DB tidak ada kolom bernama itu
    unset($data['pemilik_id']);
    
    // Set foreign key
    if ($jenis === 'uep') {
        $data['uep_id'] = $id;
        $data['kube_id'] = null;
    } else {
        $data['kube_id'] = $id;
        $data['uep_id'] = null;
    }

    // 4. Logika Upload Foto
    if ($request->hasFile('foto_produk')) {
        $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
    }

    // 5. Simpan ke Database
    \App\Models\ProdukUmkm::create($data);

    return redirect()->route('produk.index')
                     ->with('success', 'Produk berhasil ditambahkan!');
}

public function create()
{
    $ueps = \App\Models\Uep::all();
    $kubes = \App\Models\Kube::all();
    return view('produk.create', compact('ueps', 'kubes'));
}
public function edit($id)
{
    $produk = \App\Models\ProdukUmkm::findOrFail($id);
    $ueps = \App\Models\Uep::all();
    return view('produk.edit', compact('produk', 'ueps'));
}

public function update(Request $request, $id)
{
    $produk = \App\Models\ProdukUmkm::findOrFail($id);

    $validated = $request->validate([
        'uep_id'           => 'required|exists:ueps,id',
        'nama_produk'      => 'required|string|max:255',
        'kategori'         => 'required|string',
        'harga_jual'       => 'required|numeric',
        'stok'             => 'required|integer',
        'status_publikasi' => 'required|in:Ditampilkan,Draft',
        'foto_produk'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Jika ada foto baru, hapus foto lama dan simpan yang baru
    if ($request->hasFile('foto_produk')) {
        if ($produk->foto_produk) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->foto_produk);
        }
        $validated['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
    }

    $produk->update($validated);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
}

public function destroy($id)
{
    $produk = \App\Models\ProdukUmkm::findOrFail($id);

    // Hapus file foto dari storage
    if ($produk->foto_produk) {
        \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->foto_produk);
    }

    $produk->delete();

    return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
}
public function show($id)
{
    $produk = \App\Models\ProdukUmkm::with('uep')->findOrFail($id);
    return view('produk.show', compact('produk'));
}
}