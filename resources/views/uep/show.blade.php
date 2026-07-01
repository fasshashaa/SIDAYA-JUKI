@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ============ HEADER ============ --}}
      <div class="mb-8">
        <br>
        <a href="{{ route('uep.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline flex items-center gap-1.5 mb-3 w-fit">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Detail Usaha Ekonomi Produktif</h1>
        <p class="text-sm text-gray-500 mt-1">Data Usaha Ekonomi Produktif Kabupaten Cilacap.</p>
    </div>

    <div class="bg-white shadow-sm shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">

        {{-- ============ IDENTITY BLOCK ============ --}}
        <div class="p-6 md:p-8 border-b border-slate-100 bg-gradient-to-br from-slate-50/80 to-white flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-lg font-bold shrink-0 shadow-lg shadow-indigo-600/20">
                {{ strtoupper(substr($uep->nama_usaha, 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 truncate">{{ $uep->nama_usaha }}</h2>
                    @php
                        $verifStyles = [
                            'disetujui' => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                            'ditolak'   => ['bg-rose-50 text-rose-600', 'bg-rose-500'],
                            'pending'   => ['bg-amber-50 text-amber-600', 'bg-amber-500'],
                        ];
                        [$verifBadge, $verifDot] = $verifStyles[$uep->status_verifikasi] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];

                        $usahaStyles = [
                            'Aktif'          => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                            'Tidak Aktif'    => ['bg-rose-50 text-rose-600', 'bg-rose-500'],
                            'Tutup Sementara'=> ['bg-amber-50 text-amber-600', 'bg-amber-500'],
                        ];
                        [$usahaBadge, $usahaDot] = $usahaStyles[$uep->status_usaha] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $verifBadge }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $verifDot }}"></span>
                        {{ ucfirst($uep->status_verifikasi) }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $usahaBadge }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $usahaDot }}"></span>
                        {{ $uep->status_usaha }}
                    </span>
                </div>
                <span class="inline-block mt-2 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                    {{ $uep->kategori_produk }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8 space-y-8">

            {{-- ============ SECTION 1: PENERIMA MANFAAT ============ --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">1</span>
                    <h4 class="text-sm font-bold text-slate-800">Data Penerima Manfaat</h4>
                </div>
                @if($uep->penerimaManfaat)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                        <div>
                            <span class="block text-xs text-slate-400 mb-0.5">Nama Lengkap</span>
                            <p class="text-sm font-medium text-slate-800">{{ $uep->penerimaManfaat->nama_lengkap }}</p>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-0.5">NIK</span>
                            <p class="text-sm font-medium text-slate-800 font-mono">{{ $uep->penerimaManfaat->nik }}</p>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-0.5">No. KK</span>
                            <p class="text-sm font-medium text-slate-800 font-mono">{{ $uep->penerimaManfaat->no_kk }}</p>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-0.5">No. WhatsApp</span>
                            @if($uep->penerimaManfaat->no_wa)
                                <a href="https://wa.me/{{ str_starts_with($uep->penerimaManfaat->no_wa, '0') ? '62'.substr($uep->penerimaManfaat->no_wa, 1) : $uep->penerimaManfaat->no_wa }}" target="_blank" class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                                    {{ $uep->penerimaManfaat->no_wa }}
                                </a>
                            @else
                                <p class="text-sm text-slate-300">&mdash;</p>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="text-sm text-rose-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19h14.14a1 1 0 00.86-1.5L12.86 5a1 1 0 00-1.72 0L4.07 17.5a1 1 0 00.86 1.5z"/></svg>
                        Data penerima manfaat tidak ditemukan
                    </p>
                @endif
            </div>

            {{-- ============ SECTION 2: PROFIL USAHA ============ --}}
            <div class="pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">2</span>
                    <h4 class="text-sm font-bold text-slate-800">Profil Usaha</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Nama Usaha</span>
                        <p class="text-sm font-medium text-slate-800">{{ $uep->nama_usaha }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Kategori</span>
                        <p class="text-sm font-medium text-slate-800">{{ $uep->kategori_produk }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Tahun Realisasi</span>
                        <p class="text-sm font-medium text-slate-800">{{ $uep->tahun_realisasi }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Wilayah</span>
                        <p class="text-sm font-medium text-slate-800">{{ $uep->kecamatan_usaha }}, {{ $uep->desa_kelurahan_usaha }}</p>
                    </div>
                    <div class="sm:col-span-2">
                        <span class="block text-xs text-slate-400 mb-0.5">Alamat Lengkap</span>
                        <p class="text-sm font-medium text-slate-800">{{ $uep->alamat_lengkap }}</p>
                    </div>
                </div>
            </div>

            {{-- ============ SECTION 3: PEMBIAYAAN & VERIFIKASI ============ --}}
            <div class="pt-6 border-t border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-6 h-6 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold flex items-center justify-center shrink-0">3</span>
                    <h4 class="text-sm font-bold text-slate-800">Data Pembiayaan &amp; Verifikasi</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Sumber Anggaran</span>
                        <p class="text-sm font-semibold text-slate-900">{{ $uep->sumber_anggaran }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Status Verifikasi</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $verifBadge }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $verifDot }}"></span>
                            {{ ucfirst($uep->status_verifikasi) }}
                        </span>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Status Usaha</span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $usahaBadge }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $usahaDot }}"></span>
                            {{ $uep->status_usaha }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ ACTIONS ============ --}}
        <div class="px-6 md:px-8 pb-6 md:pb-8 pt-2 flex items-center gap-3">
            <a href="{{ route('uep.edit', $uep->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-5 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Data
            </a>
        </div>
    </div>
</div>
@endsection