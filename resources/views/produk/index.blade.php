@extends('layouts.app')
@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-5">
        <div>
           <br> {{-- <p class="text-xs font-semibold text-indigo-600 tracking-wide uppercase mb-1.5">Data Master</p> --}}
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Katalog Produk UMKM</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar produk yang telah dipublikasikan.</p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" class="hidden sm:inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-medium px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Ekspor
            </button>
            <a href="{{ route('produk.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm shadow-indigo-600/20 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk Baru
            </a>
        </div>
    </div>

    {{-- ================= SUCCESS ALERT ================= --}}
    {{-- @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-2xl flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif --}}

{{-- ================= SUMMARY BAR ================= --}}
@php
    $totalProduk    = $produks->count();
    $totalTampil    = $produks->where('status_publikasi', 'Ditampilkan')->count();
    $totalDraft     = $produks->where('status_publikasi', 'Draft')->count();
    $totalStokHabis = $produks->where('stok', 0)->count();
@endphp

<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
    
    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Produk</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalProduk }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Ditampilkan</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalTampil }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Draft</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalDraft }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Stok Habis</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalStokHabis }}</p>
        </div>
    </div>
</div>
    {{-- ================= TOOLBAR ================= --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:max-w-xs">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            <input type="text" placeholder="Cari nama produk atau kategori..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </button>
            <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl whitespace-nowrap">{{ $totalProduk }} produk</span>
        </div>
    </div>

    {{-- ================= GRID CONTAINER ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        @forelse($produks as $item)
            <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-lg hover:shadow-slate-200/60 hover:-translate-y-0.5 hover:border-slate-200 transition-all duration-300 flex flex-col group">

                {{-- Foto Produk --}}
                <div class="relative aspect-square w-full bg-slate-50 overflow-hidden">

                    @php
                        $statusColors = [
                            'Ditampilkan' => 'bg-emerald-500',
                            'Draft'       => 'bg-amber-500'
                        ];
                    @endphp

                    <div class="absolute top-3 right-3 z-10 px-2.5 py-1 rounded-full text-[9px] font-bold text-white shadow-sm {{ $statusColors[$item->status_publikasi] ?? 'bg-slate-400' }} uppercase tracking-wider">
                        {{ $item->status_publikasi }}
                    </div>

                    @if($item->stok == 0)
                        <div class="absolute inset-0 z-[5] bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                            <span class="px-3 py-1.5 bg-slate-900/80 text-white text-[10px] font-bold uppercase tracking-wider rounded-full">Stok Habis</span>
                        </div>
                    @endif

                    @if($item->foto_produk)
                        <img src="{{ asset('storage/' . $item->foto_produk) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif

                    {{-- Quick actions overlay --}}
                    <div class="absolute inset-x-0 bottom-0 z-10 p-2 flex justify-end gap-1 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-200">
    <!-- Tombol Lihat -->
    <a href="{{ route('produk.show', $item->id) }}" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-indigo-600 shadow-sm transition-colors" title="Lihat">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
    </a>
    
    <!-- Tombol Edit -->
    <a href="{{ route('produk.edit', $item->id) }}" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-amber-600 shadow-sm transition-colors" title="Edit">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
    </a>

    <!-- Tombol Hapus (Sudah diselaraskan) -->
    <form action="{{ route('produk.destroy', $item->id) }}" method="POST" id="delete-form-{{ $item->id }}">
        @csrf
        @method('DELETE')
        <button type="button" onclick="confirmDelete({{ $item->id }})" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-rose-600 shadow-sm transition-colors" title="Hapus">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </button>
    </form>
</div>
                </div>

                {{-- Detail Produk --}}
             <div class="flex-grow p-4">
    <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider mb-1 truncate">
        {{-- Cek apakah relasi uep ada, jika tidak cek kube --}}
        @if($item->uep_id)
            {{ $item->uep->nama_usaha ?? 'Tanpa Nama UEP' }}
        @elseif($item->kube_id)
            {{ $item->kube->nama_kelompok_kube ?? 'Tanpa Nama KUBE' }}
        @else
            Tanpa Pemilik
        @endif
    </p>
    
    <h3 class="font-semibold text-slate-900 line-clamp-1">{{ $item->nama_produk }}</h3>
    <p class="text-xs text-slate-400 mt-1 mb-2">{{ $item->kategori }}</p>
    <p class="text-indigo-600 font-bold text-sm">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</p>
</div>

                <div class="px-4 pb-4 pt-3 border-t border-slate-50 flex justify-between items-center">
                    <span class="text-[10px] {{ $item->stok > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} px-2.5 py-1 rounded-full font-bold">
                        Stok: {{ $item->stok }}
                    </span>
                    <div class="flex gap-1 sm:hidden">
                        {{-- fallback actions untuk layar sentuh tanpa hover --}}
                        <a href="{{ route('produk.show', $item->id) }}" class="p-1.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full flex flex-col items-center justify-center gap-3 p-20 text-center">
                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                    <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Belum ada produk yang ditampilkan</p>
                    <p class="text-xs text-slate-400 mt-1">Tambahkan produk pertama untuk mulai membangun katalog.</p>
                </div>
                <a href="{{ route('produk.create') }}" class="mt-1 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Produk Baru
                </a>
            </div>
        @endforelse
    </div>
 <script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: "Data akan dihapus permanen.",
        icon: 'warning',
        width: '300px', // Sedikit lebih ramping
        padding: '1.5rem', // Padding dikurangi agar tidak mepet
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#f1f5f9',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-3xl shadow-xl border border-gray-100',
            icon: 'mb-4', // Memberi jarak bawah pada ikon
            title: 'text-lg font-bold text-gray-800', // Ukuran title disesuaikan
            htmlContainer: 'text-xs text-gray-500 m-0', // Margin 0 agar tidak mepet
            actions: 'mt-6 w-full', // Memastikan area tombol punya ruang
            confirmButton: 'bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1',
            cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    });
}
</script>
@endsection