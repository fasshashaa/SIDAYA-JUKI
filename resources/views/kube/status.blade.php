@extends('layouts.app')
@section('content')

<div class="mb-8">
    <br>
    {{-- <a href="{{ url('/dashboard') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Dashboard
    </a> --}}
    <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Status Pengajuan KUBE Saya</h1>
    <p class="text-sm text-slate-500 mt-1">Pantau perkembangan verifikasi pengajuan Kelompok Usaha Bersama Anda.</p>
</div>

@if(session('success'))
    <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-2xl flex items-center gap-2.5">
        <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
@endif

@if($kubes->isEmpty())
    {{-- ============ EMPTY STATE ============ --}}
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 p-14 text-center max-w-2xl">
        <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4"/></svg>
        </div>
        <p class="text-sm font-semibold text-slate-600">Anda belum pernah mengajukan KUBE</p>
        <p class="text-xs text-slate-400 mt-1 mb-5">Ajukan Kelompok Usaha Bersama untuk mulai mendapatkan bantuan pembinaan.</p>
        <a href="{{ route('kube.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-sm shadow-indigo-600/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan KUBE Sekarang
        </a>
    </div>
@else
    @php
        $latest = $kubes->first();
        // Cari submission mana pun yang statusnya sudah disetujui, bukan cuma yang paling baru diajukan
        $approvedKube = $kubes->firstWhere('status_verifikasi', 'disetujui');
    @endphp

    {{-- ============ STATUS TERKINI (STEPPER) ============ --}}
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 p-6 md:p-8 mb-6 max-w-3xl">
        <div class="flex items-center justify-between mb-6">
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-indigo-500 mb-1">Pengajuan Terbaru</p>
                <h2 class="text-lg font-bold text-slate-900">{{ $latest->nama_kelompok_kube }}</h2>
                <p class="text-xs text-slate-400 mt-0.5">Diajukan {{ $latest->created_at->translatedFormat('d F Y') }}</p>
            </div>
            @if($latest->status_verifikasi == 'disetujui')
                <span class="px-3 py-1.5 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-full">Disetujui</span>
            @elseif($latest->status_verifikasi == 'ditolak')
                <span class="px-3 py-1.5 bg-rose-50 text-rose-600 text-xs font-bold rounded-full">Ditolak</span>
            @else
                <span class="px-3 py-1.5 bg-amber-50 text-amber-600 text-xs font-bold rounded-full">Menunggu Verifikasi</span>
            @endif
        </div>

        {{-- Stepper --}}
        @php
            $step = $latest->status_verifikasi == 'pending' ? 2 : 3;
            $isRejected = $latest->status_verifikasi == 'ditolak';
        @endphp
        <div class="flex items-center">
            <div class="flex flex-col items-center flex-1">
                <div class="w-9 h-9 rounded-full bg-indigo-600 text-white flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-[11px] font-semibold text-slate-600 mt-2 text-center">Diajukan</p>
            </div>

            <div class="flex-1 h-0.5 -mt-5 {{ $step >= 2 ? 'bg-indigo-600' : 'bg-slate-200' }}"></div>

            <div class="flex flex-col items-center flex-1">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0
                    {{ $step >= 2 ? ($latest->status_verifikasi == 'pending' ? 'bg-amber-500 text-white animate-pulse' : 'bg-indigo-600 text-white') : 'bg-slate-100 text-slate-400' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <p class="text-[11px] font-semibold text-slate-600 mt-2 text-center">Diperiksa Admin</p>
            </div>

            <div class="flex-1 h-0.5 -mt-5 {{ $step >= 3 ? ($isRejected ? 'bg-rose-500' : 'bg-emerald-500') : 'bg-slate-200' }}"></div>

            <div class="flex flex-col items-center flex-1">
                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0
                    {{ $step >= 3 ? ($isRejected ? 'bg-rose-500 text-white' : 'bg-emerald-500 text-white') : 'bg-slate-100 text-slate-400' }}">
                    @if($isRejected)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    @else
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @endif
                </div>
                <p class="text-[11px] font-semibold text-slate-600 mt-2 text-center">{{ $isRejected ? 'Ditolak' : 'Disetujui' }}</p>
            </div>
        </div>

        @if($latest->status_verifikasi == 'pending')
            <div class="mt-6 flex items-start gap-3 p-4 rounded-xl border border-amber-200 bg-amber-50">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <p class="text-sm text-amber-700">Pengajuan Anda sedang menunggu peninjauan dari admin. Proses ini biasanya memerlukan beberapa hari kerja.</p>
            </div>
        @elseif($latest->status_verifikasi == 'ditolak')
            <div class="mt-6 flex items-start gap-3 p-4 rounded-xl border border-rose-200 bg-rose-50">
                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" /></svg>
                <div>
                    <p class="text-sm text-rose-700 font-medium">Pengajuan Anda ditolak.</p>
                     @if($latest->catatan_penolakan)
                        <div class="mt-2 p-3 bg-white/70 border border-rose-100 rounded-lg">
                            <p class="text-[11px] font-bold uppercase tracking-wide text-rose-500 mb-1">Alasan dari Admin</p>
                            <p class="text-sm text-rose-700">{{ $latest->catatan_penolakan }}</p>
                        </div>
                    @else
                        <p class="text-sm text-rose-700 mt-1">Silakan hubungi admin untuk informasi lebih lanjut.</p>
                    @endif
                    <a href="{{ route('kube.create') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-rose-700 hover:text-rose-800 mt-3">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        Ajukan Ulang dengan Data Diperbaiki
                    </a>
                </div>
            </div>
        @else
            <div class="mt-6 flex items-start gap-3 p-4 rounded-xl border border-emerald-200 bg-emerald-50">
                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-emerald-700">Selamat! Pengajuan KUBE Anda telah disetujui dan tercatat sebagai kelompok binaan aktif.</p>
            </div>
        @endif
    </div>

    {{-- ============ PROFIL KELOMPOK AKTIF (khusus untuk submission yang sudah disetujui) ============ --}}
    @if($approvedKube)
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden mb-6 max-w-3xl">
        <div class="p-5 border-b border-slate-100 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-1.13a4 4 0 10-4-4 4 4 0 004 4zm6 0a4 4 0 10-4-4" /></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold uppercase tracking-widest text-emerald-600">Terverifikasi</p>
                <h3 class="text-sm font-bold text-slate-800">Profil Kelompok Aktif Anda</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 divide-y sm:divide-y-0 sm:divide-x divide-slate-50">
            <div class="p-5 space-y-4">
                <div>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Nama Kelompok</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->nama_kelompok_kube }}</p>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Jenis Usaha</p>
                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-medium inline-block">{{ $approvedKube->jenis_usaha_kube }}</span>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Ketua Kelompok</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->ketua->nama_lengkap ?? '-' }}</p>
                </div>
            </div>

            <div class="p-5 space-y-4">
                <div>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Wilayah</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->desa_kube }}</p>
                    <p class="text-xs text-slate-400">Kec. {{ $approvedKube->kecamatan_kube }}</p>
                </div>
                <div class="flex gap-6">
                    <div>
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Jumlah Anggota</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->jumlah_anggota }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Tahun Realisasi</p>
                        <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->tahun_realisasi ?? '-' }}</p>
                    </div>
                </div>
                <div>
                    <p class="text-[11px] font-medium text-slate-400 uppercase tracking-wide mb-1">Sumber Anggaran</p>
                    <p class="text-sm font-semibold text-slate-800">{{ $approvedKube->sumber_anggaran ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- ============ RIWAYAT PENGAJUAN ============ --}}
    @if($kubes->count() > 1)
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden max-w-3xl">
        <div class="p-5 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-800">Riwayat Pengajuan Lainnya</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($kubes->skip(1) as $item)
                <div class="p-4 px-6 flex items-center justify-between gap-3">
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate">{{ $item->nama_kelompok_kube }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $item->created_at->translatedFormat('d F Y') }}</p>
                        @if($item->status_verifikasi == 'ditolak' && $item->catatan_penolakan)
                            <p class="text-xs text-rose-500 mt-1 max-w-md truncate" title="{{ $item->catatan_penolakan }}">Alasan: {{ $item->catatan_penolakan }}</p>
                        @endif
                    </div>
                    @if($item->status_verifikasi == 'disetujui')
                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full whitespace-nowrap">Disetujui</span>
                    @elseif($item->status_verifikasi == 'ditolak')
                        <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full whitespace-nowrap">Ditolak</span>
                    @else
                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full whitespace-nowrap">Pending</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- <div class="mt-6 max-w-3xl">
        <a href="{{ route('kube.create') }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-5 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Ajukan KUBE Baru
        </a>
    </div> --}}
@endif

@endsection