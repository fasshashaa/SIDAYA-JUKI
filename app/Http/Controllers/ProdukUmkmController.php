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

    $validated['user_id'] = auth()->id();
    $produk = \App\Models\ProdukUmkm::create($validated);

    // Catat Log
    \App\Models\Activity::create([
        'user_id'     => auth()->id(),
        'causer_name' => auth()->user()->name,
        'description' => 'Menambahkan data Produk UMKM baru: ' . $validated['nama_produk'],
    ]);
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
    
    // Ambil data UEP dan KUBE
    $ueps = \App\Models\Uep::all(); // Sesuaikan nama modelnya
    $kubes = \App\Models\Kube::all(); // Sesuaikan nama modelnya

    // Kirim ke view
    return view('produk.edit', compact('produk', 'ueps', 'kubes'));
}

public function update(Request $request, $id)
{
    $produk = \App\Models\ProdukUmkm::findOrFail($id);

    // Perbaikan Validasi: Hapus uep_id dari sini karena kita akan mengisinya secara manual nanti
    $validated = $request->validate([
        'pemilik_id'       => 'required', // Tetap butuh ini
        'nama_produk'      => 'required|string|max:255',
        'kategori'         => 'required|string',
        'harga_jual'       => 'required|numeric',
        'stok'             => 'required|integer',
        'status_publikasi' => 'required|in:Ditampilkan,Draft',
        'foto_produk'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Pecah nilai pemilik_id
    $pemilik = explode('_', $request->pemilik_id);
    $jenis = $pemilik[0]; 
    $pemilik_id = $pemilik[1];

    // Ambil semua data input kecuali yang tidak perlu
    $data = $request->except(['pemilik_id', 'foto_produk']);

    // Set relasi berdasarkan jenis
    if ($jenis === 'uep') {
        $data['uep_id'] = $pemilik_id;
        $data['kube_id'] = null; // KUBE harus null kalau UEP dipilih
    } else {
        $data['kube_id'] = $pemilik_id;
        $data['uep_id'] = null; // UEP harus null kalau KUBE dipilih
    }

    // Handle foto
    if ($request->hasFile('foto_produk')) {
        if ($produk->foto_produk) {
            \Storage::disk('public')->delete($produk->foto_produk);
        }
        $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
    }

    $produk->update($data);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
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