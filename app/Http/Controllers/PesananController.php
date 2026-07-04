<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\ProdukUmkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    /**
     * Dipanggil saat pembeli klik "Beli via WA".
     * Mencatat pesanan berstatus "menunggu_konfirmasi" (stok BELUM berkurang),
     * lalu meneruskan pembeli ke WhatsApp penjual dengan kode pesanan di pesannya.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk_umkms,id',
            'jumlah'    => 'required|integer|min:1',
        ]);

        $produk = ProdukUmkm::findOrFail($validated['produk_id']);

        abort_if($produk->status_publikasi !== 'Ditampilkan', 404, 'Produk tidak tersedia.');
        abort_if($produk->stok < $validated['jumlah'], 422, 'Stok tidak mencukupi.');

        $pesanan = Pesanan::create([
            'kode_pesanan'     => Pesanan::generateKode(),
            'produk_umkm_id'   => $produk->id,
            'user_id'          => auth()->id(),
            'jumlah'           => $validated['jumlah'],
            'harga_saat_pesan' => $produk->harga_jual,
            'status'           => 'menunggu_konfirmasi',
        ]);

        $totalHarga = number_format($produk->harga_jual * $pesanan->jumlah);

        $pesan = "Halo, saya mau pesan produk berikut:\n\n"
               . "Kode Pesanan: {$pesanan->kode_pesanan}\n"
               . "Produk: {$produk->nama_produk}\n"
               . "Jumlah: {$pesanan->jumlah}\n"
               . "Total: Rp{$totalHarga}\n\n"
               . "Mohon konfirmasi ketersediaannya, terima kasih.";

        $waLink = "https://wa.me/" . $produk->whatsapp_sales . "?text=" . urlencode($pesan);

        return redirect()->away($waLink);
    }

    /**
     * Antrian konfirmasi untuk pemilik usaha (UEP/KUBE miliknya) atau admin/super_admin (semua).
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'menunggu_konfirmasi');

        $query = Pesanan::with(['produk.uep', 'produk.kube', 'pembeli']);

        if (!in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            $query->whereHas('produk', function ($q) {
                $q->whereHas('uep', fn ($q2) => $q2->where('user_id', auth()->id()))
                  ->orWhereHas('kube', fn ($q2) => $q2->where('user_id', auth()->id()));
            });
        }

        if ($status !== 'semua') {
            $query->where('status', $status);
        }

        $pesanans = $query->latest()->paginate(15)->withQueryString();

        return view('pesanan.index', compact('pesanans', 'status'));
    }

    /**
     * Konfirmasi pesanan -> stok baru dipotong di sini, bukan saat klik WA.
     */
    public function confirm($id)
    {
        $pesanan = Pesanan::with('produk')->findOrFail($id);
        $this->authorizeAccess($pesanan);

        abort_if($pesanan->status !== 'menunggu_konfirmasi', 422, 'Pesanan ini sudah diproses sebelumnya.');

        DB::transaction(function () use ($pesanan) {
            $produk = ProdukUmkm::lockForUpdate()->findOrFail($pesanan->produk_umkm_id);

            abort_if($produk->stok < $pesanan->jumlah, 422, 'Stok tidak lagi mencukupi untuk pesanan ini.');

            $produk->decrement('stok', $pesanan->jumlah);

            $pesanan->update([
                'status'       => 'dikonfirmasi',
                'confirmed_by' => auth()->id(),
                'confirmed_at' => now(),
            ]);
        });

        return back()->with('success', "Pesanan {$pesanan->kode_pesanan} dikonfirmasi, stok telah diperbarui.");
    }

    /**
     * Tolak pesanan -> stok tidak berubah sama sekali.
     */
    public function reject(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $this->authorizeAccess($pesanan);

        abort_if($pesanan->status !== 'menunggu_konfirmasi', 422, 'Pesanan ini sudah diproses sebelumnya.');

        $pesanan->update([
            'status'       => 'ditolak',
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'catatan'      => $request->input('catatan'),
        ]);

        return back()->with('success', "Pesanan {$pesanan->kode_pesanan} ditolak.");
    }

    /**
     * Riwayat pesanan milik pembeli yang sedang login.
     */
    public function riwayat()
    {
        $pesanans = Pesanan::with('produk')
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pesanan.riwayat', compact('pesanans'));
    }

    /**
     * Pastikan hanya pemilik usaha terkait atau admin/super_admin yang bisa konfirmasi/tolak.
     */
    private function authorizeAccess(Pesanan $pesanan): void
    {
        if (in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            return;
        }

        $produk = $pesanan->produk ?? ProdukUmkm::with(['uep', 'kube'])->find($pesanan->produk_umkm_id);

        $isOwner = ($produk->uep && $produk->uep->user_id === auth()->id())
            || ($produk->kube && $produk->kube->user_id === auth()->id());

        abort_unless($isOwner, 403, 'Anda tidak memiliki akses ke pesanan ini.');
    }
}