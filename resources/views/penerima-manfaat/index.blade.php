@extends('layouts.app')
@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
        <br>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Penerima Manfaat</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar Penerima Manfaat binaan Dinsos PPPA Kabupaten Cilacap.</p>
    </div>

    <div class="flex items-center gap-2">
        {{-- Tombol Ekspor (Dropdown) --}}
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" type="button" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                Ekspor
            </button>
            <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50 animate-in fade-in zoom-in duration-200">
                <a href="{{ route('penerima-manfaat.export.excel') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Excel</a>
                <a href="{{ route('penerima-manfaat.export.pdf') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">PDF</a>
            </div>
        </div>

        {{-- Tombol Import (File Input) --}}
        <form action="{{ route('penerima-manfaat.import') }}" method="POST" enctype="multipart/form-data" class="relative">
            @csrf
            <input type="file" name="file" onchange="this.form.submit()" class="hidden" id="file-upload">
            <label for="file-upload" class="cursor-pointer inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                Import
            </label>
        </form>

        {{-- Tombol Tambah --}}
        <a href="{{ route('penerima-manfaat.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-md shadow-indigo-600/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Baru
        </a>
    </div>
</div>

    {{-- ================= SUCCESS ALERT ================= --}}
    {{-- @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-2xl flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif --}}
 {{-- ============ STAT SUMMARY STRIP ============ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    
    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Orang</p>
            <p class="text-xl font-bold text-slate-900">{{ $penerimaManfaat->count() }}</p>
        </div>
    </div>
  @php
        $statusCounts = [
            'pending'   => $penerimaManfaat->where('status_verifikasi', 'pending')->count(),
            'disetujui' => $penerimaManfaat->where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => $penerimaManfaat->where('status_verifikasi', 'ditolak')->count(),
        ];
    @endphp
     <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-bold text-slate-900">{{ $statusCounts['pending'] }}</p>
            </div>
        </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Disetujui</p>
            <p class="text-xl font-bold text-slate-900">{{ $statusCounts['disetujui'] }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Ditolak</p>
            <p class="text-xl font-bold text-slate-900">{{ $statusCounts['ditolak'] }}</p>
        </div>
    </div>

</div>
    {{-- ================= QUICK STATS ROW =================
    @php
        $statusCounts = [
            'pending'   => $penerimaManfaat->where('status_verifikasi', 'pending')->count(),
            'disetujui' => $penerimaManfaat->where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => $penerimaManfaat->where('status_verifikasi', 'ditolak')->count(),
        ];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-bold text-slate-900">{{ $statusCounts['pending'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Disetujui</p>
                <p class="text-xl font-bold text-slate-900">{{ $statusCounts['disetujui'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Ditolak</p>
                <p class="text-xl font-bold text-slate-900">{{ $statusCounts['ditolak'] }}</p>
            </div>
        </div>
    </div> --}}

    {{-- ================= TABLE CARD ================= --}}
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden">

        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="relative w-full sm:max-w-xs">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input type="text" placeholder="Cari nama atau NIK..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    Filter
                </button>
                <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl whitespace-nowrap">{{ $penerimaManfaat->total() }} orang</span>
            </div>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wide">
                        <th class="p-4 pl-6 font-semibold">Nama Lengkap</th>
                        <th class="p-4 font-semibold">NIK</th>
                        <th class="p-4 font-semibold">Wilayah</th>
                        <th class="p-4 font-semibold">WhatsApp</th>
                        <th class="p-4 font-semibold">Status</th>
                        <th class="p-4 font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($penerimaManfaat as $item)
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ Str::of($item->nama_lengkap)->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                                    </div>
                                    <span class="font-semibold text-slate-900">{{ $item->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-slate-500 text-xs">{{ Str::mask($item->nik, '•', 4, 8) }}</td>
                            <td class="p-4">
                                <div class="text-slate-800 text-xs font-medium">{{ $item->desa }}</div>
                                <div class="text-slate-400 text-[11px] mt-0.5">Kec. {{ $item->kecamatan }}</div>
                            </td>
                            <td class="p-4">
                                @if($item->no_wa)
                                    <a href="https://wa.me/{{ str_starts_with($item->no_wa, '0') ? '62'.substr($item->no_wa, 1) : $item->no_wa }}" target="_blank" class="inline-flex items-center gap-1.5 text-emerald-600 hover:text-emerald-700 font-medium text-xs">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                                        {{ $item->no_wa }}
                                    </a>
                                @else
                                    <span class="text-slate-300">&mdash;</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $statusStyles = [
                                        'pending'   => ['bg-amber-50 text-amber-600', 'bg-amber-500'],
                                        'disetujui' => ['bg-emerald-50 text-emerald-600', 'bg-emerald-500'],
                                        'ditolak'   => ['bg-rose-50 text-rose-600', 'bg-rose-500'],
                                    ];
                                    [$badgeClass, $dotClass] = $statusStyles[$item->status_verifikasi] ?? ['bg-slate-100 text-slate-600', 'bg-slate-400'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
                                    {{ ucfirst($item->status_verifikasi) }}
                                </span>
                            </td>

                            {{-- Aksi --}}
                            <td class="p-4 relative">
                                <div x-data="{ open: false, dropUp: false }"
                                     x-on:click.away="open = false"
                                     class="relative inline-block text-left">

                                    <button @click="open = !open; dropUp = (window.innerHeight - $el.getBoundingClientRect().top) < 200"
                                            class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/></svg>
                                    </button>

                                    <div x-show="open"
                                         x-cloak
                                         x-transition:enter="transition ease-out duration-150"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         :class="dropUp ? 'bottom-full mb-2' : 'top-full mt-2'"
                                         class="absolute right-0 z-[100] w-40 bg-white rounded-xl shadow-xl shadow-slate-900/10 border border-slate-100 py-1.5">

                                        <a href="{{ route('penerima-manfaat.show', $item->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            Lihat
                                        </a>

                                        <a href="{{ route('penerima-manfaat.edit', $item->id) }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-amber-600 hover:bg-amber-50">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            Edit
                                        </a>

                                        <div class="my-1 border-t border-slate-50"></div>

                                        <form action="{{ route('penerima-manfaat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-14 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M23 21v-2a4 4 0 00-3-3.87"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-600">Belum ada data penerima manfaat</p>
                                        <p class="text-xs text-slate-400 mt-1">Tambahkan penerima baru untuk mulai mengelola data.</p>
                                    </div>
                                    <a href="{{ route('penerima-manfaat.create') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tambah Penerima Manfaat
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 bg-slate-50/40">
            {{ $penerimaManfaat->links() }}
        </div>
    </div>
@endsection