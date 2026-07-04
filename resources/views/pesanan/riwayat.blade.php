@extends('layouts.marketplace')

@section('content')
<div class="min-h-screen" style="background: var(--surface);">
<div class="max-w-4xl mx-auto p-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                Riwayat Pesanan
            </h2>
            <p class="text-sm mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                Daftar transaksi yang pernah kamu lakukan.
            </p>
        </div>
        <a href="{{ route('marketplace.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2.5 rounded-xl transition border hover:shadow-sm"
           style="color: var(--text-strong); border-color: var(--border-soft); background: var(--surface-card); font-family: 'Inter', sans-serif;">
            <i class="fa-solid fa-arrow-left text-[13px]" style="color:#0E7C9E;"></i>
            Lanjut Belanja
        </a>
    </div>

    @if(session('success'))
        <div class="mb-5 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2"
             style="background: rgba(34,197,94,0.1); color: #16A34A; font-family: 'Inter', sans-serif;">
            <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
    @endif

    @forelse($pesanans as $pesanan)
    @php
        $badge = match($pesanan->status) {
            'menunggu_konfirmasi' => ['bg' => 'rgba(245,158,11,0.12)', 'text' => '#B45309', 'label' => 'Menunggu Konfirmasi'],
            'dikonfirmasi'         => ['bg' => 'rgba(34,197,94,0.12)', 'text' => '#16A34A', 'label' => 'Dikonfirmasi'],
            'ditolak'              => ['bg' => 'rgba(220,38,38,0.1)', 'text' => '#DC2626', 'label' => 'Ditolak'],
            default                => ['bg' => 'rgba(100,116,139,0.1)', 'text' => '#64748B', 'label' => $pesanan->status],
        };
    @endphp
    <div class="rounded-2xl border overflow-hidden mb-4"
         style="background: var(--surface-card); border-color: var(--border-soft); box-shadow: 0 1px 3px var(--shadow-soft);">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-5">

            {{-- Icon produk --}}
            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white shrink-0"
                 style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                <i class="fa-solid fa-box text-base"></i>
            </div>

            {{-- Info produk --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <p class="text-sm font-bold truncate" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                        {{ $pesanan->produk->nama_produk ?? 'Produk tidak tersedia' }}
                    </p>
                    <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full shrink-0"
                          style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                        {{ $badge['label'] }}
                    </span>
                </div>
                <p class="text-xs mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                    {{ $pesanan->kode_pesanan }} &middot; {{ $pesanan->jumlah }} item
                    &middot; {{ $pesanan->created_at->translatedFormat('d F Y, H:i') }}
                </p>
                @if($pesanan->status === 'ditolak' && $pesanan->catatan)
                    <p class="text-xs mt-1" style="color: #DC2626;">
                        Alasan ditolak: {{ $pesanan->catatan }}
                    </p>
                @endif
            </div>

            {{-- Total --}}
            <div class="text-left sm:text-right shrink-0">
                <p class="text-[11px] font-medium uppercase tracking-wide" style="color: var(--text-muted);">Total</p>
                <p class="text-base font-extrabold" style="color: var(--price); font-family: 'Plus Jakarta Sans', sans-serif;">
                    Rp {{ number_format($pesanan->total_harga) }}
                </p>
            </div>

            {{-- Hubungi Penjual (hanya kalau masih menunggu / relevan dihubungi) --}}
            @if($pesanan->produk && $pesanan->produk->whatsapp_sales)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->produk->whatsapp_sales) }}" target="_blank"
                   class="inline-flex items-center justify-center gap-2 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition hover:brightness-110 active:scale-[0.98] shrink-0"
                   style="background: linear-gradient(135deg,#22C55E,#16A34A); font-family: 'Inter', sans-serif;">
                    <i class="fa-brands fa-whatsapp text-[15px]"></i>
                    Chat Penjual
                </a>
            @endif
        </div>
    </div>
    @empty
        {{-- ================= EMPTY STATE ================= --}}
        <div class="flex flex-col items-center justify-center text-center py-24 rounded-3xl border border-dashed"
             style="border-color: var(--border-strong); background: var(--surface-card);">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                 style="background: linear-gradient(135deg, rgba(14,124,158,0.15), rgba(95,217,232,0.15));">
                <i class="fa-solid fa-receipt text-2xl" style="color:#0E7C9E;"></i>
            </div>
            <p class="text-lg font-bold" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                Belum ada riwayat pesanan
            </p>
            <p class="text-sm mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                Transaksi yang kamu buat akan muncul di sini.
            </p>
            <a href="{{ route('marketplace.index') }}"
               class="mt-5 inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl text-white transition hover:brightness-110"
               style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                <i class="fa-solid fa-store text-xs"></i> Mulai Belanja
            </a>
        </div>
    @endforelse

    @if(method_exists($pesanans ?? null, 'links'))
        <div class="mt-5">{{ $pesanans->links() }}</div>
    @endif

</div>
</div>
@endsection