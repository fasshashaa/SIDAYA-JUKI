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
       <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Ubah Data Pengguna</h1>
    <p class="text-sm text-slate-500 mt-1">Ubah Data Pengguna dan Level Hak Akses Pengguna.</p>
  </div>

<div class="rounded-3xl shadow-sm border p-6 md:p-8 max-w-3xl"
     style="background: var(--surface); border-color: var(--surface-border)"
     x-data="{ role: '{{ old('role', $user->role) }}', status: '{{ old('status', $user->status) }}' }">

    <form action="{{ route('superadmin.users.update', $user->id) }}" method="POST" class="space-y-8">
        @csrf @method('PUT')

        {{-- ============ SECTION I: INFORMASI AKUN ============ --}}
        <div>
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                <h4 class="text-sm font-bold" style="color: var(--text-strong)">Informasi Akun</h4>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Nama Lengkap *</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                    @error('name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Email *</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                    @error('email') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
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
                    ['value' => 'user', 'label' => 'Masyarakat', 'desc' => 'Akses terbatas ke usaha & produk milik sendiri.'],
                    ['value' => 'admin', 'label' => 'Admin', 'desc' => 'Kelola data & verifikasi, tanpa manajemen user.'],
                    ['value' => 'super_admin', 'label' => 'Super Admin', 'desc' => 'Akses penuh termasuk manajemen pengguna.'],
                      ['value' => 'pelanggan', 'label' => 'Pelanggan', 'desc' => 'Akses marketplace pelanggan.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach($roles as $r)
                <label class="relative flex flex-col gap-1 p-4 rounded-xl border cursor-pointer transition-all"
                       :class="role === '{{ $r['value'] }}' ? 'border-teal-500 ring-2 ring-teal-500/20' : ''"
                       style="border-color: var(--surface-border)">
                    <input type="radio" name="role" value="{{ $r['value'] }}" x-model="role" class="sr-only" {{ old('role', $user->role) === $r['value'] ? 'checked' : '' }}>
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

        {{-- ============ SECTION III: STATUS AKUN ============ --}}
        <div class="pt-6 border-t" style="border-color: var(--surface-border)">
            <div class="flex items-center gap-3 mb-5">
                <span class="w-6 h-6 rounded-full bg-teal-50 text-teal-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
                <h4 class="text-sm font-bold" style="color: var(--text-strong)">Status Akun</h4>
            </div>

            <div class="grid grid-cols-2 gap-3 max-w-sm">
                <label class="relative flex items-center gap-2 p-4 rounded-xl border cursor-pointer transition-all"
                       :class="status === 'aktif' ? 'border-emerald-500 ring-2 ring-emerald-500/20' : ''"
                       style="border-color: var(--surface-border)">
                    <input type="radio" name="status" value="aktif" x-model="status" class="sr-only" {{ old('status', $user->status) === 'aktif' ? 'checked' : '' }}>
                    <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                    <span class="text-sm font-semibold" style="color: var(--text-strong)">Aktif</span>
                </label>
                <label class="relative flex items-center gap-2 p-4 rounded-xl border cursor-pointer transition-all"
                       :class="status === 'nonaktif' ? 'border-rose-500 ring-2 ring-rose-500/20' : ''"
                       style="border-color: var(--surface-border)">
                    <input type="radio" name="status" value="nonaktif" x-model="status" class="sr-only" {{ old('status', $user->status) === 'nonaktif' ? 'checked' : '' }}>
                    <span class="h-2 w-2 rounded-full bg-rose-500"></span>
                    <span class="text-sm font-semibold" style="color: var(--text-strong)">Nonaktif</span>
                </label>
            </div>
            @error('status') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
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