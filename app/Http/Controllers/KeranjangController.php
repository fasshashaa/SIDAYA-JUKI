<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\RiwayatPesanan;
use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller {
    
    // Menampilkan isi keranjang
    // app/Http/Controllers/KeranjangController.php

public function index() 
{
    $keranjangs = Keranjang::where('user_id', auth()->id())
                           ->with(['produkUmkm.uep', 'produkUmkm.kube'])
                           ->get();

    // Kita kelompokkan berdasarkan gabungan tipe dan id
    $grouped = $keranjangs->groupBy(function($item) {
        if ($item->produkUmkm->uep_id) {
            return 'UEP_' . $item->produkUmkm->uep_id;
        } else {
            return 'KUBE_' . $item->produkUmkm->kube_id;
        }
    });

    return view('marketplace.keranjang', compact('grouped'));
}

    // Fungsi tambah ke keranjang
   public function store(Request $request) 
{
    // Cek apakah produk sudah ada di keranjang user?
    $item = Keranjang::where('user_id', auth()->id())
                     ->where('produk_umkm_id', $request->produk_id)
                     ->first();

    if ($item) {
        // Jika sudah ada, tinggal tambah jumlahnya
        $item->increment('jumlah');
    } else {
        // Jika belum ada, buat baru
        Keranjang::create([
            'user_id' => auth()->id(),
            'produk_umkm_id' => $request->produk_id,
            'jumlah' => 1
        ]);
    }

  return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
}



public function checkout(Request $request, $id)
{
    $items = Keranjang::where('user_id', auth()->id())
                      ->whereHas('produkUmkm', function ($q) use ($id) {
                          $q->where('kube_id', $id)->orWhere('uep_id', $id);
                      })
                      ->with('produkUmkm')
                      ->get();

    if ($items->isEmpty()) {
        return back()->with('error', 'Keranjang kosong!');
    }

    // Validasi stok dulu untuk semua item sebelum membuat pesanan
    foreach ($items as $item) {
        if ($item->produkUmkm->stok < $item->jumlah) {
            return back()->with('error', "Stok {$item->produkUmkm->nama_produk} tidak mencukupi.");
        }
    }

    $cleanWa = preg_replace('/[^0-9]/', '', $items->first()->produkUmkm->whatsapp_sales);

    $pesananList = DB::transaction(function () use ($items) {
        $list = [];
        foreach ($items as $item) {
            $list[] = Pesanan::create([
                'kode_pesanan'     => Pesanan::generateKode(),
                'produk_umkm_id'   => $item->produk_umkm_id,
                'user_id'          => auth()->id(),
                'jumlah'           => $item->jumlah,
                'harga_saat_pesan' => $item->produkUmkm->harga_jual,
                'status'           => 'menunggu_konfirmasi',
            ]);
        }
        $items->each->delete(); // kosongkan keranjang toko ini
        return $list;
    });

    // Susun pesan WA berisi semua item
    $pesan = "Halo, saya mau pesan produk berikut:\n\n";
    $totalSemua = 0;
    foreach ($pesananList as $p) {
        $subtotal = $p->harga_saat_pesan * $p->jumlah;
        $totalSemua += $subtotal;
        $pesan .= "Kode: {$p->kode_pesanan}\n"
                . "Produk: {$p->produk->nama_produk}\n"
                . "Jumlah: {$p->jumlah}\n"
                . "Subtotal: Rp" . number_format($subtotal) . "\n\n";
    }
    $pesan .= "Total: Rp" . number_format($totalSemua) . "\n\nMohon konfirmasi ketersediaannya, terima kasih.";

    return redirect()->away("https://wa.me/{$cleanWa}?text=" . urlencode($pesan));
}
// Update jumlah barang
public function update(Request $request, $id)
{
    $item = Keranjang::findOrFail($id);
    // Logika agar jumlah tidak kurang dari 1
    $item->jumlah = max(1, $request->jumlah);
    $item->save();

   return back()->with('success', 'Jumlah item berhasil diperbarui.');
}

// Hapus barang dari keranjang
public function destroy($id)
{
    Keranjang::findOrFail($id)->delete();
    return back()->with('success', 'Item berhasil dihapus dari keranjang.');
}
}