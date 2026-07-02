<div>
    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400 mb-1">Overview</p>
    <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--text-strong)">Dashboard Usaha Saya</h1>
    <p class="text-sm mt-1" style="color: var(--text-muted)">
        Selamat datang, <span class="font-semibold" style="color: var(--text-body)">{{ auth()->user()->name }}</span>.
    </p>
</div>

@php
    $statusMap = [
        'pending'   => ['label' => 'Pending',   'color' => 'amber',   'desc' => 'Pengajuan Anda sedang ditinjau oleh admin.'],
        'disetujui' => ['label' => 'Disetujui',  'color' => 'emerald', 'desc' => 'Selamat! Usaha Anda telah terverifikasi.'],
        'ditolak'   => ['label' => 'Ditolak',    'color' => 'rose',    'desc' => 'Pengajuan Anda perlu diperbaiki, cek catatan di bawah.'],
    ];
    $status = $statusMap[$data['statusVerifikasi'] ?? 'pending'];
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5 mt-8">

    {{-- Status Verifikasi --}}
    <div class="lg:col-span-2 relative overflow-hidden rounded-3xl p-8 shadow-xl shadow-slate-900/10"
         style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">
        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full blur-3xl" style="background: rgba(95, 217, 232, 0.12)"></div>
        <div class="relative z-10">
            <p class="text-[11px] font-bold uppercase tracking-widest text-cyan-300/70 mb-3">Status Verifikasi Usaha</p>
            <div class="flex items-center gap-3 mb-3">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm font-bold
                    bg-{{ $status['color'] }}-500/15 text-{{ $status['color'] }}-400 border border-{{ $status['color'] }}-400/20">
                    <span class="h-2 w-2 rounded-full bg-{{ $status['color'] }}-400"></span>
                    {{ $status['label'] }}
                </span>
                @if(!empty($data['tanggalPengajuan']))
                    <span class="text-xs text-slate-400">Diajukan {{ \Carbon\Carbon::parse($data['tanggalPengajuan'])->translatedFormat('d F Y') }}</span>
                @endif
            </div>
            <p class="text-slate-300 text-sm max-w-md">{{ $status['desc'] }}</p>

            @if(($data['statusVerifikasi'] ?? null) === 'ditolak' && !empty($data['catatanVerifikasi']))
                <div class="mt-4 p-4 rounded-xl bg-rose-500/10 border border-rose-400/20">
                    <p class="text-xs font-bold text-rose-400 uppercase tracking-wide mb-1">Catatan Admin</p>
                    <p class="text-sm text-rose-100/90">{{ $data['catatanVerifikasi'] }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Ringkasan Produk --}}
    <div class="rounded-2xl border shadow-sm p-6 flex flex-col justify-between" style="background: var(--surface); border-color: var(--surface-border)">
        <div>
            <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">Total Produk Saya</p>
            <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ number_format($data['totalProdukSaya'] ?? 0) }}</h3>
        </div>
        <a href="{{ route('produk.index') }}" class="mt-5 inline-flex items-center justify-center gap-2 text-sm font-semibold px-4 py-2.5 rounded-xl border transition hover:-translate-y-0.5" style="border-color: var(--surface-border); color: var(--text-body)">
            Kelola Produk Saya
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
        </a>
    </div>
</div>