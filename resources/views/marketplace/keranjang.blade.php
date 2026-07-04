@extends('layouts.marketplace')

@section('content')
<div class="min-h-screen" style="background: var(--surface);">
<div class="max-w-4xl mx-auto p-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-extrabold tracking-tight" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                Keranjang Belanja
            </h2>
            <p class="text-sm mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                Periksa kembali pesananmu sebelum checkout.
            </p>
        </div>
        <a href="{{ route('marketplace.index') }}"
           class="inline-flex items-center gap-2 text-sm font-medium px-4 py-2.5 rounded-xl transition border hover:shadow-sm"
           style="color: var(--text-strong); border-color: var(--border-soft); background: var(--surface-card); font-family: 'Inter', sans-serif;">
            <i class="fa-solid fa-arrow-left text-[13px]" style="color:#0E7C9E;"></i>
            Lanjut Belanja
        </a>
    </div>

    @forelse($grouped as $key => $items)
    @php
        // Pecah key untuk tahu ini UEP atau KUBE
        $isUep = str_contains($key, 'UEP_');
        $namaToko = $isUep
            ? ($items->first()->produkUmkm->uep->nama_usaha ?? 'UEP')
            : ($items->first()->produkUmkm->kube->nama_kelompok_kube ?? 'KUBE');
        $subtotal = 0;
    @endphp

    <div class="rounded-2xl border overflow-hidden mb-6"
         style="background: var(--surface-card); border-color: var(--border-soft); box-shadow: 0 1px 3px var(--shadow-soft);">

        {{-- Header Toko --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b" style="border-color: var(--border-soft);">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white text-xs font-bold shrink-0"
                 style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                {{ strtoupper(substr($namaToko, 0, 2)) }}
            </div>
            <div class="min-w-0">
                <p class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--teal);">
                    {{ $isUep ? 'UEP' : 'KUBE' }}
                </p>
                <h3 class="font-bold text-[15px] truncate" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                    {{ $namaToko }}
                </h3>
            </div>
        </div>

        {{-- Daftar Item --}}
        <div class="divide-y" style="border-color: var(--border-soft);">
            @foreach($items as $item)
                @php $subtotal += ($item->produkUmkm->harga_jual * $item->jumlah); @endphp
                <div class="flex items-center justify-between gap-4 px-6 py-4" x-data="{ qty: {{ $item->jumlah }} }">

                    {{-- Nama produk --}}
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold truncate" style="color: var(--text-strong); font-family: 'Inter', sans-serif;">
                            {{ $item->produkUmkm->nama_produk }}
                        </p>
                        <p class="text-xs mt-0.5" style="color: var(--text-muted);">
                            Rp {{ number_format($item->produkUmkm->harga_jual) }} / item
                        </p>
                    </div>

                    {{-- Stepper jumlah --}}
                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="shrink-0">
                        @csrf
                        <div class="flex items-center rounded-lg border overflow-hidden" style="border-color: var(--border-strong);">
                            <button type="button"
                                    @click="if (qty > 1) { qty--; $el.closest('form').querySelector('input[name=jumlah]').value = qty; $el.closest('form').submit(); }"
                                    class="w-7 h-8 flex items-center justify-center text-xs transition"
                                    style="color: var(--text-muted); background: var(--surface-muted);">
                                <i class="fa-solid fa-minus text-[9px]"></i>
                            </button>
                            <input type="number" name="jumlah" x-model="qty" min="1"
                                   onchange="this.form.submit()"
                                   class="w-12 text-center text-sm font-bold outline-none border-0"
                                   style="color: var(--text-strong) !important; background: var(--surface-input) !important; -webkit-text-fill-color: var(--text-strong); appearance: textfield; -moz-appearance: textfield;">
                            <button type="button"
                                    @click="qty++; $el.closest('form').querySelector('input[name=jumlah]').value = qty; $el.closest('form').submit();"
                                    class="w-7 h-8 flex items-center justify-center text-xs transition"
                                    style="color: var(--text-muted); background: var(--surface-muted);">
                                <i class="fa-solid fa-plus text-[9px]"></i>
                            </button>
                        </div>
                    </form>

                    {{-- Subtotal item --}}
                    <span class="text-sm font-bold w-28 text-right shrink-0" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                        Rp {{ number_format($item->produkUmkm->harga_jual * $item->jumlah) }}
                    </span>

                    {{-- Hapus --}}
                    <form id="delete-cart-form-{{ $item->id }}" action="{{ route('keranjang.destroy', $item->id) }}" method="POST" class="shrink-0">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDeleteCartItem({{ $item->id }}, {{ json_encode($item->produkUmkm->nama_produk) }})"
                                class="w-8 h-8 flex items-center justify-center rounded-lg transition"
                                style="color: #EF4444; background: rgba(239,68,68,0.08);"
                                title="Hapus item">
                            <i class="fa-solid fa-trash-can text-[13px]"></i>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Footer: total + checkout --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-6 py-4"
             style="background: var(--surface-muted);">
            <div>
                <p class="text-[11px] font-medium uppercase tracking-wide" style="color: var(--text-muted);">Subtotal Toko Ini</p>
                <p class="text-lg font-extrabold" style="color: var(--price); font-family: 'Plus Jakarta Sans', sans-serif;">
                    Rp {{ number_format($subtotal) }}
                </p>
            </div>
             
            <form action="{{ route('keranjang.checkout', $items->first()->produkUmkm->kube_id ?? $items->first()->produkUmkm->uep_id) }}" method="POST">
                @csrf
                <button type="submit"
                        class="w-full sm:w-auto inline-flex items-center justify-center gap-2 text-white font-semibold px-6 py-3 rounded-xl text-sm transition hover:brightness-110 active:scale-[0.98]"
                        style="background: linear-gradient(135deg,#22C55E,#16A34A); font-family: 'Inter', sans-serif;">
                    <i class="fa-solid fa-bag-shopping text-[13px]"></i>
                    Checkout Toko Ini
                </button>
            </form>
        </div>
    </div>
    @empty
        {{-- ================= EMPTY STATE ================= --}}
        <div class="flex flex-col items-center justify-center text-center py-24 rounded-3xl border border-dashed"
             style="border-color: var(--border-strong); background: var(--surface-card);">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
                 style="background: linear-gradient(135deg, rgba(14,124,158,0.15), rgba(95,217,232,0.15));">
                <i class="fa-solid fa-cart-shopping text-2xl" style="color:#0E7C9E;"></i>
            </div>
            <p class="text-lg font-bold" style="color: var(--text-strong); font-family: 'Plus Jakarta Sans', sans-serif;">
                Keranjang kamu masih kosong
            </p>
            <p class="text-sm mt-1" style="color: var(--text-muted); font-family: 'Inter', sans-serif;">
                Yuk mulai belanja produk UMKM &amp; KUBE binaan Dinsos PPPA Cilacap.
            </p>
            <a href="{{ route('marketplace.index') }}"
               class="mt-5 inline-flex items-center gap-2 text-sm font-semibold px-5 py-2.5 rounded-xl text-white transition hover:brightness-110"
               style="background: linear-gradient(135deg, var(--navy), var(--teal));">
                <i class="fa-solid fa-store text-xs"></i> Mulai Belanja
            </a>
        </div>
    @endforelse
</div>
</div>

<script>
function confirmDeleteCartItem(id, namaProduk) {
    Swal.fire({
        title: 'Hapus item ini?',
        text: namaProduk + ' akan dihapus dari keranjang.',
        icon: 'warning',
        width: '340px',
        padding: '1.5rem',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
            cancelButtonColor: '#f1f5f9',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl shadow-lg border border-gray-100',
            title: 'text-base font-bold',
            htmlContainer: 'text-xs',
             confirmButton: 'bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1'
           },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-cart-form-' + id).submit();
        }
    });
}
</script>
@endsection