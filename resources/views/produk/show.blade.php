@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
<div class="mb-8 flex items-center justify-between">
    <a href="{{ route('produk.index') }}" 
       class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Katalog
    </a>

    <div class="flex items-center gap-2">
        <a href="{{ route('produk.edit', $produk->id) }}" 
           class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2 rounded-xl text-sm border border-gray-200 shadow-sm transition-all active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Edit Produk
        </a>
    </div>
</div>
    {{-- ================= HEADER ================= --}}
    {{-- <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('produk.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Katalog  
        </a>
        <div class="inline-flex gap-2">
            <a href="{{ route('produk.edit', $produk->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-gray-200 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Produk
            </a>
        </div>
    </div> --}}

    {{-- ================= MAIN CARD ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden grid md:grid-cols-2">

        {{-- Foto Produk --}}
        <div class="relative aspect-square bg-gray-100 overflow-hidden">
            @php
                $statusColors = [
                    'Ditampilkan' => 'bg-emerald-500',
                    'Draft'       => 'bg-amber-500'
                ];
            @endphp
            <div class="absolute top-4 left-4 z-10 px-3 py-1.5 rounded-full text-[10px] font-bold text-white shadow-sm {{ $statusColors[$produk->status_publikasi] ?? 'bg-gray-400' }} uppercase tracking-wider">
                {{ $produk->status_publikasi }}
            </div>

            @if($produk->foto_produk)
                <img src="{{ asset('storage/' . $produk->foto_produk) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
            @endif
        </div>

        {{-- Detail Produk --}}
        <div class="p-8 flex flex-col">
            <span class="w-fit text-xs font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-lg uppercase tracking-wide">{{ $produk->kategori }}</span>
            <h1 class="text-3xl font-extrabold text-gray-900 mt-3 leading-tight">{{ $produk->nama_produk }}</h1>
            <p class="text-2xl font-extrabold text-blue-600 mt-2">Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}</p>

            <div class="mt-6 space-y-5">
                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gray-50 text-gray-500 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Deskripsi</h4>
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $produk->deskripsi_produk ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Mitra UEP</h4>
                        <p class="text-sm text-gray-900 font-semibold mt-0.5">{{ $produk->uep->nama_usaha ?? '-' }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-9 h-9 rounded-xl {{ $produk->stok > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Stok Tersedia</h4>
                        <p class="text-sm text-gray-900 font-semibold mt-0.5">
                            {{ $produk->stok }} Pcs
                            @if($produk->stok == 0)
                                <span class="text-rose-500 font-bold ml-1">&middot; Habis</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            @if($produk->whatsapp_sales)
                <a href="https://wa.me/{{ str_starts_with($produk->whatsapp_sales, '0') ? '62'.substr($produk->whatsapp_sales, 1) : $produk->whatsapp_sales }}"
                   target="_blank"
                   class="mt-8 flex items-center justify-center gap-2 w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3.5 rounded-xl transition-all shadow-lg shadow-emerald-600/20">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                    Hubungi Penjual via WhatsApp
                </a>
            @else
                <div class="mt-8 flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-400 font-semibold py-3.5 rounded-xl text-sm">
                    Nomor WhatsApp sales belum tersedia
                </div>
            @endif
        </div>
    </div>
</div>
@endsection