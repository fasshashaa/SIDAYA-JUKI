@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ============ HEADER ============ --}}
    <div class="mb-8">
        <br>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kelola Profil</h1>
        <p class="text-sm text-gray-500 mt-1">Informasi akun yang sedang kamu gunakan.</p>
    </div>

    <div class="bg-white shadow-sm shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">

        {{-- ============ IDENTITY BLOCK ============ --}}
        <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-br from-slate-50/80 to-white flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-lg font-bold shrink-0 shadow-lg shadow-indigo-600/20">
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 truncate">{{ auth()->user()->name }}</h2>
                    @php
                        $roleStyles = [
                            'super_admin' => ['bg-indigo-50 text-indigo-600', 'bg-indigo-500'],
                            'admin'       => ['bg-sky-50 text-sky-600', 'bg-sky-500'],
                            'user'        => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                        ];
                        [$roleBadge, $roleDot] = $roleStyles[auth()->user()->role] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleBadge }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                        {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                    </span>
                </div>
                <span class="inline-block mt-2 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                    {{ auth()->user()->email }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">

            {{-- ============ SECTION 1: INFORMASI AKUN ============ --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                    <h4 class="text-sm font-bold text-slate-800">Informasi Akun</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Nama Lengkap</span>
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Email</span>
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Role / Peran</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleBadge }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                            {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Akun Dibuat</span>
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->created_at->translatedFormat('d F Y') }}</p>
                    </div>
                    @if(auth()->user()->nomor_wa)
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Nomor WhatsApp</span>
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->nomor_wa }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Status Akun</span>
                        @php
                            $isAktif = (auth()->user()->status ?? 'aktif') !== 'nonaktif';
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $isAktif ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $isAktif ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                            {{ $isAktif ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- ============ SECTION 2: RINGKASAN AKUN ============ --}}
            <div class="pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                    <h4 class="text-sm font-bold text-slate-800">Ringkasan</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Role Saat Ini</span>
                        <p class="text-sm font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Email Terdaftar</span>
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Bergabung Sejak</span>
                        <p class="text-sm font-semibold text-slate-900"> {{ auth()->user()->created_at->translatedFormat('d M Y') }}</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- ============ INFO KEAMANAN ============ --}}
        <div class="px-6 md:px-8 pb-6 md:pb-8 pt-2">
            <div class="bg-slate-50 border border-slate-100 rounded-2xl p-4 flex items-start gap-3">
                <svg class="w-4 h-4 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-xs text-slate-500">
                    Untuk mengubah nama, email, atau password, silakan hubungi Administrator sistem.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection