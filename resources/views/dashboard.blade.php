@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard Overview</h1>
            <p class="text-slate-500 text-sm">Selamat datang kembali, Admin Verifikator. Pantau aktivitas sistem Anda.</p>
        </div>
        <div class="flex items-center gap-2 text-sm bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-slate-600 font-medium">Sistem Berjalan Normal</span>
        </div>
    </div>

   <!-- Alert Section -->
<div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-100 p-8 shadow-sm">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h2 class="text-lg font-bold text-amber-900">Perlu Verifikasi</h2>
            <p class="text-amber-700/80 text-sm mt-1">
                Terdapat <span class="font-bold">{{ $data['pendingVerifikasi'] }}</span> item yang menunggu tindakan Anda.
            </p>
        </div>
        
        @if($data['pendingVerifikasi'] > 0)
            <a href="{{ route($data['targetRoute'], ['status_verifikasi' => 'pending']) }}" 
               class="inline-flex items-center justify-center gap-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold px-6 py-3 rounded-xl transition-all shadow-lg shadow-amber-600/20 text-sm">
                Proses Verifikasi Sekarang
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        @else
            <div class="px-6 py-3 bg-amber-200/50 text-amber-800 rounded-xl text-sm font-semibold">
                Semua Data Sudah Diverifikasi
            </div>
        @endif
    </div>
</div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $stats = [
                ['label' => 'Total Penerima Manfaat', 'value' => $data['totalPM'], 'color' => 'blue'],
                ['label' => 'Total UEP', 'value' => $data['totalUEP'], 'color' => 'indigo'],
                ['label' => 'Total KUBE', 'value' => $data['totalKUBE'], 'color' => 'violet'],
                ['label' => 'Total Katalog Produk', 'value' => $data['totalProduk'], 'color' => 'emerald'],
            ];
        @endphp

        @foreach($stats as $stat)
        <div class="group bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all hover:shadow-md hover:border-slate-300">
            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ $stat['label'] }}</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-2">{{ $stat['value'] }}</h3>
            <div class="mt-4 flex items-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-{{ $stat['color'] }}-500"></span>
                <span class="text-xs font-medium text-slate-400">Aktif</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection