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
     x-data="{
        showPassword: false,
        showConfirm: false,
        role: '{{ old('role', 'user') }}',
        password: '',
        confirm: '',
        get checks() {
            return {
                length: this.password.length >= 8,
                upper: /[A-Z]/.test(this.password),
                lower: /[a-z]/.test(this.password),
                number: /[0-9]/.test(this.password),
                symbol: /[^A-Za-z0-9]/.test(this.password),
            };
        },
        get score() {
            return Object.values(this.checks).filter(Boolean).length;
        },
        get strengthLabel() {
            if (this.password.length === 0) return '';
            if (this.score <= 2) return 'Lemah';
            if (this.score === 3) return 'Sedang';
            if (this.score === 4) return 'Kuat';
            return 'Sangat Kuat';
        },
        get strengthColor() {
            if (this.score <= 2) return 'bg-rose-500';
            if (this.score === 3) return 'bg-amber-500';
            if (this.score === 4) return 'bg-teal-500';
            return 'bg-emerald-500';
        },
        get strengthTextColor() {
            if (this.score <= 2) return 'text-rose-500';
            if (this.score === 3) return 'text-amber-500';
            if (this.score === 4) return 'text-teal-600';
            return 'text-emerald-600';
        },
        get confirmMatches() {
            return this.confirm.length > 0 && this.confirm === this.password;
        },
        get confirmMismatch() {
            return this.confirm.length > 0 && this.confirm !== this.password;
        }
     }">

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

                {{-- ============ PASSWORD + STRENGTH METER ============ --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Password *</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                               x-model="password"
                               class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 pr-11 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all">
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    @error('password') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror

                    {{-- Strength bar --}}
                    <div class="mt-3" x-show="password.length > 0" x-cloak x-transition>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-300 ease-out"
                                     :class="strengthColor"
                                     :style="`width: ${(score / 5) * 100}%`"></div>
                            </div>
                            <span class="text-xs font-semibold w-24 text-right" :class="strengthTextColor" x-text="strengthLabel"></span>
                        </div>

                        {{-- Criteria checklist --}}
                        <div class="grid grid-cols-2 gap-x-4 gap-y-1.5 mt-3">
                            <div class="flex items-center gap-1.5 text-xs" :class="checks.length ? 'text-emerald-600' : 'text-slate-400'">
                                <svg x-show="checks.length" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <svg x-show="!checks.length" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Minimal 8 karakter
                            </div>
                            <div class="flex items-center gap-1.5 text-xs" :class="checks.upper ? 'text-emerald-600' : 'text-slate-400'">
                                <svg x-show="checks.upper" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <svg x-show="!checks.upper" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Huruf besar (A-Z)
                            </div>
                            <div class="flex items-center gap-1.5 text-xs" :class="checks.lower ? 'text-emerald-600' : 'text-slate-400'">
                                <svg x-show="checks.lower" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <svg x-show="!checks.lower" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Huruf kecil (a-z)
                            </div>
                            <div class="flex items-center gap-1.5 text-xs" :class="checks.number ? 'text-emerald-600' : 'text-slate-400'">
                                <svg x-show="checks.number" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <svg x-show="!checks.number" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Angka (0-9)
                            </div>
                            <div class="flex items-center gap-1.5 text-xs" :class="checks.symbol ? 'text-emerald-600' : 'text-slate-400'">
                                <svg x-show="checks.symbol" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <svg x-show="!checks.symbol" class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                Simbol (!@#$%)
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ============ KONFIRMASI PASSWORD ============ --}}
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold mb-2" style="color: var(--text-body)">Konfirmasi Password *</label>
                    <div class="relative">
                        <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation" required
                               x-model="confirm"
                               class="w-full rounded-xl border-slate-200 bg-slate-50/60 text-sm p-3 pr-11 focus:bg-white focus:border-teal-400 focus:ring-2 focus:ring-teal-500/20 transition-all"
                               :class="confirmMismatch ? 'border-rose-300 focus:border-rose-400 focus:ring-rose-500/20' : (confirmMatches ? 'border-emerald-300' : '')">
                        <button type="button" @click="showConfirm = !showConfirm"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                            <svg x-show="!showConfirm" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            <svg x-show="showConfirm" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" /></svg>
                        </button>
                    </div>
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1" x-show="confirmMismatch" x-cloak x-transition>
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        Password tidak sama
                    </p>
                    <p class="text-xs text-emerald-600 mt-1.5 flex items-center gap-1" x-show="confirmMatches" x-cloak x-transition>
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Password cocok
                    </p>
                    @error('password_confirmation') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
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
                    <button type="submit"
                            class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="confirm.length > 0 && confirmMismatch">
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
</div>
@endsection