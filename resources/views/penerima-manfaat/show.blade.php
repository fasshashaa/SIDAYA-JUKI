@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto">

    {{-- ================= HEADER ================= --}}
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('penerima-manfaat.index') }}" class="text-sm font-medium text-slate-500 hover:text-indigo-600 flex items-center gap-1.5 w-fit transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Daftar
        </a>
        {{-- <div class="inline-flex gap-2">
            <a href="{{ route('penerima-manfaat.edit', $penerima->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Data
            </a>
        </div> --}}
    </div>

    {{-- ================= MAIN CARD ================= --}}
    <div class="bg-white shadow-sm shadow-slate-200/50 border border-slate-100 rounded-3xl overflow-hidden">

        {{-- Profile header --}}
        <div class="p-8 pb-6 border-b border-slate-100 bg-gradient-to-br from-slate-50/80 to-white flex items-center gap-5">
            <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center font-extrabold text-xl shrink-0 shadow-lg shadow-indigo-600/20">
                {{ Str::of($penerima->nama_lengkap)->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
            </div>
            <div class="min-w-0">
                <h2 class="text-2xl font-extrabold text-slate-900 truncate">{{ $penerima->nama_lengkap }}</h2>
                @php
                    $statusStyles = [
                        'pending'   => ['bg-amber-50 text-amber-600', 'bg-amber-500'],
                        'disetujui' => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                        'ditolak'   => ['bg-rose-50 text-rose-600', 'bg-rose-500'],
                    ];
                    [$badgeClass, $dotClass] = $statusStyles[$penerima->status_verifikasi] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                @endphp
                <span class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 {{ $badgeClass }} text-xs font-bold rounded-full">
                    <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
                    {{ ucfirst($penerima->status_verifikasi) }}
                </span>
            </div>
        </div>

        {{-- Detail fields --}}
        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-7">
                <div class="space-y-7">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Ibu Kandung</span>
                            <p class="text-base text-slate-800 font-semibold mt-0.5">{{ $penerima->nama_ibu_kandung }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">NIK</span>
                            <p class="text-base text-slate-800 font-semibold font-mono mt-0.5 tracking-wide">{{ $penerima->nik }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor WhatsApp</span>
                            @if($penerima->no_wa)
                                <a href="https://wa.me/{{ str_starts_with($penerima->no_wa, '0') ? '62'.substr($penerima->no_wa, 1) : $penerima->no_wa }}" target="_blank" class="text-base text-indigo-600 font-semibold mt-0.5 inline-block hover:text-indigo-700">{{ $penerima->no_wa }}</a>
                            @else
                                <p class="text-base text-slate-300 font-semibold mt-0.5">&mdash;</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-7">
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor Kartu Keluarga</span>
                            <p class="text-base text-slate-800 font-semibold font-mono mt-0.5 tracking-wide">{{ $penerima->no_kk }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Wilayah (Kecamatan / Desa)</span>
                            <p class="text-base text-slate-800 font-semibold mt-0.5">{{ $penerima->kecamatan }} <span class="text-slate-300 mx-1">/</span> {{ $penerima->desa }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                        </div>
                        <div class="min-w-0">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat Detail</span>
                            <p class="text-base text-slate-800 font-semibold mt-0.5">{{ $penerima->alamat_detail }}</p>
                        </div>
                    </div>
                </div>
                 <div class="inline-flex gap-2">
            <a href="{{ route('penerima-manfaat.edit', $penerima->id) }}" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit Data
            </a>
        </div>
            </div>
        </div>
    </div>
</div>
@endsection