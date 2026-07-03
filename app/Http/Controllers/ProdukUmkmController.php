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
        $data = (in_array(auth()->user()->role, ['super_admin', 'admin']))
            ? \App\Models\ProdukUmkm::all()
            : \App\Models\ProdukUmkm::whereHas('uep', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->orWhereHas('kube', function ($q) {
                    $q->where('user_id', auth()->id());
                })
                ->get();

        return view('produk.index', compact('data'));
    }

    public function store(Request $request)
    {
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

        // Pecah nilai pemilik_id (contoh: "uep_1" atau "kube_6")
        [$jenis, $id] = explode('_', $request->pemilik_id);
        if (!in_array(auth()->user()->role, ['admin', 'super_admin'])) {
    $usaha = $jenis === 'uep'
        ? \App\Models\Uep::where('id', $id)->where('user_id', auth()->id())->first()
        : \App\Models\Kube::where('id', $id)->where('user_id', auth()->id())->first();

    abort_if(!$usaha, 403, 'Usaha tidak ditemukan atau bukan milik Anda.');
    abort_if($usaha->status_verifikasi !== 'disetujui', 422, 'Usaha ini belum disetujui, produk belum bisa disimpan.');
}

        $data = $validated;
        unset($data['pemilik_id']);

        if ($jenis === 'uep') {
            $data['uep_id']  = $id;
            $data['kube_id'] = null;
        } else {
            $data['kube_id'] = $id;
            $data['uep_id']  = null;
        }

        if ($request->hasFile('foto_produk')) {
            $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
        }

        $produk = \App\Models\ProdukUmkm::create($data);

        \App\Models\Activity::create([
            'user_id'     => auth()->id(),
            'causer_name' => auth()->user()->name,
            'description' => 'Menambahkan data Produk UMKM baru: ' . $data['nama_produk'],
        ]);

        return redirect()->route('produk.index')
                         ->with('success', 'Produk berhasil ditambahkan!');
    }

 public function create()
{
    if (in_array(auth()->user()->role, ['admin', 'super_admin'])) {
        $ueps  = \App\Models\Uep::all();
        $kubes = \App\Models\Kube::all();
        $myUeps  = collect();
        $myKubes = collect();
    } else {
        $ueps  = collect();
        $kubes = collect();
        // Hanya usaha milik user yang belum ditolak (pending atau disetujui)
        $myUeps  = \App\Models\Uep::where('user_id', auth()->id())
                        ->where('status_verifikasi', '!=', 'ditolak')
                        ->get();
        $myKubes = \App\Models\Kube::where('user_id', auth()->id())
                        ->where('status_verifikasi', '!=', 'ditolak')
                        ->get();
    }

    return view('produk.create', compact('ueps', 'kubes', 'myUeps', 'myKubes'));
}
    public function edit($id)
    {
        $produk = \App\Models\ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

        $ueps  = \App\Models\Uep::all();
        $kubes = \App\Models\Kube::all();

        return view('produk.edit', compact('produk', 'ueps', 'kubes'));
    }

    public function update(Request $request, $id)
    {
        $produk = \App\Models\ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

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

        [$jenis, $pemilikId] = explode('_', $request->pemilik_id);

        $data = $validated;
        unset($data['pemilik_id'], $data['foto_produk']);

        if ($jenis === 'uep') {
            $data['uep_id']  = $pemilikId;
            $data['kube_id'] = null;
        } else {
            $data['kube_id'] = $pemilikId;
            $data['uep_id']  = null;
        }

        if ($request->hasFile('foto_produk')) {
            if ($produk->foto_produk) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->foto_produk);
            }
            $data['foto_produk'] = $request->file('foto_produk')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $produk = \App\Models\ProdukUmkm::findOrFail($id);
        $this->authorizeOwnership($produk);

        if ($produk->foto_produk) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($produk->foto_produk);
        }

        $produk->delete();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function show($id)
    {
        $produk = \App\Models\ProdukUmkm::with(['uep', 'kube'])->findOrFail($id);
        $this->authorizeOwnership($produk);

        return view('produk.show', compact('produk'));
    }

    /**
     * Pastikan produk ini memang milik user yang login (untuk role 'user').
     * Admin & super_admin selalu boleh akses semua produk.
     */
    private function authorizeOwnership(ProdukUmkm $produk): void
    {
        if (in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            return;
        }

        $isOwner = ($produk->uep && $produk->uep->user_id === auth()->id())
            || ($produk->kube && $produk->kube->user_id === auth()->id());

        abort_unless($isOwner, 403, 'Anda tidak memiliki akses ke produk ini.');
    }
}