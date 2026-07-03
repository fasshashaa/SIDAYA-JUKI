    @extends('layouts.app')
    @section('content')

        {{-- ============ HEADER ============ --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-5">
            <div>
            <br>
                <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Kelolaan UEP</h1>
                <p class="text-sm text-slate-500 mt-1">Daftar Usaha Ekonomi Produktif yang terdaftar dan terverifikasi.</p>
            </div>
        <div class="flex items-center gap-2">
        {{-- Dropdown Ekspor --}}
    <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button" class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Ekspor
                </button>
                <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-40 bg-white rounded-xl shadow-xl border border-slate-100 py-1 z-50 animate-in fade-in zoom-in duration-200">
                    <a href="{{ route('uep.export.excel') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">Excel</a>
                    <a href="{{ route('uep.export.pdf') }}" class="flex items-center px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">PDF</a>
                </div>
            </div>

            {{-- Tombol Import (File Input) --}}
            <form action="{{ route('uep.import') }}" method="POST" enctype="multipart/form-data" class="relative">
                @csrf
                <input type="file" name="file" onchange="this.form.submit()" class="hidden" id="file-upload">
                <label for="file-upload" class="cursor-pointer inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                    Import
                </label>
            </form>
        @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('uep.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-colors shadow-sm shadow-indigo-600/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Usaha
                </a>
                @endif
            </div>
        </div>

        {{-- ============ ALERT ============ --}}
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
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Total Usaha</p>
                <p class="text-xl font-bold text-slate-900">{{ $ueps->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div>
                <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Status Aktif</p>
                <p class="text-xl font-bold text-slate-900">{{ $ueps->where('status_usaha', 'Aktif')->count() }}</p>
            </div>
        </div>

        @php
            $statusCounts = [
                'disetujui' => $ueps->where('status_verifikasi', 'disetujui')->count(),
                'ditolak'   => $ueps->where('status_verifikasi', 'ditolak')->count(),
            ];
        @endphp

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
        
        {{-- ============ MAIN CARD ============ --}}
        <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden">

            {{-- Toolbar --}}
            <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="relative w-full sm:max-w-xs">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                    <input type="text" placeholder="Cari nama usaha atau pemilik..." class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button type="button" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        Filter
                    </button>
                    <span class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl">{{ $ueps->count() }} usaha</span>
                </div>
            </div>

            <div class="overflow-x-auto min-h-[400px]">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 text-xs font-semibold uppercase tracking-wide">
                            <th class="p-4 pl-6 font-semibold">Nama Usaha / Pemilik</th>
                            <th class="p-4 font-semibold">Kategori Produk</th>
                            <th class="p-4 font-semibold">Wilayah Usaha</th>
                            <th class="p-4 font-semibold">Perkembangan</th>
                            <th class="p-4 font-semibold">Verifikasi</th>
                            <th class="p-4 font-semibold">Status</th>
                            <th class="p-4 pr-6 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-slate-700">
                        @forelse($ueps as $item)
                            <tr class="hover:bg-slate-50/70 transition-colors group">

                                {{-- Nama Usaha / Pemilik --}}
                                <td class="p-4 pl-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold shrink-0">
                                            {{ strtoupper(substr($item->nama_usaha, 0, 2)) }}
                                        </div>
                                        <div class="min-w-0">
                                        <div class="font-semibold text-slate-900 truncate">{{ $item->nama_usaha }}</div>
                                        <div class="text-xs text-slate-400 mt-0.5 truncate">
                                            {{ $item->nama_lengkap ?? 'Data tidak tersedia' }} &middot; NIK {{ $item->nik ? substr($item->nik, 0, 4).'••••••••' : '-' }}
                                        </div>
                                    </div>
                                    </div>
                                </td>

                                {{-- Kategori --}}
                                <td class="p-4">
                                    <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap">{{ $item->kategori_produk }}</span>
                                </td>

                                {{-- Wilayah --}}
                                <td class="p-4">
                                    <div class="text-slate-800 text-xs font-medium">{{ $item->desa_kelurahan_usaha }}</div>
                                    <div class="text-slate-400 text-[11px] mt-0.5">Kec. {{ $item->kecamatan_usaha }}</div>
                                </td>

                                {{-- Perkembangan --}}
                                <td class="p-4">
                                    @if($item->status_perkembangan == 'mandiri')
                                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Mandiri
                                        </span>
                                    @elseif($item->status_perkembangan == 'berkembang')
                                        <span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Berkembang
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Rintisan
                                        </span>
                                    @endif
                                </td>

                                {{-- Verifikasi --}}
                                <td class="p-4">
                                    @if($item->status_verifikasi == 'disetujui')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full">Disetujui</span>
                                    @elseif($item->status_verifikasi == 'ditolak')
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full">Ditolak</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">Pending</span>
                                    @endif
                                </td>

                                {{-- Status Usaha --}}
                                <td class="p-4">
                                    @if($item->status_usaha == 'Aktif')
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full">Aktif</span>
                                    @elseif($item->status_usaha == 'Tidak Aktif')
                                        <span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full">Tidak Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">Tutup Sementara</span>
                                    @endif
                                </td>

                                {{-- Aksi --}}
                            <td class="p-4 pr-6 text-right relative">
        <div x-data="{ open: false, isTop: false }" 
            @click.away="open = false" 
            class="relative inline-block text-left">
            
            <button @click="open = !open; isTop = (window.innerHeight - $el.getBoundingClientRect().top) < 200" 
                    class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-all">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
            </button>

            <div x-show="open" 
                x-cloak
                :class="isTop ? 'bottom-full mb-2' : 'top-full mt-2'"
                class="absolute right-0 z-[100] w-36 bg-white rounded-xl shadow-2xl border border-slate-100 py-1 transition-all">
                
                <a href="{{ route('uep.show', $item->id) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    Lihat
                </a>
                
                <a href="{{ route('uep.edit', $item->id) }}" class="flex items-center gap-3 px-4 py-2 text-sm text-amber-600 hover:bg-amber-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                    @if(auth()->user()->role === 'super_admin')
                <form id="delete-form-{{ $item->id }}" action="{{ route('uep.destroy', $item->id) }}" method="POST">
        @csrf 
        @method('DELETE')
        
        <button type="button" onclick="confirmDelete({{ $item->id }})" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            Hapus
        </button>
    </form>
    @endif
            </div>
        </div>
    </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-14 text-center">
                                    <div class="flex flex-col items-center justify-center gap-3">
                                        <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-slate-600">Belum ada data register mitra UEP</p>
                                            <p class="text-xs text-slate-400 mt-1">Tambahkan usaha baru untuk mulai mengelola data.</p>
                                        </div>
                                            @if(auth()->user()->role === 'super_admin')
                                        <a href="{{ route('uep.create') }}" class="mt-2 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                            Tambah Usaha Baru
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            <script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Usaha Ekonomi Produktif?',
            text: "Data akan dihapus permanen.",
            icon: 'warning',
            width: '300px', // Sedikit lebih ramping
            padding: '1.5rem', // Padding dikurangi agar tidak mepet
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-3xl shadow-xl border border-gray-100',
                icon: 'mb-4', // Memberi jarak bawah pada ikon
                title: 'text-lg font-bold text-gray-800', // Ukuran title disesuaikan
                htmlContainer: 'text-xs text-gray-500 m-0', // Margin 0 agar tidak mepet
                actions: 'mt-6 w-full', // Memastikan area tombol punya ruang
                confirmButton: 'bg-rose-600 hover:bg-rose-700 text-white rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl px-5 py-2 text-xs font-semibold shadow-sm mx-1'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
    </script>
    @endsection