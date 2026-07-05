@extends('layouts.app')
@section('content')

    {{-- ============ HEADER ============ --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-end md:justify-between gap-5">
        <div>
        <br>
            <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Kelolaan UEP</h1>
            <p class="text-sm text-slate-500 mt-1">Daftar Usaha Ekonomi Produktif yang terdaftar dan terverifikasi.</p>
        </div>

        <div class="flex items-center gap-2.5">

            {{-- Hidden form untuk Import (dipicu dari dalam dropdown lewat label for="file-upload") --}}
            <form action="{{ route('uep.import') }}" method="POST" enctype="multipart/form-data" class="hidden">
                @csrf
                <input type="file" name="file" onchange="this.form.submit()" id="file-upload">
            </form>

            {{-- ================= DROPDOWN: KELOLA DATA ================= --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" type="button"
                        class="inline-flex items-center gap-2 bg-white hover:bg-slate-50 text-slate-600 font-semibold px-4 py-2.5 rounded-xl text-sm border border-slate-200 shadow-sm transition-all">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 1.657 3.582 3 8 3s8-1.343 8-3V7M4 7c0 1.657 3.582 3 8 3s8-1.343 8-3M4 7c0-1.657 3.582-3 8-3s8 1.343 8 3m0 5c0 1.657-3.582 3-8 3s-8-1.343-8-3" />
                    </svg>
                    Kelola Data
                    <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" x-cloak
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="absolute right-0 mt-2 w-64 bg-white rounded-2xl shadow-2xl shadow-slate-900/10 border border-slate-100 py-2 z-50 origin-top-right">

                    <p class="px-4 pt-1.5 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Ekspor Data</p>

                    <a href="{{ route('uep.export.excel') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <span class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-6 0H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2" /></svg>
                        </span>
                        <span class="font-medium">Excel (.xlsx)</span>
                    </a>

                    <a href="{{ route('uep.export.pdf') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <span class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a2 2 0 012-2h2a2 2 0 012 2v2m-6 0h6m-6 0H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2" /></svg>
                        </span>
                        <span class="font-medium">PDF</span>
                    </a>

                    <div class="my-1.5 border-t border-slate-50"></div>

                    <p class="px-4 pt-1.5 pb-2 text-[10px] font-bold uppercase tracking-wider text-slate-400">Import Data</p>

                    <a href="{{ route('uep.template') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                        <span class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3" /></svg>
                        </span>
                        <span class="font-medium">Download Template</span>
                    </a>

                    <label for="file-upload" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-colors cursor-pointer">
                        <span class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" /></svg>
                        </span>
                        <span class="font-medium">Upload File Excel</span>
                    </label>
                </div>
            </div>

            {{-- ================= TOMBOL TAMBAH (CTA utama) ================= --}}
            @if(auth()->user()->role === 'super_admin')
                <a href="{{ route('uep.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-md shadow-indigo-600/20 active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
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
            <p class="text-xl font-bold text-slate-900">{{ $totalUsaha }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-4 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <div>
            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">Status Aktif</p>
            <p class="text-xl font-bold text-slate-900">{{ $statusAktif }}</p>
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

    {{-- ============ MAIN CARD ============ --}}
    <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden"
         x-data="uepSearch()" x-init="load()">

        {{-- Toolbar --}}
        <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="relative w-full sm:max-w-xs">
                <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
                <input type="text" x-model="search" @input.debounce.400ms="load(1)"
                       placeholder="Cari nama usaha atau pemilik..."
                       class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
            </div>
            <div class="flex items-center gap-2 shrink-0">
                <select x-model="status" @change="load(1)"
                        class="text-xs font-semibold text-slate-500 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-colors cursor-pointer">
                    <option value="">Semua Verifikasi</option>
                    <option value="pending">Pending</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <span x-show="loading" x-cloak class="text-xs text-slate-400">Memuat...</span>
                <span x-show="!loading" x-cloak class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl" x-text="total + ' usaha'"></span>
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
                <tbody class="divide-y divide-slate-50 text-slate-700" x-ref="tbody">
                    {{-- Baris tabel diisi otomatis oleh JavaScript (uepSearch) --}}
                    <tr>
                        <td colspan="7" class="p-14 text-center text-slate-400 text-sm">Memuat data...</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Pagination sederhana (prev/next) --}}
        <div class="p-4 border-t border-slate-100 bg-slate-50/40 flex items-center justify-between" x-show="lastPage > 1" x-cloak>
            <button type="button" @click="load(currentPage - 1)" :disabled="currentPage <= 1"
                    class="text-xs font-semibold px-3 py-2 rounded-lg bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
                &larr; Sebelumnya
            </button>
            <span class="text-xs text-slate-400">Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span></span>
            <button type="button" @click="load(currentPage + 1)" :disabled="currentPage >= lastPage"
                    class="text-xs font-semibold px-3 py-2 rounded-lg bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
                Berikutnya &rarr;
            </button>
        </div>
    </div>

    <script>
    function uepSearch() {
        return {
            search: '{{ request('search') }}',
            status: '{{ request('status') }}',
            loading: false,
            total: {{ $ueps->total() }},
            currentPage: 1,
            lastPage: 1,
            isSuperAdmin: @json(auth()->user()->role === 'super_admin'),
            baseUrl: '{{ route('uep.index') }}',
            csrfToken: '{{ csrf_token() }}',

            routeShow(id)    { return '{{ route('uep.show', ':id') }}'.replace(':id', id); },
            routeEdit(id)    { return '{{ route('uep.edit', ':id') }}'.replace(':id', id); },
            routeDestroy(id) { return '{{ route('uep.destroy', ':id') }}'.replace(':id', id); },

            load(page = 1) {
                this.loading = true;
                const url = new URL(this.baseUrl);
                if (this.search) url.searchParams.set('search', this.search); else url.searchParams.delete('search');
                if (this.status) url.searchParams.set('status', this.status); else url.searchParams.delete('status');
                url.searchParams.set('page', page);

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                    .then(res => res.json())
                    .then(json => {
                        this.total = json.total;
                        this.currentPage = json.current_page;
                        this.lastPage = json.last_page;
                        this.renderRows(json.data);
                        window.history.replaceState({}, '', url.toString());
                    })
                    .catch(() => {
                        this.$refs.tbody.innerHTML = `
                            <tr><td colspan="7" class="p-14 text-center text-rose-400 text-sm">Gagal memuat data. Silakan coba lagi.</td></tr>`;
                    })
                    .finally(() => { this.loading = false; });
            },

            initials(nama) {
                return String(nama || '').slice(0, 2).toUpperCase();
            },
            maskNik(nik) {
                if (!nik) return '-';
                nik = String(nik);
                return nik.length >= 4 ? nik.slice(0, 4) + '••••••••' : nik;
            },
            escapeHtml(str) {
                if (str === null || str === undefined) return '';
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            },

            perkembanganBadge(s) {
                if (s === 'mandiri') {
                    return `<span class="inline-flex items-center gap-1.5 bg-emerald-50 text-emerald-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Mandiri
                            </span>`;
                } else if (s === 'berkembang') {
                    return `<span class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Berkembang
                            </span>`;
                }
                return `<span class="inline-flex items-center gap-1.5 bg-amber-50 text-amber-600 px-2.5 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Rintisan
                        </span>`;
            },
            verifikasiBadge(s) {
                if (s === 'disetujui') {
                    return `<span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full">Disetujui</span>`;
                } else if (s === 'ditolak') {
                    return `<span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full">Ditolak</span>`;
                }
                return `<span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">Pending</span>`;
            },
            statusUsahaBadge(s) {
                if (s === 'Aktif') {
                    return `<span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-xs font-semibold rounded-full">Aktif</span>`;
                } else if (s === 'Tidak Aktif') {
                    return `<span class="px-2.5 py-1 bg-rose-50 text-rose-600 text-xs font-semibold rounded-full">Tidak Aktif</span>`;
                }
                return `<span class="px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-semibold rounded-full">Tutup Sementara</span>`;
            },

            renderRows(items) {
                if (!items.length) {
                    this.$refs.tbody.innerHTML = `
                        <tr>
                            <td colspan="7" class="p-14 text-center">
                                <div class="flex flex-col items-center justify-center gap-3">
                                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                        <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-600">Data tidak ditemukan</p>
                                        <p class="text-xs text-slate-400 mt-1">Coba kata kunci atau filter lain.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>`;
                    return;
                }

                this.$refs.tbody.innerHTML = items.map(item => {
                    const namaUsahaEsc = this.escapeHtml(item.nama_usaha);
                    const namaLengkapEsc = this.escapeHtml(item.nama_lengkap || 'Data tidak tersedia');
                    const kategoriEsc = this.escapeHtml(item.kategori_produk);
                    const desaEsc = this.escapeHtml(item.desa_kelurahan_usaha);
                    const kecEsc = this.escapeHtml(item.kecamatan_usaha);
                    const nikEsc = this.escapeHtml(item.nik || '');

                    const deleteHtml = this.isSuperAdmin ? `
                        <form id="delete-form-${item.id}" action="${this.routeDestroy(item.id)}" method="POST">
                            <input type="hidden" name="_token" value="${this.csrfToken}">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="button" onclick="confirmDelete(${item.id})" class="w-full flex items-center gap-2.5 px-4 py-2 text-sm text-rose-600 hover:bg-slate-50">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                Hapus
                            </button>
                        </form>` : '';

                    // NIK dengan hover-copy: pb-2 (bukan mb-2) supaya celah antara teks & tooltip
                    // tetap "milik" elemen ini, sehingga kursor bisa turun ke tooltip tanpa memutus hover.
                    const nikHtml = item.nik ? `
                        <span class="relative inline-flex" x-data="{ show: false, copied: false }" @mouseenter="show = true" @mouseleave="show = false; copied = false">
                            <span class="cursor-pointer select-none">NIK ${this.maskNik(item.nik)}</span>
                            <span x-show="show" x-cloak
                                  x-transition:enter="transition ease-out duration-150"
                                  x-transition:enter-start="opacity-0 translate-y-1"
                                  x-transition:enter-end="opacity-100 translate-y-0"
                                  class="absolute bottom-full left-0 pb-2 z-30">
                                <span @click="navigator.clipboard.writeText('${nikEsc}'); copied = true; setTimeout(() => { copied = false; show = false }, 900)"
                                      class="relative whitespace-nowrap bg-slate-900 text-white text-xs font-mono font-semibold px-3 py-1.5 rounded-lg shadow-lg cursor-pointer hover:bg-slate-800 transition-colors inline-flex items-center gap-2"
                                      title="Klik untuk menyalin">
                                    <span x-show="!copied">${nikEsc}</span>
                                    <span x-show="copied" x-cloak class="text-emerald-400 font-semibold">Tersalin!</span>
                                    <svg x-show="!copied" class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    <svg x-show="copied" x-cloak class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span class="absolute top-full left-4 -mt-1 w-2 h-2 bg-slate-900 rotate-45"></span>
                                </span>
                            </span>
                        </span>` : `<span>NIK -</span>`;

                    return `
                    <tr class="hover:bg-slate-50/70 transition-colors group">
                        <td class="p-4 pl-6">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center text-xs font-bold shrink-0">${this.initials(item.nama_usaha)}</div>
                                <div class="min-w-0">
                                    <div class="font-semibold text-slate-900 truncate">${namaUsahaEsc}</div>
                                    <div class="text-xs text-slate-400 mt-0.5 flex items-center gap-1">
                                        <span class="truncate">${namaLengkapEsc}</span>
                                        <span class="shrink-0">&middot;</span>
                                        ${nikHtml}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-lg text-xs font-medium whitespace-nowrap">${kategoriEsc}</span>
                        </td>
                        <td class="p-4">
                            <div class="text-slate-800 text-xs font-medium">${desaEsc}</div>
                            <div class="text-slate-400 text-[11px] mt-0.5">Kec. ${kecEsc}</div>
                        </td>
                        <td class="p-4">${this.perkembanganBadge(item.status_perkembangan)}</td>
                        <td class="p-4">${this.verifikasiBadge(item.status_verifikasi)}</td>
                        <td class="p-4">${this.statusUsahaBadge(item.status_usaha)}</td>
                        <td class="p-4 pr-6 text-right relative">
                            <div x-data="{ open: false, isTop: false }" @click.away="open = false" class="relative inline-block text-left">
                                <button @click="open = !open; isTop = (window.innerHeight - $el.getBoundingClientRect().top) < 200" class="p-2 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 13a1 1 0 100-2 1 1 0 000 2zM12 6a1 1 0 100-2 1 1 0 000 2zM12 20a1 1 0 100-2 1 1 0 000 2z"/></svg>
                                </button>
                                <div x-show="open" x-cloak :class="isTop ? 'bottom-full mb-2' : 'top-full mt-2'" class="absolute right-0 z-[100] w-36 bg-white rounded-xl shadow-2xl border border-slate-100 py-1 transition-all">
                                    <a href="${this.routeShow(item.id)}" class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 hover:bg-slate-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Lihat
                                    </a>
                                    <a href="${this.routeEdit(item.id)}" class="flex items-center gap-3 px-4 py-2 text-sm text-amber-600 hover:bg-slate-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    ${deleteHtml}
                                </div>
                            </div>
                        </td>
                    </tr>`;
                }).join('');
            }
        }
    }
    </script>

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