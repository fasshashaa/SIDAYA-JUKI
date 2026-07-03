@extends('layouts.app')
@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
    <div>
        <h1 class="text-2xl md:text-3xl font-bold text-slate-900 tracking-tight">Produk UMKM</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar Produk UMKM binaan Dinsos PPPA Kabupaten Cilacap.</p>
    </div>
    @if(auth()->user()->role === 'user')
        {{-- Tombol Tambah --}}
        <a href="{{ route('produk.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2.5 rounded-xl text-sm transition-all shadow-md shadow-indigo-600/20 active:scale-95">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Baru
        </a>
    @endif
</div>

{{-- ================= SUMMARY BAR ================= --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Total Produk</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalProduk }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Ditampilkan</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalTampil }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Draft</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalDraft }}</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 p-5 flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <p class="text-[11px] font-semibold text-slate-400 uppercase tracking-wide">Stok Habis</p>
            <p class="text-2xl font-bold text-slate-900">{{ $totalStokHabis }}</p>
        </div>
    </div>
</div>

{{-- ================= WRAPPER: TOOLBAR + GRID (Alpine) ================= --}}
<div x-data="produkSearch()" x-init="load()">

    {{-- ================= TOOLBAR ================= --}}
    <div class="bg-white rounded-2xl border border-slate-100 p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="relative w-full sm:max-w-xs">
            <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z"/></svg>
            <input type="text" x-model="search" @input.debounce.400ms="load(1)"
                   placeholder="Cari nama produk atau kategori..."
                   class="w-full pl-10 pr-4 py-2.5 text-sm bg-slate-50 border border-slate-100 rounded-xl placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-300 transition-all">
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <select x-model="status" @change="load(1)"
                    class="text-xs font-semibold text-slate-500 bg-slate-50 hover:bg-slate-100 px-3.5 py-2.5 rounded-xl border-0 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 transition-colors cursor-pointer">
                <option value="">Semua Status</option>
                <option value="Ditampilkan">Ditampilkan</option>
                <option value="Draft">Draft</option>
            </select>
            <span x-show="loading" x-cloak class="text-xs text-slate-400">Memuat...</span>
            <span x-show="!loading" x-cloak class="text-xs bg-indigo-50 text-indigo-600 font-semibold px-3 py-2.5 rounded-xl whitespace-nowrap" x-text="total + ' produk'"></span>
        </div>
    </div>

    {{-- ================= GRID CONTAINER ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5 min-h-[300px]" x-ref="grid">
        {{-- Kartu produk diisi otomatis oleh JavaScript (produkSearch) --}}
        <div class="col-span-full flex items-center justify-center p-20 text-sm text-slate-400">Memuat data...</div>
    </div>

    {{-- Pagination sederhana (prev/next) --}}
    <div class="mt-6 flex items-center justify-between" x-show="lastPage > 1" x-cloak>
        <button type="button" @click="load(currentPage - 1)" :disabled="currentPage <= 1"
                class="text-xs font-semibold px-4 py-2.5 rounded-xl bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
            &larr; Sebelumnya
        </button>
        <span class="text-xs text-slate-400">Halaman <span x-text="currentPage"></span> dari <span x-text="lastPage"></span></span>
        <button type="button" @click="load(currentPage + 1)" :disabled="currentPage >= lastPage"
                class="text-xs font-semibold px-4 py-2.5 rounded-xl bg-white border border-slate-200 disabled:opacity-40 disabled:cursor-not-allowed hover:bg-slate-50 transition-colors">
            Berikutnya &rarr;
        </button>
    </div>
</div>

<script>
function produkSearch() {
    return {
        search: '{{ request('search') }}',
        status: '{{ request('status') }}',
        loading: false,
        total: {{ $produk->total() }},
        currentPage: 1,
        lastPage: 1,
        isUser: @json(auth()->user()->role === 'user'),
        baseUrl: '{{ route('produk.index') }}',
        csrfToken: '{{ csrf_token() }}',

        routeShow(id)    { return '{{ route('produk.show', ':id') }}'.replace(':id', id); },
        routeEdit(id)    { return '{{ route('produk.edit', ':id') }}'.replace(':id', id); },
        routeDestroy(id) { return '{{ route('produk.destroy', ':id') }}'.replace(':id', id); },

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
                    this.renderCards(json.data);
                    window.history.replaceState({}, '', url.toString());
                })
                .catch(() => {
                    this.$refs.grid.innerHTML = `
                        <div class="col-span-full p-20 text-center text-rose-400 text-sm">Gagal memuat data. Silakan coba lagi.</div>`;
                })
                .finally(() => { this.loading = false; });
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
        formatRupiah(angka) {
            const n = Number(angka || 0);
            return 'Rp ' + n.toLocaleString('id-ID');
        },
        statusColor(s) {
            return s === 'Ditampilkan' ? 'bg-emerald-500' : (s === 'Draft' ? 'bg-amber-500' : 'bg-slate-400');
        },

        renderCards(items) {
            if (!items.length) {
                this.$refs.grid.innerHTML = `
                    <div class="col-span-full flex flex-col items-center justify-center gap-3 p-20 text-center">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-600">Produk tidak ditemukan</p>
                            <p class="text-xs text-slate-400 mt-1">Coba kata kunci atau filter lain.</p>
                        </div>
                    </div>`;
                return;
            }

            this.$refs.grid.innerHTML = items.map(item => {
                const namaEsc = this.escapeHtml(item.nama_produk);
                const kategoriEsc = this.escapeHtml(item.kategori);

                let pemilikLabel = 'Tanpa Pemilik';
                if (item.uep_id) {
                    pemilikLabel = this.escapeHtml(item.uep_nama || 'Tanpa Nama UEP');
                } else if (item.kube_id) {
                    pemilikLabel = this.escapeHtml(item.kube_nama || 'Tanpa Nama KUBE');
                }

                const fotoHtml = item.foto_url
                    ? `<img src="${item.foto_url}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">`
                    : `<div class="w-full h-full flex items-center justify-center text-slate-300">
                         <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                       </div>`;

                const stokBadgeClass = item.stok > 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600';

                const stokHabisOverlay = item.stok == 0
                    ? `<div class="absolute inset-0 z-[5] bg-white/60 backdrop-blur-[1px] flex items-center justify-center">
                         <span class="px-3 py-1.5 bg-slate-900/80 text-white text-[10px] font-bold uppercase tracking-wider rounded-full">Stok Habis</span>
                       </div>`
                    : '';

                const deleteHtml = this.isUser ? `
                    <form action="${this.routeDestroy(item.id)}" method="POST" id="delete-form-${item.id}">
                        <input type="hidden" name="_token" value="${this.csrfToken}">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" onclick="confirmDelete(${item.id})" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-rose-600 shadow-sm transition-colors" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>` : '';

                return `
                <div class="bg-white rounded-3xl shadow-sm shadow-slate-200/50 border border-slate-100 overflow-hidden hover:shadow-lg hover:shadow-slate-200/60 hover:-translate-y-0.5 hover:border-slate-200 transition-all duration-300 flex flex-col group">

                    <div class="relative aspect-square w-full bg-slate-50 overflow-hidden">

                        <div class="absolute top-3 right-3 z-10 px-2.5 py-1 rounded-full text-[9px] font-bold text-white shadow-sm ${this.statusColor(item.status_publikasi)} uppercase tracking-wider">
                            ${this.escapeHtml(item.status_publikasi)}
                        </div>

                        ${stokHabisOverlay}

                        ${fotoHtml}

                        <div class="absolute inset-x-0 bottom-0 z-10 p-2 flex justify-end gap-1 translate-y-2 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-200">
                            <a href="${this.routeShow(item.id)}" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-indigo-600 shadow-sm transition-colors" title="Lihat">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="${this.routeEdit(item.id)}" class="p-2 bg-white/95 backdrop-blur rounded-lg text-slate-500 hover:text-amber-600 shadow-sm transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            ${deleteHtml}
                        </div>
                    </div>

                    <div class="flex-grow p-4">
                        <p class="text-[10px] font-bold text-indigo-500 uppercase tracking-wider mb-1 truncate">${pemilikLabel}</p>
                        <h3 class="font-semibold text-slate-900 line-clamp-1">${namaEsc}</h3>
                        <p class="text-xs text-slate-400 mt-1 mb-2">${kategoriEsc}</p>
                        <p class="text-indigo-600 font-bold text-sm">${this.formatRupiah(item.harga_jual)}</p>
                    </div>

                    <div class="px-4 pb-4 pt-3 border-t border-slate-50 flex justify-between items-center">
                        <span class="text-[10px] ${stokBadgeClass} px-2.5 py-1 rounded-full font-bold">Stok: ${item.stok}</span>
                        <div class="flex gap-1 sm:hidden">
                            <a href="${this.routeShow(item.id)}" class="p-1.5 text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }
    }
}
</script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Produk?',
        text: "Data akan dihapus permanen.",
        icon: 'warning',
        width: '300px',
        padding: '1.5rem',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        cancelButtonColor: '#f1f5f9',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        customClass: {
            popup: 'rounded-3xl shadow-xl border border-gray-100',
            icon: 'mb-4',
            title: 'text-lg font-bold text-gray-800',
            htmlContainer: 'text-xs text-gray-500 m-0',
            actions: 'mt-6 w-full',
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