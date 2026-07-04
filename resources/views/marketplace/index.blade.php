@extends('layouts.marketplace')

@section('content')
<div class="min-h-screen" style="background: var(--surface);">
<div class="container mx-auto px-4 py-8 max-w-7xl">

    {{-- ================= HERO ================= --}}
    <div class="relative overflow-hidden rounded-3xl mb-8 p-8 md:p-12"
         style="background: linear-gradient(135deg, #08182C 0%, #0B2A4A 55%, #0E7C9E 130%);">

        {{-- decorative glow --}}
        <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full opacity-20 blur-3xl pointer-events-none"
             style="background: #5FD9E8;"></div>
        <div class="absolute -bottom-24 left-1/3 w-80 h-80 rounded-full opacity-10 blur-3xl pointer-events-none"
             style="background: #0E7C9E;"></div>
        {{-- subtle grid pattern --}}
        <div class="absolute inset-0 opacity-[0.04] pointer-events-none"
             style="background-image: linear-gradient(to right, #fff 1px, transparent 1px), linear-gradient(to bottom, #fff 1px, transparent 1px); background-size: 32px 32px;"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-end justify-between gap-6">
            <div>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-semibold tracking-wider uppercase px-3 py-1.5 rounded-full mb-4"
                      style="background: rgba(95,217,232,0.15); color: #5FD9E8; font-family: 'Inter', sans-serif;">
                    <i class="fa-solid fa-store text-[10px]"></i> Pasar Berdaya &middot; by SIDAYA
                </span>
                <h2 class="text-3xl md:text-5xl font-extrabold text-white leading-tight tracking-tight"
                    style="font-family: 'Plus Jakarta Sans', sans-serif;">
                    Jelajahi Produk<br class="hidden md:block"> UMKM &amp; KUBE
                </h2>
                <p class="text-slate-300 text-sm md:text-base mt-3 max-w-md" style="font-family: 'Inter', sans-serif;">
                    Temukan produk terbaik dari mitra binaan Dinsos PPPA Kabupaten Cilacap.
                </p>

                {{-- trust chips --}}
                <div class="flex flex-wrap items-center gap-2 mt-5">
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-3 py-1.5 rounded-full text-white"
                          style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                        <i class="fa-solid fa-shield-check text-[11px]" style="color:#5FD9E8;"></i>
                        {{ $produks->count() }}+ Produk Terdaftar di Pasar Berdaya
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-[11px] font-medium px-3 py-1.5 rounded-full text-white"
                          style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.12);">
                        <i class="fa-solid fa-people-group text-[11px]" style="color:#5FD9E8;"></i>
                        Mitra Binaan Terverifikasi
                    </span>
                </div>
            </div>

            {{-- Search (auto-submit, no button) --}}
            <form action="{{ route('marketplace.index') }}" method="GET"
                  x-ref="searchForm" x-data="{ loading: false }"
                  class="w-full lg:w-[420px]">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"
                       x-show="!loading"></i>
                    <i class="fa-solid fa-circle-notch fa-spin absolute left-4 top-1/2 -translate-y-1/2 text-sm"
                       style="color:#0E7C9E;" x-show="loading" x-cloak></i>

                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari produk impianmu..."
                           autocomplete="off"
                           x-on:input.debounce.500ms="loading = true; $refs.searchForm.submit()"
                           class="w-full rounded-xl pl-10 pr-10 py-3.5 text-sm outline-none transition
                                  bg-white/95 border border-white/10 placeholder-slate-400 text-slate-800 shadow-lg shadow-black/10
                                  focus:ring-2 focus:ring-offset-0"
                           style="font-family: 'Inter', sans-serif; --tw-ring-color: #5FD9E8;">

                    @if(request('search'))
                        <a href="{{ route('marketplace.index') }}"
                           class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition">
                            <i class="fa-solid fa-xmark text-sm"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ================= CATEGORY PILLS + SUB NAV ================= --}}
    @php
        $kategoriList = $produks->pluck('kategori')->filter()->unique()->values();
    @endphp
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-7">
        <div class="flex items-center gap-2 overflow-x-auto pb-1 -mx-1 px-1 scrollbar-hide">
            <a href="{{ route('marketplace.index', array_filter(['search' => request('search')])) }}"
               class="shrink-0 inline-flex items-center gap-1.5 text-xs font-semibold px-4 py-2 rounded-full transition"
               style="{{ !request('kategori')
                    ? 'background: linear-gradient(135deg, var(--navy), var(--teal)); color: #fff;'
                    : 'background: var(--surface-card); color: var(--text-muted); border: 1px solid var(--border-soft);' }}">
                <i class="fa-solid fa-grid-2 text-[11px]"></i> Semua
            </a>
            @foreach($kategoriList as $kat)
                <a href="{{ route('marketplace.index', array_filter(['search' => request('search'), 'kategori' => $kat])) }}"
                   class="shrink-0 inline-flex items-center text-xs font-semibold px-4 py-2 rounded-full transition whitespace-nowrap"
                   style="{{ request('kategori') == $kat
                        ? 'background: linear-gradient(135deg, var(--navy), var(--teal)); color: #fff;'
                        : 'background: var(--surface-card); color: var(--text-muted); border: 1px solid var(--border-soft);' }}">
                    {{ $kat }}
                </a>
            @endforeach
        </div>

        <a href="{{ route('riwayat.index') }}"
           class="shrink-0 inline-flex items-center gap-2 text-sm font-medium px-4 py-2.5 rounded-xl transition border hover:shadow-sm"
           style="color: var(--text-strong); border-color: var(--border-soft); background: var(--surface-card); font-family: 'Inter', sans-serif;">
            <i class="fa-solid fa-clock-rotate-left text-[13px]" style="color:#0E7C9E;"></i>
            Riwayat Pesanan
        </a>
    </div>

    {{-- ================= PRODUCT GRID ================= --}}
    @if($produks->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($produks as $produk)
            <div class="group relative rounded-2xl border overflow-hidden transition-all duration-300
                        hover:-translate-y-1.5"
                 style="background: var(--surface-card); border-color: var(--border-soft); box-shadow: 0 1px 3px var(--shadow-soft);"
                 onmouseover="this.style.boxShadow='0 20px 40px var(--shadow-strong)'"
                 onmouseout="this.style.boxShadow='0 1px 3px var(--shadow-soft)'">

                {{-- Image --}}
                <div class="h-44 overflow-hidden relative" style="background: var(--surface-muted);">
                    <img src="{{ asset('storage/' . $produk->foto_produk) }}"
                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105
                                {{ $produk->stok <= 0 ? 'grayscale opacity-60' : '' }}">
                    <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full text-white shadow-sm"
                          style="background: rgba(8,24,44,0.75); font-family: 'Inter', sans-serif; backdrop-filter: blur(4px);">
                        {{ $produk->kategori }}
                    </span>

                    @if($produk->stok <= 0)
                        <span class="absolute inset-0 flex items-center justify-center">
                            <span class="text-[11px] font-bold uppercase tracking-wider px-3 py-1.5 rounded-full text-white shadow-sm"
                                  style="background: rgba(220,38,38,0.9); font-family: 'Inter', sans-serif;">
                                Stok Habis
                            </span>
                        </span>
                    @endif

                    <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"
                         style="background: linear-gradient(to top, rgba(8,24,44,0.35), transparent 55%);"></div>
                </div>

                {{-- Content --}}
                <div class="p-4">
                    <h3 class="font-bold text-[15px] leading-snug mt-0.5 truncate"
                        style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $produk->nama_produk }}
                    </h3>
                    <p class="text-xs mt-1 mb-3 leading-relaxed" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                        {{ Str::limit($produk->deskripsi_produk, 50) }}
                    </p>

                    <div class="flex justify-between items-center mb-3">
                        <span class="text-base font-extrabold" style="color: var(--price); font-family: 'Plus Jakarta Sans', sans-serif;">
                            Rp {{ number_format($produk->harga_jual) }}
                        </span>
                        <span class="text-[11px] font-semibold px-2 py-1 rounded-md"
                              style="{{ $produk->stok <= 0
                                    ? 'background: rgba(220,38,38,0.1); color:#DC2626;'
                                    : ($produk->stok <= 5
                                        ? 'background: rgba(245,158,11,0.12); color:#B45309;'
                                        : 'background: rgba(14,124,158,0.1); color:#0E7C9E;') }}">
                            {{ $produk->stok <= 0 ? 'Habis' : 'Stok: ' . $produk->stok }}
                        </span>
                    </div>

                    {{-- Button WA: submit ke pesanan.store dulu (catat pesanan menunggu konfirmasi), baru diarahkan ke WA --}}
                    @if($produk->stok > 0)
                        <form action="{{ route('pesanan.store') }}" method="POST" target="_blank"
                              x-data="{ qtyWa: 1, maxQtyWa: {{ $produk->stok }} }"
                              class="mb-2">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" x-bind:value="qtyWa">

                            <div class="flex items-center gap-2">
                                {{-- <div class="flex items-center rounded-lg border overflow-hidden shrink-0"
                                     style="border-color: var(--border-strong);">
                                    <button type="button" @click="qtyWa = Math.max(1, qtyWa - 1)"
                                            class="w-6 h-9 flex items-center justify-center text-xs transition"
                                            style="color: var(--text-muted); background: var(--surface-muted);">
                                        <i class="fa-solid fa-minus text-[9px]"></i>
                                    </button>
                                    <span class="w-7 text-center text-sm font-semibold" style="color: var(--text-strong); font-family: 'Inter', sans-serif;" x-text="qtyWa"></span>
                                    <button type="button" @click="qtyWa = Math.min(maxQtyWa, qtyWa + 1)"
                                            class="w-6 h-9 flex items-center justify-center text-xs transition"
                                            style="color: var(--text-muted); background: var(--surface-muted);">
                                        <i class="fa-solid fa-plus text-[9px]"></i>
                                    </button>
                                </div> --}}

                                <button type="submit"
                                        class="flex-1 flex items-center justify-center gap-2 text-center font-semibold py-2.5 rounded-xl
                                               text-white text-sm transition hover:brightness-110 active:scale-[0.98]"
                                        style="background: linear-gradient(135deg,#22C55E,#16A34A); font-family: 'Inter', sans-serif;">
                                    <i class="fa-brands fa-whatsapp text-[15px]"></i> Beli via WA
                                </button>
                            </div>
                        </form>
                    @else
                        <button type="button" disabled
                                class="flex items-center justify-center gap-2 w-full text-center font-semibold py-2.5 rounded-xl
                                       text-sm mb-2 cursor-not-allowed"
                                style="background: var(--surface-muted); color: var(--text-muted); font-family: 'Inter', sans-serif;">
                            <i class="fa-brands fa-whatsapp text-[15px]"></i> Stok Habis
                        </button>
                    @endif

                    {{-- Cart form --}}
                    @if($produk->stok > 0)
                        <form action="{{ route('keranjang.store') }}" method="POST"
                              x-data="{ qty: 1, maxQty: {{ $produk->stok }} }"
                              class="flex items-center gap-2 pt-3 border-t" style="border-color: var(--border-soft);">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" x-bind:value="qty">

                            <div class="flex items-center rounded-lg border overflow-hidden shrink-0"
                                 style="border-color: var(--border-strong);">
                                <button type="button" @click="qty = Math.max(1, qty - 1)"
                                        class="w-6 h-8 flex items-center justify-center text-xs transition"
                                        style="color: var(--text-muted); background: var(--surface-muted);">
                                    <i class="fa-solid fa-minus text-[9px]"></i>
                                </button>
                                <span class="w-7 text-center text-sm font-semibold" style="color: var(--text-strong); font-family: 'Inter', sans-serif;" x-text="qty"></span>
                                <button type="button" @click="qty = Math.min(maxQty, qty + 1)"
                                        class="w-6 h-8 flex items-center justify-center text-xs transition"
                                        style="color: var(--text-muted); background: var(--surface-muted);">
                                    <i class="fa-solid fa-plus text-[9px]"></i>
                                </button>
                            </div>

                            <button type="submit"
                                    class="flex-1 flex items-center justify-center gap-1.5 text-white text-sm font-semibold py-2 rounded-lg
                                           transition hover:brightness-110 active:scale-[0.98]"
                                    style="background: linear-gradient(135deg,#0E7C9E,#0B2A4A); font-family: 'Inter', sans-serif;">
                                <i class="fa-solid fa-cart-plus text-[13px]"></i> Keranjang
                            </button>
                        </form>
                    @else
                        <div class="flex items-center justify-center gap-2 pt-3 border-t text-xs font-medium"
                             style="border-color: var(--border-soft); color: var(--text-muted); font-family: 'Inter', sans-serif;">
                            <i class="fa-solid fa-circle-exclamation"></i> Produk sedang tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @else
        {{-- ================= EMPTY STATE ================= --}}
        <div class="flex flex-col items-center justify-center text-center py-24 rounded-3xl border border-dashed"
             style="border-color: var(--border-strong); background: var(--surface-card);">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                 style="background: linear-gradient(135deg, rgba(14,124,158,0.15), rgba(95,217,232,0.15));">
                <i class="fa-solid fa-box-open text-2xl" style="color:#0E7C9E;"></i>
            </div>
            <p class="text-lg font-bold" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                Produk tidak ditemukan
            </p>
            <p class="text-sm mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                Coba ubah kata kunci pencarian atau jelajahi kategori lain.
            </p>
            @if(request('search') || request('kategori'))
                <a href="{{ route('marketplace.index') }}"
                   class="mt-5 inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl text-white transition hover:brightness-110"
                   style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                    <i class="fa-solid fa-rotate-left text-xs"></i> Reset Pencarian
                </a>
            @endif
        </div>
    @endif

</div>
</div>
@endsection