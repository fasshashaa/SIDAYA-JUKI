@extends('layouts.app')
@section('content')

    {{-- ================= HEADER ================= --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            {{-- <p class="text-xs font-semibold text-blue-500 uppercase tracking-widest mb-1">Data Master</p> --}}
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Penerima Manfaat</h1>
            <p class="text-sm text-gray-500 mt-1">Daftar Penerima Manfaat Binaan Dinsos PPPA Kabupaten Cilacap.</p>
        </div>
        <div>
            <a href="{{ route('penerima-manfaat.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-xl text-sm transition-all shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Penerima Manfaat
            </a>
        </div>
    </div>

    {{-- ================= SUCCESS ALERT ================= --}}
    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-medium rounded-2xl flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- ================= QUICK STATS ROW ================= --}}
    @php
        $statusCounts = [
            'pending'   => $penerimaManfaat->where('status_verifikasi', 'pending')->count(),
            'disetujui' => $penerimaManfaat->where('status_verifikasi', 'disetujui')->count(),
            'ditolak'   => $penerimaManfaat->where('status_verifikasi', 'ditolak')->count(),
        ];
    @endphp
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Pending</p>
                <p class="text-xl font-extrabold text-gray-900">{{ $statusCounts['pending'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Disetujui</p>
                <p class="text-xl font-extrabold text-gray-900">{{ $statusCounts['disetujui'] }}</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center gap-4 shadow-sm">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Ditolak</p>
                <p class="text-xl font-extrabold text-gray-900">{{ $statusCounts['ditolak'] }}</p>
            </div>
        </div>
    </div>

    {{-- ================= TABLE CARD ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider">Data Register Penerima</h3>
            <span class="text-xs bg-blue-50 text-blue-600 font-semibold px-3 py-1.5 rounded-full w-fit">Total: {{ $penerimaManfaat->total() }} Orang</span>
        </div>

        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse text-sm ">
                <thead>
                    <tr class="bg-gray-50/70 border-b border-gray-100 text-gray-500 font-semibold text-xs uppercase tracking-wide">
                        <th class="p-4 pl-6">Nama Lengkap</th>
                        <th class="p-4">NIK</th>
                        <th class="p-4">Wilayah</th>
                        <th class="p-4">WhatsApp</th>
                        <th class="p-4">Status</th>
                        <th class="p-4 text-right pr-6">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 text-gray-700 font-medium">
                    @forelse($penerimaManfaat as $item)
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="p-4 pl-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ Str::of($item->nama_lengkap)->explode(' ')->map(fn($w) => Str::substr($w, 0, 1))->take(2)->implode('') }}
                                    </div>
                                    <span class="font-bold text-gray-900">{{ $item->nama_lengkap }}</span>
                                </div>
                            </td>
                            <td class="p-4 font-mono text-gray-500 text-xs">{{ Str::mask($item->nik, '*', 4, 8) }}</td>
                            <td class="p-4">
                                <div class="text-gray-900">{{ $item->desa }}</div>
                                <div class="text-gray-400 text-[11px] mt-0.5">Kec. {{ $item->kecamatan }}</div>
                            </td>
                            <td class="p-4">
                                @if($item->no_wa)
                                    <a href="https://wa.me/{{ str_starts_with($item->no_wa, '0') ? '62'.substr($item->no_wa, 1) : $item->no_wa }}" target="_blank" class="inline-flex items-center gap-1.5 text-blue-600 hover:text-blue-700 hover:underline">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.472-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.001 2.003c-5.523 0-9.999 4.476-9.999 9.999 0 1.762.464 3.484 1.346 5.001L2 22l5.109-1.334a9.958 9.958 0 004.892 1.246h.005c5.523 0 9.999-4.476 9.999-9.999 0-2.67-1.04-5.179-2.928-7.067A9.936 9.936 0 0012.001 2.003zm0 18.174h-.004a8.163 8.163 0 01-4.166-1.14l-.299-.177-3.03.792.809-2.954-.195-.303a8.156 8.156 0 01-1.256-4.396c0-4.516 3.674-8.19 8.19-8.19 2.187 0 4.243.852 5.79 2.401a8.13 8.13 0 012.399 5.792c-.001 4.516-3.675 8.19-8.191 8.19z"/></svg>
                                        {{ $item->no_wa }}
                                    </a>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $statusStyles = [
                                        'pending'   => ['bg-amber-50 text-amber-700', 'bg-amber-500'],
                                        'disetujui' => ['bg-emerald-50 text-emerald-700', 'bg-emerald-500'],
                                        'ditolak'   => ['bg-rose-50 text-rose-700', 'bg-rose-500'],
                                    ];
                                    [$badgeClass, $dotClass] = $statusStyles[$item->status_verifikasi] ?? ['bg-gray-100 text-gray-600', 'bg-gray-400'];
                                @endphp
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold {{ $badgeClass }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $dotClass }}"></span>
                                    {{ ucfirst($item->status_verifikasi) }}
                                </span>
                            </td>
<td class="p-4 pr-6 text-right relative">
    <div x-data="{ open: false, isTop: false }" 
         x-on:click.away="open = false"
         class="relative inline-block text-left">
        
        <button @click="open = !open; isTop = (window.innerHeight - $el.getBoundingClientRect().top) < 200" 
                class="p-2 text-gray-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-all">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/></svg>
        </button>

        <div x-show="open" 
             x-cloak
             :class="isTop ? 'bottom-full mb-2' : 'top-full mt-2'"
             class="absolute right-0 z-[100] w-36 bg-white rounded-xl shadow-2xl border border-gray-100 py-1 transition-all duration-200">
             
            <a href="{{ route('penerima-manfaat.show', $item->id) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                Lihat
            </a>
            
            <a href="{{ route('penerima-manfaat.edit', $item->id) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-amber-600 hover:bg-amber-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                Edit
            </a>
            
            <form action="{{ route('penerima-manfaat.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                @csrf @method('DELETE')
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</td>
<script>
function toggleMenu(btn, event) {
    event.stopPropagation();
    // Tutup semua menu lain
    document.querySelectorAll('.dropdown-content').forEach(el => el.classList.add('hidden'));
    
    let menu = btn.nextElementSibling;
    menu.classList.remove('hidden');
    
    // Posisikan secara absolut berdasarkan layar (bukan container)
    let rect = btn.getBoundingClientRect();
    menu.style.position = 'fixed';
    menu.style.top = (rect.bottom + 5) + 'px';
    menu.style.left = (rect.right - 140) + 'px';
}

// Klik di luar untuk menutup
window.addEventListener('click', () => {
    document.querySelectorAll('.dropdown-content').forEach(el => el.classList.add('hidden'));
});
</script>                 </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-gray-400 font-normal">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-gray-50 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                                    </div>
                                    <p class="text-sm">Belum ada data penerima manfaat.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-50 bg-gray-50/30">
            {{ $penerimaManfaat->links() }}
        </div>
    </div>
@endsection