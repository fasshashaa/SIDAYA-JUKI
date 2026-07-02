@extends('layouts.app')
@section('content')

<div class="mb-8">
        <div class="mb-8">
        <br>
        <a href="{{ route('superadmin.users.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
       <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Tambah Data Pengguna</h1>
    <p class="text-sm text-slate-500 mt-1">Buat Akun Baru dan Level Hak Akses Pengguna.</p>
  </div>

<div class="rounded-3xl shadow-sm border p-6 md:p-8 max-w-3xl"
     style="background: var(--surface); border-color: var(--surface-border)"
     x-data="{ showPassword: false, role: '{{ old('role', 'user') }}' }">

    <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-8">
        @csrf

        {{-- ============ SECTION I: INFORMASI AKUN ============ --}}
        <div>
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                <h4 class="text-sm font-bold" style="color: var(--text-strong)">Informasi Akun</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Nama Lengkap *</label>
                    <input type="text" name="name" required value="{{ old('name') }}"
                           class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Email *</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                           class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Password *</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                               class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 pr-11 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Konfirmasi Password *</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                               class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 pr-11 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- ============ SECTION II: LEVEL AKSES ============ --}}
        <div class="pt-6 border-t" style="border-color: var(--surface-border)">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                <h4 class="text-sm font-bold" style="color: var(--text-strong)">Level Akses</h4>
            </div>

            @php
                $roles = [
                    ['value' => 'user', 'label' => 'Pengguna', 'desc' => 'Akses terbatas ke usaha & produk milik sendiri.'],
                    ['value' => 'admin', 'label' => 'Admin', 'desc' => 'Kelola data & verifikasi, tanpa manajemen user.'],
                    ['value' => 'super_admin', 'label' => 'Super Admin', 'desc' => 'Akses penuh termasuk manajemen pengguna.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($roles as $r)
                <label class="relative flex flex-col gap-1 p-4 rounded-xl border cursor-pointer transition-all"
                       :class="role === '{{ $r['value'] }}' ? 'border-teal-500 ring-2 ring-teal-500/20' : ''"
                       style="border-color: var(--surface-border)">
                    <input type="radio" name="role" value="{{ $r['value'] }}" x-model="role" class="sr-only" {{ old('role', 'user') === $r['value'] ? 'checked' : '' }}>
                    <span class="text-sm font-bold" style="color: var(--text-strong)">{{ $r['label'] }}</span>
                    <span class="text-xs" style="color: var(--text-muted)">{{ $r['desc'] }}</span>
                    <svg x-show="role === '{{ $r['value'] }}'" x-cloak class="w-4 h-4 text-teal-500 absolute top-3 right-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </label>
                @endforeach
            </div>
            @error('role') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
        </div>

        {{-- ============ ACTIONS ============ --}}
         <div class="sticky bottom-4 z-10">
                <div class="bg-white/90 backdrop-blur border border-gray-100 shadow-lg shadow-black/5 rounded-2xl p-4 flex items-center gap-3">
                    <button type="submit" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Baru
                    </button>
                    <a href="{{ route('superadmin.users.index') }}" class="bg-white hover:bg-gray-50 text-gray-500 font-semibold px-6 py-3 rounded-xl text-sm border border-gray-200 transition-all">
                        Batal
                    </a>
                    {{-- <span class="ml-auto text-xs text-gray-400 hidden sm:flex items-center gap-1.5">
                        <span class="text-rose-500">*</span> wajib diisi
                    </span> --}}
                </div>
            </div>
    </form>
</div>
@endsection