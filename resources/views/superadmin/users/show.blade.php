@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ============ HEADER ============ --}}
    <div class="mb-8">
        <br>
        <a href="{{ route('superadmin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Pengguna</h1>
        <p class="text-sm text-gray-500 mt-1">Data akun pengguna sistem SIDAYA.</p>
    </div>

    <div class="bg-white shadow-sm shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">

        {{-- ============ IDENTITY BLOCK ============ --}}
        <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-br from-slate-50/80 to-white flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-lg font-bold shrink-0 shadow-lg shadow-indigo-600/20">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 truncate">{{ $user->name }}</h2>
                    @php
                        $roleStyles = [
                            'super_admin' => ['bg-indigo-50 text-indigo-600', 'bg-indigo-500'],
                            'admin'       => ['bg-sky-50 text-sky-600', 'bg-sky-500'],
                            'user'        => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                        ];
                        [$roleBadge, $roleDot] = $roleStyles[$user->role] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleBadge }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                        {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                    </span>
                </div>
                <span class="inline-block mt-2 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                    {{ $user->email }}
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
                        <p class="text-sm font-medium text-slate-800">{{ $user->name }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Email</span>
                        <p class="text-sm font-medium text-slate-800">{{ $user->email }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Role / Peran</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $roleBadge }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $roleDot }}"></span>
                            {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                        </span>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Akun Dibuat</span>
                        <p class="text-sm font-medium text-slate-800">{{ $user->created_at->format('d F Y') }}</p>
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
                        <p class="text-sm font-semibold text-slate-900">{{ ucfirst(str_replace('_', ' ', $user->role)) }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Email Terdaftar</span>
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $user->email }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Bergabung Sejak</span>
                        <p class="text-sm font-semibold text-slate-900">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ ACTIONS ============ --}}
        <div class="px-6 md:px-8 pb-6 md:pb-8 pt-2 flex items-center gap-3">
            {{-- Sesuaikan/uncomment jika route edit user tersedia --}}
            {{-- <a href="{{ route('superadmin.users.edit', $user->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-5 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Data
            </a> --}}
            {{-- <a href="{{ route('superadmin.users.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700 font-medium px-2 py-2.5 text-sm transition-colors">
                Kembali ke daftar
            </a> --}}
        </div>
    </div>
</div>
@endsection