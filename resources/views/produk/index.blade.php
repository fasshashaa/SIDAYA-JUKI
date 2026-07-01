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
                <div class="aspect-square w-full bg-gray-100 rounded-2xl overflow-hidden mb-4">
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
                    <h3 class="font-bold text-gray-900 line-clamp-1">{{ $item->nama_produk }}</h3>
                    <p class="text-xs text-gray-400 mt-1 mb-2">{{ $item->kategori }}</p>
                    <p class="text-blue-600 font-bold text-sm">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</p>
                </div>

                <!-- Aksi -->
                <div class="mt-4 pt-4 border-t border-gray-50 flex justify-between items-center">
                    <span class="text-[10px] bg-green-50 text-green-600 px-2 py-1 rounded-full font-bold">Stok: {{ $item->stok }}</span>
                    <div class="flex gap-1">
                        <a href="{{ route('produk.edit', $item->id) }}" class="p-2 text-gray-400 hover:text-amber-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('produk.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 text-gray-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
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