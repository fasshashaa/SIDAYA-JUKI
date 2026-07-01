@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ============ HEADER ============ --}}
    <div class="mb-8">
        <a href="{{ route('kube.index') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-slate-500 hover:text-indigo-600 transition-colors mb-3">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar KUBE
        </a>
        <p class="text-xs font-semibold text-indigo-600 tracking-wide uppercase mb-1.5">Detail Kelompok</p>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Detail Kelompok KUBE</h1>
    </div>

    <div class="bg-white shadow-sm shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">

        {{-- ============ IDENTITY BLOCK ============ --}}
        <div class="p-6 md:p-8 border-b border-slate-100 flex items-start gap-4">
            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg font-bold shrink-0">
                {{ strtoupper(substr($kube->nama_kelompok_kube, 0, 2)) }}
            </div>
            <div class="min-w-0 flex-1">
                <div class="flex flex-wrap items-center gap-2.5">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 truncate">{{ $kube->nama_kelompok_kube }}</h2>
                    @php
                        $statusStyles = [
                            'disetujui' => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                            'ditolak'   => ['bg-rose-50 text-rose-600', 'bg-rose-500'],
                            'pending'   => ['bg-amber-50 text-amber-600', 'bg-amber-500'],
                        ];
                        [$badgeClass, $dotClass] = $statusStyles[$kube->status_verifikasi] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                    @endphp
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                        <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
                        {{ ucfirst($kube->status_verifikasi) }}
                    </span>
                </div>
                <span class="inline-block mt-2 px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-medium rounded-lg">
                    {{ $kube->jenis_usaha_kube }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-8">

            {{-- ============ INFORMASI OPERASIONAL ============ --}}
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Informasi Operasional</h4>
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Kecamatan</span>
                        <p class="text-sm font-medium text-slate-800">{{ $kube->kecamatan_kube }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Desa / Kelurahan</span>
                        <p class="text-sm font-medium text-slate-800">{{ $kube->desa_kube }}</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Alamat Lengkap</span>
                        <p class="text-sm font-medium text-slate-800">{{ $kube->alamat_lengkap_kube }}</p>
                    </div>
                </div>
            </div>

            {{-- ============ DATA ANGGOTA & KONTAK ============ --}}
            <div>
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Data Anggota &amp; Kontak</h4>
                <div class="space-y-4">
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Ketua Kelompok</span>
                        @if($kube->ketua)
                            <p class="text-sm font-medium text-slate-800">{{ $kube->ketua->nama_lengkap }}</p>
                        @else
                            <p class="text-sm font-medium text-rose-400 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M4.93 19h14.14a1 1 0 00.86-1.5L12.86 5a1 1 0 00-1.72 0L4.07 17.5a1 1 0 00.86 1.5z"/></svg>
                                Tidak ada data
                            </p>
                        @endif
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">Jumlah Anggota</span>
                        <p class="text-sm font-medium text-slate-800">{{ $kube->jumlah_anggota }} Orang</p>
                    </div>
                    <div>
                        <span class="block text-xs text-slate-400 mb-0.5">No. Telepon</span>
                        @if($kube->no_telp_kube)
                            <a href="https://wa.me/{{ str_starts_with($kube->no_telp_kube, '0') ? '62'.substr($kube->no_telp_kube, 1) : $kube->no_telp_kube }}" target="_blank" class="text-sm font-medium text-emerald-600 hover:text-emerald-700 inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                                {{ $kube->no_telp_kube }}
                            </a>
                        @else
                            <p class="text-sm text-slate-300">&mdash;</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ============ STATUS & PEMBIAYAAN ============ --}}
            <div class="md:col-span-2 pt-6 border-t border-slate-100">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Status &amp; Pembiayaan</h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Tahun Realisasi</span>
                        <p class="text-sm font-semibold text-slate-900">{{ $kube->tahun_realisasi }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Sumber Anggaran</span>
                        <p class="text-sm font-semibold text-slate-900">{{ $kube->sumber_anggaran }}</p>
                    </div>
                    <div class="bg-slate-50 rounded-2xl p-4">
                        <span class="block text-xs text-slate-400 mb-1">Status Verifikasi</span>
                        <p class="text-sm font-semibold text-slate-900 capitalize">{{ $kube->status_verifikasi }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- ============ ACTIONS ============ --}}
        <div class="px-6 md:px-8 pb-6 md:pb-8 pt-2 flex items-center gap-3">
            <a href="{{ route('kube.edit', $kube->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-5 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Ubah Data
            </a>
        </div>
    </div>
</div>
@endsection