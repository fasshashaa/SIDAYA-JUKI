@extends('layouts.app')
@section('content')
<div class="max-w-3xl mx-auto">
    <a href="{{ route('produk.index') }}" class="text-sm text-gray-500 hover:text-gray-900 mb-4 inline-block">&larr; Kembali ke Katalog</a>
    
    <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 grid md:grid-cols-2 gap-8">
        <div class="aspect-square bg-gray-100 rounded-2xl overflow-hidden">
            <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="w-full h-full object-cover">
        </div>

        <div>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg uppercase">{{ $produk->kategori }}</span>
            <h1 class="text-3xl font-bold mt-3">{{ $produk->nama_produk }}</h1>
            <p class="text-2xl font-bold text-gray-900 mt-2">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>
            
            <div class="mt-6 space-y-4">
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase">Deskripsi</h4>
                    <p class="text-gray-600 mt-1">{{ $produk->deskripsi_produk ?: 'Tidak ada deskripsi.' }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase">Mitra UEP</h4>
                    <p class="text-gray-900 font-semibold">{{ $produk->uep->nama_usaha }}</p>
                </div>
                <div>
                    <h4 class="text-[10px] font-bold text-gray-400 uppercase">Stok Tersedia</h4>
                    <p class="text-gray-900 font-semibold">{{ $produk->stok }} Pcs</p>
                </div>
            </div>
            
            <a href="https://wa.me/{{ $produk->whatsapp_sales }}" target="_blank" class="mt-8 flex items-center justify-center gap-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 rounded-xl transition-all">
                Hubungi Penjual via WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection