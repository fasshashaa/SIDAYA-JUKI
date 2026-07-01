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
    // 1. Validasi Input
    $validated = $request->validate([
        'uep_id'           => 'required|exists:ueps,id',
        'nama_produk'      => 'required|string|max:255',
        'kategori'         => 'required|string|max:100',
        'harga_jual'       => 'required|numeric|min:0',
        'stok'             => 'required|integer|min:0',
        'deskripsi_produk' => 'nullable|string',
        'whatsapp_sales'   => 'nullable|string|max:20',
        'status_publikasi' => 'required|in:Ditampilkan,Draft',
        'foto_produk'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // 2. Persiapan Data
    $data = $validated;

    // 3. Logika Upload Foto
    if ($request->hasFile('foto_produk')) {
        $path = $request->file('foto_produk')->store('produk', 'public');
        $data['foto_produk'] = $path;
    }

    // 4. Simpan ke Database
    // Menggunakan $validated (bukan $request->all()) agar lebih aman
    \App\Models\ProdukUmkm::create($data);

    // 5. Redirect dengan pesan sukses
    return redirect()->route('produk.index')
                     ->with('success', 'Produk berhasil ditambahkan!');
}

public function create()
{
    // Mengambil semua data UEP untuk dropdown
    $ueps = \App\Models\Uep::all(); 
    return view('produk.create', compact('ueps'));
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