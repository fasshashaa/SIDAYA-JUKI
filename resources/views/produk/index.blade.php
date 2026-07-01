@extends('layouts.app')
@section('content')

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Katalog Produk UMKM</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar produk yang telah dipublikasikan.</p>
        </div>
        <a href="{{ route('produk.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl text-sm transition-all shadow-sm shadow-blue-500/10">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk Baru
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 text-sm font-medium rounded-xl flex items-center gap-2">
            {{ session('success') }}
        </div>
    @endif

    <!-- GRID CONTAINER -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
        @forelse($produks as $item)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-4 hover:shadow-xl transition-all duration-300 flex flex-col group">
                <!-- Foto Produk -->
             <div class="relative aspect-square w-full bg-gray-100 rounded-2xl overflow-hidden mb-4">
    
  @php
    $statusColors = [
        'Ditampilkan' => 'bg-emerald-500',
        'Draft'       => 'bg-amber-500'
    ];
@endphp

<div class="absolute top-3 right-3 z-10 px-2 py-1 rounded-md text-[9px] font-bold text-white shadow-sm {{ $statusColors[$item->status_publikasi] ?? 'bg-gray-400' }} uppercase tracking-wider">
    {{ $item->status_publikasi }}
</div>
    

    @if($item->foto_produk)
        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
    @else
        <div class="w-full h-full flex items-center justify-center text-gray-300">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
        </div>
    @endif
</div>
                <!-- Detail Produk -->
               <div class="flex-grow">
    <p class="text-[10px] font-bold text-blue-500 uppercase tracking-wider mb-1">{{ $item->uep->nama_usaha ?? 'Tanpa UEP' }}</p>
    
    <h3 class="font-bold text-gray-900 line-clamp-1">{{ $item->nama_produk }}</h3>
    <p class="text-xs text-gray-400 mt-1 mb-2">{{ $item->kategori }}</p>
    <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</p>
</div>
<div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
    <span class="text-[10px] bg-green-50 text-green-600 px-2 py-1 rounded-full font-bold">Stok: {{ $item->stok }}</span>
    <div class="flex gap-1">
        <a href="{{ route('produk.show', $item->id) }}" class="p-2 text-gray-400 hover:text-blue-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </a>
        
        <a href="{{ route('produk.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-amber-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </a>
        
        <form action="{{ route('produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="p-2 text-gray-400 hover:text-red-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="3 6 5 6 21 6"></polyline>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                </svg>
            </button>
        </form>
    </div>
</div>
            </div>
        @empty
            <div class="col-span-full p-20 text-center text-gray-400">
                Belum ada produk yang ditampilkan.
            </div>
        @endforelse
    </div>
@endsection