@extends('layouts.app')

@section('content')

<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <div>
        <h2 class="text-2xl font-extrabold font-display" style="color: var(--text-strong);">
            Konfirmasi Pesanan
        </h2>
        <p class="text-sm mt-1" style="color: var(--text-muted);">
            Pesanan masuk lewat WhatsApp perlu dikonfirmasi di sini agar stok ikut diperbarui.
        </p>
    </div>

    {{-- Status filter tabs --}}
    <div class="flex items-center gap-1.5 rounded-xl p-1" style="background: var(--surface); border: 1px solid var(--surface-border);">
        @foreach(['menunggu_konfirmasi' => 'Menunggu', 'dikonfirmasi' => 'Dikonfirmasi', 'ditolak' => 'Ditolak', 'semua' => 'Semua'] as $key => $label)
            <a href="{{ route('pesanan.index', ['status' => $key]) }}"
               class="px-3.5 py-1.5 rounded-lg text-xs font-semibold transition"
               style="{{ $status === $key
                    ? 'background: linear-gradient(135deg, var(--navy-800), var(--teal-600)); color:#fff;'
                    : 'color: var(--text-muted);' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
</div>

@if(session('success'))
    <div class="mb-5 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2"
         style="background: rgba(34,197,94,0.1); color: #16A34A;">
        <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
    </div>
@endif

@if($pesanans->count() > 0)
    <div class="rounded-2xl border overflow-hidden" style="border-color: var(--surface-border); background: var(--surface);">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs uppercase tracking-wider" style="color: var(--text-muted); background: var(--surface-alt);">
                        <th class="px-4 py-3 font-semibold">Kode</th>
                        <th class="px-4 py-3 font-semibold">Produk</th>
                        <th class="px-4 py-3 font-semibold">Pembeli</th>
                        <th class="px-4 py-3 font-semibold text-center">Jumlah</th>
                        <th class="px-4 py-3 font-semibold text-right">Total</th>
                        <th class="px-4 py-3 font-semibold text-center">Status</th>
                        <th class="px-4 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesanans as $pesanan)
                    <tr class="border-t" style="border-color: var(--surface-border);">
                        <td class="px-4 py-3 font-mono text-xs font-semibold" style="color: var(--text-strong);">
                            {{ $pesanan->kode_pesanan }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold" style="color: var(--text-strong);">{{ $pesanan->produk->nama_produk ?? '-' }}</div>
                            <div class="text-xs" style="color: var(--text-muted);">
                                {{ $pesanan->produk->uep->nama_usaha ?? $pesanan->produk->kube->nama_kelompok_kube ?? '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-3" style="color: var(--text-muted);">
                            {{ $pesanan->pembeli->name ?? '-' }}
                        </td>
                        <td class="px-4 py-3 text-center font-semibold" style="color: var(--text-strong);">
                            {{ $pesanan->jumlah }}
                        </td>
                        <td class="px-4 py-3 text-right font-bold" style="color: var(--text-strong);">
                            Rp {{ number_format($pesanan->total_harga) }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            @php
                                $badge = match($pesanan->status) {
                                    'menunggu_konfirmasi' => ['bg' => 'rgba(245,158,11,0.12)', 'text' => '#B45309', 'label' => 'Menunggu'],
                                    'dikonfirmasi'         => ['bg' => 'rgba(34,197,94,0.12)', 'text' => '#16A34A', 'label' => 'Dikonfirmasi'],
                                    'ditolak'              => ['bg' => 'rgba(220,38,38,0.1)', 'text' => '#DC2626', 'label' => 'Ditolak'],
                                    default                => ['bg' => 'rgba(100,116,139,0.1)', 'text' => '#64748B', 'label' => $pesanan->status],
                                };
                            @endphp
                            <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full"
                                  style="background: {{ $badge['bg'] }}; color: {{ $badge['text'] }};">
                                {{ $badge['label'] }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if($pesanan->status === 'menunggu_konfirmasi')
                                <div class="flex items-center justify-end gap-1.5">
                                    <form id="confirm-pesanan-form-{{ $pesanan->id }}" action="{{ route('pesanan.confirm', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                                onclick="confirmApprovePesanan({{ $pesanan->id }}, {{ json_encode($pesanan->kode_pesanan) }})"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold text-white transition hover:brightness-110"
                                                style="background: linear-gradient(135deg,#22C55E,#16A34A);">
                                            <i class="fa-solid fa-check text-[11px]"></i> Konfirmasi
                                        </button>
                                    </form>
                                    <form id="reject-pesanan-form-{{ $pesanan->id }}" action="{{ route('pesanan.reject', $pesanan->id) }}" method="POST">
                                        @csrf
                                        <button type="button"
                                                onclick="confirmRejectPesanan({{ $pesanan->id }}, {{ json_encode($pesanan->kode_pesanan) }})"
                                                class="px-3 py-1.5 rounded-lg text-xs font-semibold transition hover:brightness-95"
                                                style="background: var(--surface-alt); color: var(--text-muted);">
                                            <i class="fa-solid fa-xmark text-[11px]"></i> Tolak
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs" style="color: var(--text-muted);">
                                    {{ $pesanan->confirmed_at?->translatedFormat('d M Y, H:i') ?? '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-5">
        {{ $pesanans->links() }}
    </div>
@else
    <div class="flex flex-col items-center justify-center text-center py-20 rounded-3xl border border-dashed"
         style="border-color: var(--surface-border); background: var(--surface);">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-4"
             style="background: linear-gradient(135deg, rgba(14,124,158,0.15), rgba(95,217,232,0.15));">
            <i class="fa-solid fa-inbox text-2xl" style="color:#0E7C9E;"></i>
        </div>
        <p class="text-lg font-bold font-display" style="color: var(--text-strong);">
            Tidak ada pesanan
        </p>
        <p class="text-sm mt-1" style="color: var(--text-muted);">
            Belum ada pesanan pada status ini.
        </p>
    </div>
@endif

<script>
function confirmApprovePesanan(id, kode) {
    Swal.fire({
        title: 'Konfirmasi pesanan ini?',
        html: `Pesanan <b>${kode}</b> akan dikonfirmasi dan <b>stok otomatis berkurang</b>.`,
        icon: 'question',
        width: '360px',
        padding: '1.5rem',
        showCancelButton: true,
        confirmButtonText: 'Ya, Konfirmasi',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-2xl shadow-lg border border-gray-100',
            title: 'text-base font-bold',
            htmlContainer: 'text-xs',
            confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1',
            cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1'
        },
        buttonsStyling: false
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('confirm-pesanan-form-' + id).submit();
        }
    });
}

function confirmRejectPesanan(id, kode) {
    Swal.fire({
        title: 'Tolak pesanan ini?',
        html: `Pesanan <b>${kode}</b> akan ditandai <b>ditolak</b> dan stok tidak berubah.`,
        icon: 'warning',
        width: '360px',
        padding: '1.5rem',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak',
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
            document.getElementById('reject-pesanan-form-' + id).submit();
        }
    });
}
</script>

@endsection