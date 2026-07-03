@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 pb-10">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--text-strong)">Dashboard</h1>
            <p class="text-sm mt-1" style="color: var(--text-muted)">
                Selamat datang kembali, <span class="font-semibold" style="color: var(--text-body)">{{ auth()->user()->name }}</span>. Pantau aktivitas sistem Anda hari ini.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <span class="hidden sm:inline-flex items-center gap-2 text-sm px-4 py-2.5 rounded-xl border shadow-sm"
                  style="background: var(--surface); border-color: var(--surface-border); color: var(--text-muted)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
                {{ now()->translatedFormat('d F Y') }}
            </span>
        </div>
    </div>

    {{-- ================= ALERT SECTION: SUPER ADMIN / ADMIN ================= --}}
    @if(auth()->user()->role !== 'user')
    <div class="relative overflow-hidden rounded-3xl p-8 md:p-10 shadow-xl shadow-slate-900/10"
         style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">

        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full blur-3xl" style="background: rgba(95, 217, 232, 0.15)"></div>
        <div class="absolute -bottom-24 -left-10 w-72 h-72 rounded-full blur-3xl" style="background: rgba(14, 124, 158, 0.15)"></div>
        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#fff_1px,transparent_1px),linear-gradient(to_bottom,#fff_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-400/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-amber-400/80 mb-1">Butuh Tindakan</p>
                    <h2 class="text-lg font-bold text-white">Perlu Verifikasi</h2>
                    <p class="text-slate-400 text-sm mt-1 max-w-md">
                        Terdapat <span class="font-bold text-amber-400">{{ $data['pendingVerifikasi'] }}</span> item yang menunggu tindakan Anda. Segera tinjau untuk menjaga kelancaran proses.
                    </p>
                </div>
            </div>

            @if($data['pendingVerifikasi'] > 0)
                <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}"
                   class="group inline-flex items-center justify-center gap-2 bg-white hover:bg-cyan-50 text-slate-900 font-semibold px-6 py-3.5 rounded-2xl transition-all shadow-lg shadow-black/10 text-sm whitespace-nowrap">
                    Proses Verifikasi Sekarang
                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <div class="inline-flex items-center gap-2 px-6 py-3.5 bg-emerald-500/10 border border-emerald-400/20 text-emerald-400 rounded-2xl text-sm font-semibold whitespace-nowrap">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Semua Data Sudah Diverifikasi
                </div>
            @endif
        </div>
    </div>
    @endif

    {{-- ================= STAT CARDS: SUPER ADMIN / ADMIN ================= --}}
    @if(auth()->user()->role !== 'user')
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
        @if(auth()->user()->role === 'super_admin')
        <div class="group relative p-6 rounded-2xl shadow-sm transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
             style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">
            <div class="w-11 h-11 rounded-xl bg-cyan-400/10 border border-cyan-400/20 flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <p class="text-[11px] font-bold text-cyan-300/70 uppercase tracking-wider mt-5">Total User</p>
            <h3 class="text-3xl font-extrabold text-white mt-1 tabular-nums">{{ number_format($data['totalUser']) }}</h3>
            <div class="mt-4 flex items-center gap-2 pt-4 border-t border-white/10">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-400"></span>
                <span class="text-xs font-medium text-cyan-100/50">Akses sistem</span>
            </div>
        </div>
        @endif

        @php
            $stats = [
                [
                    'label' => 'Total Penerima Manfaat', 'value' => $data['totalPM'], 'trend' => '+4.2%', 'up' => true,
                    'ring' => 'ring-teal-500/10', 'iconBg' => 'bg-teal-50', 'iconText' => 'text-teal-600', 'dot' => 'bg-teal-500',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />',
                ],
                [
                    'label' => 'Total UEP', 'value' => $data['totalUEP'], 'trend' => '+1.8%', 'up' => true,
                    'ring' => 'ring-cyan-500/10', 'iconBg' => 'bg-cyan-50', 'iconText' => 'text-cyan-700', 'dot' => 'bg-cyan-500',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />',
                ],
                [
                    'label' => 'Total KUBE', 'value' => $data['totalKUBE'], 'trend' => '-0.6%', 'up' => false,
                    'ring' => 'ring-slate-500/10', 'iconBg' => 'bg-slate-100', 'iconText' => 'text-slate-600', 'dot' => 'bg-slate-400',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477" />',
                ],
                [
                    'label' => 'Total Katalog Produk', 'value' => $data['totalProduk'], 'trend' => '+7.4%', 'up' => true,
                    'ring' => 'ring-emerald-500/10', 'iconBg' => 'bg-emerald-50', 'iconText' => 'text-emerald-600', 'dot' => 'bg-emerald-500',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />',
                ],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group relative p-6 rounded-2xl border shadow-sm ring-1 {{ $stat['ring'] }} transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5"
             style="background: var(--surface); border-color: var(--surface-border)">
            <div class="flex items-start justify-between">
                <div class="w-11 h-11 rounded-xl {{ $stat['iconBg'] }} flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $stat['iconText'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $stat['icon'] !!}
                    </svg>
                </div>
                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-1 rounded-full {{ $stat['up'] ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                    <svg class="w-3 h-3 {{ $stat['up'] ? '' : 'rotate-180' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 17a.75.75 0 01-.75-.75V5.612L5.29 9.77a.75.75 0 01-1.08-1.04l5.25-5.5a.75.75 0 011.08 0l5.25 5.5a.75.75 0 11-1.08 1.04l-3.96-4.158V16.25A.75.75 0 0110 17z" clip-rule="evenodd" />
                    </svg>
                    {{ $stat['trend'] }}
                </span>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">{{ $stat['label'] }}</p>
            <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ number_format($stat['value']) }}</h3>
            <div class="mt-4 flex items-center gap-2 pt-4 border-t" style="border-color: var(--surface-border)">
                <span class="h-1.5 w-1.5 rounded-full {{ $stat['dot'] }}"></span>
                <span class="text-xs font-medium" style="color: var(--text-muted)">Data aktif &middot; diperbarui hari ini</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- ================= HERO: SAMBUTAN UNTUK ROLE USER ================= --}}
    @if(auth()->user()->role === 'user')
    <div class="relative overflow-hidden rounded-3xl p-8 md:p-10 shadow-xl shadow-slate-900/10"
         style="background: linear-gradient(135deg, #0A1F38, #0B2A4A);">

        <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full blur-3xl" style="background: rgba(95, 217, 232, 0.15)"></div>
        <div class="absolute -bottom-24 -left-10 w-72 h-72 rounded-full blur-3xl" style="background: rgba(14, 124, 158, 0.15)"></div>
        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#fff_1px,transparent_1px),linear-gradient(to_bottom,#fff_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-cyan-400/15 border border-cyan-400/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-cyan-300/70 mb-1">Usaha Saya</p>
                    <h2 class="text-lg font-bold text-white">Kelola Usaha & Produk Anda</h2>
                    <p class="text-slate-400 text-sm mt-1 max-w-md">
                        Anda punya <span class="font-bold text-cyan-300">{{ $data['totalUsahaDisetujui'] ?? 0 }}</span> usaha yang sudah disetujui
                        @if(($data['totalUsahaPending'] ?? 0) > 0)
                            dan <span class="font-bold text-amber-400">{{ $data['totalUsahaPending'] }}</span> masih menunggu verifikasi
                        @endif
                        .
                    </p>
                </div>
            </div>

            {{-- <a href="{{ route('uep.create') }}"
               class="group inline-flex items-center justify-center gap-2 bg-white hover:bg-cyan-50 text-slate-900 font-semibold px-6 py-3.5 rounded-2xl transition-all shadow-lg shadow-black/10 text-sm whitespace-nowrap">
                Ajukan Usaha Baru
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a> --}}
        </div>
    </div>
    @endif

    {{-- ================= STAT CARDS: RINGKASAN UNTUK ROLE USER ================= --}}
    @if(auth()->user()->role === 'user')
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="p-6 rounded-2xl border shadow-sm transition-all" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="w-11 h-11 rounded-xl bg-teal-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">Total Usaha Saya</p>
            <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ ($data['myBusinesses'] ?? collect())->count() }}</h3>
            <div class="mt-4 flex items-center gap-2 pt-4 border-t" style="border-color: var(--surface-border)">
                <span class="h-1.5 w-1.5 rounded-full bg-teal-500"></span>
                <span class="text-xs font-medium" style="color: var(--text-muted)">UEP &amp; KUBE gabungan</span>
            </div>
        </div>

        <div class="p-6 rounded-2xl border shadow-sm transition-all" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">Usaha Disetujui</p>
            <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ $data['totalUsahaDisetujui'] ?? 0 }}</h3>
            <div class="mt-4 flex items-center gap-2 pt-4 border-t" style="border-color: var(--surface-border)">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-xs font-medium" style="color: var(--text-muted)">Siap dipakai untuk produk</span>
            </div>
        </div>

        <div class="p-6 rounded-2xl border shadow-sm transition-all" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="w-11 h-11 rounded-xl bg-cyan-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                </svg>
            </div>
            <p class="text-[11px] font-bold uppercase tracking-wider mt-5" style="color: var(--text-muted)">Produk Saya</p>
            <h3 class="text-3xl font-extrabold mt-1 tabular-nums" style="color: var(--text-strong)">{{ $data['totalProduk'] }}</h3>
            <div class="mt-4 flex items-center gap-2 pt-4 border-t" style="border-color: var(--surface-border)">
                <span class="h-1.5 w-1.5 rounded-full bg-cyan-500"></span>
                <span class="text-xs font-medium" style="color: var(--text-muted)">Terdaftar di katalog</span>
            </div>
        </div>
    </div>
    @endif

    {{-- ================= DAFTAR USAHA SAYA (ROLE USER) ================= --}}
    @if(auth()->user()->role === 'user')
    <div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
        <div class="flex items-center justify-between mb-5">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Status</p>
                <h3 class="font-bold" style="color: var(--text-strong)">Usaha Saya</h3>
            </div>
        </div>

        @php
            $statusStyle = [
                'pending'   => ['bg' => 'bg-amber-50',   'text' => 'text-amber-600',   'dot' => 'bg-amber-500',   'label' => 'Pending'],
                'disetujui' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500', 'label' => 'Disetujui'],
                'ditolak'   => ['bg' => 'bg-rose-50',    'text' => 'text-rose-600',    'dot' => 'bg-rose-500',    'label' => 'Ditolak'],
            ];
        @endphp

        <div class="divide-y" style="border-color: var(--surface-border)">
            @forelse(($data['myBusinesses'] ?? collect()) as $usaha)
                @php $st = $statusStyle[$usaha->status] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400', 'label' => $usaha->status]; @endphp
                <div class="flex items-center justify-between gap-4 py-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="w-9 h-9 shrink-0 rounded-full bg-teal-50 flex items-center justify-center text-[10px] font-bold text-teal-600 uppercase">
                            {{ $usaha->jenis }}
                        </div>
                        <p class="text-sm font-semibold truncate" style="color: var(--text-strong)">{{ $usaha->nama }}</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 shrink-0 text-[11px] font-bold px-2.5 py-1 rounded-full {{ $st['bg'] }} {{ $st['text'] }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $st['dot'] }}"></span>
                        {{ $st['label'] }}
                    </span>
                </div>
            @empty
                <div class="py-10 text-center">
                    <p class="text-sm" style="color: var(--text-muted)">Anda belum mengajukan UEP maupun KUBE.</p>
                    <a href="{{ route('uep.create') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-teal-600 hover:text-teal-700">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajukan Sekarang
                    </a>
                </div>
            @endforelse
        </div>
    </div>
    @endif

    {{-- ================= GRAFIK: BAR + DONUT (SUPER ADMIN / ADMIN) ================= --}}
    @if(auth()->user()->role !== 'user')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <div class="lg:col-span-2 rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-teal-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Analitik</p>
                    <h3 class="font-bold" style="color: var(--text-strong)">Grafik Sebaran Bantuan</h3>
                </div>
            </div>
            <canvas id="bantuanChart" height="110"></canvas>
        </div>

        <div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-cyan-50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Proporsi</p>
                    <h3 class="font-bold" style="color: var(--text-strong)">Distribusi Bantuan</h3>
                </div>
            </div>
            <canvas id="distribusiChart" height="180"></canvas>
        </div>
    </div>
    @endif

    {{-- ================= AKTIVITAS TERBARU + AKSES CEPAT ================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Aktivitas Terbaru --}}
        <div class="lg:col-span-2 rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
            <div class="flex items-center justify-between mb-5">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400">Log</p>
                    <h3 class="font-bold" style="color: var(--text-strong)">Aktivitas Terbaru</h3>
                </div>
                <a href="{{ route('activities.index') }}" class="text-xs font-semibold text-teal-600 hover:text-teal-700">Lihat Semua</a>
            </div>

            <div class="divide-y" style="border-color: var(--surface-border)">
                @forelse($data['recentActivities'] ?? [] as $activity)
                    <div class="flex items-start gap-4 py-4">
                        <div class="w-9 h-9 shrink-0 rounded-full bg-teal-50 flex items-center justify-center text-xs font-bold text-teal-600 uppercase">
                            {{ Str::substr($activity->causer_name ?? 'SY', 0, 2) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm" style="color: var(--text-body)">
                                <span class="font-semibold" style="color: var(--text-strong)">{{ $activity->causer_name ?? 'Sistem' }}</span>
                                {{ $activity->description ?? 'melakukan perubahan data' }}
                            </p>
                            <p class="text-xs mt-0.5" style="color: var(--text-muted)">{{ optional($activity->created_at ?? null)->diffForHumans() ?? '-' }}</p>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <p class="text-sm" style="color: var(--text-muted)">Belum ada aktivitas untuk ditampilkan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Akses Cepat --}}
        <div class="rounded-2xl border shadow-sm p-6" style="background: var(--surface); border-color: var(--surface-border)">
            <p class="text-[11px] font-bold uppercase tracking-widest text-teal-600 dark:text-cyan-400 mb-1">Shortcut</p>
            <h3 class="font-bold mb-5" style="color: var(--text-strong)">Akses Cepat</h3>

            <div class="space-y-2.5">
                @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('superadmin.users.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
                    <div class="w-9 h-9 rounded-lg bg-teal-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium" style="color: var(--text-body)">Tambah Pengguna</span>
                </a>
                @endif

                @if(auth()->user()->role !== 'user')
                <a href="{{ route('penerima-manfaat.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
                    <div class="w-9 h-9 rounded-lg bg-teal-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </div>
                    <span class="text-sm font-medium" style="color: var(--text-body)">Tambah Penerima Manfaat</span>
                </a>
                @endif

                @if(auth()->user()->role !== 'user')
                <a href="{{ route('kube.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
                    <div class="w-9 h-9 rounded-lg bg-teal-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <span class="text-sm font-medium" style="color: var(--text-body)">Tambah KUBE</span>
                </a>
                @endif

                <a href="{{ route('produk.create') }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
                    <div class="w-9 h-9 rounded-lg bg-cyan-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-cyan-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5" /></svg>
                    </div>
                    <span class="text-sm font-medium" style="color: var(--text-body)">Tambah Produk</span>
                </a>

                @if(auth()->user()->role !== 'user')
                <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}" class="flex items-center gap-3 p-3 rounded-xl border transition hover:-translate-y-0.5 hover:shadow-sm" style="border-color: var(--surface-border)">
                    <div class="w-9 h-9 rounded-lg bg-cyan-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-cyan-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <span class="text-sm font-medium" style="color: var(--text-body)">Verifikasi Data Pending</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const barCanvas = document.getElementById('bantuanChart');
            if (barCanvas) {
                const gradient = barCanvas.getContext('2d').createLinearGradient(0, 0, 0, 260);
                gradient.addColorStop(0, '#0E7C9E');
                gradient.addColorStop(1, '#5FD9E8');

                new Chart(barCanvas, {
                    type: 'bar',
                    data: {
                        labels: ['PM', 'UEP', 'KUBE'],
                        datasets: [{
                            label: 'Jumlah Bantuan',
                            data: [{{ $data['totalPM'] }}, {{ $data['totalUEP'] }}, {{ $data['totalKUBE'] }}],
                            backgroundColor: gradient,
                            borderRadius: 8,
                            maxBarThickness: 56,
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(148,163,184,0.15)' } },
                            x: { grid: { display: false } }
                        }
                    }
                });
            }

            const donutCanvas = document.getElementById('distribusiChart');
            if (donutCanvas) {
                new Chart(donutCanvas, {
                    type: 'doughnut',
                    data: {
                        labels: ['PM', 'UEP', 'KUBE'],
                        datasets: [{
                            data: [{{ $data['totalPM'] }}, {{ $data['totalUEP'] }}, {{ $data['totalKUBE'] }}],
                            backgroundColor: ['#0E7C9E', '#5FD9E8', '#94A3B8'],
                            borderWidth: 0,
                        }]
                    },
                    options: {
                        responsive: true,
                        cutout: '68%',
                        plugins: { legend: { position: 'bottom', labels: { boxWidth: 10, font: { size: 11 } } } }
                    }
                });
            }
        });
    </script>

</div>
@endsection