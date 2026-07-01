@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>

            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Dashboard</h1>
            <p class="text-slate-500 text-sm mt-1">Selamat datang kembali, <span class="font-semibold text-slate-700">Admin Verifikator</span>. Pantau aktivitas sistem Anda hari ini.</p>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white/80 backdrop-blur px-4 py-2.5 rounded-xl border border-slate-200/80 shadow-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            {{-- <span class="text-slate-600 font-medium">Sistem Berjalan Normal</span> --}}
        </div>
    </div>

    {{-- ================= ALERT SECTION ================= --}}
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 p-8 md:p-10 shadow-xl shadow-slate-900/10">
        {{-- decorative glow --}}
        <div class="absolute -top-24 -right-24 w-72 h-72 bg-amber-500/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -left-10 w-72 h-72 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute inset-0 opacity-[0.03] bg-[linear-gradient(to_right,#fff_1px,transparent_1px),linear-gradient(to_bottom,#fff_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                <div class="shrink-0 w-12 h-12 rounded-2xl bg-amber-500/15 border border-amber-400/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-white">Perlu Verifikasi</h2>
                    <p class="text-slate-400 text-sm mt-1 max-w-md">
                        Terdapat <span class="font-bold text-amber-400">{{ $data['pendingVerifikasi'] }}</span> item yang menunggu tindakan Anda. Segera tinjau untuk menjaga kelancaran proses.
                    </p>
                </div>
            </div>

            @if($data['pendingVerifikasi'] > 0)
                <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}"
                   class="group inline-flex items-center justify-center gap-2 bg-white hover:bg-amber-50 text-slate-900 font-semibold px-6 py-3.5 rounded-2xl transition-all shadow-lg shadow-black/10 text-sm whitespace-nowrap">
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

    {{-- ================= STAT CARDS ================= --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @php
            // Tailwind JIT tidak bisa resolve class hasil concatenation (bg-{{ $color }}-500),
            // jadi mapping harus berupa string class LENGKAP di sini.
            $stats = [
                [
                    'label' => 'Total Penerima Manfaat',
                    'value' => $data['totalPM'],
                    'trend' => '+4.2%',
                    'up'    => true,
                    'ring'  => 'ring-blue-500/10',
                    'iconBg' => 'bg-blue-50',
                    'iconText' => 'text-blue-600',
                    'dot'   => 'bg-blue-500',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />',
                ],
                [
                    'label' => 'Total UEP',
                    'value' => $data['totalUEP'],
                    'trend' => '+1.8%',
                    'up'    => true,
                    'ring'  => 'ring-indigo-500/10',
                    'iconBg' => 'bg-indigo-50',
                    'iconText' => 'text-indigo-600',
                    'dot'   => 'bg-indigo-500',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />',
                ],
                [
                    'label' => 'Total KUBE',
                    'value' => $data['totalKUBE'],
                    'trend' => '-0.6%',
                    'up'    => false,
                    'ring'  => 'ring-violet-500/10',
                    'iconBg' => 'bg-violet-50',
                    'iconText' => 'text-violet-600',
                    'dot'   => 'bg-violet-500',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477" />',
                ],
                [
                    'label' => 'Total Katalog Produk',
                    'value' => $data['totalProduk'],
                    'trend' => '+7.4%',
                    'up'    => true,
                    'ring'  => 'ring-emerald-500/10',
                    'iconBg' => 'bg-emerald-50',
                    'iconText' => 'text-emerald-600',
                    'dot'   => 'bg-emerald-500',
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />',
                ],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group relative bg-white p-6 rounded-2xl border border-slate-200/70 shadow-sm ring-1 {{ $stat['ring'] }} transition-all duration-200 hover:shadow-lg hover:-translate-y-0.5">
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

            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mt-5">{{ $stat['label'] }}</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1 tabular-nums">{{ number_format($stat['value']) }}</h3>

            <div class="mt-4 flex items-center gap-2 pt-4 border-t border-slate-100">
                <span class="h-1.5 w-1.5 rounded-full {{ $stat['dot'] }}"></span>
                <span class="text-xs font-medium text-slate-400">Data aktif &middot; diperbarui hari ini</span>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection 